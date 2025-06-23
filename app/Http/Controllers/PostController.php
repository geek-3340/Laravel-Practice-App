<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    // createメソッド
    public function create(){
        // post/create.blade.phpを返す
        return view('post.create');
    }

    // storeメソッド
    // 呼び出し元ルートのリクエストデータを引数に設定
    public function store(Request $request){
        // リクエストデータからtitleとbodyを取得し、Postモデルのcreateメソッド（ Post::create([]); ）を
        // 使用して新しいレコードを作成、同時にでPostモデルを介してレコードをDBサーバーに保存します。
        // 作成したレコードを$post変数に格納します。
        // 保存したレコード（モデルインスタンス）を$post変数に格納することは、後の処理で使用するためのものです。
        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body
        ]);
        // 保存が完了したら、元のページにリダイレクトします
        // リダイレクト時に、'message'というセッション変数に
        // '保存しました'というメッセージを設定します。
        return back()->with('message', '保存しました');
    }
}