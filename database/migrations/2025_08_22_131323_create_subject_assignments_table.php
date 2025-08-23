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
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('school_classes')->onDelete('cascade');
            $table->string('academic_year', 9);
            $table->enum('term', ['First', 'Second', 'Third']);
            $table->boolean('is_class_teacher')->default(false);
            $table->timestamps();
            
            // Prevent duplicate assignments
            $table->unique(['teacher_id', 'subject_id', 'class_id', 'academic_year', 'term']);
            
            // Only one class teacher per class per term
            $table->unique(['class_id', 'academic_year', 'term', 'is_class_teacher'], 'unique_class_teacher');
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
