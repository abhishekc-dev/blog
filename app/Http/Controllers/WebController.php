<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        if ($query) {
            $posts = Post::where('title', 'LIKE', "%{$query}%")
                ->orWhere('content', 'LIKE', "%{$query}%")
                ->paginate(2);
        } else {
            $posts = Post::paginate(2);
        }

        if ($request->ajax()) {
            $view = view('post.post-table', compact('posts'))->render();
            $pagination = $posts->links()->render();
            return response()->json(['html' => $view, 'pagination' => $pagination]);
        }

        return view('dashboard', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('show', compact('post'));
    }

    public function showBlog($id)
    {
        $post = Post::with(['user', 'comments.user'])->findOrFail($id);
        return response()->json($post);
    }




    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'author_id' => auth()->id(),
        ]);

        return redirect('/dashboard');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if ($post->author_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($post->author_id !== auth()->id()) {
            return redirect('/dashboard')->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $post->update($request->only(['title', 'content']));

        return redirect('/dashboard')->with('success', 'Post updated successfully.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($post->author_id !== auth()->id()) {
            return redirect('/dashboard')->with('error', 'Unauthorized action.');
        }

        $post->delete();
        return redirect('/dashboard')->with('success', 'Post deleted successfully.');
    }

    public function listBlog(Request $request)
    {
        $posts = Post::with('user')->paginate(10);
        return view('home', ['posts' => $posts]);
    }

}
