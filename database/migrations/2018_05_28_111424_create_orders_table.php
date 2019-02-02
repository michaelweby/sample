<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('status',
                ['processing','on_hold','completed','canceled']
            );
            $table->integer('customer_id');
            $table->string('shipping_id')->nullable();
            $table->string('shipping_value');
            $table->string('coupon_id')->nullable();
            $table->string('note')->nullable();
            $table->integer('total')->nullable();
            $table->integer('discount')->deafualt(0);
            $table->timestamps();
        });

        Schema::create('order_product', function (Blueprint $table) {
            $table->integer('product_id');
            $table->integer('order_id');
            $table->integer('quantity');
            $table->integer('original_price');
            $table->integer('discount')->default(0);
            $table->enum('discount_type',['no_type','pound','percentae']);
            $table->primary(['product_id','order_id']);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_product');
    }
}
