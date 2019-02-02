<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->string('serial_number');
            $table->float('price');
            $table->integer('discount');
            $table->enum('type',['pound','percentage']);
            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
            $table->string('image');
            $table->unsignedInteger('shop_id');
            $table->boolean('recommendation');
            $table->boolean('published');
            $table->integer('preparing_days')->unsigned();
            $table->integer('visits')->defualt(0);
            $table->unsignedInteger('priorty')->defualt(0);
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
        Schema::dropIfExists('products');
    }
}
