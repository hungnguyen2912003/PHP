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
        Schema::table('user_steps', function (Blueprint $table) {
            $table->unique(['user_id', 'device_source', 'recorded_at'], 'user_device_record_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_steps', function (Blueprint $table) {
            $table->dropUnique('user_device_record_unique');
        });
    }
};
