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
            $table->foreignUuid('role_id')->constrained('roles')->onDelete('cascade');
            $table->string('name')->unique();
            $table->date('birth_date')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->string('address')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('google_id')->nullable();
            $table->string('activation_token')->nullable();
            $table->timestamp('activation_token_sent_at')->nullable();
            $table->enum('status', ['pending', 'active', 'banned', 'deleted'])->default('pending');
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
