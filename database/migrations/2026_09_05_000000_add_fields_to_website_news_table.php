<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('website_news', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
            $table->string('author_name')->nullable()->after('category');
            $table->string('tags')->nullable()->after('author_name');
            $table->unsignedBigInteger('views_count')->default(0)->after('is_published');
            $table->boolean('is_featured')->default(false)->after('views_count');
        });

        // Generate slugs for any existing records
        if (Schema::hasTable('website_news')) {
            $items = DB::table('website_news')->whereNull('slug')->get();
            foreach ($items as $item) {
                $baseSlug = Str::slug($item->title) ?: 'berita-' . $item->id;
                $slug = $baseSlug;
                $counter = 1;

                while (DB::table('website_news')->where('slug', $slug)->where('id', '!=', $item->id)->exists()) {
                    $slug = "{$baseSlug}-{$counter}";
                    $counter++;
                }

                DB::table('website_news')->where('id', $item->id)->update([
                    'slug' => $slug,
                    'author_name' => 'Tim Redaksi YSDS',
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_news', function (Blueprint $table) {
            $table->dropColumn(['slug', 'author_name', 'tags', 'views_count', 'is_featured']);
        });
    }
};
