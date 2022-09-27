<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings        = new Settings();
        $settings->key   = 'overtime_method';
        $settings->value = 1;
        $settings->save();
    }
}
