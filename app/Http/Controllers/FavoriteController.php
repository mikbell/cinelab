<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Favorites/Index', [
            'favorites' => $request->user()->favorites()->get(),
        ]);
    }
    
    
    public function store(Request $request, $movieId)
    {
        $user = $request->user();
    
        $user->favorites()->create([
            'movie_id' => $movieId,
            'title' => $request->input('title'),
            'poster_path' => $request->input('poster_path'),
        ]);
    
        return response()->json(['message' => 'Aggiunto ai preferiti']);
    }
    

    public function destroy(Request $request, $movieId)
    {
        $favorite = $request->user()->favorites()->where('movie_id', $movieId)->first();

        if ($favorite) {
            $favorite->delete();
        }

        return response()->json(['message' => 'Removed from favorites']);
    }
}

