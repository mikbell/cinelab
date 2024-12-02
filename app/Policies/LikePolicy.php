<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;

class LikePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user, Model $likeable)
    {
        if (! in_array($likeable::class, [Post::class, Comment::class])){
            return false;
        }
        
        return $likeable->likes()->whereBelongsTo($user)->doesntExist();
    }

    public function delete(User $user, Model $likeable)
    {
        if (! in_array($likeable::class, [Post::class, Comment::class])){
            return false;
        }
        
        return $likeable->likes()->whereBelongsTo($user)->exists();
    }
}
