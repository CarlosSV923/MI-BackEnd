<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlergiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alergias', function (Blueprint $table) {
            $table->bigIncrements('id_alergia');
            $table->string('paciente');
            $table->string('descrip')->nullable();
            $table->bigInteger('medicamento')->unsigned();
            $table->timestamps();

            $table->foreign('medicamento')
            ->references('id_medicamento')->on('medicamentos')
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
        Schema::dropIfExists('alergias');
    }
}
