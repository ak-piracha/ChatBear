<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('user_a_id',false,true);
            $table->integer('user_b_id',false,true);
            $table->integer('type_id',false,true);
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('room_types');
            $table->foreign('user_a_id')->references('id')->on('users');   
            $table->foreign('user_b_id')->references('id')->on('users');   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
