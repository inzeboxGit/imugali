<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_header_settings', function (Blueprint $table) {
            $columnsToDrop = [];

            if (Schema::hasColumn('page_header_settings', 'availability_small')) {
                $columnsToDrop[] = 'availability_small';
            }
            if (Schema::hasColumn('page_header_settings', 'availability_title')) {
                $columnsToDrop[] = 'availability_title';
            }
            if (Schema::hasColumn('page_header_settings', 'availability_text')) {
                $columnsToDrop[] = 'availability_text';
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }

    public function down(): void
    {
        Schema::table('page_header_settings', function (Blueprint $table) {
            $table->string('availability_small')->nullable();
            $table->string('availability_title')->nullable();
            $table->text('availability_text')->nullable();
        });
    }
};
