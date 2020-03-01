<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosprocesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posprocesos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo_proceso',50);
            $table->integer('cliente_id')->unsigned()->nullable();
            $table->integer('usuario_id')->unsigned()->nullable();
            $table->double('subtotal',30,2);
            $table->integer('descuento');
            $table->double('total',30,2);
            $table->string('tipo_pago',50);
            $table->integer('items_totales');
            $table->integer('registros_totales');
            $table->longtext('comentario')->nullable();
            $table->string('tipo_proceso',10);
            $table->longtext('motivo_rechazo')->nullable();
            $table->char('status', 1)->default('1');
            $table->timestamps();

            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('set null');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posprocesos');
    }
}
