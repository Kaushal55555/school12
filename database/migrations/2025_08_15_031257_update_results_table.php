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
        Schema::table('results', function (Blueprint $table) {
            // Drop existing columns if they exist
            if (Schema::hasColumn('results', 'marks_obtained')) {
                $table->dropColumn('marks_obtained');
            }
            
            if (Schema::hasColumn('results', 'percentage')) {
                $table->dropColumn('percentage');
            }
            
            // Add required columns if they don't exist
            if (!Schema::hasColumn('results', 'marks')) {
                $table->decimal('marks', 5, 2)->after('class_id');
            }
            
            if (!Schema::hasColumn('results', 'grade')) {
                $table->string('grade', 10)->after('marks');
            }
            
            if (!Schema::hasColumn('results', 'term')) {
                $table->string('term')->after('grade');
            }
            
            if (!Schema::hasColumn('results', 'academic_year')) {
                $table->year('academic_year')->after('term');
            }
            
            if (!Schema::hasColumn('results', 'percentage')) {
                $table->decimal('percentage', 5, 2)->nullable()->after('grade');
            }
            
            // Make sure the timestamps exist
            if (!Schema::hasColumn('results', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('results', function (Blueprint $table) {
            //
        });
    }
};
