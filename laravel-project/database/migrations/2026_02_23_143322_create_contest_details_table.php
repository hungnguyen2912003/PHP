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
            $table->integer('total_steps')->default(0);
            $table->tinyInteger('device_type')->default(0);
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1: incompleted, 2: completed, 3: cancelled');
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
