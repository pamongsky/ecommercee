<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
    Schema::create('products', function (Blueprint $t) {
        $t->id();
        $t->string('name');
        $t->foreignId('category_id')->constrained()->cascadeOnDelete();
        $t->unsignedInteger('stock')->default(0);
        $t->unsignedBigInteger('price'); // simpan rupiah tanpa koma
        $t->boolean('is_active')->default(true);
        $t->string('image_path')->nullable();
        $t->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
