<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoMedicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_medica', function (Blueprint $table) {
            $table->bigIncrements('id_info_medica');
            $table->bigInteger('cita')->unsigned()->nullable();
            $table->bigInteger('seguimiento')->unsigned()->nullable();
            $table->string('key');
            $table->string('value');
            $table->string('unidad');
            $table->string('descrip')->nullable();
            $table->timestamps();

            $table->foreign('cita')
            ->references('id_cita')->on('citas')
            ->onDelete('set null')
            ->onUpdate('cascade');

            $table->foreign('seguimiento')
            ->references('id_seguimiento')->on('seguimientos')
            ->onDelete('set null')
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
        Schema::dropIfExists('info_medica');
    }
}
