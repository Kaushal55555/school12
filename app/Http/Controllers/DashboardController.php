<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Result;
use App\Models\Subject;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with statistics and recent activities.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get counts for dashboard statistics
        $stats = [
            'total_students' => Student::count(),
            'total_results' => Result::count(),
            'total_subjects' => Subject::count(),
            'total_classes' => SchoolClass::count(),
        ];

        // Get recent results with relationships loaded
        $recentResults = Result::with(['student', 'subject', 'student.schoolClass'])
            ->latest()
            ->take(5)
            ->get();

        // Generate sample recent activities (in a real app, this would come from an activity log)
        $recentActivities = $this->getRecentActivities();

        return view('dashboard', compact('stats', 'recentResults', 'recentActivities'));
    }

    /**
     * Generate sample recent activities.
     * In a production app, this would come from an activity log or similar.
     *
     * @return array
     */
    protected function getRecentActivities()
    {
        $now = Carbon::now();
        
        return [
            [
                'icon' => 'person-plus',
                'color' => 'primary',
                'description' => 'New student registered: John Doe',
                'time' => $now->subMinutes(15)->diffForHumans()
            ],
            [
                'icon' => 'journal-text',
                'color' => 'success',
                'description' => 'Results published for Class 10 - Term 1',
                'time' => $now->subHours(2)->diffForHumans()
            ],
            [
                'icon' => 'book',
                'color' => 'info',
                'description' => 'New subject added: Computer Science',
                'time' => $now->subDays(1)->diffForHumans()
            ],
            [
                'icon' => 'building',
                'color' => 'warning',
                'description' => 'New class created: Class 11 (A)',
                'time' => $now->subDays(2)->diffForHumans()
            ],
            [
                'icon' => 'graph-up',
                'color' => 'success',
                'description' => 'Monthly performance report generated',
                'time' => $now->subDays(3)->diffForHumans()
            ]
        ];
    }

    /**
     * Display the admin dashboard with advanced statistics.
     *
     * @return \Illuminate\View\View
     */
    public function admin()
    {
        // Get counts for admin dashboard statistics
        $stats = [
            'total_students' => Student::count(),
            'total_results' => Result::count(),
            'total_subjects' => Subject::count(),
            'total_classes' => SchoolClass::count(),
            'pending_results' => Result::where('status', 'pending')->count(),
            'published_results' => Result::where('status', 'published')->count(),
        ];

        // Get recent results with relationships loaded
        $recentResults = Result::with(['student', 'subject', 'student.class'])
            ->latest()
            ->take(10)
            ->get();

        // Get recent activities
        $recentActivities = $this->getRecentActivities();

        // Get class-wise student distribution
        $classDistribution = SchoolClass::withCount('students')
            ->orderBy('name')
            ->get()
            ->mapWithKeys(function ($class) {
                return [$class->name => $class->students_count];
            });

        return view('admin.dashboard', compact('stats', 'recentResults', 'recentActivities', 'classDistribution'));
    }
}
