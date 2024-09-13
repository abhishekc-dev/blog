<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        if ($posts) {
            return response()->json([
                'status' => true,
                'message' => 'Posts Found successfully',
                'total' => 'total ' . count($posts) . ' Post Found',
                'error' => null,
                'data' => $posts,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'No posts available',
                'error' => 'No posts found in the database',
                'data' => [],
            ], 404);
        }
    }


    public function show($id)
    {
        $post = Post::find($id);

        if ($post) {
            return response()->json([
                'status' => true,
                'message' => 'Post Found successfully',
                'error' => null,
                'data' => $post,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Post not found',
                'error' => 'No record found for the ID : ' . $id,
                'data' => [],
            ], 404);
        }
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = Post::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'author_id' => Auth::id(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Post created successfully',
            'data' => $post
        ], 201);
    }


    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($post->author_id !== Auth::id()) {
            return response()->json([
                'status' => false,
                'error' => 'Unauthorized access',
                'message' => 'You are not authorized to update this post'
            ], 403);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Post updated successfully',
            'data' => $post
        ]);
    }


    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Post not found',
                'error' => 'No record found for the ID : ' . $id,
                'data' => [],
            ], 404);
        }
        if ($post->author_id !== Auth::id()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized action',
                'error' => 'You are not allowed to delete this post',
                'data' => [],
            ], 403);
        }
        $post->delete();
        return response()->json([
            'status' => true,
            'message' => 'Post deleted successfully',
            'error' => null,
            'data' => [],
        ], 200);
    }

}
