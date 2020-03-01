<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolFormRequest;
use App\Http\Requests\UpdateRolFormRequest;
use App\Rol;
use App\Permiso;
use App\User;
use App\Configuracion;
use Illuminate\Http\Request;

class RolController extends Controller {

    public function __construct(){

        $sistema = Configuracion::where('id', '=', 1)->firstOrFail();

        \App::setLocale($sistema->idioma);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $rols    = Rol::where('id', '!=', 1)->where('id', '!=', 2)->get();
        $sistema =  Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.configuracion.rol.index', compact('rols','sistema'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        
        $sistema =  Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.configuracion.rol.create', compact('sistema'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RolFormRequest $request) {
        //


        $nombre = strtoupper($request->get('nombre'));

        //REGISTRO ROLS
        $rol = new Rol(array(
            'nombre' => $nombre,
        ));

        $rol->save();

        //REGISTRO AUTOMATICO DE LA PERMISOLOGIA ASOCIADA AL NUEVO ROL
        if($rol->id){
            $permiso = new Permiso(array(
                'rol_id'    => $rol->id,
                'catego_i'    => 0,
                'catego_r'    => 0,
                'catego_e'    => 0,
                'catego_b'    => 0,
                'subcatego_i' => 0,
                'subcatego_r' => 0,
                'subcatego_e' => 0,
                'subcatego_b' => 0,
                'producto_i'  => 0,
                'producto_r'  => 0,
                'producto_e'  => 0,
                'producto_b'  => 0,
                'gasto_i'     => 0,
                'gasto_r'     => 0,
                'gasto_e'     => 0,
                'gasto_b'     => 0,
                'kardex_i'    => 0,
                'venta_i'     => 0,
                'venta_r'     => 0,
                'compra_i'    => 0,
                'compra_r'    => 0,
                'persona_i'   => 0,
                'reporte_i'   => 0,
            ));

            $permiso->save();
        }
        return redirect('/configuracion/roles')->with('status', __('idioma.alert_registro'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
        $rol     = Rol::whereId($id)->firstOrFail();
        $sistema =  Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.configuracion.rol.show', compact('rol','sistema'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
        $rol     = Rol::whereId($id)->firstOrFail();
        $sistema = Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.configuracion.rol.edit', compact('rol','sistema'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRolFormRequest $request, $id) {
        //

        $rol    = Rol::whereId($id)->firstOrFail();
        $nombre = strtoupper($request->get('nombre'));

        $rol->nombre = $nombre;
        $rol->save();

        return redirect('/configuracion/roles/')->with('status', __('idioma.alert_actua'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {


        $clientes_existencia =  User::where('rol_id', '=', $id)->count();

        //dd($clientes_existencia);

        if($clientes_existencia > 0){

            return redirect("/configuracion/roles/$id")->with('error', __('idioma.alert_ya_uso'));
           
        }else{
            
             //ELIMINAR PERMISO
            $permiso_id =  Permiso::where('rol_id', '=', $id)->value("id");
            //dd($permiso_id);
            $permiso    =  Permiso::whereId($permiso_id)->firstOrFail();
            $permiso->delete();
            
            //ELIMINAR ROL
            $rol = Rol::whereId($id)->firstOrFail();
            $rol->delete();

            return redirect('/configuracion/roles')->with('status', __('idioma.alert_borrar'));

        }
    }
}
