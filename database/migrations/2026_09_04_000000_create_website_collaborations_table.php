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
        Schema::create('website_collaborations', function (Blueprint $table) {
            $table->id();
            $table->string('institution_name');
            $table->string('institution_logo')->nullable();
            $table->string('category')->nullable();
            $table->string('location')->nullable();
            $table->date('handover_date')->nullable();
            $table->string('pic_name')->nullable();
            $table->text('description')->nullable();
            $table->integer('order_no')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_collaborations');
    }
};
