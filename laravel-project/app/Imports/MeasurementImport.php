<?php

namespace App\Imports;

use App\Models\Measurement;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class MeasurementImport implements ToModel, WithStartRow, SkipsEmptyRows
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $recorded_at_raw = $row[0] ?? null;
        if (!$recorded_at_raw) {
            return null;
        }

        $recorded_at = null;
        if (is_numeric($recorded_at_raw)) {
            $recorded_at = Date::excelToDateTimeObject($recorded_at_raw);
            $recorded_at = Carbon::instance($recorded_at);
        } else {
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

        // Format to minute precision
        $recorded_at = $recorded_at->startOfMinute();

        // Handle height (Column B)
        $height = $row[1] ?? 0;
        if (is_string($height)) {
            $height = (float) str_replace(',', '.', $height);
        }

        // Handle weight (Column C)
        $weight = $row[2] ?? 0;
        if (is_string($weight)) {
            $weight = (float) str_replace(',', '.', $weight);
        }

        // Handle bmi (Column D)
        $bmi = $row[3] ?? null;
        if (is_string($bmi)) {
            $bmi = (float) str_replace(',', '.', $bmi);
        }

        // Handle body_fat (Column E)
        $body_fat = $row[4] ?? null;
        if (is_string($body_fat)) {
            $body_fat = (float) str_replace(',', '.', $body_fat);
        }

        // Handle fat_free_body_weight (Column F)
        $fat_free_body_weight = $row[5] ?? null;
        if (is_string($fat_free_body_weight)) {
            $fat_free_body_weight = (float) str_replace(',', '.', $fat_free_body_weight);
        }

        // Check for existing records for the same user and timestamp
        $query = Measurement::where('user_id', $this->userId)
            ->where('recorded_at', $recorded_at);

        $existingRecords = $query->get();

        if ($existingRecords->count() > 1) {
            // Consolidate: delete all but the first one
            $first = $existingRecords->first();
            $otherIds = $existingRecords->pluck('id')->reject(fn($id) => $id === $first->id);
            Measurement::whereIn('id', $otherIds)->delete();
        }

        return Measurement::updateOrCreate(
            [
                'user_id'     => $this->userId,
                'recorded_at' => $recorded_at,
            ],
            [
                'weight' => $weight,
                'height' => $height,
                'bmi' => $bmi,
                'body_fat' => $body_fat,
                'fat_free_body_weight' => $fat_free_body_weight,
            ]
        );
    }
}
