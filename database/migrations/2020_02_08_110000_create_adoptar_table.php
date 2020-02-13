<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdoptarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adoptar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger ('idPersona')->unsigned();
            $table->foreign('idPersona')->references('id')->on('personas');
            $table->string('nombreMacota', 45)->nullable();
            $table->string('especie', 45)->nullable();
            $table->string('raza', 30)->nullable();
            $table->string('fechaNacimiento', 25)->nullable();
            $table->string('edad', 4)->nullable();
            $table->string('observacion', 200)->nullable();
            $table->string('imagen')->nullable();
            $table->boolean('estado')->default(1);    
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adoptar');
    }
}
