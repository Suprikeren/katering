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
    Schema::create('order_items', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('order_id');
        $table->foreign('order_id')
            ->references('id')
            ->on('orders')
            ->onDelete('cascade');

        $table->unsignedBigInteger('menu_id')->nullable();
        $table->foreign('menu_id')
            ->references('id')
            ->on('menus')
            ->onDelete('set null');

        $table->string('menu_name');
        $table->integer('price');
        $table->unsignedInteger('quantity');
        $table->integer('subtotal');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
