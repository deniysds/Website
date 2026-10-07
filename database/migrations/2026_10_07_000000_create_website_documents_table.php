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
        Schema::create('website_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category', 64)->default('laporan_tahunan');
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->unsignedBigInteger('file_size')->default(0);
            $table->string('file_extension', 16)->default('pdf');
            $table->year('published_year')->nullable();
            $table->unsignedInteger('download_count')->default(0);
            $table->unsignedInteger('order_no')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_documents');
    }
};
