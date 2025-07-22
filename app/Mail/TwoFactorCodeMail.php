<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class TwoFactorCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    // 2FA
    public function __construct(public User $user) {}

    public function build()
    {
        return $this->subject('あなたの認証コード')
                    ->view('emails.two_factor_code');
    }
}
