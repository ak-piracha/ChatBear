<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalIdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_ids', function (Blueprint $table) {
            $table->increments('id');
            $table->string('player_id');
            $table->integer('external_user_id',false,true);
            $table->string('first_name');
            $table->string('channel');
            $table->timestamps();

            $table->foreign('external_user_id')->references('id')->on('users');      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_ids');
    }
}
