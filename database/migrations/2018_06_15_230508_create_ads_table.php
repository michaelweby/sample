<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->timestamp('from')->nullable();
            $table->timestamp('to')->nullable();
            $table->boolean('active')->deafualt(1);
            $table->boolean('home')->deafualt(0);
            $table->boolean('single_product')->deafualt(0);
            $table->unsignedInteger('shows')->deafualt(0);
            $table->unsignedInteger('clicks')->deafualt(0);
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
        Schema::dropIfExists('ads');
    }
}
