<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Teacher;

// Get the first teacher with relationships
$teacher = Teacher::with(['classes', 'subjects'])->first();

echo "Teacher: " . $teacher->user->name . "\n";
echo "Employee ID: " . $teacher->employee_id . "\n";
echo "Qualification: " . $teacher->qualification . "\n";
echo "\nClasses assigned:\n";
foreach ($teacher->classes as $class) {
    echo "- " . $class->name . " (Grade " . $class->grade . ")" . "\n";
}

echo "\nSubjects taught:\n";
foreach ($teacher->subjects as $subject) {
    echo "- " . $subject->name . " (Code: " . $subject->code . ")" . "\n";
}
