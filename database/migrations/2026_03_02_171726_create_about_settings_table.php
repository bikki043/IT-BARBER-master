<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
    Schema::create('about_settings', function (Blueprint $table) {
        $table->id();
        $table->string('hero_title')->default('THE LEGACY');
        $table->text('story_description'); // ประวัติร้าน
        $table->string('stat_years')->default('5+'); // สถิติปี
        $table->string('stat_cuts')->default('25k+'); // สถิติจำนวนลูกค้า
        $table->string('stat_satisfaction')->default('100%'); // ความพึงพอใจ
        $table->string('image_path')->nullable(); // รูปภาพหลัก
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_settings');
    }
};
