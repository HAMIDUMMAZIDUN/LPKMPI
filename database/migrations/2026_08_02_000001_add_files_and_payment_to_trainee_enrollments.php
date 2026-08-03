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
        Schema::table('trainee_enrollments', function (Blueprint $table) {
            $table->string('ktp_path')->nullable()->after('position');
            $table->string('ijazah_path')->nullable()->after('ktp_path');
            $table->string('payment_method')->nullable()->after('ijazah_path');
            $table->string('payment_status')->default('UNPAID')->after('payment_method');
            $table->string('payment_reference')->nullable()->after('payment_status');
            $table->integer('payment_amount')->nullable()->after('payment_reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainee_enrollments', function (Blueprint $table) {
            $table->dropColumn([
                'ktp_path',
                'ijazah_path',
                'payment_method',
                'payment_status',
                'payment_reference',
                'payment_amount'
            ]);
        });
    }
};
