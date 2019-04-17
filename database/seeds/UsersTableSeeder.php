<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('admin'),
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'Editor',
            'email' => 'editor@test.com',
            'password' => Hash::make('editor'),
            'role' => 'editor'
        ]);
        User::create([
            'name' => 'User',
            'email' => 'user@test.com',
            'password' => Hash::make('user'),
            'role' => 'user'
        ]);


        $faker = Faker\Factory::create();
        for ($i = 0; $i<10; $i++){
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->safeEmail,
                'password' => bcrypt('password'),
                'role' => 'professor'
            ]);

            $user->courses()->sync(range(1, random_int(1, 15)));
        }
    }
}
