<?php

namespace App\Traits;

use App\Exceptions\MissingAttributeException;

trait GeneratesUniqueNumber
{
    /**
     * @throws MissingAttributeException
     */
    public static function generateNumber(): string
    {
        $withYear = isset(static::$withYear) ? static::$withYear : true;

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

    private static function generateLastNumber($field): string
    {
        $lastNumber = static::max($field);

        if ($lastNumber === '') {
            $lastNumber = 0;
        } else {
            $lastFiveDigits = substr($lastNumber, -5);
            $lastFiveDigits = preg_replace('/[^0-9]/', '', $lastFiveDigits);
            $lastNumber = (int) $lastFiveDigits;
        }

        return str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
    }

    private static function hasField($field): bool
    {
        return in_array($field, (new static)->getFillable());
    }
}
