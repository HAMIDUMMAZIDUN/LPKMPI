<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('class_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('training_program_id');
            $table->foreign('training_program_id')->references('id')->on('training_programs')->onDelete('cascade');
            $table->foreignId('asesor_id')->constrained('users')->onDelete('cascade');
            $table->string('topic');
            $table->dateTime('scheduled_at');
            $table->string('location');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('class_schedules');
    }
};
