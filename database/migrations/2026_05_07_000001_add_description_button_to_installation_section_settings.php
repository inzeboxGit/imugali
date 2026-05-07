<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('installation_section_settings', function (Blueprint $table) {
            $table->text('description')->nullable()->after('subtitle');
            $table->string('button_link')->nullable()->after('description');
            $table->string('button_text')->nullable()->after('button_link');
        });
    }

    public function down(): void
    {
        Schema::table('installation_section_settings', function (Blueprint $table) {
            $table->dropColumn(['description', 'button_link', 'button_text']);
        });
    }
};
