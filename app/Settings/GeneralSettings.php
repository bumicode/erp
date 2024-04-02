<?php

namespace App\Settings;

use Illuminate\Support\Facades\Cache;
use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;

    public bool $site_active;

    public static function group(): string
    {
        return 'general';
    }

    public static function copyright(): string
    {
        $currentYear = date('Y');
        return ($currentYear == 2024) ? $currentYear : "$currentYear - " . ($currentYear + 1);
    }

    public static function getBrandName()
    {
        return Cache::rememberForever('app_name', function () {
            return (new \App\Settings\GeneralSettings)->site_name;
        });
    }
}
