<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'class_id'];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'subject_id');
    }

    /**
     * Get the subject assignments for the subject.
     */
    public function subjectAssignments()
    {
        return $this->hasMany(SubjectAssignment::class);
    }
}