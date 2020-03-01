<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 30);
            $table->string('apellido', 30);
            $table->string('cedula', 10)->unique();
            $table->string('email', 50)->unique();
            $table->string('sexo',2)->nullable();
            $table->string('telefono',20)->nullable();
            $table->longText('direccion')->nullable();
            $table->string('imagen', 100)->nullable();
            $table->integer('rol_id')->unsigned()->nullable();
            $table->char('status', 1)->default('1');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('rol_id')->references('id')->on('roles')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
