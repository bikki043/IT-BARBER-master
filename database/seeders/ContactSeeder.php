<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    \App\Models\Contact::create([
        'address' => '123 หมู่ 1 ต.ในเมือง จ.บุรีรัมย์',
        'phone' => '098-478-4512',
        'line_id' => '@IT-BARBER',
        'facebook' => 'https://facebook.com/itbarber',
        'google_map_iframe' => '<iframe src="..."></iframe>'
    ]);
}
}
