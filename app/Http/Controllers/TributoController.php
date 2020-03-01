<?php

namespace App\Http\Controllers;

use App\Http\Requests\TributoFormRequest;
use App\Http\Requests\UpdateTributoFormRequest;
use Illuminate\Http\Request;
use App\Tributo;
use App\Configuracion;
use App\DetalleProceso;

class TributoController extends Controller {
   
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

        $datos    =  Tributo::all();
        $sistema  =  Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.configuracion.tributo.index', compact('datos','sistema'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $sistema =  Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.configuracion.tributo.create', compact('sistema'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TributoFormRequest $request) {
        //


        $nombre = strtoupper($request->get('nombre'));
        $tipo   = $request->get('tipo');
        $monto  = $request->get('monto');

        //REGISTRO ROLS
        $datos = new Tributo(array(
            'nombre' => $nombre,
            'tipo'   => $tipo,
            'monto'  => $monto,
        ));

        $datos->save();

        return redirect('/configuracion/tributos')->with('status',  __('idioma.alert_registro'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
        $datos   = Tributo::whereId($id)->firstOrFail();
        $sistema = Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.configuracion.tributo.show', compact('datos','sistema'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
        $datos   = Tributo::whereId($id)->firstOrFail();
        $sistema = Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.configuracion.tributo.edit', compact('datos','sistema'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTributoFormRequest $request, $id) {
        //

        $datos    = Tributo::whereId($id)->firstOrFail();
        $nombre   = strtoupper($request->get('nombre'));
        $tipo     = $request->get('tipo');
        $monto    = $request->get('monto');

        $datos->nombre = $nombre;
        $datos->tipo   = $tipo;
        $datos->monto  = $monto;
        $datos->save();

        return redirect()->action('TributoController@show', $datos->id)->with('status', __('idioma.alert_actua'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {


         $dato_consulta =  DetalleProceso::where('tributo_id', '=', $id)->count();

        if($dato_consulta > 0){

            return redirect("/configuracion/tributo/$id")->with('error', __('idioma.alert_ya_uso'));
           
        }else{
                        
            //ELIMINAR DATO
            $datos = Tributo::whereId($id)->firstOrFail();
            $datos->delete();

            return redirect('/configuracion/tributos')->with('status', __('idioma.alert_borrar'));

        }
    }
}
