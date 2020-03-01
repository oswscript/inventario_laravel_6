<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\DetalleProceso;
use App\Posproceso;
use App\Cliente;
use App\Configuracion;
use App\Producto;
use App\Temporales;
use Barryvdh\DomPDF\Facade as PDF;

class VentaController extends Controller
{
    
    public function __construct(){

        $sistema = Configuracion::where('id', '=', 1)->firstOrFail();

        \App::setLocale($sistema->idioma);
    }
    
     //CALCULAR NUMERO DE FACTURA
    function numero_factura(){

        $anio        = date("Y");
        $mes         = date("m");
        $n_registros = Posproceso::count();
        $n_factura   = $anio.$mes."-".($n_registros+1);

        return $n_factura;

    }   

    //Mostra listado de ventas
    public function index_pendientes()
    {   
        $datos     = Posproceso::where('tipo_proceso','=','venta')->where('status','=',1)->orderBy('created_at', 'desc')->get();
        $sistema   = Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.venta.index_pendientes', compact('sistema','datos'));
    }

    //Mostra listado de ventas
    public function index_rechazadas()
    {   
        $datos     = Posproceso::where('tipo_proceso','=','venta')->where('status','=',0)->orderBy('created_at', 'desc')->get();
        $sistema   = Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.venta.index_rechazadas', compact('sistema','datos'));
    }
    
    //Mostra listado de ventas
    public function index_aprobadas()
    {   
        $datos     = Posproceso::where('tipo_proceso','=','venta')->where('status','=',2)->orderBy('created_at', 'desc')->get();
        $sistema   = Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.venta.index_aprobadas', compact('sistema','datos'));
    }

    public function update_aprobar_status(Request $request)
    {
        $datos  = Posproceso::whereId($request->get("id"))->firstOrFail();

        $datos->status = 2;
        $datos->save();

        return redirect()->action('VentaController@index_pendientes')->with('status',  __('idioma.vent_fac_aproba'));
    }

    public function update_rechazar_status(Request $request)
    {   
        
        $datos  = Posproceso::whereId($request->get("id"))->firstOrFail();

        //ACTUALIZAR STATUS
        $datos->status = 0;
        $datos->motivo_rechazo = $request->get("motivo");
        $datos->save();

        //VOLVER A AGREGAR LOS PRODUCTOS AL STOCK Q SE HABIAN APARTADO EN EL POSPROCESO
        $datos_detalles = DetalleProceso::where('codigo_proceso','=', $datos->codigo_proceso)->get();
        
        foreach($datos_detalles as $dt){
            
            //CAPTURAR PRODUCTOS
            $datos_producto = Producto::whereId($dt->producto_id)->firstOrFail();
            $datos_producto->cantidad = $datos_producto->cantidad + $dt->cantidad;
            $datos_producto->save();
        
        }
        

        return redirect()->action('VentaController@index_pendientes')->with('status', __('idioma.vent_fac_rechaza'));
    }

    //Mostra la vista del POS
    public function create()
    {   
        $datos['n_factura']   = $this->numero_factura();
        $datos['clientes']    = Cliente::where('status','=',1)->where('tipo_cliente','=','CLIENTE')->get();
        $sistema              = Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.venta.pos.index_pos', compact('sistema','datos'));
    }

    //Lista de productos de la modal
    public function pos_cargar_lista_productos()
    {
        
        $lista_productos = Producto::where('status','=',1)
                                    //->where('cantidad','>',0)
                                    ->limit(10)
                                    ->orderBy('id', 'desc')
                                    ->get();

        return json_encode($lista_productos);

    }

    //Cargar lista de productos de la vista principal y montos calculados
    public function pos_cargar_lista_productos_temporal(Request $request)
    {
        
        $subtotal         = 0;
        $subtotal_general = 0;
        $montos_sumados   = 0;
        $cantidad_total   = 0;
        $cantidad_regis   = 0;
        $total_impuestos  = 0;
        $datos            = array();
        $codigo           = $this->numero_factura();

        //Verificar cantidad ingresada contra la cantidad stock
        $lista_productos_temporal = Temporales::where('usuario_id','=',\Session::get("usuario_id"))
                                               ->where('tipo_proceso','=','venta')
                                               ->get();

        //Calcular cantidad de registros
        $cantidad_regis = $lista_productos_temporal->count();

        //Sumar todas las cantidades en cada registro
        foreach ($lista_productos_temporal as $key => $p) {
            
            $cantidad_total += $p->cantidad;
        
        }

        foreach($lista_productos_temporal as $key => $l){

            //Capturar datos para actualizar subtotal
            $subtotal_query = Temporales::where('id','=',$l->id)->first();

            //calcular cantidad de productos por el precio del producto
            $cantidad_precio     = $l->cantidad * $l->producto->precio_publico;


            $subtotal_por_item  = $cantidad_precio * ($l->tributo->monto/100);
            $subtotal_lista     = $cantidad_precio + $subtotal_por_item;
            $total_impuestos   += $subtotal_por_item;
            $subtotal_general  += $subtotal_lista;

           
            
            //Actualizar Subtotal temporal por producto
            $subtotal_query->subtotal = $subtotal_lista;
            $subtotal_query->save();

            //subtotal sin impuestos
            $subtotal_sin_impuestos = $subtotal_general - $total_impuestos;

            //Datos de la lista  principal
            $datos['dato'.$key]   = $l->producto->codigo."|". // array 0
                                    $l->producto->nombre."|". // array 1
                                    $l->cantidad."|".  // array 2
                                    number_format($l->producto->precio_publico,2)."|".  // array 3
                                    $l->tributo->monto."|". // array 4
                                    $l->id."|". // array 5
                                    number_format($subtotal_lista,2)."|". // array 6
                                    $l->tributo->tipo."|". // array 7
                                    number_format($subtotal_general,2)."|". // array 8
                                    $subtotal_general."|".  // array 9
                                    $cantidad_regis."|". // array 10
                                    $cantidad_total."|". // array 11
                                    $codigo."|". // array 12
                                    number_format($subtotal_por_item,2)."|". // array 13
                                    number_format($total_impuestos,2)."|". // array 14
                                    number_format($subtotal_sin_impuestos,2); // array 15

        }//cierre foreach

        return json_encode($datos);

    }

    //Buscar productos "search modal"
    public function pos_buscar_productos(Request $request)
    {
        $busqueda = $request->get("busqueda");

        //si se ha ingresado texto de busqueda, buscar por codigo o por nombre del producto
        if($busqueda){

            $lista_productos = Producto::where('status','=',1)
                                        ->where('cantidad','>',0)
                                        ->where('codigo', 'like', '%' .$busqueda. '%')
                                        ->orWhere('nombre', 'like', '%' .$busqueda. '%')
                                        ->orderBy('id', 'desc')
                                        ->limit(10)
                                        ->get();

        //si busqueda esta vacio mostrar todo el contenido sin filtro textual
        }else{

            $lista_productos = Producto::where('status','=',1)
                                        ->where('cantidad','>',0)
                                        ->orderBy('id', 'desc')
                                        ->limit(10)
                                        ->get();
        }

            return json_encode($lista_productos);


    }

    //Insertar producto en la tabla temporal sino existe nada o actualizar cantidad desde la MODAL
    public function pos_insertar_producto_temporal(Request $request)
    {
        $producto_id    = $request->get("producto_id");
        $tributo_id     = $request->get("tributo_id");
        
        //cantidad condicionada a que estÃ© vacia o sea cero en el formulario
        if($request->get("cantidad") == ""){$cantidad = 0;}else{$cantidad = $request->get("cantidad");}
        if($request->get("cantidad") == 0 ){$cantidad = 0;}else{$cantidad = $request->get("cantidad");}

        //Verificar cantidad ingresada contra la cantidad stock
        $lista_productos = Producto::where('id','=',$producto_id)->firstOrFail();


        //Cantidad ingresada vacia
        if($cantidad == 0){

            return "cantidad_vacia";

        }
        //Cantidad ingresada mayor a la cantidad en stock
        elseif($cantidad > $lista_productos->cantidad){

            return "stock";

        }

        //Si todo se cumple, registra el producto en temporales
        else{

             //Intentar verificar si producto existe en temporal, sino registrarlo
            try {


                $datos  = Temporales::whereProductoId($producto_id)->whereUsuarioId(\Session::get("usuario_id"))->whereTipoProceso('venta')->firstOrFail();
                
                //Cantidades sumadas
                $cant_sum   = $cantidad + $datos->cantidad;

                if($cant_sum > $lista_productos->cantidad){

                    return "stock";

                }else{

                    //Actualizar cantidad
                    $datos->cantidad = $cantidad+$datos->cantidad;
                    $datos->save();

                    return "ok";

                }

            } catch (\Exception $e) {

                    //Registro producto temporal sino existe previamente
                    $datos = new Temporales(array(

                        'producto_id'    => $producto_id,
                        'tributo_id'     => $tributo_id,
                        'cantidad'       => $cantidad,
                        'usuario_id'     => \Session::get("usuario_id"),
                        'tipo_proceso'   => 'venta'

                    ));
                    $datos->save();

                    return  "ok";
                
            }//cierre catch

        }//cierre else
        
    }//cierre funcion

    public function pos_descuento(Request $request)
    {

        $descuento           = $request->get("descuento");
        $usuario_id          = $request->get("usuario_id");
        $subtotal_general_sf = 0;

        //Datos de usuario en Temporales
        $datos = Temporales::where('usuario_id','=',$usuario_id)->where('tipo_proceso','=','venta')->get();

        //Sumar todos los subtotales de los productos de este usuario
        foreach ($datos as $key => $d) {

            $subtotal_general_sf += $d->subtotal;

        }

        //Si estÃ¡ vacio o es cero
        if($descuento == 0 or $descuento == ""){

            $data['total']             = "vacio";
            $data['total_con_formato'] = number_format($subtotal_general_sf,2);
            $data['total_sin_formato'] = $subtotal_general_sf;

            //return $data;

        }
        //Si todo esta bien, calcular nuevo subtotal general
        else{

            $valor_porcentual          = $descuento/100;
            $valor_monto               = $subtotal_general_sf * $valor_porcentual;
            $subtotal_calc             = $subtotal_general_sf - $valor_monto;
            $data['total']             = "ok";

            if($subtotal_calc > 0){

                $data['total_con_formato'] = number_format($subtotal_calc,2);
                $data['total_sin_formato'] = $subtotal_calc;

            }else{

                $data['total_con_formato'] = number_format(0,2);
                $data['total_sin_formato'] = 0.00;

            }

        }

        return $data;
        

    }//cierre funcion

    public function pos_eliminar_producto_temporal(Request $request)
    {

        $datos = Temporales::whereId($request->get("id"))->firstOrFail();
        $datos->delete();

        return  "eliminado";

    }//cierre funcion



    public function pos_total(Request $request){

        $total = 0;

        try{

            //Datos de usuario en Temporales
            $datos = Temporales::where('usuario_id','=',$request->get('usuario_id'))->where('tipo_proceso','=','venta')->get();

            //Sumar todos los subtotales de los productos de este usuario
            foreach ($datos as $key => $d) {

                //contadores
                $total += $d->subtotal;

                $data['total_sf'] = $total;
                $data['total_cf'] = number_format($total,2);

            }


        } catch (\Exception $e) {

            $data['total_sf'] = 0.00;
            $data['total_cf'] = 0.00;

        }

        return $data;
        
    }

    public function pos_procesar(Request $request){

        $codigo_proceso = $request->get('codigo_proceso');
        $cliente_id     = $request->get('cliente_id');
        $usuario_id     = $request->get('usuario_id');
        $subtotal       = $request->get('subtotal');
        $descuento      = $request->get('descuento');
        $total          = $request->get('total');
        $tipo_pago      = $request->get('tipo_pago');
        $comentario     = $request->get('comentario');
        $items_totales  = $request->get('items_totales');
        $regis_totales  = $request->get('regis_totales');
        $status         = 1;//PENDIENTE

        try{
        
                //Registrar en la tabla Posproceso
                $datos_posproceso = new Posproceso(array(

                    'codigo_proceso'    => $codigo_proceso,
                    'cliente_id'        => $cliente_id,
                    'usuario_id'        => $usuario_id,
                    'subtotal'          => $subtotal,
                    'descuento'         => $descuento,
                    'total'             => $total,
                    'tipo_pago'         => $tipo_pago,
                    'items_totales'     => $items_totales,
                    'registros_totales' => $regis_totales,
                    'comentario'        => $comentario,
                    'tipo_proceso'      => 'venta',
                    'status'            => $status

                ));

                $datos_posproceso->save();

                //Registrar detalles del proceso
                $datos_temporales = Temporales::where('usuario_id','=',$usuario_id)->where('tipo_proceso','=','venta')->get();

                foreach ($datos_temporales as $key => $d) {

                    //Sacar valores de la tabla productos para precio publico sin tributo
                    $datos_producto = Producto::whereId($d->producto_id)->firstOrFail();

                    //Registrar en la tabla Detalles
                    $datos_detalles = new DetalleProceso(array(

                        'codigo_proceso'       => $codigo_proceso,
                        'proceso_id'           => $datos_posproceso->id,
                        'producto_id'          => $d->producto_id,
                        'tributo_id'           => $d->tributo_id,
                        'cantidad'             => $d->cantidad,
                        'subtotal'             => $d->subtotal,
                        'costo_publico_vendido'=> $datos_producto->precio_publico

                    ));

                    $datos_detalles->save();

                    //Actualizar stock del producto
                    $datos_actu_cant_pro           = Producto::whereId($d->producto_id)->firstOrFail();
                    $nueva_cantidad                = $datos_actu_cant_pro->cantidad - $d->cantidad;
                    $datos_actu_cant_pro->cantidad = $nueva_cantidad;
                    $datos_actu_cant_pro->save();
                    
                }//cierre foreach

                    //Eliminar registros de la tabla temporal para el usuario que ha procesado
                    $eliminar_temporal = Temporales::whereUsuarioId($usuario_id)->whereTipoProceso('venta');
                    $eliminar_temporal->delete();

                return "procesada";

            }//cierre Try

            catch (\Exception $e) {

                echo 'ExcepciÃ³n capturada: ',  $e->getMessage(), "\n";

                return "no procesada";

            }//cierre catch
        
    }//cierre funcion

    public function pos_vaciar_lista_principal(Request $request){

        $usuario_id    = $request->get('usuario_id');

        try{

            //Eliminar registros de la tabla temporal para el usuario
            $eliminar_temporal = Temporales::whereUsuarioId($usuario_id)->whereTipoProceso('venta');
            $eliminar_temporal->delete();

            return "vacia";

        }//cierre Try

        catch (\Exception $e) {

            echo 'ExcepciÃ³n capturada: ',  $e->getMessage(), "\n";

            return "no vacia";

        }//cierre catch
        
    }//cierre funcion

    /*Impresiones PDF*/
    public function pdf_pendientes()
    {        

        $datos    = Posproceso::where('tipo_proceso','=','venta')->where('status','=',1)->orderBy('created_at', 'desc')->get(); 
        $sistema  = Configuracion::where('id', '=', 1)->firstOrFail();

       $pdf = PDF::loadView('Back.pdf.ventas.lista_pendientes', compact('datos', 'sistema'));
       return $pdf->download(__('idioma.vent_pendi_titu').'.pdf');

        //return view('Back.pdf.ventas.lista_pendientes', compact('sistema','datos'));
    }
    
    /*Impresiones PDF*/
    public function pdf_rechazadas()
    {        

        $datos    = Posproceso::where('tipo_proceso','=','venta')->where('status','=',0)->orderBy('created_at', 'desc')->get(); 
        $sistema  = Configuracion::where('id', '=', 1)->firstOrFail();

        $pdf = PDF::loadView('Back.pdf.ventas.lista_rechazadas', compact('datos', 'sistema'));
        return $pdf->download(__('idioma.vent_recha_titu').'.pdf');
    }

    /*Impresiones PDF*/
    public function pdf_aprobadas()
    {        

        $datos    = Posproceso::where('tipo_proceso','=','venta')->where('status','=',2)->orderBy('created_at', 'desc')->get(); 
        $sistema  = Configuracion::where('id', '=', 1)->firstOrFail();

        $pdf = PDF::loadView('Back.pdf.ventas.lista_aprobadas', compact('datos', 'sistema'));
        return $pdf->download(__('idioma.vent_aprob_titu').'.pdf');
    }


    public function pdf_factura($id)
    {        


        $datos    = Posproceso::where('tipo_proceso','=','venta')->where('id','=',$id)->firstOrFail();
        $detalles = DetalleProceso::where('proceso_id', '=', $datos->id)->get(); 
        $sistema  = Configuracion::where('id', '=', 1)->firstOrFail();

        //Fecha factura reformateada 
        $fecha    = date('Y-m-d', strtotime($datos->created_at));

        //Calcular Ahorro

        if($datos->descuento == 0){

            $ahorro = 0;

        }else{

            $ahorro = $datos->subtotal - $datos->total;

        }

        $pdf = PDF::loadView('Back.pdf.ventas.factura', compact('datos', 'sistema', 'fecha', 'detalles', 'ahorro'));
        
        return $pdf->download(__('idioma.gral_factura').'_'.$datos->codigo_proceso.'.pdf');
    }

    /*Impresiones CSV*/
    public function csv_pendientes()
    {        

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=Pending sales.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
    
        $reviews = Posproceso::where("tipo_proceso","=","venta")->where("status","=",1)->orderBy('created_at', 'desc')->get();
        $sistema = Configuracion::where('id', '=', 1)->firstOrFail();
        $columns = array("#","Code","Registered by","Customers", "Subtotal (Tax free)", "Taxes", "Total (Tax included)","Discount"."(%)", "Discounted amount"." ($sistema->moneda)","PAID OUT"." ($sistema->moneda)","Quantity","Type of payment", "Date","Commentary");

        $callback = function() use ($reviews, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns,';');
    
            foreach($reviews as $key => $review) {

                $total_sin_impuestos = 0;
                $total_impuesto      = 0;

                  $datos_detalles =\DB::table('detalleprocesos')->where('proceso_id', $review->id)->get();

                  foreach ($datos_detalles as $key => $dt) {

                     //capturar tributo
                     $tributo =\DB::table('tributos')->where('id', $dt->tributo_id)->first();

                      //total sin impuestos Suma de precios publico po cantidad
                     $total_sin_impuestos += $dt->cantidad * $dt->costo_publico_vendido;

                     //Calculo total impuesto
                     $calculo_1 = $dt->cantidad * $dt->costo_publico_vendido;

                     $total_impuesto      += $calculo_1 * ($tributo->monto/100);

                     //Monto del descuento
                     $calculo = $total_sin_impuestos + $total_impuesto;
                     $monto_descuento = $calculo * ($review->descuento/100);


                  }

                fputcsv($file, array(++$key, $review->codigo_proceso , $review->usuario->cedula, $review->cliente->cedula, $total_sin_impuestos, round($total_impuesto,2), $review->subtotal, $review->descuento, round($monto_descuento,2), $review->total, $review->items_totales, $review->tipo_pago, date("Y/m/d", strtotime($review->created_at)), $review->comentario),';');
                
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);

    }
    
    /*Impresiones CSV*/
    public function csv_rechazadas()
    {        

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=Sales rejected.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $reviews = Posproceso::where("tipo_proceso","=","venta")->where("status","=",0)->orderBy('created_at', 'desc')->get();
        $sistema = Configuracion::where('id', '=', 1)->firstOrFail();
        $columns = array("#","Code","Registered by","Customers", "Subtotal (Tax free)", "Taxes", "Total (Tax included)","Discount"."(%)", "Discounted amount"." ($sistema->moneda)","PAID OUT"." ($sistema->moneda)","Quantity","Type of payment", "Date","Commentary","Reason for rejection");

        $callback = function() use ($reviews, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns,';');
    
            foreach($reviews as $key => $review) {

                $total_sin_impuestos = 0;
                $total_impuesto      = 0;

                  $datos_detalles =\DB::table('detalleprocesos')->where('proceso_id', $review->id)->get();

                  foreach ($datos_detalles as $key => $dt) {

                     //capturar tributo
                     $tributo =\DB::table('tributos')->where('id', $dt->tributo_id)->first();

                      //total sin impuestos Suma de precios publico po cantidad
                     $total_sin_impuestos += $dt->cantidad * $dt->costo_publico_vendido;

                     //Calculo total impuesto
                     $calculo_1 = $dt->cantidad * $dt->costo_publico_vendido;

                     $total_impuesto      += $calculo_1 * ($tributo->monto/100);

                     //Monto del descuento
                     $calculo = $total_sin_impuestos + $total_impuesto;
                     $monto_descuento = $calculo * ($review->descuento/100);


                  }

                fputcsv($file, array(++$key, $review->codigo_proceso , $review->usuario->cedula, $review->cliente->cedula, $total_sin_impuestos, round($total_impuesto,2), $review->subtotal, $review->descuento, round($monto_descuento,2), $review->total, $review->items_totales, $review->tipo_pago, date("Y/m/d", strtotime($review->created_at)), $review->comentario, $review->motivo_rechazo),';');
                
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);

    }
    
    /*Impresiones CSV*/
    public function csv_aprobadas()
    {        

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=Approved sales.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
    
        $reviews = Posproceso::where("tipo_proceso","=","venta")->where("status","=",2)->orderBy('created_at', 'desc')->get();
        $sistema = Configuracion::where('id', '=', 1)->firstOrFail();
        $columns = array("#","Code","Registered by","Customers", "Subtotal (Tax free)", "Taxes", "Total (Tax included)","Discount"."(%)", "Discounted amount"." ($sistema->moneda)","PAID OUT"." ($sistema->moneda)","Quantity","Type of payment", "Date","Commentary");
    
        $callback = function() use ($reviews, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns,';');
    
            foreach($reviews as $key => $review) {

                $total_sin_impuestos = 0;
                $total_impuesto      = 0;

                  $datos_detalles =\DB::table('detalleprocesos')->where('proceso_id', $review->id)->get();

                  foreach ($datos_detalles as $key => $dt) {

                     //capturar tributo
                     $tributo =\DB::table('tributos')->where('id', $dt->tributo_id)->first();

                      //total sin impuestos Suma de precios publico po cantidad
                     $total_sin_impuestos += $dt->cantidad * $dt->costo_publico_vendido;

                     //Calculo total impuesto
                     $calculo_1 = $dt->cantidad * $dt->costo_publico_vendido;

                     $total_impuesto      += $calculo_1 * ($tributo->monto/100);

                     //Monto del descuento
                     $calculo = $total_sin_impuestos + $total_impuesto;
                     $monto_descuento = $calculo * ($review->descuento/100);


                  }

                fputcsv($file, array(++$key, $review->codigo_proceso , $review->usuario->cedula, $review->cliente->cedula, $total_sin_impuestos, round($total_impuesto,2), $review->subtotal, $review->descuento, round($monto_descuento,2), $review->total, $review->items_totales, $review->tipo_pago, date("Y/m/d", strtotime($review->created_at)), $review->comentario),';');
                
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);

    }

}//Cierre clase