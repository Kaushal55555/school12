<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $faker = \Faker\Factory::create();

    for ($i = 1; $i <= 10; $i++) {
        \App\Models\Student::create([
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'phone' => $faker->phoneNumber,
            'address' => $faker->address,
            'date_of_birth' => $faker->date(),
            'gender' => $faker->randomElement(['male', 'female']),
            'class_id' => $faker->numberBetween(1, 3),
            'roll_number' => 'STD-' . str_pad($i, 3, '0', STR_PAD_LEFT),
            'parent_name' => $faker->name,
            'parent_phone' => $faker->phoneNumber,
        ]);
    }
}
}
