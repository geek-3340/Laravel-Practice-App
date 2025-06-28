<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // この領域にミドルウェアを設定

        // ログイン中のユーザーのroleがadminであればリクエストを実行する
        if(auth()->user()->role == 'admin'){
            return $next($request);
        }

        // 上記の条件に合わない場合、dashboardルートにリダイレクトする
        return redirect()->route('dashboard');
    }
}
