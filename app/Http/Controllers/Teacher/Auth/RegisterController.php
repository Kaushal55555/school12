<?php

namespace App\Http\Controllers\Teacher\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Show the teacher registration form.
     */
    public function showRegistrationForm()
    {
        return view('teacher.auth.register');
    }

    /**
     * Handle a registration request for the application.
     */
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'qualification' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:20'],
                'address' => ['required', 'string', 'max:500'],
                'date_of_birth' => ['required', 'date', 'before:today'],
                'gender' => ['required', 'in:male,female,other'],
                'joining_date' => ['required', 'date', 'after_or_equal:date_of_birth'],
            ]);

            // Start database transaction
            \DB::beginTransaction();

            // Create user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'teacher',
                'email_verified_at' => now(),
            ]);

            // Assign teacher role using Spatie Permission
            $user->assignRole('teacher');

            // Format dates
            $dateOfBirth = \Carbon\Carbon::parse($validated['date_of_birth']);
            $joiningDate = \Carbon\Carbon::parse($validated['joining_date']);

            // Create teacher profile
            $teacher = new Teacher([
                'user_id' => $user->id,
                'employee_id' => 'TCHR' . strtoupper(Str::random(6)),
                'qualification' => $validated['qualification'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'date_of_birth' => $dateOfBirth,
                'gender' => $validated['gender'],
                'joining_date' => $joiningDate,
                'is_active' => true,
            ]);
            
            $teacher->save();

            // Commit transaction
            \DB::commit();

            // Log the user in using the web guard
            Auth::guard('web')->login($user);

            // Regenerate the session
            $request->session()->regenerate();

            // Redirect to the teacher dashboard
            return redirect()->route('teacher.dashboard')
                ->with('success', 'Registration successful! Welcome to your dashboard.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Rollback transaction on validation error
            \DB::rollBack();
            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            // Rollback transaction on any other error
            \DB::rollBack();
            \Log::error('Registration error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return back()
                ->withInput()
                ->withErrors(['error' => 'Registration failed. Please try again. ' . $e->getMessage()]);
        }
    }

    /**
     * Get a validator for an incoming registration request.
     */
    // Removed the separate validator method as we're now validating directly in the register method

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'teacher',
        ]);
    }
}
