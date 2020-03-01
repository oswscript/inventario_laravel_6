<?php



namespace App;



use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;



class User extends Authenticatable

{

    use Notifiable;



    protected $table = "users";



    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    protected $fillable = [

        'id', 'nombre', 'apellido', 'imagen', 'cedula', 'email', 'sexo', 'telefono', 'direccion', 'password', 'rol_id', 'cargo', 'edad','institucion', 'created_at', 'status'

    ];



    /**

     * The attributes that should be hidden for arrays.

     *

     * @var array

     */

    protected $hidden = [

        'password', 'remember_token',

    ];


    public function rol() {

        return $this->belongsTo('App\Rol');

    }

     public function resetpassword() {

        return $this->hasOne('App\Resetpassword');

    }

    public function temporales() {

        return $this->hasMany('App\Temporales');

    }

    public function gastos() {

        return $this->hasMany('App\Gasto');

    }


}

