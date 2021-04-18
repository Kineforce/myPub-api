<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        Client::truncate();
        $faker = \Faker\Factory::create();

        $gender = ['m', 'f'];

        for ($i = 0; $i < 500; $i++){
            Client::create([
                "name" => $faker->name,
                "cpf" => "123.123.123.12",  
                "gender" => $gender[array_rand([1, 2])],
                "phone_number" => $faker->phoneNumber,
                "adress" => $faker->address,
            ]);
        }


    }
}
