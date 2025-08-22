<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subject_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_id')->constrained('school_classes')->onDelete('cascade');
            $table->enum('academic_year', [
                '2023-2024', '2024-2025', '2025-2026', '2026-2027', '2027-2028'
            ]);
            $table->enum('term', ['first', 'second', 'third']);
            $table->boolean('is_class_teacher')->default(false);
            $table->timestamps();

            // Ensure a teacher can't be assigned to the same subject and class in the same academic year and term
            $table->unique(
                ['teacher_id', 'subject_id', 'class_id', 'academic_year', 'term'],
                'subj_assign_unique'  // Shorter name for the index
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_assignments');
    }
};
