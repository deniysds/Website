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
        Schema::create('website_donations', function (Blueprint $table) {
            $table->id();
            $table->string('donation_code', 32)->unique();
            $table->string('donor_name');
            $table->string('donor_type', 32)->default('individual');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('program_target')->default('alkes_pcr_3t');
            $table->unsignedBigInteger('amount');
            $table->date('transfer_date')->nullable();
            $table->string('payment_method')->default('transfer_bank');
            $table->string('bank_name')->default('BCA');
            $table->string('proof_path')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_donations');
    }
};
