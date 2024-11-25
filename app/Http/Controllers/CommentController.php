<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        Comment::make($request->validate([
            'content' => 'required|max:1000|min:3|string',
        ]))->user()
            ->associate($request->user())
            ->post()
            ->associate($post)
            ->save();

        return to_route('posts.show', $post)->banner('Comment added');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);
        
        $data = $request->validate([
            'content' => 'required|max:1000|min:3|string',
        ]);

        $comment->update($data);

        return to_route('posts.show', ['post' => $comment->post_id, 'page' => $request->query('page')])->banner('Comment updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Comment $comment)
    {
        $this->authorize('delete', $comment);


        $comment->delete();

        return to_route('posts.show', [$comment->post_id, 'page' => $request->query('page')])->banner('Comment deleted');
    }
}
