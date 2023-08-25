<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts =  Post::all();
        return response()->json([
            'posts' => $posts,
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id()
        ]);
        return response()->json([
            'post' => $post,
            'success' => 'post created successfully'
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $post = Post::findOrFail($id);
            return response()->json([
                'post' => $post
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'post not found ' . $e->getMessage()
            ],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        try {
            $post->title = $request->title;
            $post->content = $request->content;
            $post->save();
            return response()->json([
                'post' => $post,
                'success' => 'post updated successfully'
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'post not found'.$e->getMessage(),
            ],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        try {
            $post->delete();
        } catch (Exception $e) {
            return response()->json([
                'error' => 'post not found'.$e->getMessage(),
            ],404);
        }
    }
}
