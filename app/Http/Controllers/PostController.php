<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    // createメソッド
    public function create(){
        // post/create.blade.phpを表示
        return view('post.create');
    }

    // storeメソッド
    public function store(Request $request){
        // Postモデルを使用して、フォームから送信されたデータを保存
        // リクエストからtitleとbodyを取得し、Postモデルのcreateメソッドを使用して新しいレコードを作成します。
        // 作成したレコードを$post変数に格納します。
        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body
        ]);
        return back()->with('message', '保存しました');
    }
}