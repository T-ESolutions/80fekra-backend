<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
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
                'title_ar' => 'الشروط والاحكام',
                'title_en' => 'terms and conditions',
                'body_ar' => 'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم مطبوعه … بروشور او فلاير على سبيل المثال … او نماذج مواقع انترنت',
                'body_en' => 'Lorem Ipsum is a virtual model that is placed in the designs to be presented to the client to imagine the way to put texts in the designs, whether they are printed designs ... a brochure or flyer for example ... or models for websites',
                'image' => '1.png',
            ],
            [
                'title_ar' => 'سياسة الخصوصية',
                'title_en' => 'privacy policy',
                'body_ar' => 'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم مطبوعه … بروشور او فلاير على سبيل المثال … او نماذج مواقع انترنت',
                'body_en' => 'Lorem Ipsum is a virtual model that is placed in the designs to be presented to the client to imagine the way to put texts in the designs, whether they are printed designs ... a brochure or flyer for example ... or models for websites',
                'image' => '2.png',
            ],
            [
                'title_ar' => 'عن التطبيق',
                'title_en' => 'about application',
                'body_ar' => 'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم مطبوعه … بروشور او فلاير على سبيل المثال … او نماذج مواقع انترنت',
                'body_en' => 'Lorem Ipsum is a virtual model that is placed in the designs to be presented to the client to imagine the way to put texts in the designs, whether they are printed designs ... a brochure or flyer for example ... or models for websites',
                'image' => '3.png',
            ],

        ];
        foreach ($data as $get) {
            Page::updateOrCreate($get);
        }
    }
}
