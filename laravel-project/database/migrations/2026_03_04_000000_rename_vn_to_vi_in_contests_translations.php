<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Rename the "vn" locale key to "vi" (ISO 639-1) in the
     * translatable JSON columns of the contests table.
     */
    public function up(): void
    {
        $this->renameLocaleKey('vn', 'vi');
    }

    public function down(): void
    {
        $this->renameLocaleKey('vi', 'vn');
    }

    private function renameLocaleKey(string $from, string $to): void
    {
        $contests = DB::table('contests')->get(['id', 'name', 'description']);

        foreach ($contests as $contest) {
            $updates = [];

            foreach (['name', 'description'] as $column) {
                $json = json_decode($contest->$column, true);
                if (is_array($json) && array_key_exists($from, $json)) {
                    $json[$to] = $json[$from];
                    unset($json[$from]);
                    $updates[$column] = json_encode($json, JSON_UNESCAPED_UNICODE);
                }
            }

            if (!empty($updates)) {
                DB::table('contests')->where('id', $contest->id)->update($updates);
            }
        }
    }
};
