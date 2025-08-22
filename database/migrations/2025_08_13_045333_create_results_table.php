<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('results', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('student_id');
        $table->unsignedBigInteger('subject_id');
        $table->unsignedBigInteger('class_id');
        $table->decimal('marks', 5, 2);
        $table->string('grade');
        $table->text('remarks')->nullable();
        $table->string('term');
        $table->year('academic_year');
        $table->timestamps();

        // Foreign key constraints
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
        Schema::dropIfExists('results');
    }
};
