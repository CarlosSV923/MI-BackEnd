<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuidadorSeguimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuidador_seguimiento', function (Blueprint $table) {
            $table->bigIncrements('id_cuidador_seguimiento');
            $table->string('cuidador');
            $table->bigInteger('seguimiento')->unsigned();
            $table->timestamps();
           
            $table->foreign('seguimiento')
            ->references('id_seguimiento')->on('seguimientos')
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
        Schema::dropIfExists('cuidador_seguimiento');
    }
}
