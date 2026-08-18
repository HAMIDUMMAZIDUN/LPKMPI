<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asesi_portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('training_program_id');
            $table->foreign('training_program_id')->references('id')->on('training_programs')->onDelete('cascade');
            $table->string('document_name'); // cv, work_experience, education_certificate, training_certificate, other
            $table->string('file_path');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asesi_portfolios');
    }
};
