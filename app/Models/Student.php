<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Result;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'address', 'date_of_birth', 
        'gender', 'class_id', 'roll_number', 'parent_name', 
        'parent_phone', 'photo_path'
    ];

    protected $dates = ['date_of_birth'];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'student_id');
    }

    /**
     * Get the user account associated with the student.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}