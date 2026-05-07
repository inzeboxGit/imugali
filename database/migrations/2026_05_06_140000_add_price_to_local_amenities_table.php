<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('local_amenities', function (Blueprint $table) {
            if (! Schema::hasColumn('local_amenities', 'price')) {
                $table->string('price')->nullable()->after('link_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('local_amenities', function (Blueprint $table) {
            if (Schema::hasColumn('local_amenities', 'price')) {
                $table->dropColumn('price');
            }
        });
    }
};
