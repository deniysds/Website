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
        Schema::create('website_officers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title_prefix')->nullable();
            $table->string('title_suffix')->nullable();
            $table->string('position');
            $table->string('category')->default('pengurus_harian');
            $table->unsignedTinyInteger('hierarchy_level')->default(2);
            $table->string('affiliation')->nullable();
            $table->text('bio')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('email')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->integer('order_no')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['category', 'hierarchy_level', 'order_no']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_officers');
    }
};
