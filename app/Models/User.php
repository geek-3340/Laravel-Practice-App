<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// 2FA
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCodeMail;

class User extends Authenticatable 
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Postモデルを介してpostsテーブルの複数のレコードとリレーション
    public function posts(){
        return $this -> hasMany(Post::class);
    }

    // 2FA
    public function generateTwoFactorCode()
    {
        // 100000~999999のランダムな数字をtwo_factor_codeカラムに保存
        $this->two_factor_code = random_int(100000, 999999);
        // 2FAコードの有効期限をメソッド呼び出し時点から10分後に設定しカラムに保存
        $this->two_factor_expires_at = now()->addMinutes(10);
        // モデルのインスタンス更新を保存
        $this->save();

        // TwoFactorCodeMailに基づいてメールを送信
        Mail::to($this->email)->send(new TwoFactorCodeMail($this));
    }
}
