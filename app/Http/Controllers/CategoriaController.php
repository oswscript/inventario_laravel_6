<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoriaFormRequest;
use App\Http\Requests\UpdateCategoriaFormRequest;
use App\Http\Controllers\Controller;
use App\Producto;
use App\Categoria;
use App\SubCategoria;
use App\Configuracion;

class CategoriaController extends Controller
{
    
    public function __construct(){

        $sistema = Configuracion::where('id', '=', 1)->firstOrFail();

        \App::setLocale($sistema->idioma);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos     =  Categoria::all();
        $sistema   =  Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.categoria.index', compact('datos','sistema'));
    }

    /**
     * Show the form for creating a new resour0ce.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sistema =  Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.categoria.create', compact('sistema'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriaFormRequest $request)
    {
        
        $nombre = strtoupper($request->get('nombre'));

        $datos = new Categoria(array(
            'nombre' => $nombre,
        ));

        $datos->save();

        return redirect('/categorias')->with('status', __('idioma.alert_registro'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datos   =  Categoria::whereId($id)->firstOrFail();
        $sistema =  Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.categoria.show', compact('datos','sistema'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datos   = Categoria::whereId($id)->firstOrFail();
        $sistema = Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.categoria.edit', compact('datos','sistema'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoriaFormRequest $request, $id)
    {
        $datos  = Categoria::whereId($id)->firstOrFail();
        $nombre = strtoupper($request->get('nombre'));

        $datos->nombre = $nombre;
        $datos->save();

        return redirect()->action('CategoriaController@show', $datos->id)->with('status', __('idioma.alert_actua'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $consulta_producto     = Producto::where('categoria_id', '=', $id)->count();
        $consulta_subcategoria = SubCategoria::where('categoria_id', '=', $id)->count();
        
        if($consulta_producto > 0 or $consulta_subcategoria > 0){

            return redirect()->action('CategoriaController@show',$id)->with('error', __('idioma.alert_ya_uso'));
           
        }else{
            
            //ELIMINAR CATEGORIA
            $datos = Categoria::whereId($id)->firstOrFail();
            $datos->delete();

            return redirect('/categorias')->with('status', __('idioma.alert_borrar'));

        }
    }
}
