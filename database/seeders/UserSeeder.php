<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::find(1)) {
            User::updateOrCreate([
                'id' => 1,
                'f_name' => 'admin',
                'l_name' => 'admin',
                'phone' => '900000000',
                'email' => 'admin@admin.com',
                'email_verified_at' => \Carbon\Carbon::now(),
                'password' => encrypt("123456"),
                'type' => 'admin',
                'country_id' => 1,
            ]);
        }
    }
}
