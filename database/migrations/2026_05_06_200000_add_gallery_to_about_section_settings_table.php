<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_section_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('about_section_settings', 'gallery')) {
                $table->json('gallery')->nullable()->after('third_image');
            }
        });

        // Seed the restaurant_gallery row
        if (Schema::hasTable('about_section_settings')) {
            DB::table('about_section_settings')->updateOrInsert(
                ['section' => 'restaurant_gallery'],
                [
                    'small_title' => 'Image Gallery',
                    'title'       => 'Restaurant Gallery',
                    'gallery'     => json_encode([]),
                    'updated_at'  => now(),
                    'created_at'  => now(),
                ]
            );
        }
    }

    public function down(): void
    {
        Schema::table('about_section_settings', function (Blueprint $table) {
            if (Schema::hasColumn('about_section_settings', 'gallery')) {
                $table->dropColumn('gallery');
            }
        });

        if (Schema::hasTable('about_section_settings')) {
            DB::table('about_section_settings')
                ->where('section', 'restaurant_gallery')
                ->delete();
        }
    }
};
