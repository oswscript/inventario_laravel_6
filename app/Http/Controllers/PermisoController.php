<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permiso;
use App\Roles;
use App\Configuracion;

class PermisoController extends Controller
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
        $sistema  = Configuracion::where('id', '=', 1)->firstOrFail();
        $permisos = Permiso::where('rol_id', '!=', 1)->where('rol_id', '!=', 2)->get();;
        return view('Back.configuracion.permiso.index', compact('permisos','sistema'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permisos = Permiso::whereId($id)->firstOrFail();
        $sistema  = Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.configuracion.permiso.show', compact('permisos','sistema'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {       

        $post     = $request->all();

        
        //VATIABLES DEL MODULO CATEGORIA
        if(isset($post['catego_i'])){$catego_i= $post['catego_i'];}else{$catego_i= 0;}
        if(isset($post['catego_r'])){$catego_r= $post['catego_r'];}else{$catego_r= 0;}
        if(isset($post['catego_e'])){$catego_e= $post['catego_e'];}else{$catego_e= 0;}
        if(isset($post['catego_b'])){$catego_b= $post['catego_b'];}else{$catego_b= 0;}

        //VATIABLES DEL MODULO SUBCATEGORIA
        if(isset($post['subcatego_i'])){$subcatego_i= $post['subcatego_i'];}else{$subcatego_i= 0;}
        if(isset($post['subcatego_r'])){$subcatego_r= $post['subcatego_r'];}else{$subcatego_r= 0;}
        if(isset($post['subcatego_e'])){$subcatego_e= $post['subcatego_e'];}else{$subcatego_e= 0;}
        if(isset($post['subcatego_b'])){$subcatego_b= $post['subcatego_b'];}else{$subcatego_b= 0;}
        
        //VATIABLES DEL MODULO PRODUCTO
        if(isset($post['producto_i'])){$producto_i= $post['producto_i'];}else{$producto_i= 0;}
        if(isset($post['producto_r'])){$producto_r= $post['producto_r'];}else{$producto_r= 0;}
        if(isset($post['producto_e'])){$producto_e= $post['producto_e'];}else{$producto_e= 0;}
        if(isset($post['producto_b'])){$producto_b= $post['producto_b'];}else{$producto_b= 0;}

        //VATIABLES DEL MODULO GASTO
        if(isset($post['gasto_i'])){$gasto_i= $post['gasto_i'];}else{$gasto_i= 0;}
        if(isset($post['gasto_e'])){$gasto_e= $post['gasto_e'];}else{$gasto_e= 0;}
        if(isset($post['gasto_r'])){$gasto_r= $post['gasto_r'];}else{$gasto_r= 0;}
        if(isset($post['gasto_b'])){$gasto_b= $post['gasto_b'];}else{$gasto_b= 0;}

        //VATIABLES DEL MODULO KARDEX
        if(isset($post['kardex_i'])){$kardex_i= $post['kardex_i'];}else{$kardex_i= 0;}

        //VATIABLES DEL MODULO VENTA
        if(isset($post['venta_i'])){$venta_i= $post['venta_i'];}else{$venta_i= 0;}
        if(isset($post['venta_r'])){$venta_r= $post['venta_r'];}else{$venta_r= 0;}

        //VATIABLES DEL MODULO COMPRA
        if(isset($post['compra_i'])){$compra_i= $post['compra_i'];}else{$compra_i= 0;}
        if(isset($post['compra_r'])){$compra_r= $post['compra_r'];}else{$compra_r= 0;}

        //VATIABLES DEL MODULO PERSONA
        if(isset($post['persona_i'])){$persona_i= $post['persona_i'];}else{$persona_i= 0;}

        //VATIABLES DEL MODULO REPORTE
        if(isset($post['reporte_i'])){$reporte_i= $post['reporte_i'];}else{$reporte_i= 0;}
       
            $update             = Permiso::where('id', '=', $id)->firstOrFail();
            
            //CATEGORIA
            $update->catego_i  = $catego_i;
            $update->catego_r  = $catego_r;
            $update->catego_e  = $catego_e;
            $update->catego_b  = $catego_b;
            
            //SUBCATEGORIA
            $update->subcatego_i  = $subcatego_i;
            $update->subcatego_r  = $subcatego_r;
            $update->subcatego_e  = $subcatego_e;
            $update->subcatego_b  = $subcatego_b;

            //PRODUCTO
            $update->producto_i  = $producto_i;
            $update->producto_r  = $producto_r;
            $update->producto_e  = $producto_e;
            $update->producto_b  = $producto_b;
            
            //GASTO
            $update->gasto_i  = $gasto_i;
            $update->gasto_r  = $gasto_r;
            $update->gasto_e  = $gasto_e;
            $update->gasto_b  = $gasto_b;

            //KARDEX
            $update->kardex_i    = $kardex_i;
            
            //VENTA
            $update->venta_i    = $venta_i;
            $update->venta_r    = $venta_r;

            //VENTA
            $update->compra_i   = $compra_i;
            $update->compra_r   = $compra_r;

            //PERSONA
            $update->persona_i  = $persona_i;

            //REPORTE
            $update->reporte_i  = $reporte_i;


            //GUARDAR
            $update->save();

            return redirect("/configuracion/permiso/show_permiso/$id")->with('status', __('idioma.alert_actua'));
            
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
