<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $classes = [
        ['name' => 'Class 1', 'section' => 'A', 'description' => 'First Grade'],
        ['name' => 'Class 2', 'section' => 'A', 'description' => 'Second Grade'],
        ['name' => 'Class 3', 'section' => 'A', 'description' => 'Third Grade'],
    ];

    foreach ($classes as $class) {
        \App\Models\SchoolClass::create($class);
    }
}
}
