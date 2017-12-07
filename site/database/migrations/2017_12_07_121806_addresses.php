<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Addresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adressen', function (Blueprint $table) {
            $table->increments('id');
            $table->string('straatnaam');
            $table->integer('huisnummer');
            $table->string('toevoeging');
            $table->string('postcode');
            $table->string('plaats');
            $table->string('longitude');
            $table->string('altitude');
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
        Schema::dropIfExists('addresses');
    }
}
