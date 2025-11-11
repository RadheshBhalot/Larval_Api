<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        return response()->json([
            'status' => true,
            'posts' => $posts
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        $post = $request->user()->posts()->create([
            'title' => $request->title,
            'body'  => $request->body,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Post created succesfully',
            'posts' => $post,
        ], 201);
    }
}
