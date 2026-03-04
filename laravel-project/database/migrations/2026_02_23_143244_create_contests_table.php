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
            $table->tinyInteger('type')->default(1)->comment('1: walking, 2: running, 3: sprint');
            $table->string('image_url')->nullable();
            $table->json('description')->nullable();
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->timestamp('calculate_at');
            $table->integer('target')->default(1);
            $table->tinyInteger('unit')->default(1)->comment('1: steps, 2: km, 3: meters');
            $table->integer('reward_points')->default(0);
            $table->integer('win_limit')->default(0);
            $table->tinyInteger('status')->default(1)->comment('1: inprogress, 2: completed, 3: finalized');
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
