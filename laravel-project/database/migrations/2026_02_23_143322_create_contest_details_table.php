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
        Schema::create('contest_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('contest_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('joined_at')->useCurrent();
            $table->integer('final_steps')->default(0);
            $table->integer('final_rank')->nullable();
            $table->integer('reward_points')->default(0);
            $table->tinyInteger('status')->unsigned()->default(1)->comment('1: in_progress, 2: finished');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contest_details');
    }
};
