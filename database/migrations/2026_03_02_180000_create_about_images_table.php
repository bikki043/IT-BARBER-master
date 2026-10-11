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
        Schema::create('about_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_setting_id')
                  ->constrained('about_settings')
                  ->onDelete('cascade');
            $table->string('image_path');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // หากมีข้อมูลรูปภาพหลักอยู่ก่อน ให้ย้ายเป็นเรคคอร์ด Gallery
        if (Schema::hasTable('about_settings')) {
            $records = \DB::table('about_settings')->select('id', 'image_path')->whereNotNull('image_path')->get();
            foreach ($records as $rec) {
                \DB::table('about_images')->insert([
                    'about_setting_id' => $rec->id,
                    'image_path' => $rec->image_path,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_images');
    }
};
