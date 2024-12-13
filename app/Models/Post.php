<?php

namespace App\Models;

use App\Models\Concerns\ConvertsMarkdownToHtml;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;
    use ConvertsMarkdownToHtml;
    use Searchable;

    protected $withCount = ['likes'];

    protected $fillable = [
        'user_id',
        'topic_id',
        'title',
        'slug',
        'content',
        'html',
    ];

    const TITLE_MIN_LENGTH = 10;
    const TITLE_MAX_LENGTH = 120;
    const CONTENT_MIN_LENGTH = 100;
    const CONTENT_MAX_LENGTH = 10_000;


    protected static function boot()
    {
        parent::boot();

        static::saving(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function title(): Attribute
    {
        return Attribute::set(fn($value) => Str::title($value));
    }

    public function showRoute(array $parameters = [])
    {
        return route('posts.show', [
            'post' => $this->id, // Assicurati che `$this->id` o `$this->slug` sia corretto
            'slug' => Str::slug($this->title), // Assicurati che il titolo sia presente
            ...$parameters,
        ]);
    }


    public function editRoute(array $parameters = [])
    {
        return route('posts.edit', [
            'post' => $this->id, // Specifica esplicitamente l'id del post
            'slug' => Str::slug($this->title), // Include lo slug del titolo
            ...$parameters, // Eventuali parametri aggiuntivi
        ]);
    }
}
