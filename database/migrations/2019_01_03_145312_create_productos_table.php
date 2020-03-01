<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('codigo',30)->unique();;
            $table->integer('categoria_id')->unsigned()->nullable();
            $table->integer('subcategoria_id')->unsigned()->nullable();          
            $table->integer('cantidad');
            $table->longtext('descripcion')->nullable();
            $table->double('precio_costo',30,2)->nullable();
            $table->double('precio_publico',30,2)->nullable();
            $table->integer('tributo_id')->unsigned()->nullable();
            $table->char('status', 1)->default('1');
            $table->string('imagen')->nullable();
            $table->timestamps();

            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');
            $table->foreign('subcategoria_id')->references('id')->on('subcategorias')->onDelete('set null');
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
        Schema::dropIfExists('productos');
    }
}
