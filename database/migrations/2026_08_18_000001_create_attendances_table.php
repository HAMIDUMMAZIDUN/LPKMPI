<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('class_schedule_id')->constrained('class_schedules')->onDelete('cascade');
            $table->string('status'); // 'present', 'absent', 'permit'
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'class_schedule_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};
