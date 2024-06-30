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
        Schema::create('discounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_discount_id');
            $table->unsignedBigInteger('product_id');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('percentage');
            $table->foreign('category_discount_id')->references('id')->on('discount_categories');
            $table->foreign('product_id')->references('id')->on('products');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
