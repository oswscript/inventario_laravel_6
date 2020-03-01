<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temporales extends Model {
    //
    protected $table = "temporales";

    protected $fillable = ['id', 'producto_id', 'tributo_id', 'usuario_id', 'cantidad', 'subtotal', 'tipo_proceso'];

	public function posprocesos() {

	    return $this->belongsTo('App\Posproceso');

	}

	public function producto() {

	    return $this->belongsTo('App\Producto');

	}

	public function tributo() {

	    return $this->belongsTo('App\Tributo');

	}

	public function usuario() {

	    return $this->belongsTo('App\User');

	}
}