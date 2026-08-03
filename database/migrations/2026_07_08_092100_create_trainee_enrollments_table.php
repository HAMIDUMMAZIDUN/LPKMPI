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
        Schema::create('trainee_enrollments', function (Blueprint $table) {
            $table->id();
            $table->string('training_program_id');
            $table->string('name');
            $table->string('nik', 16)->index();
            $table->string('email');
            $table->string('phone');
            $table->string('education');
            $table->string('category');
            $table->string('company');
            $table->string('position');
            $table->string('certificate_number')->unique()->nullable();
            $table->date('certificate_date')->nullable();
            $table->string('status')->default('LULUS');
            $table->timestamps();

            $table->foreign('training_program_id')
                  ->references('id')
                  ->on('training_programs')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainee_enrollments');
    }
};
