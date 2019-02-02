<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username')->unique();
            $table->string('phone');
            $table->timestamp('birthday');
            $table->enum('gender',['male','female']);
            $table->string('email')->unique();
            $table->text('image')->nullable();
            $table->string('password');
            $table->text('address')->nullable();
            $table->enum('type',['admin','vendor','customer']);
            $table->boolean('activated')->default(false);
            $table->string('facebook_id')->nullable();
            $table->string('google_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
