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
            $table->dateTime('inicio_cita');
            $table->dateTime('fin_cita');
            $table->string('init_comment')->nullable();
            $table->string('estado')->default("P");
            $table->string('observRec')->nullable();
            $table->string('planTratam')->nullable();
            $table->string('procedimiento')->nullable();
            $table->string('instrucciones')->nullable();
            $table->string('sintomas')->nullable();
            $table->dateTime('fecha_agendada')->nullable();
            $table->dateTime('fecha_atencion')->nullable();
            $table->bigInteger('seguimiento')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('seguimiento')
            ->references('id_seguimiento')->on('seguimientos')
            ->onDelete('set null')
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
