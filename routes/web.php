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
    // post\createがリクエストされたときに
    // PostControllerのcreateメソッドを呼び出すルート
    Route::get('/post/create', [PostController::class, 'create']);
});

// PostControllerのcreateメソッドでは、create.blade.phpを表示する処理を行います。
// create.blade.phpはapp.blade.phpをテンプレートとして使用しており、その中でinclude
// しているnavigation.blade.phpにはuserの名前を表示するためのコードが含まれています。
// そのため、ユーザーがログインしていないと、userの値がnullになり、
// navigation.blade.phpのuserの名前を表示する部分でエラーが発生してしまいます。
// これを防ぐために、上記のミドルウェア定義領域内にルートを定義しました。


// 
Route::post('post', [PostController::class, 'store'])->name('post.store');

require __DIR__.'/auth.php';
