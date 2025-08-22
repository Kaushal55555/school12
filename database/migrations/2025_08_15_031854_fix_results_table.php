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
        // First, drop the existing foreign key constraints if they exist
        Schema::table('results', function (Blueprint $table) {
            // This is a workaround for dropping foreign keys in SQLite
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['student_id']);
                $table->dropForeign(['subject_id']);
                $table->dropForeign(['class_id']);
            }
        });
        
        // Now, modify the table structure
        Schema::table('results', function (Blueprint $table) {
            // Drop existing columns if they exist
            if (Schema::hasColumn('results', 'marks_obtained')) {
                $table->dropColumn('marks_obtained');
            }
            
            // Add or modify columns
            if (!Schema::hasColumn('results', 'marks')) {
                $table->decimal('marks', 5, 2)->after('class_id');
            }
            
            if (!Schema::hasColumn('results', 'percentage')) {
                $table->decimal('percentage', 5, 2)->nullable()->after('marks');
            }
            
            if (!Schema::hasColumn('results', 'grade')) {
                $table->string('grade', 10)->after('percentage');
            }
            
            if (!Schema::hasColumn('results', 'term')) {
                $table->string('term')->after('grade');
            }
            
            if (!Schema::hasColumn('results', 'academic_year')) {
                $table->year('academic_year')->after('term');
            }
            
            // Re-add foreign key constraints
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('school_classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
