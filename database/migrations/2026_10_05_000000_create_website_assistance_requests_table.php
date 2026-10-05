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
        Schema::create('website_assistance_requests', function (Blueprint $table) {
            $table->id();
            $table->string('institution_name');
            $table->string('institution_type')->default('Rumah Sakit');
            $table->string('pic_name');
            $table->string('pic_position')->nullable();
            $table->string('pic_phone');
            $table->string('pic_email');
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->string('assistance_type')->default('Alat Kesehatan / Lab PCR');
            $table->text('equipment_needed');
            $table->text('urgency_reason')->nullable();
            $table->string('attachment_path')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'approved', 'rejected', 'distributed'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('distributed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_assistance_requests');
    }
};
