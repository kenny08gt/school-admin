<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use \App\Course;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 15; $i++) {
            Course::create([
                'name' => $faker->domainWord,
                'description' => $faker->text,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
