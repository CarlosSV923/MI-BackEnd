<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->bigIncrements('id_cita');
            $table->string('medico');
            $table->string('paciente');
            $table->string('estado')->default("P");
            $table->string('observRec')->nullable();
            $table->string('planTratam')->nullable();
            $table->string('procedimiento')->nullable();
            $table->string('instrucciones');
            $table->string('sintomas');
            $table->date('fecha_agendada');
            $table->date('fecha_atencion');
            $table->bigInteger('seguimiento')->unsigned();
            $table->timestamps();

            $table->foreign('seguimiento')
            ->references('id_seguimiento')->on('seguimientos')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            
            $table->foreign('paciente')
            ->references('cedula')->on('personas')
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
        Schema::dropIfExists('citas');
    }
}
