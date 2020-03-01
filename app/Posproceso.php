<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posproceso extends Model {
    //
    protected $table = "posprocesos";

    protected $fillable = ['id', 'codigo_proceso', 'cliente_id', 'usuario_id', 'subtotal', 'descuento', 'total', 'tipo_pago', 'items_totales', 'registros_totales', 'comentario', 'tipo_proceso', 'status', 'motivo_rechazo', 'created_at'];

	public function cliente() {

	    return $this->belongsTo('App\Cliente');

    }
    
    public function usuario() {

        return $this->belongsTo('App\User');

    }

	public function detalleprocesos() {

        return $this->hasMany('App\DetalleProceso');

    }

    public function temporales() {

        return $this->hasMany('App\Temporales');

    }

}