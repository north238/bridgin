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
        // リスクIDとジャンルIDとの中間テーブル
        Schema::create('genres_risks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risk_id')->constrained()->comment('リスクID'); //リスクidの外部キー制約の付与
            $table->foreignId('genre_id')->constrained()->comment('ジャンルID'); //ジャンルidの外部キー制約の付与
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genres_risks');
    }
};
