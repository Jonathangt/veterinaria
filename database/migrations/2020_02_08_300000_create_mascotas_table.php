<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMascotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mascotas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger ('idUsuario')->unsigned();
            $table->foreign('idUsuario')->references('id')->on('users');
            $table->bigInteger ('idCliente')->unsigned();
            $table->foreign('idCliente')->references('id')->on('clientes')->onDelete('cascade');
            $table->string('nombreMascota', 30)->nullable();
            $table->string('especie', 45)->nullable();
            $table->string('raza', 30)->nullable();
            $table->string('fechaNacimiento', 40)->nullable();
            $table->string('edad', 15)->nullable();
            $table->string('sexo', 20)->nullable();
            //$table->boolean('estado')->default(1);    
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
        Schema::dropIfExists('mascotas');
    }
}
