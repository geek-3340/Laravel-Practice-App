<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 認証済みのユーザーのみがアクセスできるルートを定義します。
// 'auth'ミドルウェアは、ユーザーがログインしているかどうかを確認し、
// ログインしていない場合はログインページにリダイレクトします
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 【動作フロー】以下のrouteについて
    // ブラウザからwebサーバーを介して、/postがリクエストされたときに
    // APサーバーで動作するこのrouteが呼び出されます。
    // このrouteは呼び出されたらPostControllerのindexメソッドを呼び出します
    // PostControllerのindexメソッドでは以下の処理を行います。
        // Postモデルを介して、postsテーブルのデータを全て取得し$posts変数に格納します。
        // compact関数で$postsをindex.blade.phpへ受け渡し参照できるようにします。
        // index.blade.phpを返す処理を行います。
    // 返り値のindex.blade.phpは、このrouteのgetメソッドでURL（/post）に紐づけられ
    // webサーバーに戻され、ブラウザに表示されます。
    Route::get('post',[PostController::class,'index']);
});


// 【ミドルウェアの設定】
// 複数のルートに同じミドルウェアを適用したい場合
// 構文
    // Route::middleware('ミドルウェア名','ミドルウェア名'…)->group(function(){
    //     Route~
    //     Route^
    // });
Route::middleware('auth','admin')->group(function () {

// 【動作フロー】以下のrouteについて
    // ブラウザからwebサーバーを介して、/post/createがリクエストされたときに
    // APサーバーで動作するこのrouteが呼び出されます。
    // このrouteは呼び出されたらPostControllerのcreateメソッドを呼び出します
    // PostControllerのcreateメソッドでは、create.blade.phpを返す処理を行います。
    // 返り値のcreate.blade.phpは、このrouteのgetメソッドでURL（/post/create）に紐づけられ
    // webサーバーに戻され、ブラウザに表示されます。
// 【補足】
    // create.blade.phpはapp.blade.phpをテンプレートとして使用しており、その中でinclude
    // しているnavigation.blade.phpにはuserの名前を表示するためのコードが含まれています。
    // そのため、ユーザーがログインしていないと、userの値がnullになり、
    // navigation.blade.phpのuserの名前を表示する部分でエラーが発生してしまいます。
    // これを防ぐために、上記のミドルウェア定義領域内にルートを定義しました。
Route::get('/post/create', [PostController::class, 'create']);
// 特定のルートにのみミドルウェアを適用する場合は以下のような記述でも良い
// Route::get('/post/create', [PostController::class, 'create'])->middleware('auth','admin');

// 【動作フロー】以下のrouteについて
        // create.blade.php内のフォームにてデータが送信された際、ブラウザからwebサーバーを介して
        // formのactionで指定されたルート名(post.store)がURL（/post）に変換されてリクエストされ
        // APサーバーで動作するこのrouteが呼び出されます。また、method属性でPOSTが指定されているため
        // このrouteのメソッドはPOSTである必要があります。
        // このrouteは呼び出されたらPostControllerのstoreメソッドを呼び出します
        // PostControllerのstoreメソッドでは、以下の処理を行います。
            // 1. リクエストからtitleとbodyを取得し、Postモデルのcreateメソッドを使用して新しいレコードを作成
            //    同時にPostモデルを介してレコードをDBサーバーに保存します。
            // 2. 作成したレコードを$post変数に格納します。
            //    保存したレコード（モデルインスタンス）を$post変数に格納することは、後の処理で使用するためのものです。
            // 3. 保存が完了したら、元のページにリダイレクトします。
            // 4. リダイレクト時に、'message'というセッション変数に'保存しました'というメッセージを設定します。
        // リダイレクトされたcreate.blade.phpにてセッション変数' message'が存在する場合、
        // そのメッセージを表示する処理が行われます。
        // メッセージを反映したcreate.blade.phpがwebサーバーに戻され、ブラウザに表示されます。
Route::post('post', [PostController::class, 'store'])->name('post.store');
}); 

require __DIR__.'/auth.php';
