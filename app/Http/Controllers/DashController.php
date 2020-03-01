<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

use App\User;
use App\Gasto;
use App\Producto;
use App\Cliente;
use App\Posproceso;
use App\DetalleProceso;
use App\Configuracion;

class DashController extends Controller {

    public function __construct(){

        $sistema = Configuracion::where('id', '=', 1)->firstOrFail();

        \App::setLocale($sistema->idioma);
    }
    
    // DASHBORARD
    public function dash() {
        
        $sistema				  = Configuracion::where('id', '=', 1)->firstOrFail();

        //Clientes
        $clientes_existencia      = Cliente::where('tipo_cliente','=','CLIENTE')->where('status','=',1)->count();

        //Proveedores
        $proveedor_existencia     = Cliente::where('tipo_cliente','=','PROVEEDOR')->where('status','=',1)->count();

        //Gastos
        $gastos_existencia        = Cliente::all()->count();
        
        //Usuarios
    	  $usuarios_existencia      = User::where('rol_id', '!=', 1)->where('id', '!=', 2)->where('status', '=', 1)->count();
        $ultimos_usuarios		  = User::where('rol_id', '!=', 1)->where('id', '!=', 2)->where('status', '=', 1)->get();
        
        //Productos
    	  $productos_existencia     = Producto::all()->count();
        $ultimos_productos		  = Producto::where('status', '=', 1)->get();

        //Compras
        $compras_existencia       = Posproceso::where('tipo_proceso', '=', 'compra')->where('status', '=', 2)->count();
        $ultimas_compras  		  = Posproceso::where('tipo_proceso', '=', 'compra')->orderBy('created_at', 'desc')->limit(3)->get();

        //Calcular total de compras
        $consulta_compras  		  = Posproceso::where('tipo_proceso', '=', 'compra')->where('status', '=', 2)->get();
        $total_compras            = 0;

        foreach($consulta_compras as $key => $cc){

            $total_compras += $cc->total;
        }
        
        //Ventas
        $ventas_existencia        = Posproceso::where('tipo_proceso', '=', 'venta')->where('status', '=', 2)->count();
        $ultimas_ventas  		  = Posproceso::where('tipo_proceso', '=', 'venta')->orderBy('created_at', 'desc')->limit(3)->get();

        //Calcular total de ventas
        $consulta_ventas  		  = Posproceso::where('tipo_proceso', '=', 'venta')->where('status', '=', 2)->get();
        $total_ventas             = 0;

        foreach($consulta_ventas as $key => $cv){

            $total_ventas += $cv->total;
        }
        
    	return view('Back.index', compact('sistema', 'usuarios_existencia', 'ultimos_usuarios', 'productos_existencia', 'ultimos_productos', 'compras_existencia', 'ventas_existencia', 'ultimas_compras', 'ultimas_ventas', 'total_compras', 'total_ventas', 'clientes_existencia', 'proveedor_existencia', 'gastos_existencia'));

    }


}

