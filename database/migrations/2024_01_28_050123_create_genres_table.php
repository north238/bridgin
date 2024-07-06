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
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false)->comment('ジャンル名');
            $table->foreignId('color_id')->constrained('m_chart_colors')->comment('カラーID');  // color_idの外部キー制約の付与
            $table->tinyInteger('risk_rank')->comment('リスクランク1:なし 2:あり 3:その他');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genres');
    }
};
