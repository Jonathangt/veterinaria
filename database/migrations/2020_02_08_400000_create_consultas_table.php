<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger ('idUsuario')->unsigned();
            $table->foreign('idUsuario')->references('id')->on('users');
            $table->bigInteger ('idCliente')->unsigned();
            $table->foreign('idCliente')->references('id')->on('clientes')->onDelete('cascade');
            $table->bigInteger ('idMascota')->unsigned();
            $table->foreign('idMascota')->references('id')->on('mascotas')->onDelete('cascade');
            $table->string('esterilizado', 5)->nullable();
            $table->string('tipoProcedimiento', 45)->nullable();
            $table->string('modoOptencion', 40)->nullable();
            $table->string('peso', 15)->nullable();
            $table->string('observacionDiagnostico', 200)->nullable();
            $table->string('fechaAtencion', 25)->nullable();
            $table->string('horaAtencion',25)->nullable();
            $table->string('medicamento',200)->nullable();
            $table->string('horario',200)->nullable();
            $table->string('observacionReceta',200)->nullable(); 
            $table->string('fechaSgtConsulta', 25)->nullable();         
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
        Schema::dropIfExists('consultas');
    }
}
