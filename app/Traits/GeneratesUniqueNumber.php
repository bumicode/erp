<?php

namespace App\Traits;

use App\Exceptions\MissingAttributeException;

trait GeneratesUniqueNumber
{
    /**
     * Generate a unique number
     * @throws MissingAttributeException
     */
    public static function generateNumber(): string
    {
        $withYear = static::$withYear ?? true;

        if (! isset(static::$numberPrefix) || ! isset(static::$numberField)) {
            throw new MissingAttributeException('numberPrefix or numberField');
        }

        $field = static::$numberField;
        if (! static::hasField($field)) {
            throw new \InvalidArgumentException("Field '$field' does not exist in the model.");
        }

        $prefix = static::$numberPrefix;
        $year = $withYear ? date('Y') : '';
        $lastNumber = static::generateLastNumber($field);

        if ($withYear) {
            return "$prefix-$year-$lastNumber";
        } else {
            return "$prefix-$lastNumber";
        }
    }

    /**
     * Get the last number in the database
     */
    private static function generateLastNumber($field): string
    {
        $lastNumber = static::max($field);

        if ($lastNumber === '') {
            $lastNumber = 0;
        } else {
            $lastFiveDigits = substr($lastNumber, -5);
            $lastFiveDigits = preg_replace('/\D/', '', $lastFiveDigits);
            $lastNumber = (int) $lastFiveDigits;
        }

        // Check for duplicates
        $counter = 0;
        $newNumber = $lastNumber + 1;
        while (static::where($field, $newNumber)->exists()) {
            $newNumber = $lastNumber + ++$counter;
        }

        return str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Check if the field exists in the model
     */
    private static function hasField($field): bool
    {
        return in_array($field, (new static)->getFillable());
    }
}
