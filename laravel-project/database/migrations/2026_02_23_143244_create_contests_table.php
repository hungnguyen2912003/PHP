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
        Schema::create('contests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->json('name');
            $table->tinyInteger('type')->default(0);
            $table->string('image_url')->nullable();
            $table->json('description')->nullable();
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->integer('target')->default(0);
            $table->integer('reward_points')->default(0);
            $table->integer('win_limit')->default(0);
            $table->tinyInteger('status')->default(1)->comment('1: inprogress, 2: completed, 3: cancelled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contests');
    }
};
