<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategoria extends Model {
    //
    protected $table = "subcategorias";

    protected $fillable = ['id', 'nombre', 'categoria_id'];

    public function categoria() {

        return $this->belongsTo('App\Categoria');

    }

    public function producto() {

        return $this->hasMany('App\Producto');

    }

}
