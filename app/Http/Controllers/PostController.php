<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Resources\CommentResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Posts/Index', [
            'posts' => PostResource::collection(Post::query()
                ->with(['user', 'topic'])
                ->latest()
                ->latest('id')
                ->paginate())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Posts/Create');
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
        if (!Str::contains($post->showRoute(), $request->path())) {
            return redirect($post->showRoute($request->query()), 301);
        }

        $post->load('user');

        return inertia('Posts/Show', [
            'post' => fn() => PostResource::make($post),
            'comments' => fn() => CommentResource::collection($post->comments()->with('user')->latest()->paginate(10))
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post); // Assicurati di avere una policy definita
        $post->delete();

        return redirect()->route('posts.index')->banner('success', 'Post eliminato con successo.');
    }

}
