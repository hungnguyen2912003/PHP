<?php

namespace App\Services;

class HealthStatusService
{
    const LOW = 1;
    const NORMAL = 2;
    const HIGH = 3;

    public static function bmi(?float $bmi): ?int
    {
        if (!$bmi)
            return null;
        return $bmi < 18.5 ? self::LOW : ($bmi < 25 ? self::NORMAL : self::HIGH);
    }

    public static function height(?float $height): ?int
    {
        if (is_null($height))
            return null;

        return $height < 150
            ? self::LOW
            : ($height <= 185 ? self::NORMAL : self::HIGH);
    }

    public static function bodyFat(?float $bf, ?string $gender = null): ?int
    {
        if (!$bf)
            return null;

        if ($gender === 'male') {
            return $bf < 8 ? self::LOW : ($bf <= 20 ? self::NORMAL : self::HIGH);
        }

        if ($gender === 'female') {
            return $bf < 21 ? self::LOW : ($bf <= 33 ? self::NORMAL : self::HIGH);
        }

        // fallback nếu chưa có gender
        return $bf < 10 ? self::LOW : ($bf <= 25 ? self::NORMAL : self::HIGH);
    }

    public static function muscleMass(?float $muscle, ?float $weight): ?int
    {
        if (!$muscle || !$weight)
            return null;
        $ratio = $muscle / $weight;
        return $ratio < 0.35 ? self::LOW : ($ratio < 0.45 ? self::NORMAL : self::HIGH);
    }

    public static function skeletalMuscle(?float $percent): ?int
    {
        if (!$percent)
            return null;
        return $percent < 30 ? self::LOW : ($percent <= 40 ? self::NORMAL : self::HIGH);
    }

    public static function bodyWater(?float $water): ?int
    {
        if (!$water)
            return null;
        return $water < 50 ? self::LOW : ($water <= 65 ? self::NORMAL : self::HIGH);
    }

    public static function protein(?float $protein): ?int
    {
        if (!$protein)
            return null;
        return $protein < 16 ? self::LOW : ($protein <= 20 ? self::NORMAL : self::HIGH);
    }

    public static function boneMass(?float $bone, ?float $weight): ?int
    {
        if (!$bone || !$weight)
            return null;

        if ($weight < 50)
            return $bone < 2.0 ? self::LOW : ($bone <= 2.5 ? self::NORMAL : self::HIGH);
        if ($weight <= 75)
            return $bone < 2.5 ? self::LOW : ($bone <= 3.2 ? self::NORMAL : self::HIGH);
        return $bone < 3.0 ? self::LOW : ($bone <= 3.8 ? self::NORMAL : self::HIGH);
    }

    public static function visceralFat(?float $vf): ?int
    {
        if (!$vf)
            return null;
        return $vf <= 9 ? self::NORMAL : self::HIGH;
    }

    public static function subcutaneousFat(?float $sf): ?int
    {
        if (!$sf)
            return null;
        return $sf < 8 ? self::LOW : ($sf <= 18 ? self::NORMAL : self::HIGH);
    }

    public static function bmr(?float $bmr, ?string $gender = null): ?int
    {
        if (!$bmr)
            return null;

        if ($gender === 'male') {
            return $bmr < 1600 ? self::LOW : ($bmr <= 2000 ? self::NORMAL : self::HIGH);
        }

        if ($gender === 'female') {
            return $bmr < 1400 ? self::LOW : ($bmr <= 1800 ? self::NORMAL : self::HIGH);
        }

        return null;
    }

    public static function whr(?float $whr, ?string $gender = null): ?int
    {
        if (!$whr)
            return null;

        if ($gender === 'male') {
            return $whr < 0.9 ? self::NORMAL : self::HIGH;
        }

        if ($gender === 'female') {
            return $whr < 0.8 ? self::NORMAL : self::HIGH;
        }

        return null;
    }
}
