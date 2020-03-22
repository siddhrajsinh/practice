<?php

use App\Visitor;
use Illuminate\Database\Seeder;

class CreateVisitorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        
        for ($i = 1; $i <= 500; $i++) {
            
            $visitor = [
                'first_name'       => $faker->firstName,
                'last_name'        => $faker->lastName,
                'email'            => $faker->safeEmail,
                'date_of_birth'    => $faker->dateTimeBetween('1990-01-01', '2020-03-22')->format('Y-m-d'),
                'ip_address'       => $faker->ipv4,
                'created_at'       => $faker->dateTimeBetween('2001-01-01', '2020-03-22')->format('Y-m-d'),
            ];
            
            Visitor::create($visitor);

        }
    }
}
