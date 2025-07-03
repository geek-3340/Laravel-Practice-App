<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function create(){
        return view('post.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'title'=> 'required|max:20',
            'body'=> 'required|max:400',
        ]);
        $validated['user_id'] = auth()->id();
        $post = Post::create($validated);
        return back()->with('message', '保存しました');
    }

    public function index(){
        $posts = Post::all();
        $posts = Post::with('user')->get();
        $terms = Post::whereIn('user_id',[1,3])->whereTime('created_at','>','22:00')->with('user')->get();
        return view('post.index',compact('posts','terms'));
    }

    public function show (Post $post) {
        return view('post.show',compact('post'));
    }
    
    public function edit (Post $post){
        return view('post.edit',compact('post'));
    }

    public function update(Request $request,Post $post){
        $validated = $request->validate([
            'title'=> 'required|max:20',
            'body'=> 'required|max:400',
        ]);
        $validated['user_id'] = auth()->id();
        $post->update($validated);
        return back()->with('message', '更新しました');
    }

    public function destroy(Request $request,Post $post){
        $post->delete();
        $request->session()->flash('message','削除しました');
        return redirect('post');
    }
}