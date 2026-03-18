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
        Schema::table('user_contests', function (Blueprint $table) {
            $table->tinyInteger('device_source')->nullable()->after('total_steps');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_contests', function (Blueprint $table) {
            $table->dropColumn('device_source');
        });
    }
};
