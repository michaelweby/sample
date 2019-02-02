<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponConstraintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_constraints', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coupon_id');
            $table->tinyInteger('allow')->defulat(0);
            $table->enum('type',['vendor','customer','category','product']);
            $table->integer('type_id');
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
        Schema::dropIfExists('coupon_constraints');
    }
}
