<?php

namespace App\Http\Controllers;
;
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
        $validatedData = $request->validate([
            'content' => 'required|max:1000|min:3|string',
        ]);

        // Creazione del commento
        $comment = new Comment($validatedData);
        $comment->user()->associate($request->user());
        $comment->post()->associate($post);
        $comment->save();

        return redirect($post->showRoute())->banner('Commento creato con successo');
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

        return redirect($comment->post->showRoute(['page' => $request->query('page')]))->banner('Commento modificato con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Comment $comment)
    {
        $this->authorize('delete', $comment);


        $comment->delete();

        return redirect($comment->post->showRoute(['page' => $request->query('page')]))->banner('Commento eliminato con successo');
    }
}
