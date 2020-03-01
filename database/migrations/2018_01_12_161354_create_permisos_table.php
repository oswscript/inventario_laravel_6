<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permisos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('catego_i')->default('0');
            $table->integer('catego_r')->default('0');
            $table->integer('catego_e')->default('0');
            $table->integer('catego_b')->default('0');
            $table->integer('subcatego_i')->default('0');
            $table->integer('subcatego_r')->default('0');
            $table->integer('subcatego_e')->default('0');
            $table->integer('subcatego_b')->default('0');
            $table->integer('producto_i')->default('0');
            $table->integer('producto_r')->default('0');
            $table->integer('producto_e')->default('0');
            $table->integer('producto_b')->default('0');
            $table->integer('gasto_i')->default('0');
            $table->integer('gasto_r')->default('0');
            $table->integer('gasto_e')->default('0');
            $table->integer('gasto_b')->default('0');
            $table->integer('kardex_i')->default('0');
            $table->integer('venta_i')->default('0');
            $table->integer('venta_r')->default('0');
            $table->integer('compra_i')->default('0');
            $table->integer('compra_r')->default('0');
            $table->integer('persona_i')->default('0');
            $table->integer('reporte_i')->default('0');
            $table->integer('rol_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('rol_id')->references('id')->on('roles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permisos');
    }
}
