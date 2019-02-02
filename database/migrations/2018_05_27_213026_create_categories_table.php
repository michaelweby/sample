<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('image');
            $table->string('cover')->nullable();
            $table->string('url')->nullable();
            $table->string('cover');
            $table->text('url_cover');
            $table->text('description')->nullabel();
            $table->unsignedInteger('parent_id');
            $table->boolean('elite')->default(0);
            $table->timestamps();
        });
        Schema::create('category_product',function (Blueprint $table){
            $table->integer('category_id');
            $table->integer('product_id');
            $table->primary(['product_id','category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('category_product');
    }
}
