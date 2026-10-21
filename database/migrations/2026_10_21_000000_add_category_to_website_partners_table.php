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
        if (Schema::hasTable('website_partners') && !Schema::hasColumn('website_partners', 'category')) {
            Schema::table('website_partners', function (Blueprint $table) {
                $table->string('category')->nullable()->after('type');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('website_partners') && Schema::hasColumn('website_partners', 'category')) {
            Schema::table('website_partners', function (Blueprint $table) {
                $table->dropColumn('category');
            });
        }
    }
};
