<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 20 teachers
        $teachers = Teacher::factory()
            ->count(20)
            ->create();

        // Get all classes and subjects
        $classes = SchoolClass::all();
        $subjects = Subject::all();

        // Assign classes and subjects to teachers
        $teachers->each(function ($teacher) use ($classes, $subjects) {
            // Assign 1-3 random classes to each teacher
            $assignedClasses = $classes->random(rand(1, min(3, $classes->count())));
            
            $classTeacherAssigned = false;
            
            foreach ($assignedClasses as $class) {
                // Randomly decide if this teacher is a class teacher for this class (20% chance)
                $isClassTeacher = !$classTeacherAssigned && rand(1, 5) === 1;
                
                if ($isClassTeacher) {
                    $classTeacherAssigned = true;
                }
                
                // Attach class to teacher with class teacher status
                $teacher->classes()->attach($class->id, [
                    'is_class_teacher' => $isClassTeacher
                ]);
                
                // Get subjects that belong to this class
                $classSubjectIds = $class->subjects->pluck('id')->toArray();
                
                if (!empty($classSubjectIds)) {
                    // Assign 1 to all subjects for this class to the teacher
                    $numSubjects = rand(1, count($classSubjectIds));
                    $classSubjects = $subjects->whereIn('id', $classSubjectIds)
                                            ->random($numSubjects);
                    
                    foreach ($classSubjects as $subject) {
                        // Check if this subject is already assigned to this teacher for any class
                        $alreadyAssigned = $teacher->subjects()
                                                ->where('subject_id', $subject->id)
                                                ->wherePivot('class_id', $class->id)
                                                ->exists();
                        
                        if (!$alreadyAssigned) {
                            // Attach subject to teacher for this class
                            $teacher->subjects()->attach($subject->id, [
                                'class_id' => $class->id
                            ]);
                        }
                    }
                }
            }
        });
        
        $this->command->info('Successfully seeded teachers with classes and subjects.');
    }
}
