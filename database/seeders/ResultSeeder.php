<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
 {
    for ($i = 1; $i <= 20; $i++) {
        \App\Models\Result::create([
            'student_id' => $i <= 10 ? $i : $i - 10,
            'subject_id' => rand(1, 4),
            'class_id' => rand(1, 3),
            'marks' => rand(40, 100),
            'grade' => $this->calculateGrade(rand(40, 100)),
            'term' => 'First Term',
            'academic_year' => date('Y'),
        ]);
    }
 }

    private function calculateGrade($marks)
 {
    if ($marks >= 90) return 'A+';
    if ($marks >= 80) return 'A';
    if ($marks >= 70) return 'B+';
    if ($marks >= 60) return 'B';
    if ($marks >= 50) return 'C+';
    if ($marks >= 40) return 'C';
    return 'F';
 }
}
