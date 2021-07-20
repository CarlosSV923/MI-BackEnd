<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicoEspecialidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medico_especialidad', function (Blueprint $table) {
            $table->bigIncrements('id_medico_especialidad');
            $table->string('medico');
            $table->bigInteger('especialidad')->unsigned();
            $table->timestamps();

            $table->foreign('especialidad')
            ->references('id_especialidad')->on('especialidades')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('medico')
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
        Schema::dropIfExists('medico_especialidad');
    }
}
