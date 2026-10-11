<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\AboutSetting::create([
        'hero_title' => 'THE LEGACY',
        'story_description' => 'At IT BARBER, we believe that grooming is more than just a haircut...',
        'stat_years' => '5+',
        'stat_cuts' => '25k+',
        'stat_satisfaction' => '100%',
    ]);
}
}
