<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Contacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();

        Schema::create('contactpersonen', function (Blueprint $table) {
            $table->increments('id');
            $table->string('voornaam');
            $table->string('tussenvoegsel');
            $table->string('achternaam');
            $table->datetime('geboortedatum');
            $table->string('email');
            $table->string('fotoPad');
            $table->string('beschrijving');
            $table->unsignedInteger('adresID');
            $table->unsignedInteger('toegevoedDoor');
            $table->timestamps();
        });

        Schema::table('contactpersonen', function ($table){
            $table->foreign('adresID')->references('id')->on('adressen');
            $table->foreign('toegevoedDoor')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contactpersonen');
    }
}
