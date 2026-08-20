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
        Schema::table('class_schedules', function (Blueprint $table) {
            $table->string('type')->default('offline')->after('location'); // 'online' or 'offline'
            $table->string('online_link')->nullable()->after('type');       // Zoom/Meet/etc link for online
            $table->string('share_location')->nullable()->after('online_link'); // Google Maps link for offline
            $table->boolean('notification_sent')->default(false)->after('share_location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('class_schedules', function (Blueprint $table) {
            $table->dropColumn(['type', 'online_link', 'share_location', 'notification_sent']);
        });
    }
};
