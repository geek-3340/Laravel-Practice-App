<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // authorize()を使うためのuse宣言

class PostController extends Controller
{
    use AuthorizesRequests; // authorize()を使うためのuse宣言
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $posts = Post::with('user')->get();
        // $posts = Post::with('user')->paginate(10);
        // $terms = Post::whereIn('user_id',[1,3])->whereTime('created_at','>','22:00')->with('user')->get();
        // return view('post.index',compact('posts','terms'));

        // 日付フィルター用のロジック
        $query = Post::query()->with('user');
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
        $posts = $query->latest()->paginate(10);

        // postデータをindexに渡して表示
        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'=> 'required|max:20',
            'body'=> 'required|max:400',
        ]);
        $validated['user_id'] = auth()->id();
        $post = Post::create($validated);
        return back()->with('message', '保存しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post); // ← ここで認可チェック
        return view('post.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title'=> 'required|max:20',
            'body'=> 'required|max:400',
        ]);
        $validated['user_id'] = auth()->id();
        $post->update($validated);
        return back()->with('message', '更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,Post $post)
    {
        $this->authorize('delete', $post); // ← ここで認可チェック
        $post->delete();
        $request->session()->flash('message','削除しました');
        return redirect('post');
    }
}
