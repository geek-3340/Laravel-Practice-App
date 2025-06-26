<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // postsテーブル内のtitle・body・user_idカラムをfillableに設定
    // fillableプロパティは、値を一括保存・削除したいカラムを指定します。
    // ここに設定されたカラム以外は、処理の対象外となります。
    // これにより、Mass Assignment（大量割り当て）攻撃を防ぐことができます。
    protected $fillable = [
        'title',
        'body',
        'user_id',

    // その他のプロパティとしてguardedを使用することもできます。
    // guardedプロパティは、値を一括保存・削除したくないカラムを指定します。
    // ここに設定されたカラム以外を一括保存・削除の対象とします。
    // guardedは、fillableの逆の意味を持ちます。
    ];

    // Userモデルを介してusersテーブルの唯一のレコードとリレーション
    public function user(){
        return $this -> belongsTo(User::class);
    }
    // 「リレーション用の他テーブルのidを格納するカラム（外部キー）」は
    //  1対多リレーションの場合は「多側（posts）」に必要です。
    //      例：postsテーブルのuser_idカラム（usersテーブルのidを参照）
    // 「1側（users）」には、外部キー（他テーブルのid）は不要です。
    // 「多側（posts）」にだけ、リレーション用のid（user_idなど）を持たせるのが
    //  ベストプラクティスです。
}