<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('payment_slip')->nullable();
            $table->string('payment_status')->default('unpaid'); // unpaid, pending, paid, rejected
            $table->timestamp('slip_uploaded_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['payment_slip', 'payment_status', 'slip_uploaded_at']);
        });
    }
};