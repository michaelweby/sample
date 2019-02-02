<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelatedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // pivot table to self relation
    public function up()
    {
        Schema::create('related_products', function (Blueprint $table) {
            $table->integer('product_id')->unsigned();
            $table->integer('related_id')->unsigned();
            $table->timestamps();
            $table->primary(['product_id','related_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('related_products');
    }
}
