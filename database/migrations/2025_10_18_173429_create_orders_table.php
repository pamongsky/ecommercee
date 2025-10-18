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
        Schema::create('orders', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->string('recipient_name');
            $t->string('phone');
            $t->text('address_text');
            $t->string('note')->nullable();
            $t->unsignedBigInteger('subtotal');
            $t->unsignedBigInteger('shipping_cost')->default(0);
            $t->unsignedBigInteger('grand_total');
            $t->string('status')->default('pending'); // pending|processing|shipped|completed|cancelled
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};