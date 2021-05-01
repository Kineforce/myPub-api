<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use App\Models\Action;
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
        $faker = \Faker\Factory::create();
        
        Client::truncate();

        $gender = ['m', 'f'];

        for ($i = 0; $i < 50; $i++){
            Client::create([    
                "name" => $faker->name,
                "cpf" => "123.123.123.12",  
                "gender" => $gender[array_rand([1, 2])],
                "phone_number" => $faker->phoneNumber,
                "adress" => $faker->address,
            ]);
        }

        Action::truncate();

        $action = ['Pagou', 'Deveu'];
        $products = ['Frango assado', 'Jantinha', 'Cerveja', 'Pinga', 'Balinha', 'Jantinha (só feijão)', 'Jantinha (só mandioca)'
        ,'Jantinha (só macarrão)', 'Churrasco'];
        
        for ($i = 0; $i< 50; $i++){
            for($j = 0; $j < 20; $j++){
                Action::create([
                    "client_id" => $i,
                    "action" => $action[array_rand([1, 2])],
                    "product" => $products[array_rand([1, 9])] ,
                    "price" => rand(0, 99),
                    "created_at" => strtotime('-4 year', time())
                ]);
                echo "Outer loop --> $i \n ";
                echo "Inner loop --> $j \n ";

            };
        };


    }
}
