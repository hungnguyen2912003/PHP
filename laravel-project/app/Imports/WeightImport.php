<?php

namespace App\Imports;

use App\Models\Weight;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class WeightImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function model(array $row)
    {
        $recorded_at_raw = $row['recorded_at'];
        $recorded_at = null;

        if (is_numeric($recorded_at_raw)) {
            $recorded_at = Date::excelToDateTimeObject($recorded_at_raw);
            $recorded_at = Carbon::instance($recorded_at);
        } else {
            // Priority for d/m/Y H:i as seen in user's image
            try {
                $recorded_at = Carbon::createFromFormat('d/m/Y H:i', $recorded_at_raw);
            } catch (\Exception $e) {
                try {
                    $recorded_at = Carbon::createFromFormat('d/m/Y', $recorded_at_raw);
                } catch (\Exception $e2) {
                    $recorded_at = Carbon::parse($recorded_at_raw);
                }
            }
        }

        // Format to minute precision to ensure overwrite logic works as expected
        $recorded_at = $recorded_at->startOfMinute();

        // Handle comma as decimal separator
        $weight = $row['weight'];
        if (is_string($weight)) {
            $weight = str_replace(',', '.', $weight);
        }

        return Weight::updateOrCreate(
            [
                'user_id'     => $this->userId,
                'recorded_at' => $recorded_at,
            ],
            [
                'weight'      => $weight ?? 0,
            ]
        );
    }
}
