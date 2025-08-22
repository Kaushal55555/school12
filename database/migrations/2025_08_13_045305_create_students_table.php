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
    Schema::create('students', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('phone')->nullable();
        $table->string('address')->nullable();
        $table->date('date_of_birth');
        $table->enum('gender', ['male', 'female', 'other']);
        $table->unsignedBigInteger('class_id');
        $table->foreign('class_id')->references('id')->on('school_classes')->onDelete('cascade');
        $table->string('roll_number');
        $table->string('parent_name')->nullable();
        $table->string('parent_phone')->nullable();
        $table->text('photo_path')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
