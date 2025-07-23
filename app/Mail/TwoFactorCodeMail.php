<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

// 2FA
class TwoFactorCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    // メール送信時に必要なユーザーモデルを受け取る
    // これにより、メール内でユーザーの情報を使用できるようになります。
    public function __construct(public User $user) {}

    // メールのビルドメソッド
    // このメソッドは、メールの内容を定義します。
    public function build()
    {
        // メールの件名を設定し、メールビューをリクエストします。
        return $this->subject('あなたの認証コード')
                    ->view('emails.two_factor_code');
    }
}
