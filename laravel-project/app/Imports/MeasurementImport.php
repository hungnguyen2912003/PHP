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
        $recorded_at_raw = $row[0] ?? null; // Column A
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
                    try {
                        $recorded_at = Carbon::parse($recorded_at_raw);
                    } catch (\Exception $e3) {
                        return null;
                    }
                }
            }
        }

        // Format to minute precision
        $recorded_at = $recorded_at->startOfMinute();

        // Helper to parse decimal values from Excel row
        $parseDecimal = function ($value) {
            if (is_null($value) || $value === '' || $value === '-')
                return null;
            if (is_string($value)) {
                $value = str_replace(',', '.', $value);
            }
            return (float) $value;
        };

        $weight = $parseDecimal($row[1] ?? null);
        $height = $parseDecimal($row[2] ?? null);
        $bmi = $parseDecimal($row[3] ?? null);
        $body_fat = $parseDecimal($row[4] ?? null);
        $fat_free_body_weight = $parseDecimal($row[5] ?? null);
        $muscle_mass = $parseDecimal($row[6] ?? null);
        $skeletal_muscle_mass = $parseDecimal($row[7] ?? null);
        $subcutaneous_fat = $parseDecimal($row[8] ?? null);
        $visceral_fat = $parseDecimal($row[9] ?? null);
        $body_water = $parseDecimal($row[10] ?? null);
        $protein = $parseDecimal($row[11] ?? null);
        $bone_mass = $parseDecimal($row[12] ?? null);
        $bmr = $parseDecimal($row[13] ?? null);
        $waist = $parseDecimal($row[14] ?? null);
        $hip = $parseDecimal($row[15] ?? null);
        $whr = $parseDecimal($row[16] ?? null);

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
                'user_id' => $this->userId,
                'recorded_at' => $recorded_at,
            ],
            [
                'weight' => $weight,
                'height' => $height,
                'bmi' => $bmi,
                'body_fat' => $body_fat,
                'fat_free_body_weight' => $fat_free_body_weight,
                'muscle_mass' => $muscle_mass,
                'skeletal_muscle_mass' => $skeletal_muscle_mass,
                'subcutaneous_fat' => $subcutaneous_fat,
                'visceral_fat' => $visceral_fat,
                'body_water' => $body_water,
                'protein' => $protein,
                'bone_mass' => $bone_mass,
                'bmr' => $bmr,
                'waist' => $waist,
                'hip' => $hip,
                'whr' => $whr,
            ]
        );
    }
}
