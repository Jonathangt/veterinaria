<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger ('idUsuario')->unsigned();
            $table->foreign('idUsuario')->references('id')->on('users');
            $table->string('recaudacion', 200)->nullable();
            $table->string('lugar', 200)->nullable();
            $table->string('motivo', 200)->nullable();
            $table->string('telefono', 10)->nullable();
            $table->string('email', 200)->nullable();
            $table->string('direccion', 200)->nullable();
            $table->string('fechaInicio', 25)->nullable();
            $table->string('fechaFin', 25)->nullable();
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
        Schema::dropIfExists('donaciones');
    }
}
