<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SubjectAssignment;
use App\Models\Student;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'teacher']);
    }


    public function index()
    {
        $teacher = Auth::user()->teacher;
        
        // Get class teacher assignments with student counts
        $classTeacherAssignments = SubjectAssignment::with([
            'schoolClass' => function($query) {
                $query->withCount('students');
            },
            'subject'
        ])
        ->where('teacher_id', $teacher->id)
        ->where('is_class_teacher', true)
        ->get();
        
        // Get all subject assignments with relationships
        $assignments = SubjectAssignment::with(['schoolClass', 'subject'])
            ->where('teacher_id', $teacher->id)
            ->get();
        
        // Get class IDs for queries
        $classIds = $assignments->pluck('class_id')->unique();
        
        // Get total students across all assigned classes
        $totalStudents = \App\Models\Student::whereIn('class_id', $classIds)->count();
        
        // Get recent students (from assigned classes)
        $recentStudents = \App\Models\Student::whereIn('class_id', $classIds)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get recent results
        $recentResults = \App\Models\Result::whereIn('class_id', $classIds)
            ->with(['student.user', 'subject'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get current academic year and term
        $currentYear = date('Y') . '-' . (date('Y') + 1);
        $currentTerm = 'Term ' . ceil(date('n') / 4);

        return view('teacher.dashboard', compact(
            'assignments',
            'recentStudents',
            'recentResults',
            'classTeacherAssignments',
            'currentYear',
            'currentTerm',
            'totalStudents'
        ));
    }

    /**
     * Show the teacher's profile.
     */
    public function profile()
    {
        $teacher = Auth::user()->teacher;
        
        // Get all subject assignments for the sidebar
        $assignments = SubjectAssignment::with(['schoolClass', 'subject'])
            ->where('teacher_id', $teacher->id)
            ->get();
            
        // Get class teacher assignments for the sidebar
        $classTeacherAssignments = $assignments->where('is_class_teacher', true);

        return view('teacher.profile', [
            'teacher' => $teacher,
            'assignments' => $assignments,
            'classTeacherAssignments' => $classTeacherAssignments
        ]);
    }

    /**
     * Update the teacher's profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ]);

        // Update user
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Update teacher
        $teacher->update([
            'phone' => $validated['phone'] ?? $teacher->phone,
            'address' => $validated['address'] ?? $teacher->address,
            'qualification' => $validated['qualification'] ?? $teacher->qualification,
            'bio' => $validated['bio'] ?? $teacher->bio,
        ]);

        return redirect()->route('teacher.profile')
            ->with('success', 'Profile updated successfully!');
    }
    
    /**
     * Update the teacher's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }
}
