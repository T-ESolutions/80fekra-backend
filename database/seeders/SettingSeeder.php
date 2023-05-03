<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'key' => 'site_name_ar',
                'value' => '80 فكرة',
                'image' => null,
            ],
            [
                'id' => 2,
                'key' => 'site_name_en',
                'value' => '80 Fekra',
                'image' => null,
            ],
            [
                'id' => 3,
                'key' => 'phone',
                'value' => '01201636129',
                'image' => null,
            ],
            [
                'id' => 4,
                'key' => 'email',
                'value' => 'info@80fekra.com',
                'image' => null,
            ],
            [
                'id' => 5,
                'key' => 'logo_ar',
                'value' => null,
                'image' => 'logo_ar.png',
            ],
            [
                'id' => 6,
                'key' => 'logo_en',
                'value' => null,
                'image' => 'logo_en.png',
            ],
            [
                'id' => 7,
                'key' => 'address_ar',
                'value' => '15 شارع خالد اباظة - القاهرة',
                'image' => null,
            ],
            [
                'id' => 8,
                'key' => 'address_en',
                'value' => 'cairo',
                'image' => null,
            ],
            [
                'id' => 9,
                'key' => 'facebook',
                'value' => 'https://www.facebook.com/',
                'image' => null,
            ],
            [
                'id' => 10,
                'key' => 'youtube',
                'value' => 'https://www.youtube.com/',
                'image' => null,
            ],
            [
                'id' => 11,
                'key' => 'instagram',
                'value' => 'https://www.instagram.com/',
                'image' => null,
            ],
            [
                'id' => 12,
                'key' => 'twitter',
                'value' => 'https://www.twitter.com/',
                'image' => null,
            ],
            [
                'id' => 13,
                'key' => 'footer_text_ar',
                'value' => 'منظومة تعليمية تعمل على تربية طفلك',
                'image' => null,
            ],
            [
                'id' => 14,
                'key' => 'footer_text_en',
                'value' => 'An educational system that works to raise your child',
                'image' => null,
            ],
            [
                'id' => 15,
                'key' => 'all_category_image',
                'value' => null,
                'image' => 'all_category_image.png',
            ],
            [
                'id' => 16,
                'key' => 'footer_image',
                'value' => null,
                'image' => 'footer_image.png',
            ],
        ];
        foreach ($data as $row) {
            Setting::updateOrCreate($row);
        }
    }
}
