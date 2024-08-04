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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('タイトル');
            $table->text('body')->comment('本文');
            $table->string('type')->nullable()->comment('通知の種類');
            $table->dateTime('expires_at')->nullable()->comment('通知の期限');
            $table->integer('priority')->default(0)->comment('通知の優先度');
            $table->json('metadata')->nullable()->comment('追加のメタデータ');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
