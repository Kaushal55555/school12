<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\SchoolInformationController;
use App\Http\Controllers\ReportController;

// Authentication Routes
require __DIR__.'/auth.php';

// Frontend Routes (Public)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Admin Routes (Protected by auth)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Public results routes
    Route::prefix('results')->name('public.')->group(function () {
        Route::get('/', [HomeController::class, 'results'])->name('results');
        Route::post('/check', [HomeController::class, 'checkResult'])->name('check.result');
    });

    // Admin Protected Routes
    Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
        // Admin Dashboard
        Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
        
        // Resource Controllers
        Route::resource('students', StudentController::class);
        Route::resource('subjects', SubjectController::class);
        Route::resource('results', ResultController::class)->except(['index']);
        Route::get('/admin/results', [ResultController::class, 'index'])->name('results.index');
        Route::resource('classes', SchoolClassController::class);
        Route::resource('teachers', \App\Http\Controllers\TeacherController::class);
        
        // Subject Assignments
        Route::resource('subject-assignments', \App\Http\Controllers\SubjectAssignmentController::class);
        
        // API Routes for subject assignments
        Route::get('/api/check-class-teacher/{teacherId}/{classId}/{academicYear}/{term}', function ($teacherId, $classId, $academicYear, $term) {
            $isClassTeacher = \App\Models\SubjectAssignment::where('teacher_id', $teacherId)
                ->where('class_id', $classId)
                ->where('academic_year', $academicYear)
                ->where('term', $term)
                ->where('is_class_teacher', true)
                ->exists();
                
            return response()->json(['is_class_teacher' => $isClassTeacher]);
        })->name('api.check-class-teacher');

        // School Information Routes
        Route::prefix('admin/school-information')->name('admin.school-information.')->group(function () {
            Route::get('/', [SchoolInformationController::class, 'edit'])->name('edit');
            Route::put('/', [SchoolInformationController::class, 'update'])->name('update');
        });

        // Report Routes
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/students', [ReportController::class, 'students'])->name('students');
            Route::get('/results', [ReportController::class, 'results'])->name('results');
            Route::post('/filter-students', [ReportController::class, 'filterStudents'])->name('filter.students');
            Route::post('/filter-results', [ReportController::class, 'filterResults'])->name('filter.results');
        });

        // Print Results Route
        Route::get('/results/print', [ResultController::class, 'print'])->name('results.print');
        
        // AJAX Routes for Results
        Route::get('/get-subjects/{classId}', [ResultController::class, 'getSubjects'])->name('get.subjects');
        Route::get('/get-students/{classId}', [ResultController::class, 'getStudents'])->name('get.students');
    });
});

require __DIR__.'/auth.php';
