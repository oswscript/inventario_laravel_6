<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',30)->nullable();;
            $table->string('apellido',30)->nullable();;
            $table->string('empresa',50)->nullable();;
            $table->string('cedula',10)->unique();
            $table->string('correo',50)->unique();
            $table->string('telefono',20)->nullable();
            $table->string('tipo_cliente',20)->nullable();         
            $table->longtext('direccion')->nullable();
            $table->char('status', 1)->default('1');    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
