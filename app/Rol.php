<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model {
    //
    protected $table = "roles";

    protected $fillable = ['id', 'nombre', 'status'];

    public function usuario() {
        return $this->hasMany('App\Usuario');
    }


}
