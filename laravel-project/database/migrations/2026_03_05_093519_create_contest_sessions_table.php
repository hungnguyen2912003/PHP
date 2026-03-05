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
        Schema::create('contest_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('contest_detail_id')->constrained()->cascadeOnDelete();
            $table->timestamp('start_time');
            $table->timestamp('stop_time');
            $table->integer('total_steps')->default(0);
            $table->timestamp('goal_reached_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contest_sessions');
    }
};
