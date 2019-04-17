<?php

use Illuminate\Database\Seeder;
use \App\Grade;

class GradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $grade = Grade::create([
                'name' => ($i+1).'- '.$faker->domainWord,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $grade->courses()->withTimestamps()->sync(range(1, random_int(1, 15)));
        }
    }
}
