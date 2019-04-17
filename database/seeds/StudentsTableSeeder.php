<?php

use Illuminate\Database\Seeder;
use \App\Student;

class StudentsTableSeeder extends Seeder
{
    /**
     * @throws Exception
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 200; $i++) {
            Student::create([
                'name' => $faker->domainWord,
                'grade_id' => random_int(1, 10),
                'updated_at' => now(),
                'created_at' => now(),
            ]);
        }
    }
}
