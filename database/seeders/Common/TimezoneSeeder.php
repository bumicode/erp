<?php

namespace Database\Seeders\Common;

use App\Models\Common\Timezone;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Database\Seeder;

class TimezoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws \Exception
     */
    public function run(): void
    {
        $timezones = DateTimeZone::listIdentifiers();

        foreach ($timezones as $timezone) {
            $date = Carbon::now(new DateTimeZone($timezone));
            $offset = $date->format('P');
            $offsetHours = $date->format('O');
            $offsetMinutes = $date->format('I');

            Timezone::create([
                'name' => $timezone,
                'offset' => $offset,
                'offset_hours' => $offsetHours,
                'offset_minutes' => $offsetMinutes,
            ]);
        }
    }
}
