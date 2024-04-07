<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Schema;

trait SelectableOptions
{
    public static function getAllData(): array
    {
        return self::all()->pluck('name', 'id')->toArray();
    }

    public static function getAllDataWithoutGroup(): array
    {
        if (! static::hasIsGroupColumn()) {
            throw new ModelNotFoundException("Model must have 'is_group' column.");
        }

        return self::where('is_group', false)->pluck('name', 'id')->toArray();
    }

    protected static function hasIsGroupColumn(): bool
    {
        return Schema::hasColumn((new static)->getTable(), 'is_group');
    }
}
