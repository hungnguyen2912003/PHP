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
            $table->uuid('id')->primary();
            $table->tinyInteger('role')->unsigned()->default(3)->comment('1: admin, 2: staff, 3: user');
            $table->string('fullname');
            $table->date('date_of_birth')->nullable();
            $table->tinyInteger('gender')->unsigned()->nullable()->comment('1: male, 2: female');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('address')->nullable();
            $table->text('bio')->nullable()->max(255);
            $table->string('username')->unique();
            $table->string('password');
            $table->string('google_id')->nullable();
            $table->string('activation_token')->nullable();
            $table->timestamp('activation_token_sent_at')->nullable();
            $table->tinyInteger('status')->unsigned()->default(1)->comment('1: pending, 2: active, 3: banned');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
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
