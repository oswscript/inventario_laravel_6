<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $table = "configuracion";

    protected $fillable = ['id','nombre_empresa','slogan','codigo_empresa','logo','correo','telefono','moneda','tributo','recuperar_clave_login','registro_usuario_login'];

   
}
