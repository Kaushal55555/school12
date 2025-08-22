<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}