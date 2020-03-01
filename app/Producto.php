<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model {
    //
    protected $table = "productos";

    protected $fillable = ['id', 'nombre', 'codigo', 'categoria_id', 'subcategoria_id', 'cantidad', 'descripcion', 'precio_costo', 'precio_publico', 'tributo_id', 'status', 'imagen'];

    public function categoria() {

        return $this->belongsTo('App\Categoria');

    }

    public function subcategoria() {

        return $this->belongsTo('App\SubCategoria');

    }

    public function tributo() {

        return $this->belongsTo('App\Tributo');

    }

    public function detalleprocesos() {

        return $this->hasMany('App\DetalleProceso');

    }

    public function temporales() {

        return $this->hasMany('App\Temporales');

    }


}