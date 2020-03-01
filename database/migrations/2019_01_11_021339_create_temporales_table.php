<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemporalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temporales', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('producto_id')->unsigned()->nullable();
            $table->integer('tributo_id')->unsigned()->nullable();
            $table->integer('usuario_id')->unsigned()->nullable();
            $table->integer('cantidad')->nullable();
            $table->double('subtotal',30,2)->nullable();
            $table->string('tipo_proceso',10);
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('temporal');
    }
}
