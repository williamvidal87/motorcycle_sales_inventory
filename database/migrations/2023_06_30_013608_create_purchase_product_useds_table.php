<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseProductUsedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_product_useds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_product_id');
            $table->unsignedBigInteger('product_category_id');
            $table->unsignedBigInteger('item_id');
            $table->decimal('price', 9, 2)->nullable();
            $table->string('qty');
            
            $table->foreign('purchase_product_id')->references('id')->on('purchase_products');
            $table->foreign('product_category_id')->references('id')->on('product_categories');
            $table->foreign('item_id')->references('id')->on('inventories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_product_useds');
    }
}
