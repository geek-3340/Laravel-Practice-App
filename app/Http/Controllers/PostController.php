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

        // フォームリクエストデータ保存の基本構文
            // リクエストデータからtitleとbodyを取得し、Postモデルのcreateメソッド（ Post::create([]); ）を
            // 使用して新しいレコードを作成、同時にPostモデルを介してレコードをDBサーバーに保存します。
            // 作成したレコードを$post変数に格納します。
            // 保存したレコード（モデルインスタンス）を$post変数に格納することは、後の処理で使用するためのものです。
        // $post = Post::create([
        //     'title' => $request->title,
        //     'body' => $request->body
        // ]);

        // バリデーション機能実装
            // リクエストデータからtitleとbodyを取得し、同時にvalidateメソッドを用いて各リクエストデータの
            // 入力条件を設定して$validate変数に格納します。
        $validated = $request->validate([
            'title'=> 'required|max:20',
            'body'=> 'required|max:400',
        ]);

        // リレーション機能
            // 投稿したユーザーのidをusersテーブルから取得し、postsテーブルのuser_idカラムに渡す値として
            // $validated変数に追加格納します。
        $validated['user_id'] = auth()->id();

        // Postモデルのcreateメソッド（ Post::create(); ）を使用して新しいレコードを作成、同時に
        // Postモデルを介してレコードをDBサーバーに保存します。
        // 作成したレコードを$post変数に格納します。
        // 保存したレコード（モデルインスタンス）を$post変数に格納することは、後の処理で使用するためのものです。
        $post = Post::create($validated);

        // 保存が完了したら、元のページにリダイレクトします
        // リダイレクト時に、'message'というセッション変数に
        // '保存しました'というメッセージを設定します。
        return back()->with('message', '保存しました');
    }

    // indexメソッド
    public function index(){
        // Postモデルを介してpostsテーブルのデータを取得し変数に格納。
        $posts = Post::all();
        // compact関数でviewファイルから変数を参照できるようにして、post/index.blade.phpを返す。
        return view('post.index',compact('posts'));
    }
}

