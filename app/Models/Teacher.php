<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\SubjectAssignment;
use App\Models\SchoolClass;
use Carbon\Carbon;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_id',
        'qualification',
        'phone',
        'address',
        'date_of_birth',
        'gender',
        'joining_date',
        'photo_path',
        'bio',
        'is_active'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date_of_birth',
        'joining_date',
        'created_at',
        'updated_at'
    ];
    
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'full_name', 
        'photo_url',
        'formatted_date_of_birth',
        'formatted_joining_date',
        'years_of_service'
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'date_of_birth' => 'date:Y-m-d',
        'joining_date' => 'date:Y-m-d',
    ];

    /**
     * Get the user account associated with the teacher.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subject assignments for the teacher.
     */
    public function subjectAssignments()
    {
        return $this->hasMany(SubjectAssignment::class);
    }

    /**
     * Get the classes taught by the teacher.
     */
    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_teacher', 'teacher_id', 'class_id')
            ->withPivot('is_class_teacher')
            ->withTimestamps();
    }

    /**
     * Get the subjects taught by the teacher.
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher', 'teacher_id', 'subject_id')
            ->withPivot('class_id')
            ->withTimestamps();
    }
    
    /**
     * Get the teacher's class teacher assignments.
     */
    public function classTeacherAssignments()
    {
        return $this->classes()->wherePivot('is_class_teacher', true);
    }
    
    /**
     * Get the teacher's subjects for a specific class.
     *
     * @param  int  $classId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function subjectsForClass($classId)
    {
        return $this->subjects()->wherePivot('class_id', $classId)->get();
    }

    /**
     * Get the teacher's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->user ? $this->user->name : 'N/A';
    }
    
    /**
     * Get the URL to the teacher's photo.
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo_path) {
            return asset('storage/' . $this->photo_path);
        }
        return asset('images/default-avatar.png');
    }
    
    /**
     * Get the formatted date of birth.
     *
     * @return string|null
     */
    public function getFormattedDateOfBirthAttribute()
    {
        return $this->date_of_birth ? Carbon::parse($this->date_of_birth)->format('F j, Y') : null;
    }
    
    /**
     * Get the formatted joining date.
     *
     * @return string|null
     */
    public function getFormattedJoiningDateAttribute()
    {
        return $this->joining_date ? Carbon::parse($this->joining_date)->format('F j, Y') : null;
    }
    
    /**
     * Get the years of service.
     *
     * @return string|null
     */
    public function getYearsOfServiceAttribute()
    {
        return $this->joining_date ? Carbon::parse($this->joining_date)->diffForHumans(null, true) : null;
    }
    
    /**
     * Scope a query to only include active teachers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    /**
     * Scope a query to only include inactive teachers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }
    
    /**
     * Check if the teacher is a class teacher for a specific class.
     *
     * @param  int  $classId
     * @return bool
     */
    public function isClassTeacher($classId)
    {
        return $this->classes()->where('class_id', $classId)
            ->wherePivot('is_class_teacher', true)
            ->exists();
    }
    
    /**
     * Get the subjects taught by the teacher for a specific class.
     *
     * @param  int  $classId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSubjectsForClass($classId)
    {
        return $this->subjects()->wherePivot('class_id', $classId)->get();
    }
}
