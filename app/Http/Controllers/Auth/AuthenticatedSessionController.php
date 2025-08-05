<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 入力されたメールアドレスとパスワードを使用してユーザーを認証します。
        $request->authenticate();

        // 認証が成功した場合、セッションを開始します。
        // これにより、ユーザーのログイン状態が維持されます。
        // ログインする度にセッションを再生成することにより、セッションハイジャック攻撃を防ぎます。
        $request->session()->regenerate();

        // return redirect()->intended(route('dashboard', absolute: false));

        // 2FA
        // メールアドレス・パスワード認証後のユーザー取得
        $user = Auth::user();
        // それに対しUSERモデルを取得し2要素認証のPINコードを生成してメール送信するgenerateTwoFactorCodeメソッドを呼び出します。
        $user->generateTwoFactorCode(); 

        // その後、pinコードの入力を促すverify-pinルートへリダイレクトします。
        return redirect()->route('verify.pin');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
