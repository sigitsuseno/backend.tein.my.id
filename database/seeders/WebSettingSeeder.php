<?php

namespace Database\Seeders;

use App\Models\WebSetting;
use Illuminate\Database\Seeder;

class WebSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $webSetting = [
            ['name' => 'nama_app', 'isi' => 'Isian Formulir'],
            // ['name' => 'logo', 'isi' => '/assets/logo.png'],
        ];

        foreach ($webSetting as $setting) {
            WebSetting::updateOrCreate(
                ['name' => $setting['name']],
                ['isi' => $setting['isi']]
            );
        }
    }
}
