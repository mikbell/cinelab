<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
    ];

    const TITLE_MIN_LENGTH = 10;
    const TITLE_MAX_LENGTH = 120;
    const CONTENT_MIN_LENGTH = 100;
    const CONTENT_MAX_LENGTH = 10_000;


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function title():Attribute
    {
        return Attribute::set(fn($value) => Str::title($value));
    }
}
