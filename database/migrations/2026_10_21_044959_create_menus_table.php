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
    Schema::create('menus', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('merchant_id');
        $table->foreign('merchant_id')
            ->references('id')
            ->on('merchants')
            ->onDelete('cascade');
        $table->string('name');
        $table->text('description')->nullable();
        $table->string('photo')->nullable();
        $table->integer('price');
        $table->enum('is_available', ['yes', 'no'])->default('yes');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
