<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuidadorCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuidador_cita', function (Blueprint $table) {
            $table->bigIncrements('id_cuidador_cita');
            $table->string('cuidador');
            $table->bigInteger('cita')->unsigned();
            $table->timestamps();

            $table->foreign('cuidador')
            ->references('cedula')->on('personas')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('cita')
            ->references('id_cita')->on('citas')
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
        Schema::dropIfExists('cuidador_citas');
    }
}
