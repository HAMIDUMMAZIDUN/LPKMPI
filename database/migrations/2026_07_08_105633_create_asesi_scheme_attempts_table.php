<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asesi_scheme_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesi_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('scheme_id')->constrained('assessment_schemes')->onDelete('cascade');
            $table->enum('status', ['in_progress', 'completed'])->default('in_progress');
            $table->integer('score')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asesi_scheme_attempts');
    }
};
