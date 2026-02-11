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
            $table->enum('role', ['admin', 'staff', 'user'])->default('user');
            $table->string('fullname');
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
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
            $table->enum('status', ['pending', 'active', 'banned'])->default('pending');
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
