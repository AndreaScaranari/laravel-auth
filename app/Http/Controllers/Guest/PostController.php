<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function show(string $slug){
        $post = Post::whereSlug($slug)->first();
        if (!$post) abort(404);
        return view('guest.posts.show', compact('post'));
    }
}
