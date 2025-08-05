<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureTwoFactorCodeIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        // ユーザーが認証されているか確認します。
        if (Auth::check()) {
            // 認証されている場合、ユーザーの情報を取得します。
            $user = Auth::user();

            // 2FAコード認証が必要な場合の処理、認証済みであれば次のリクエストへ進みます。
            if (!$request->session()->get('two_factor_authenticated') && // PINコードが認証されていない（trueでない）場合
                !$request->is('verify-pin') // 現在のリクエストがPINコードの検証ページでない場合
                ) {
                // 2FAコードの検証ページへリダイレクトします。
                return redirect()->route('verify.pin');
            }
        }
        // 2FAコードの検証が必要ない、またはすでに認証済みの場合は、次のリクエストへ進みます。
        return $next($request);
    }
}
