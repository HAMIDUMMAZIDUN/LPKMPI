<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scheme_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scheme_id')->constrained('assessment_schemes')->onDelete('cascade');
            $table->foreignId('asesor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('assigned_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamps();
            $table->unique(['scheme_id', 'asesor_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scheme_assignments');
    }
};
