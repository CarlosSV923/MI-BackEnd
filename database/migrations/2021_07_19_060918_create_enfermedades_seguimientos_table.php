<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnfermedadesSeguimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enfermedades_seguimientos', function (Blueprint $table) {
            $table->bigIncrements('id_enfermedad_seguimiento');
            $table->bigInteger('enfermedad')->unsigned();
            $table->bigInteger('seguimiento')->unsigned();
            $table->timestamps();

            $table->foreign('seguimiento')
            ->references('id_seguimiento')->on('seguimientos')
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
        Schema::dropIfExists('enfermedades_seguimientos');
    }
}
