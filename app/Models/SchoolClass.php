<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SchoolClass extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'section', 'description'];

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'class_id');
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'class_id');
    }

    /**
     * Get the subject assignments for the class.
     */
    public function subjectAssignments()
    {
        return $this->hasMany(SubjectAssignment::class, 'class_id');
    }

    /**
     * Determine if the user can view the class.
     */
    public function viewableBy(User $user): bool
    {
        return $user->hasRole('admin') || 
               $this->subjectAssignments()->where('teacher_id', $user->id)->exists();
    }

    /**
     * Determine if the user can update the class.
     */
    public function updatableBy(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can delete the class.
     */
    public function deletableBy(User $user): bool
    {
        return $user->hasRole('admin');
    }
}