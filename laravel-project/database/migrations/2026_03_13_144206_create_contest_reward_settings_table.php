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
        Schema::create('contest_rewards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('contest_id')->constrained()->onDelete('cascade');
            $table->integer('rank');
            $table->double('reward_percent');
            $table->timestamps();
            
            $table->unique(['contest_id', 'rank']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('contest_reward_settings');
        Schema::enableForeignKeyConstraints();
    }
};
