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
        // Postモデルを介してpostsテーブルの全データを取得し変数に格納。
        $posts = Post::all();

        // 【条件付きデータ取得】
            // 条件に合ったデータ取得
                // モデル名::where('条件をつけるカラム名' , 条件) -> get();
                // 以下ではuser_idカラムにログイン中のidという条件を設けてデータを取得している。
        // $terms = Post::where('user_id',auth()->id())->get();

            // 条件に合わないデータ取得
                // モデル名::where('条件をつけるカラム名' , '!=' , 条件) -> get();
                // 以下ではuser_idカラムにログイン中のid以外という条件を設けてデータを取得している。
        // $terms = Post::where('user_id','!=',auth()->id())->get();

            // 日付条件に合ったデータ取得(年：Year 月：Month 日にち：Day 時間：Time 等も可能)
                // モデル名::whereDate('条件をつけるカラム名' , '比較演算子' , 条件) -> get();
        // $terms = Post::whereDate('created_at','>','2025-06-25')->get();

            // ２つの値の間のデータ取得
                // モデル名::whereBetween('条件をつけるカラム名' , [値1 , 値2]) -> get();
        // $terms = Post::whereBetween('user_id',[1,2])->get();

            // 指定値のいずれかを含むデータ取得
                // モデル名::whereIn('条件をつけるカラム名' , [値1 , 値2]) -> get();
        // $terms = Post::whereIn('user_id',[1,3])->get();

            // 条件の組み合わせ
                // Post::条件指定 -> 条件指定 -> get();
        // $terms = Post::whereIn('user_id',[1,3])->whereTime('created_at','>','22:00')->get();

        // 【Eagerロード：N＋1問題の解決方法】
            // viewファイルでリレーションしたusersテーブルを参照するたびにアクセスが発生する問題（N＋1問題）の解決方法
            // リレーションしたUserモデルを介して予めusersテーブルのデータをpostsに加えて取得しておくことができます。
                // postsテーブルとusersテーブルの全てのデータを取得し、$posts変数に格納します。
                // 以下のコードだけで$posts = Post::all();で取得できるデータに加えてusersテーブルのデータも取得します。
        $posts = Post::with('user')->get();

                // 上記の条件でpostsテーブルとusersテーブルの全てのデータを対象に、一致するものを取得します。
                // 条件の組み合わせの応用で with('リレーション名')をget()の手前に加えるだけです。
        $terms = Post::whereIn('user_id',[1,3])->whereTime('created_at','>','22:00')->with('user')->get();

        // compact関数でviewファイルから変数を参照できるようにして、post/index.blade.phpを返す。
        return view('post.index',compact('posts','terms'));
    }

    // showメソッド
        // メソッドの第一引数にmodel名、第二引数に変数とすることにより、ルートモデルバインディング（または依存注入）
        // でリンクが押されたpostのid元にPostモデルを介してインスタンス生成し変数postに格納。
        // compact関数でviewファイルから変数を参照できるようにして、post/show.blade.phpを返す。
    public function show (Post $post) {
        return view('post.show',compact('post'));
    }
    // 引数をidの数字情報として受け取った場合は、idを元に手動でデータ取得、変数に格納します。
    // public function show ($id){
    //     $post=Post::find($id);
    //     return view('post.show',compact('post'));
    // }

    // editメソッド
    public function edit (Post $post){
        return view('post.edit',compact('post'));
    }

    // updateメソッド
    public function update(Request $request,Post $post){
        // バリデーション機能実装
            // リクエストデータからtitleとbodyを取得し、同時にvalidateメソッドを用いて各リクエストデータの
            // 入力条件を設定して$validate変数に格納します。
        $validated = $request->validate([
            'title'=> 'required|max:20',
            'body'=> 'required|max:400',
        ]);

        // リレーション機能
            // 更新したユーザーのidをusersテーブルから取得し、postsテーブルのuser_idカラムに渡す値として
            // $validated変数に追加格納します。
        $validated['user_id'] = auth()->id();

        // 
        $post->update($validated);

        // 更新が完了したら、元のページにリダイレクトします
        // リダイレクト時に、'message'というセッション変数に
        // '保存しました'というメッセージを設定します。
        return back()->with('message', '更新しました');
    }
}