<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnfermedadesCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enfermedades_citas', function (Blueprint $table) {
            $table->bigIncrements('id_enfermedad_cita');
            $table->bigInteger('cita')->unsigned();
            $table->bigInteger('enfermedad')->unsigned();
            $table->timestamps();

            $table->foreign('cita')
            ->references('id_cita')->on('citas')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('enfermedad')
            ->references('id_enfermedad')->on('enfermedades')
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
        Schema::dropIfExists('enfermedades_citas');
    }
}
