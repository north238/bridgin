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
        Schema::create('asset_switch_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->comment('ユーザーID');         // user_idの外部キー制約の付与
            $table->tinyInteger('asset_type_status')->comment('0: 表示, 1: 非表示');    // ユーザーが選択した状態を管理
            $table->tinyInteger('debut_status')->comment('0: 表示, 1: 非表示');         // ユーザーが選択した状態を管理
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_switch_statuses');
    }
};
