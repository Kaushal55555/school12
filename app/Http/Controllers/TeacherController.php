<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::with('user')->latest()->paginate(15);
        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = SchoolClass::all();
        $subjects = Subject::all();
        return view('admin.teachers.create', compact('classes', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'employee_id' => 'required|string|max:50|unique:teachers',
            'qualification' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'joining_date' => 'required|date',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'classes' => 'nullable|array',
            'classes.*' => 'exists:school_classes,id',
            'subjects' => 'nullable|array',
            'subjects.*' => 'exists:subjects,id',
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'teacher',
        ]);

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('teacher_photos', 'public');
        }

        // Create teacher
        $teacher = Teacher::create([
            'user_id' => $user->id,
            'employee_id' => $validated['employee_id'],
            'qualification' => $validated['qualification'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
            'joining_date' => $validated['joining_date'],
            'photo_path' => $photoPath,
            'bio' => $validated['bio'] ?? null,
        ]);

        // Sync classes and subjects
        if (isset($validated['classes'])) {
            $teacher->classes()->sync($validated['classes']);
        }

        if (isset($validated['subjects'])) {
            $teacher->subjects()->sync($validated['subjects']);
        }

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        $teacher->load('user', 'classes', 'subjects');
        return view('admin.teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        $teacher->load('user', 'classes', 'subjects');
        $classes = SchoolClass::all();
        $subjects = Subject::all();
        return view('admin.teachers.edit', compact('teacher', 'classes', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($teacher->user_id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'employee_id' => [
                'required',
                'string',
                'max:50',
                Rule::unique('teachers')->ignore($teacher->id),
            ],
            'qualification' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'joining_date' => 'required|date',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'classes' => 'nullable|array',
            'classes.*' => 'exists:school_classes,id',
            'subjects' => 'nullable|array',
            'subjects.*' => 'exists:subjects,id',
        ]);

        // Update user
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $teacher->user->update($userData);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($teacher->photo_path) {
                \Storage::disk('public')->delete($teacher->photo_path);
            }
            $photoPath = $request->file('photo')->store('teacher_photos', 'public');
            $validated['photo_path'] = $photoPath;
        }

        // Update teacher
        $teacher->update([
            'employee_id' => $validated['employee_id'],
            'qualification' => $validated['qualification'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
            'joining_date' => $validated['joining_date'],
            'bio' => $validated['bio'] ?? null,
            'photo_path' => $validated['photo_path'] ?? $teacher->photo_path,
        ]);

        // Sync classes and subjects
        $teacher->classes()->sync($validated['classes'] ?? []);
        $teacher->subjects()->sync($validated['subjects'] ?? []);

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        // Delete photo if exists
        if ($teacher->photo_path) {
            \Storage::disk('public')->delete($teacher->photo_path);
        }

        // Delete user
        $teacher->user->delete();

        // Teacher will be deleted automatically due to onDelete('cascade')
        
        return redirect()->route('teachers.index')
            ->with('success', 'Teacher deleted successfully.');
    }
}
