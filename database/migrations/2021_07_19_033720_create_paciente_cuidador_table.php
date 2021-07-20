<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacienteCuidadorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paciente_cuidador', function (Blueprint $table) {
            $table->bigIncrements('id_paciente_cuidador');
            $table->string('paciente');
            $table->string('cuidador');
            $table->timestamps();

            $table->foreign('paciente')
            ->references('cedula')->on('personas')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('cuidador')
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
        Schema::dropIfExists('paciente_cuidador');
    }
}
