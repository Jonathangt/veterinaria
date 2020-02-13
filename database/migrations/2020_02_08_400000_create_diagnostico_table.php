<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosticoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnostico', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger ('idUsuario')->unsigned();
            $table->foreign('idUsuario')->references('id')->on('users');
            $table->bigInteger ('idPersona')->unsigned();
            $table->foreign('idPersona')->references('id')->on('personas')->onDelete('cascade');

            $table->string('tipoProcedimiento', 45)->nullable();
            $table->string('modoOptencion', 40)->nullable();
            $table->string('observacionDiagnostico', 200)->nullable();
            $table->string('fechaAtencion', 40)->nullable();
            $table->string('horaAtencion',10)->nullable();
            $table->string('medicamento',200)->nullable();
            $table->string('horario',200)->nullable();
            $table->string('observacionReceta',200)->nullable();          
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
        Schema::dropIfExists('diagnostico');
    }
}
