<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Subject;

// Get all teachers with their relationships
$teachers = Teacher::with(['user', 'classes', 'subjects'])->limit(5)->get();

foreach ($teachers as $teacher) {
    echo "\nTeacher: " . $teacher->user->name . " (ID: " . $teacher->id . ")";
    echo "\nEmployee ID: " . $teacher->employee_id;
    echo "\nQualification: " . $teacher->qualification;
    echo "\nStatus: " . ($teacher->is_active ? 'Active' : 'Inactive');
    
    echo "\n\nClasses:";
    if ($teacher->classes->isEmpty()) {
        echo " None";
    } else {
        foreach ($teacher->classes as $class) {
            echo "\n- " . $class->name . " (Grade " . $class->grade . ")";
            echo " - Subjects: ";
            
            // Get subjects this teacher teaches for this specific class
            $subjects = $teacher->subjects->filter(function($subject) use ($class) {
                return $subject->pivot->class_id == $class->id;
            });
            
            if ($subjects->isEmpty()) {
                echo "None";
            } else {
                echo $subjects->pluck('name')->implode(', ');
            }
        }
    }
    
    echo "\n";
    echo str_repeat("-", 50) . "\n";
}

echo "\nDatabase check complete.\n";
