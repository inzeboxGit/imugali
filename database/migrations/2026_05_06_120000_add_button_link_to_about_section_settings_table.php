<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_section_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('about_section_settings', 'button_link')) {
                $table->string('button_link')->nullable()->after('signature');
            }
        });
    }

    public function down(): void
    {
        Schema::table('about_section_settings', function (Blueprint $table) {
            if (Schema::hasColumn('about_section_settings', 'button_link')) {
                $table->dropColumn('button_link');
            }
        });
    }
};
