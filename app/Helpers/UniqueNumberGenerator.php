<?php

namespace App\Helpers;

class UniqueNumberGenerator
{
    private static function generateLastNumber($model, $field): string
    {
        $lastNumber = $model::max($field);

        if ($lastNumber === '') {
            $lastNumber = 0;
        } else {
            $lastFiveDigits = substr($lastNumber, -5); // Extract last 5 characters
            $lastFiveDigits = preg_replace('/[^0-9]/', '', $lastFiveDigits); // Remove non-numeric characters
            $lastNumber = (int) $lastFiveDigits;
        }

        return str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
    }

    public static function generateStockEntryNumber($prefix, $model, $field): string
    {
        $year = date('Y');
        $randomString = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 2);
        $lastNumber = self::generateLastNumber($model, $field);
        return "STE-$year-$lastNumber";
    }
}
