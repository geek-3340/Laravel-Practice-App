<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // リレーション先の主キーを参照するためのuser_idカラムを追加
            // リレーション用に他カラムのid情報を入れるカラムはforeignIdというデータ型を用いる
            // 「リレーション用の他テーブルのidを格納するカラム（外部キー）」は
            //  1対多リレーションの場合は「多側（posts）」に必要です。
            //      例：postsテーブルのuser_idカラム（usersテーブルのidを参照）
            // 「1側（users）」には、外部キー（他テーブルのid）は不要です。
            // 「多側（posts）」にだけ、リレーション用のid（user_idなど）を持たせるのが
            //  ベストプラクティスです。
            $table->foreignId('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // dropColumn(削除するカラム名)でカラムを削除できる。
            $table->dropColumn('user_id');
        });
    }
};