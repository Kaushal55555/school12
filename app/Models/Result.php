<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject_id',
        'class_id',
        'exam_id',
        'marks',
        'grade',
        'remarks',
        'term',
        'academic_year',
        'percentage',
        'position_in_class',
        'attendance',
        'status',
        'published_at'
    ];

    protected $dates = [
        'published_at',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'marks' => 'float',
        'percentage' => 'float',
        'position_in_class' => 'integer',
        'attendance' => 'integer',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            Log::info('Creating new result', [
                'attributes' => $model->attributesToArray(),
                'connection' => config('database.default'),
                'database' => config("database.connections.".config('database.default').".database")
            ]);
        });

        static::created(function($model) {
            Log::info('Result created successfully', [
                'id' => $model->id,
                'attributes' => $model->attributesToArray()
            ]);
        });

        static::updating(function($model) {
            Log::info('Updating result', [
                'id' => $model->id,
                'old' => $model->getOriginal(),
                'new' => $model->getDirty()
            ]);
        });
    }

    /**
     * Get the student that owns the result.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Get the subject that owns the result.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    /**
     * Get the class that owns the result.
     */
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Get the exam that owns the result.
     */
    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    /**
     * Scope a query to only include published results.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope a query to only include draft results.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope a query to only include results for a specific academic year.
     */
    public function scopeForAcademicYear($query, $year)
    {
        return $query->where('academic_year', $year);
    }

    /**
     * Scope a query to only include results for a specific term.
     */
    public function scopeForTerm($query, $term)
    {
        return $query->where('term', $term);
    }

    /**
     * Publish the result.
     */
    public function publish()
    {
        $this->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    /**
     * Unpublish the result (set back to draft).
     */
    public function unpublish()
    {
        $this->update([
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    /**
     * Archive the result.
     */
    public function archive()
    {
        $this->update(['status' => 'archived']);
    }

    /**
     * Check if the result is published.
     */
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    /**
     * Check if the result is a draft.
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Check if the result is archived.
     */
    public function isArchived(): bool
    {
        return $this->status === 'archived';
    }

    /**
     * Calculate and set the grade based on the marks.
     */
    public function calculateGrade(): string
    {
        // This is a sample grading system, you can adjust it as needed
        if ($this->percentage >= 90) return 'A+';
        if ($this->percentage >= 80) return 'A';
        if ($this->percentage >= 70) return 'B';
        if ($this->percentage >= 60) return 'C';
        if ($this->percentage >= 50) return 'D';
        return 'F';
    }
}