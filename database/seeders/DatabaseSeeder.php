<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::truncate();
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++){
            User::create([
                'username' => $faker->username,
                'email'  => $faker->email,
                'password' => Hash::make('pwdpwd')
            ]);
        }


    }
}
