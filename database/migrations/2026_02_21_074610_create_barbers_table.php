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
        Schema::create('barbers', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // ชื่อช่าง
            $table->string('position');      // ตำแหน่ง (เช่น Master Barber)
            $table->string('specialty');     // ความถนัด
            $table->string('branch');        // สาขา
            $table->string('image_path')->nullable(); // รูปภาพ
            $table->boolean('is_active')->default(true); // สถานะเปิด/ปิดการโชว์
            $table->timestamps();
            $table->softDeletes(); // เพิ่มบรรทัดนี้ลงไป
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barbers');
    }
};
