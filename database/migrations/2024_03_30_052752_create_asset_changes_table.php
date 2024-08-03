<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 資産更新時の種類を保持
     * 現状の資産から更新、追加、削除を選択
     * 同じ資産名を入力しなくてもいい
     * 現状は更新画面から入力できるように想定
     */
    public function up(): void
    {
        Schema::create('asset_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained()->comment('資産ID'); //asset_idの外部キー制約の付与
            $table->foreignId('user_id')->constrained()->comment('ユーザーID'); //user_idの外部キー制約の付与
            $table->tinyInteger('changed_type_flg')->nullable(false)->comment('更新の種類');
            $table->json('changed_fields')->nullable(false)->comment('更新のデータ');
            $table->date('changed_time')->useCurrent()->nullable(false)->comment('更新日時');
            $table->string('ip_address')->nullable(false)->comment('IPアドレス');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_changes');
    }
};
