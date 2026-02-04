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
        $recorded_at = $row['recorded_at'];
        
        if (is_numeric($recorded_at)) {
            $recorded_at = Date::excelToDateTimeObject($recorded_at);
            $recorded_at = Carbon::instance($recorded_at);
        } else {
            $recorded_at = Carbon::parse($recorded_at);
        }

        // Format to minute precision to ensure overwrite logic works as expected
        $recorded_at = $recorded_at->startOfMinute();

        return Weight::updateOrCreate(
            [
                'user_id'     => $this->userId,
                'recorded_at' => $recorded_at,
            ],
            [
                'weight'      => $row['weight'],
            ]
        );
    }
}
