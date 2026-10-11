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
        Schema::table('customers', function (Blueprint $table) {
            // ✅ เช็คก่อนว่ามี google_id หรือยัง ถ้าไม่มีค่อยเพิ่ม
            if (!Schema::hasColumn('customers', 'google_id')) {
                $table->string('google_id')->nullable()->after('id');
            }

            // ✅ ปรับให้ password เป็น null ได้
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
