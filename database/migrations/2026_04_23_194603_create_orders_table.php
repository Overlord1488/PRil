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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('number', 30)->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('status', 30)->default('pending_payment');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->boolean('has_digital')->default(false);
            $table->boolean('has_physical')->default(false);
            $table->string('shipping_name', 200)->nullable();
            $table->string('shipping_phone', 32)->nullable();
            $table->string('shipping_city', 120)->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('shipping_zip', 20)->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
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
