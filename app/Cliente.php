<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model {
    //
    protected $table = "clientes";

    protected $fillable = ['id', 'nombre', 'apellido', 'empresa', 'cedula', 'correo', 'telefono', 'direccion', 'status', 'tipo_cliente'];

	public function posprocesos() {

        return $this->hasMany('App\Posproceso');

    }
}