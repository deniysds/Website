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
        Schema::create('website_collaboration_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collaboration_id')->constrained('website_collaborations')->cascadeOnDelete();
            $table->string('item_number')->comment('Nomor urut atau kode inventaris peralatan');
            $table->string('name')->comment('Nama peralatan');
            $table->string('unit')->comment('Satuan peralatan (Unit, Set, Pcs, dll)');
            $table->integer('quantity')->default(1)->comment('Jumlah unit peralatan');
            $table->text('specifications')->nullable()->comment('Spesifikasi / catatan tambahan');
            $table->integer('order_no')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_collaboration_items');
    }
};
