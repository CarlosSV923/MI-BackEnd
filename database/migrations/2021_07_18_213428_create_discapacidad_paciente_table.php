<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscapacidadPacienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discapacidad_paciente', function (Blueprint $table) {
            $table->bigIncrements('id_discapacidad_paciente');
            $table->string('paciente');
            $table->string('descrip')->nullable();
            $table->bigInteger('discapacidad')->unsigned();
            $table->timestamps();

            $table->foreign('discapacidad')
            ->references('id_discapacidad')->on('discapacidades')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('paciente')
            ->references('cedula')->on('personas')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discapacidad_paciente');
    }
}
