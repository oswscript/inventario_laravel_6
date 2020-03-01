<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tributo extends Model {
    //
    protected $table = "tributos";

    protected $fillable = ['id', 'nombre', 'tipo', 'monto'];

    public function producto() {

        return $this->hasMany('App\Producto');

    }
    
    public function detalleprocesos() {

        return $this->hasMany('App\DetalleProceso');

    }
    
    public function temporales() {

        return $this->hasMany('App\Temporales');

    }


}