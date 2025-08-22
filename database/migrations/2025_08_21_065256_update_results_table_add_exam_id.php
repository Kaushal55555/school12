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
            // Add exam_id as a foreign key
            $table->foreignId('exam_id')->after('id')->nullable()->constrained()->onDelete('cascade');
            
            // Add position_in_class if not exists
            if (!Schema::hasColumn('results', 'position_in_class')) {
                $table->unsignedInteger('position_in_class')->nullable()->after('percentage');
            }
            
            // Add remarks if not exists
            if (!Schema::hasColumn('results', 'remarks')) {
                $table->text('remarks')->nullable()->after('position_in_class');
            }
            
            // Add attendance if not exists
            if (!Schema::hasColumn('results', 'attendance')) {
                $table->unsignedInteger('attendance')->default(0)->after('remarks');
            }
            
            // Add status if not exists
            if (!Schema::hasColumn('results', 'status')) {
                $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->after('attendance');
            }
            
            // Add published_at timestamp if not exists
            if (!Schema::hasColumn('results', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('status');
            }
            
            // Add unique constraint to prevent duplicate entries
            $table->unique(['student_id', 'exam_id', 'subject_id'], 'result_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('results', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['exam_id']);
            
            // Drop the unique constraint
            $table->dropUnique('result_unique');
            
            // Drop the added columns
            $table->dropColumn([
                'exam_id',
                'position_in_class',
                'remarks',
                'attendance',
                'status',
                'published_at'
            ]);
        });
    }
};
