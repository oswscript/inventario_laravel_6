<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleprocesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalleprocesos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo_proceso',50);
            $table->integer('proceso_id')->unsigned()->nullable();
            $table->integer('producto_id')->unsigned()->nullable();
            $table->integer('tributo_id')->unsigned()->nullable();
            $table->integer('cantidad');
            $table->double('subtotal',30,2);
            $table->double('costo_publico_vendido',30,2);
            $table->timestamps();


            $table->foreign('proceso_id')->references('id')->on('posprocesos')->onDelete('set null');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('set null');
            $table->foreign('tributo_id')->references('id')->on('tributos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalleprocesos');
    }
}
