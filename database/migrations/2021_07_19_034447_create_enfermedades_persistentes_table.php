<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnfermedadesPersistentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enfermedades_persistentes', function (Blueprint $table) {
            $table->bigIncrements('id_enfermedad_persistente');
            $table->string('paciente');
            $table->string('descrip')->nullable();
            $table->bigInteger('enfermedad')->unsigned();
            $table->timestamps();

            $table->foreign('enfermedad')
            ->references('id_enfermedad')->on('enfermedades')
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
        Schema::dropIfExists('enfermedades_persistentes');
    }
}
