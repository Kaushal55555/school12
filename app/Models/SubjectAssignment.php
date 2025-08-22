<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\SchoolClass;

class SubjectAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'subject_id',
        'class_id',
        'academic_year',
        'term',
        'is_class_teacher'
    ];

    protected $casts = [
        'is_class_teacher' => 'boolean',
    ];

    /**
     * Get the teacher that owns the subject assignment.
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the subject that owns the subject assignment.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the class that owns the subject assignment.
     */
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Scope a query to only include assignments for a specific academic year.
     */
    public function scopeForAcademicYear($query, $year)
    {
        return $query->where('academic_year', $year);
    }

    /**
     * Scope a query to only include assignments for a specific term.
     */
    public function scopeForTerm($query, $term)
    {
        return $query->where('term', $term);
    }

    /**
     * Get the display name for the assignment.
     */
    public function getDisplayNameAttribute()
    {
        return "{$this->subject->name} - {$this->schoolClass->name} ({$this->academic_year} - {$this->term} term)";
    }
}
