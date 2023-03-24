<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
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
                'title_ar' => 'القاهره',
                'title_en' => 'cairo',
                'shipping_cost' => 50,
            ],
            [
                'id' => 2,
                'title_ar' => 'الاسكندرية',
                'title_en' => 'alexandria',
                'shipping_cost' => 120,
            ],
        ];
        foreach ($data as $row){
            Country::updateOrCreate($row);
        }
    }
}
