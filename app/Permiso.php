<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = "permisos";

    protected $fillable = ['id', 'rol_id', 'usuario_i', 'usuario_r', 'usuario_e', 'usuario_b', 'rol_i', 'rol_r', 'rol_e', 'rol_b'];

    public function rol() {
        return $this->belongsTo('App\Rol');
    }
}
