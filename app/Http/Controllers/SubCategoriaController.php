<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SubCategoriaFormRequest;
use App\Http\Requests\UpdateSubCategoriaFormRequest;
use App\Http\Controllers\Controller;
use App\Categoria;
use App\Producto;
use App\SubCategoria;
use App\Configuracion;

class SubCategoriaController extends Controller
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
        $datos     =  SubCategoria::all();
        $sistema   =  Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.sub_categoria.index', compact('datos','sistema'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datos_2 =  Categoria::all();
        $sistema =  Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.sub_categoria.create', compact('sistema','datos_2'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubCategoriaFormRequest $request)
    {
        
        $nombre    = strtoupper($request->get('nombre'));
        $catego_id = $request->get('categoria');

        $datos = new SubCategoria(array(
            'nombre'       => $nombre,
            'categoria_id' => $catego_id,
        ));

        $datos->save();

        return redirect('/subcategorias')->with('status', __('idioma.alert_registro'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datos   =  SubCategoria::whereId($id)->firstOrFail();
        $sistema =  Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.sub_categoria.show', compact('datos','sistema'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datos     = SubCategoria::whereId($id)->firstOrFail();
        $datos2    = Categoria::all();
        $sistema   = Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.sub_categoria.edit', compact('datos','sistema','datos2'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubCategoriaFormRequest $request, $id)
    {
        $datos        = SubCategoria::whereId($id)->firstOrFail();
        $nombre       = strtoupper($request->get('nombre'));
        $categoria_id = strtoupper($request->get('categoria'));

        $datos->nombre       = $nombre;
        $datos->categoria_id = $categoria_id;
        $datos->save();


        return redirect()->action('SubCategoriaController@show', $datos->id)->with('status', __('idioma.alert_actua'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        
        $consulta_producto     = Producto::where('subcategoria_id', '=', $id)->count();

        //dd($clientes_existencia);

        if($consulta_producto > 0){

            return redirect()->action('SubCategoriaController@show',$id)->with('error', __('idioma.alert_ya_uso'));
           
        }else{

            $datos = SubCategoria::whereId($id)->firstOrFail();
            $datos->delete();

            return redirect('/subcategorias')->with('status',  __('idioma.alert_borrar'));

        }
    }
}
