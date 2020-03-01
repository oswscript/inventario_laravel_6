<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguracionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_empresa',100);
            $table->string('slogan',100);
            $table->string('codigo_empresa',30);
            $table->string('telefono',15);
            $table->string('correo',50);
            $table->string('moneda',10);
            $table->string('tributo',10);
            $table->string('idioma',10)->default('es');
            $table->char('recuperar_clave_login',3);
            $table->char('registro_usuario_login',3);
            $table->longtext('logo')->nullable();
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
        Schema::dropIfExists('configuracion');
    }
}
