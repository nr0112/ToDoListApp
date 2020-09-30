<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToFolders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('folders', function (Blueprint $table) {
            // user_idカラムを追加　unsignedで符号なし属性を付与
            //migrateでエラーになったのでデフォルト値を1に設定(NULLにはできない)
            $table->integer('user_id')->unsigned()->default('1');

            // 外部キーを設定
            // user_idをusersテーブルのidに紐付け
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('folders', function (Blueprint $table) {
            // user_idカラムを削除する処理を記述
            $table->dropColumn('user_id');
        });
    }
}
