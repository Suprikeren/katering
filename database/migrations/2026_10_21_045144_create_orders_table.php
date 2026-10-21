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

        $table->unsignedBigInteger('merchant_id');
        $table->foreign('merchant_id')
            ->references('id')
            ->on('merchants')
            ->onDelete('restrict');

        $table->unsignedBigInteger('customer_id');
        $table->foreign('customer_id')
            ->references('id')
            ->on('customers')
            ->onDelete('restrict');

        $table->string('invoice_number', 50)->unique();
        $table->date('delivery_date');
        $table->text('delivery_address');

        $table->enum('status', [
            'pending',
            'confirmed',
            'preparing',
            'delivered',
            'completed',
            'cancelled',
        ])->default('pending');

        $table->integer('total');
        $table->text('notes')->nullable();
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
