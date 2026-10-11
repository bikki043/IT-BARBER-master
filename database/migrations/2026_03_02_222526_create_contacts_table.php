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
    Schema::create('contacts', function (Blueprint $table) {
        $table->id();
        $table->text('address')->nullable();       // ที่อยู่ร้าน
        $table->string('phone')->nullable();       // เบอร์โทร
        $table->string('email')->nullable();       // อีเมล (ถ้ามี)
        $table->string('facebook')->nullable();    // ลิงก์ FB
        $table->string('instagram')->nullable();   // ลิงก์ IG
        $table->string('line_id')->nullable();     // Line ID
        $table->text('google_map_iframe')->nullable(); // โค้ดแผนที่จาก Google
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
