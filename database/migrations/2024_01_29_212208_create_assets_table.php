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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->comment('カテゴリID'); //カテゴリーidの外部キー制約の付与
            $table->foreignId('user_id')->constrained()->comment('ユーザーID'); //カテゴリーidの外部キー制約の付与
            $table->string('name')->nullable(false)->comment('口座名'); //nullを許容しない
            $table->integer('amount')->nullable(false)->comment('資産額');
            $table->date('registration_date')->comment('登録日');
            $table->tinyInteger('asset_type_flg')->nullable(false)->comment('資産の種類');
            $table->text('memo')->nullable()->comment('資産情報');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
            $table->softDeletes();

            // user_id, name, registration_date の組み合わせにユニーク制約を追加
            $table->unique(['user_id', 'name', 'registration_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
