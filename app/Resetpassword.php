<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resetpassword extends Model {
    //
    protected $table = "resetpassword";

    protected $fillable = ['id', 'user_id', 'correo', 'token_md5'];

    public function usuario() {
        return $this->belongsTo('App\Usuario');
    }


}
