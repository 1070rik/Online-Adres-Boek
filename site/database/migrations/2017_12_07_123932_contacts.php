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

        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('voornaam');
            $table->string('tussenvoegsel')->nullable();
            $table->string('achternaam')->nullable();
            $table->datetime('geboortedatum')->nullable();
            $table->string('telefoonnummer')->nullable();
            $table->string('email')->nullable();
            $table->string('fotoPad')->nullable();
            $table->string('beschrijving')->nullable();
            $table->unsignedInteger('adresID')->nullable();
            $table->unsignedInteger('toegevoedDoor')->nullable();
            $table->timestamps();
        });

        Schema::table('contacts', function ($table){
            $table->foreign('adresID')->references('id')->on('addresses');
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
        Schema::dropIfExists('contacts');
    }
}
