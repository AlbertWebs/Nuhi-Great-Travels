<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            'url' => 'https://nuhigreattravels.com',
            'logo' => 'images/logo.png',
            'favicon' => 'images/favicon.ico',
            'shape' => 'images/shape.png',
            'email' => 'info@nuhigreattravels.com',
            'mobile' => '+254700000000',
            'location' => 'Nairobi, Kenya',
            'facebook' => 'https://facebook.com/nuhigreattravels',
            'instagram' => 'https://instagram.com/nuhigreattravels',
            'tiktok' => 'https://tiktok.com/@nuhigreattravels',
            'twitter' => 'https://twitter.com/nuhigreattravels',
            'youtube' => 'https://youtube.com/@nuhigreattravels',
            'map_iframe' => '<iframe src="YOUR_GOOGLE_MAPS_IFRAME_HERE"></iframe>',
            'linkedin' => 'https://linkedin.com/company/nuhigreattravels',
            'tawkto' => 'https://tawk.to/chat/YOUR_TAWKTO_ID',
            'whatsapp' => 'https://wa.me/254700000000',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
