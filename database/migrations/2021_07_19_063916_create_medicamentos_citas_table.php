<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicamentosCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicamentos_citas', function (Blueprint $table) {
            $table->bigIncrements('id_medicamento_cita');
            $table->bigInteger('cita')->unsigned();
            $table->bigInteger('medicamento')->unsigned();
            $table->string('dosis')->nullable();
            $table->string('frecuencia')->nullable();
            $table->string('duracion')->nullable();
            $table->timestamps();

            $table->foreign('cita')
            ->references('id_cita')->on('citas')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('medicamento')
            ->references('id_medicamento')->on('medicamentos')
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
        Schema::dropIfExists('medicamentos_citas');
    }
}
