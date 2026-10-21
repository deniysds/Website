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
        Schema::create('website_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('tag')->default('Kegiatan Terbaru');
            $table->string('year')->default('2026');
            $table->string('partner_name')->nullable();
            $table->string('sponsor_name')->nullable();
            $table->string('banner_image')->nullable();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->string('event_date')->nullable();
            $table->string('event_time')->nullable();
            $table->string('location')->nullable();
            $table->string('registration_url')->nullable();
            $table->boolean('is_featured')->default(true);
            $table->boolean('is_published')->default(true);
            $table->integer('order_no')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_events');
    }
};
