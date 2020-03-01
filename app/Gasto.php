<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model {
    //
    protected $table = "gastos";

    protected $fillable = ['id', 'monto', 'usuario_id', 'codigo', 'concepto', 'observacion', 'fecha', 'created_at'];

    
    public function usuario() {

        return $this->belongsTo('App\User');

    }

}
