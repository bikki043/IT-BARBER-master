<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // ตรวจสอบก่อนว่ามีคอลัมน์ duration หรือยัง ถ้ายังไม่มีค่อยสร้าง
        if (!Schema::hasColumn('services', 'duration')) {
            Schema::table('services', function (Blueprint $table) {
                $table->integer('duration')->default(30)->after('price');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'duration')) {
                $table->dropColumn('duration');
            }
        });
    }
};