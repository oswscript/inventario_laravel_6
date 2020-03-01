<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleProceso extends Model {
    //
    protected $table = "detalleprocesos";

    protected $fillable = ['id', 'codigo_proceso', 'proceso_id', 'producto_id', 'tributo_id', 'cantidad', 'subtotal', 'costo_publico_vendido'];

	public function posprocesos() {

	    return $this->belongsTo('App\Posproceso');

	}

	public function producto() {

	    return $this->belongsTo('App\Producto');

	}

	public function tributo() {

	    return $this->belongsTo('App\Tributo');

	}
}