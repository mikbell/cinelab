<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use App\Models\Topic;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Resources\TopicResource;
use App\Http\Resources\CommentResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Topic $topic = null)
    {
        $query = $request->query('query');
        $posts = $query
            ? Post::search($query)
                ->query(fn(Builder $q) => $q->with(['user', 'topic'])->withCount(['likes', 'comments']))
                ->when($topic, fn(\Laravel\Scout\Builder $q) => $q->where('topic_id', $topic->id))
            : Post::query()
                ->with(['user', 'topic'])
                ->withCount(['likes', 'comments']) // Aggiunge il conteggio dei commenti
                ->when($topic, fn(Builder $q) => $q->whereBelongsTo($topic))
                ->latest('id');

        return inertia('Posts/Index', [
            'posts' => Inertia::merge(fn() => PostResource::collection($posts->paginate()->withQueryString())->items()),
            'pagination' => Arr::except($posts->paginate()->withQueryString()->toArray(), 'data'),
            'topics' => Inertia::defer(fn() => TopicResource::collection(Topic::all())),
            'selectedTopic' => fn() => $topic ? TopicResource::make($topic) : null,
            'query' => fn() => $query,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia(
            'Posts/Create',
            [
                'topics' => fn() => TopicResource::collection(Topic::all())
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => [
                'required',
                'string',
                'min:' . Post::TITLE_MIN_LENGTH,
                'max:' . Post::TITLE_MAX_LENGTH,
            ],
            'topic_id' => 'required|exists:topics,id',
            'content' => [
                'required',
                'string',
                'min:' . Post::CONTENT_MIN_LENGTH,
                'max:' . Post::CONTENT_MAX_LENGTH,
            ]
        ]);

        $post = Post::create([
            ...$data,
            'user_id' => $request->user()->id,
        ]);

        return redirect($post->showRoute())->banner('Post creato con successo.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Post $post)
    {
        if (!Str::endsWith($post->showRoute(), $request->path())) {
            return redirect($post->showRoute($request->query()), 301);
        }

        $post->load('user', 'topic');

        return inertia('Posts/Show', [
            'post' => fn() => PostResource::make($post)->withLikePermission(),
            'comments' => function () use ($post) {
                $commentResource = CommentResource::collection($post->comments()->with('user')->latest()->latest('id')->paginate(10));
                $commentResource->collection->transform(fn($resource) => $resource->withLikePermission());

                return $commentResource;
            },
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return inertia(
            'Posts/Edit',
            [
                'post' => PostResource::make($post),
                'topics' => fn() => TopicResource::collection(Topic::all())
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($validated['title'] !== $post->title) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $post->update($validated);

        return redirect($post->showRoute())
            ->with('success', 'Post aggiornato con successo!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post); // Assicurati di avere una policy definita
        $post->delete();

        return redirect(route('posts.index'))->banner('success', 'Post eliminato con successo.');
    }

}
