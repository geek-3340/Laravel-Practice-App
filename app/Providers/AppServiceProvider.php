<?php

namespace App\Providers;

// use宣言は以下のものを使用
use App\Models\User;
use Illuminate\Support\Facades\Gate;
// 以下はデフォルト
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gateを使ったアクセス制限
        // middlewareと同様の制限処理が可能
        // 【構文】
            // Gate::define('Gate名',function(モデル名 メソッド変数){
            //     if(条件){
            //         return true;
            //     }
            //     return false;
            // });
        
        // ユーザーの主キーが1であればroute,view,controllerの処理を許可
        // それ以外であればエラー画面となり403(動作未許可)のレスポンスコードが表示される
        Gate::define('test',function(User $user){
            if($user->id===1){
                return true;
            }
            return false;
        });

        // 【routeへの適用】
        // routeの後ろに->middleware('can:Gate名');
        // 例 Route::get('post',[PostController::class,'index'])->middleware('can:test');


        // 【viewへの適用】
        // @can('Gate名')
        //     Gateの制御で表示を切り替えたい要素
        // endcan
        

        // 【Controllerへの適用】
        // use宣言追加 use Illuminate\Support\Facades\Gate;
        // メソッド内の最初にGate::authorize('Gate名');

        // 例 : test Gateでの制限を通った場合のみ、投稿を保存出来る
        // use Illuminate\Support\Facades\Gate;
        // (省略)
        // public function store(Request $request){

        // Gate::authorize('test');

        // $validated = $request->validate([
        //     'title'=> 'required|max:20',
        //     'body'=> 'required|max:400',
        // ]);

        // $validated['user_id'] = auth()->id();

        // $post = Post::create($validated);

        // return back()->with('message', '保存しました');
        // }
    }
}
