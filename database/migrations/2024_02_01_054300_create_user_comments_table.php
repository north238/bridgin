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
        // ユーザーIDとコメントIDとの中間テーブル
        Schema::create('user_comments', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->comment('ユーザーID'); //ユーザーidの外部キー制約の付与
            $table->foreignId('comment_id')->nullable()->constrained('comments')->comment('コメントID,NULLを受け入れる'); //コメントidの外部キー制約の付与
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_comments');
    }
};
