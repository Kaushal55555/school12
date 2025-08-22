<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $subjects = [
            ['name' => 'Mathematics', 'code' => 'MATH-101', 'class_id' => 1],
            ['name' => 'Science', 'code' => 'SCI-101', 'class_id' => 1],
            ['name' => 'English', 'code' => 'ENG-101', 'class_id' => 2],
            ['name' => 'Nepali', 'code' => 'NEP-101', 'class_id' => 2],
        ];

        foreach ($subjects as $subject) {
            \App\Models\Subject::firstOrCreate(
                ['code' => $subject['code']],
                $subject
            );
        }
    }
}
