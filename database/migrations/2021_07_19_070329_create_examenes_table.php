<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examenes', function (Blueprint $table) {
            $table->bigIncrements('id_examen');
            $table->string('medico');
            $table->string('paciente');
            $table->bigInteger('cita')->unsigned();
            $table->bigInteger('seguimiento')->unsigned();
            $table->string('tipo_examen');
            $table->string('diagnostico');
            $table->string('url_examen');
            $table->string('comentarios');
            $table->timestamps();

            $table->foreign('paciente')
            ->references('cedula')->on('personas')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('medico')
            ->references('cedula')->on('personas')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('cita')
            ->references('id_cita')->on('citas')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('seguimiento')
            ->references('id_seguimiento')->on('seguimientos')
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
        Schema::dropIfExists('examenes');
    }
}
