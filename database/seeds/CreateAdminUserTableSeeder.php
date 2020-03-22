<?php

use App\User;
use Illuminate\Database\Seeder;

class CreateAdminUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        //remove old data because we insert static record with id.
        User::whereIn('id',[1,2])->delete();
        
        User::create([
            'id' => 1,
            'name' => $faker->name,
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin@123'),
            'user_type' => 1,
        ]);

        User::create([
            'id' => 2,
            'name' => $faker->name,
            'email' => 'user@gmail.com',
            'password' => bcrypt('user@123'),
            'user_type' => 2,
        ]);


    }
}
