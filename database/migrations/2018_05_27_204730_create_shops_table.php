<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('logo');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->text('description')->nullabel();
            $table->string('bank_account_number')->length(20)->nullable();
            $table->string('bank_account_name')->nullable();
            $table->boolean('elite')->default(false);
            $table->boolean('fixed')->default(false);
            $table->enum('status',['active','inactive']);
            $table->float('rate');
            $table->unsignedInteger('commission')->nullable();
            $table->unsignedInteger('owner_id');
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
        Schema::dropIfExists('shops');
    }
}
