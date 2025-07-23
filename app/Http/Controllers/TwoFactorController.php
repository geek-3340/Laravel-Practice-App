<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    public function show()
    {
        return view('auth.verify-pin');
    }

    public function verify(Request $request)
    {
        // 入力された2FAコードの検証
        // 6桁の数字であることを確認します。
        $request->validate([
            'two_factor_code' => 'required|digits:6',
        ]);

        // メールアドレス・パスワード認証後のユーザー取得
        $user = Auth::user();

        // リクエストされた2FAコードの検証
        // ユーザーの2FAコードと入力されたコードが異なる場合、エラーを返します。
        if ($user->two_factor_code !== $request->two_factor_code) {
            return back()->withErrors(['two_factor_code' => 'コードが間違っています。']);
        }

        // 2FAコードの有効期限を確認
        // もし現在の時刻が2FAコードの有効期限を過ぎている場合、エラーを返します。
        if (now()->gt($user->two_factor_expires_at)) {
            return back()->withErrors(['two_factor_code' => 'コードの有効期限が切れています。']);
        }

        // 認証が成功した場合、各カラムをクリアし、モデルのインスタンスを更新します。
        // これにより、次回のログイン時に新しい2FAコードが生成されます。
        $user->two_factor_code = null;
        $user->two_factor_expires_at = null;
        $user->save();

        // セッションに2FA認証済みのフラグを設定します。
        // これにより、ユーザーが2FA認証を完了したことが記録されます。
        session(['two_factor_authenticated' => true]);

        // 2FA認証が成功した後、ユーザーをダッシュボードにリダイレクトします。
        return redirect()->intended('/dashboard');
    }
}
