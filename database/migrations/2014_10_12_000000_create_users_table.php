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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('provider')->nullable()->comment('認証プロバイダ名');
            $table->string('provider_id')->nullable()->comment('認証プロバイダID');
            $table->string('provider_token')->nullable()->comment('認証トークン');
            $table->string('provider_refresh_token')->nullable()->comment('認証リフレッシュトークン');
            $table->dateTime('email_verified_at')->nullable();
            $table->rememberToken();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
