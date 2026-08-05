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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->string('name');
            $table->string('email');
            $table->text('message');
            $table->string('sender_role')->default('visitor'); // 'visitor' or 'admin'
            $table->unsignedBigInteger('admin_id')->nullable(); // The admin who sent this message (if sender_role = 'admin')
            $table->unsignedBigInteger('claimed_by_admin_id')->nullable(); // The admin who claimed this chat thread
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('claimed_by_admin_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
