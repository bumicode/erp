<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'BUM;CODE');
        $this->migrator->add('general.site_active', true);
    }
};
