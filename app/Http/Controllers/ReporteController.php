<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\DetalleProceso;
use App\SubCategoria;
use App\Configuracion;
use App\Posproceso;
use App\Cliente;
use App\Producto;
use App\Categoria;
use App\Gasto;
use Barryvdh\DomPDF\Facade as PDF;

class ReporteController extends Controller
{

    public function __construct(){

        $sistema = Configuracion::where('id', '=', 1)->firstOrFail();

        \App::setLocale($sistema->idioma);
    }
     /*
        *******************************************************************
        *******************************************************************
                                REPORTE: VENTAS
        *******************************************************************
        *******************************************************************
    */

    //Resultado del filtrado
    public function modal_reporte_ventas_filtrar(Request $request)
    {

        $sistema        = Configuracion::where('id', '=', 1)->firstOrFail();
        $desde          = $request->get('modal_reporte_venta_inicio');
        $hasta          = $request->get('modal_reporte_venta_final');
        $status         = $request->get('status');

         //TEXTO STATUS
         if($status == "todas"){
            $str_status = "ALL";
         }
         elseif($status == 1){
            $str_status = "PENDING";
         }
         elseif($status == 0){
            $str_status = "REJECTED";
         }
         elseif($status == 2){
            $str_status = "APPROVED";
         }

        //TODAS
        if($status == "todas"){
            $datos = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','venta')->orderBy('created_at', 'desc')->get();
        }
        //PENDIENTES
        elseif($status == 1){
            $datos = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','venta')->where('status','=',1)->orderBy('created_at', 'desc')->get();
        }
        //RECHAZADAS
        elseif($status == 0){
            $datos = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','venta')->where('status','=',0)->orderBy('created_at', 'desc')->get();
        }
        //APROBADAS
        elseif($status == 2){
            $datos = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','venta')->where('status','=',2)->orderBy('created_at', 'desc')->get();
        }
        $gran_total       = 0;// Totales sumados con impuestos y descuentos 
        $total_sd         = 0;// Totales sin descuento, tomado de los subtotales en detalles
        $registros_total  = 0;// Cantidad de productos totales de las facturas seleccionadas
        $total_impuestos  = 0;// Monto sumado de los impuestos de las facturas
        $total_descuentos = 0;// Monto total de los impuestos
        $total_bruto      = 0; //Monto sin impuesto ni descuento, calculado de multiplicar el precio publico de los productos por la cantidad

        //Bucle principal, recorriendo los datos de la tabla de Posproceso
        foreach ($datos as $key => $d) {

            $gran_total      += $d->total;
            $registros_total += $d->items_totales;
            $datos_detalles   = DetalleProceso::where('codigo_proceso', '=', $d->codigo_proceso)->get();

            //Bucle secundario, recorriendo la tabla DetalleProceso segun el codigo encontrado en la consulta de Posproceso
            foreach ($datos_detalles as $key => $dt) {

                 //calcular la cantidad de unidades por su precio de venta
                 $cantidad_precio = $dt->cantidad * $dt->costo_publico_vendido;

                 //Totales sin descuento
                 $total_sd += $dt->subtotal;
                 
                 //Total neto, calculado con la suma de los precios publicos por las cantidades, sin impuestos y sin descuentos
                 $total_bruto += $cantidad_precio;


                 //Calculo de impuestos
                 if($dt->tributo->tipo == "PORCENTAJE"){

                    $subtotal_por_item = $cantidad_precio * ($dt->tributo->monto/100);
                    $total_impuestos  += $subtotal_por_item;

                 }//Cierre if

            }//Cierre Foreach 2

            //Descuentos totales restando el total del subtotal
            $total_descuentos = $total_sd - $gran_total;

        }//Cierre Foreach 1

        //dd($datos);
        return view('Back.reporte.ventas.show_venta', compact('sistema','datos','gran_total','total_impuestos','registros_total','desde','hasta','total_sd', 'total_descuentos', 'status', 'str_status', 'total_bruto'));

    }

    public function pdf_reporte_ventas($desde, $hasta, $status)
    {
        
        $sistema        = Configuracion::where('id', '=', 1)->firstOrFail();

         //TEXTO STATUS
         if($status == "todas"){
            $str_status = "ALL";
         }
         elseif($status == 1){
            $str_status = "PENDING";
         }
         elseif($status == 0){
            $str_status = "REJECTED";
         }
         elseif($status == 2){
            $str_status = "APPROVED";
         }


        //TODAS
        if($status == "todas"){
            $datos = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','venta')->orderBy('created_at', 'desc')->get();
        }
        //PENDIENTES
        elseif($status == 1){
            $datos = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','venta')->where('status','=',1)->orderBy('created_at', 'desc')->get();
        }
        //RECHAZADAS
        elseif($status == 0){
            $datos = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','venta')->where('status','=',0)->orderBy('created_at', 'desc')->get();
        }
        //APROBADAS
        elseif($status == 2){
            $datos = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','venta')->where('status','=',2)->orderBy('created_at', 'desc')->get();
        }

        $gran_total       = 0;// Totales sumados con impuestos y descuentos 
        $total_sd         = 0;// Totales sin descuento, tomado de los subtotales en detalles
        $registros_total  = 0;// Cantidad de productos totales de las facturas seleccionadas
        $total_impuestos  = 0;// Monto sumado de los impuestos de las facturas
        $total_descuentos = 0;// Monto total de los impuestos
        $total_bruto      = 0; //Monto sin impuesto ni descuento, calculado de multiplicar el precio publico de los productos por la cantidad
    

        //Bucle principal, recorriendo los datos de la tabla de Posproceso
        foreach ($datos as $key => $d) {

            $gran_total      += $d->total;
            $registros_total += $d->items_totales;
            $datos_detalles   = DetalleProceso::where('codigo_proceso', '=', $d->codigo_proceso)->get();

            //Bucle secundario, recorriendo la tabla DetalleProceso segun el codigo encontrado en la consulta de Posproceso
            foreach ($datos_detalles as $key => $dt) {

                 //calcular la cantidad de unidades por su precio de venta
                 $cantidad_precio = $dt->cantidad * $dt->costo_publico_vendido;

                 //Totales sin descuento
                 $total_sd += $dt->subtotal;
                 
                 //Total neto, calculado con la suma de los precios publicos por las cantidades, sin impuestos y sin descuentos
                 $total_bruto += $cantidad_precio;

                 //Calculo de impuestos
                 if($dt->tributo->tipo == "PORCENTAJE"){

                    $subtotal_por_item = $cantidad_precio * ($dt->tributo->monto/100);
                    $total_impuestos  += $subtotal_por_item;

                 }//Cierre if

            }//Cierre Foreach 2

            //Descuentos totales restando el total del subtotal
            $total_descuentos = $total_sd - $gran_total;

        }//Cierre Foreach 1

        //Variables para imprimir PDF

        $pdf = PDF::loadView('Back.reporte.ventas.pdf_reporte_venta', compact('sistema','datos','gran_total','total_impuestos','registros_total','desde','hasta','total_sd', 'total_descuentos', 'str_status', 'total_bruto'));
        
        return $pdf->download('sell_report_'.$desde.'_to_'.$hasta.'.pdf');
        
    }

    
    /*Impresiones CSV*/
    public function csv_reporte_ventas($desde, $hasta, $status)
    {        

         //TEXTO STATUS
         if($status == "todas"){
            $str_status = "ALL";
         }
         elseif($status == 1){
            $str_status = "PENDING";
         }
         elseif($status == 0){
            $str_status = "REJECTED";
         }
         elseif($status == 2){
            $str_status = "APPROVED";
         }

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=ReportSells_".$str_status."_from_".$desde."_to_".$hasta.".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        

        //TODAS
        if($status == "todas"){
            $reviews = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','venta')->orderBy('created_at', 'desc')->get();
        }
        //PENDIENTES
        elseif($status == 1){
            $reviews = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','venta')->where('status','=',1)->orderBy('created_at', 'desc')->get();
        }
        //RECHAZADAS
        elseif($status == 0){
            $reviews = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','venta')->where('status','=',0)->orderBy('created_at', 'desc')->get();
        }
        //APROBADAS
        elseif($status == 2){
            $reviews = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','venta')->where('status','=',2)->orderBy('created_at', 'desc')->get();
        }

        $sistema = Configuracion::where('id', '=', 1)->firstOrFail();
        $columns = array("#","Code","Registered by","Customer", "Subtotal (tax free)", "Taxes", "Total (with tax)","Discount (%)", "Discounted amount","NET TO PAY","Products", "Type of payment", "Date", "Status", "Commentary");
    
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

                  if($review->status == 1){
                     $str_st = __('idioma.rep_ven_md_pen');
                  }
                  elseif($review->status == 2){
                     $str_st = __('idioma.rep_ven_md_apr');
                  }
                  elseif($review->status == 0){
                     $str_st = __('idioma.rep_ven_md_rec');
                  }

                fputcsv($file, array(++$key, $review->codigo_proceso , $review->usuario->cedula, $review->cliente->cedula, $total_sin_impuestos, round($total_impuesto,2), $review->subtotal, $review->descuento, round($monto_descuento,2), $review->total, $review->items_totales, $review->tipo_pago, date("Y/m/d", strtotime($review->created_at)), $str_st, $review->comentario),';');
                
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);

    }


    /*
        *******************************************************************
        *******************************************************************
                              FIN REPORTE: VENTAS
        *******************************************************************
        *******************************************************************
    */

    
    /*
        *******************************************************************
        *******************************************************************
                                REPORTE: COMPRAS
        *******************************************************************
        *******************************************************************
    */

    //Resultado del filtrado
    public function modal_reporte_compras_filtrar(Request $request)
    {

        $sistema        = Configuracion::where('id', '=', 1)->firstOrFail();
        $desde          = $request->get('modal_reporte_compra_inicio');
        $hasta          = $request->get('modal_reporte_compra_final');
        $status         = $request->get('status');

         //TEXTO STATUS
         if($status == "todas"){
               $str_status = "ALL";
         }
         elseif($status == 1){
               $str_status = "PENDING";
         }
         elseif($status == 0){
               $str_status = "REJECTED";
         }
         elseif($status == 2){
               $str_status = "APPROVED";
         }

        //TODAS
        if($status == "todas"){
            $datos = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','compra')->orderBy('created_at', 'desc')->get();
        }
        //PENDIENTES
        elseif($status == 1){
            $datos = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','compra')->where('status','=',1)->orderBy('created_at', 'desc')->get();
        }
        //RECHAZADAS
        elseif($status == 0){
            $datos = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','compra')->where('status','=',0)->orderBy('created_at', 'desc')->get();
        }
        //APROBADAS
        elseif($status == 2){
            $datos = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','compra')->where('status','=',2)->orderBy('created_at', 'desc')->get();
        }

        $gran_total       = 0;// Totales sumados con impuestos y descuentos 
        $total_sd         = 0;// Totales sin descuento, tomado de los subtotales en detalles
        $registros_total  = 0;// Cantidad de productos totales de las facturas seleccionadas
        $total_impuestos  = 0;// Monto sumado de los impuestos de las facturas
        $total_descuentos = 0;// Monto total de los impuestos
        $total_bruto      = 0; //Monto sin impuesto ni descuento, calculado de multiplicar el precio publico de los productos por la cantidad

        //Bucle principal, recorriendo los datos de la tabla de Posproceso
        foreach ($datos as $key => $d) {

            $gran_total      += $d->total;
            $registros_total += $d->items_totales;
            $datos_detalles   = DetalleProceso::where('codigo_proceso', '=', $d->codigo_proceso)->get();

            //Bucle secundario, recorriendo la tabla DetalleProceso segun el codigo encontrado en la consulta de Posproceso
            foreach ($datos_detalles as $key => $dt) {

                 //calcular la cantidad de unidades por su precio de venta
                 $cantidad_precio = $dt->cantidad * $dt->costo_publico_vendido;

                 //Totales sin descuento
                 $total_sd += $dt->subtotal;

                 //Total neto, calculado con la suma de los precios publicos por las cantidades, sin impuestos y sin descuentos
                 $total_bruto += $cantidad_precio;

                 //Calculo de impuestos
                 if($dt->tributo->tipo == "PORCENTAJE"){

                    $subtotal_por_item = $cantidad_precio * ($dt->tributo->monto/100);
                    $total_impuestos  += $subtotal_por_item;

                 }//Cierre if

            }//Cierre Foreach 2

            //Descuentos totales restando el total del subtotal
            $total_descuentos = $total_sd - $gran_total;

        }//Cierre Foreach 1

        //dd($datos);
        return view('Back.reporte.compras.show_compra', compact('sistema','datos','gran_total','total_impuestos','registros_total','desde','hasta','total_sd', 'total_descuentos', 'status', 'str_status','total_bruto'));

    }

    public function pdf_reporte_compras($desde, $hasta, $status)
    {
        
        $sistema        = Configuracion::where('id', '=', 1)->firstOrFail();
        
        //TEXTO STATUS
        if($status == "todas"){
            $str_status = "ALL";
        }
        elseif($status == 1){
            $str_status = "PENDING";
        }
        elseif($status == 0){
            $str_status = "REJECTED";
        }
        elseif($status == 2){
            $str_status = "APPROVED";
        }

        //TODAS
        if($status == "todas"){
            $datos = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','compra')->orderBy('created_at', 'desc')->get();
        }
        //PENDIENTES
        elseif($status == 1){
            $datos = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','compra')->where('status','=',1)->orderBy('created_at', 'desc')->get();
        }
        //RECHAZADAS
        elseif($status == 0){
            $datos = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','compra')->where('status','=',0)->orderBy('created_at', 'desc')->get();
        }
        //APROBADAS
        elseif($status == 2){
            $datos = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','compra')->where('status','=',2)->orderBy('created_at', 'desc')->get();
        }

        $gran_total       = 0;// Totales sumados con impuestos y descuentos 
        $total_sd         = 0;// Totales sin descuento, tomado de los subtotales en detalles
        $registros_total  = 0;// Cantidad de productos totales de las facturas seleccionadas
        $total_impuestos  = 0;// Monto sumado de los impuestos de las facturas
        $total_descuentos = 0;// Monto total de los impuestos
        $total_bruto      = 0; //Monto sin impuesto ni descuento, calculado de multiplicar el precio publico de los productos por la cantidad

        //Bucle principal, recorriendo los datos de la tabla de Posproceso
        foreach ($datos as $key => $d) {

            $gran_total      += $d->total;
            $registros_total += $d->items_totales;
            $datos_detalles   = DetalleProceso::where('codigo_proceso', '=', $d->codigo_proceso)->get();

            //Bucle secundario, recorriendo la tabla DetalleProceso segun el codigo encontrado en la consulta de Posproceso
            foreach ($datos_detalles as $key => $dt) {

                 //calcular la cantidad de unidades por su precio de venta
                 $cantidad_precio = $dt->cantidad * $dt->costo_publico_vendido;


                 //Totales sin descuento
                 $total_sd += $dt->subtotal;

                 //Total neto, calculado con la suma de los precios publicos por las cantidades, sin impuestos y sin descuentos
                 $total_bruto += $cantidad_precio;

                 //Calculo de impuestos
                 if($dt->tributo->tipo == "PORCENTAJE"){

                    $subtotal_por_item = $cantidad_precio * ($dt->tributo->monto/100);
                    $total_impuestos  += $subtotal_por_item;

                 }//Cierre if

            }//Cierre Foreach 2

            //Descuentos totales restando el total del subtotal
            $total_descuentos = $total_sd - $gran_total;

        }//Cierre Foreach 1

        //Variables para imprimir PDF

        $pdf = PDF::loadView('Back.reporte.compras.pdf_reporte_compra', compact('sistema','datos','gran_total','total_impuestos','registros_total','desde','hasta','total_sd', 'total_descuentos', 'str_status', 'total_bruto'));
        
        return $pdf->download('purchase_report_'.$desde.'_to_'.$hasta.'.pdf');
        
    }

    
    /*Impresiones CSV*/
    public function csv_reporte_compras($desde, $hasta, $status)
    {        

        //TEXTO STATUS
         if($status == "todas"){
             $str_status = "ALL";
         }
         elseif($status == 1){
               $str_status = "PENDING";
         }
         elseif($status == 0){
               $str_status = "REJECTED";
         }
         elseif($status == 2){
               $str_status = "APPROVED";
         }

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=ReportPurchase_".$str_status."_from_".$desde."_to_".$hasta.".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        

        //TODAS
        if($status == "todas"){
            $reviews = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','compra')->orderBy('created_at', 'desc')->get();
        }
        //PENDIENTES
        elseif($status == 1){
            $reviews = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','compra')->where('status','=',1)->orderBy('created_at', 'desc')->get();
        }
        //RECHAZADAS
        elseif($status == 0){
            $reviews = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','compra')->where('status','=',0)->orderBy('created_at', 'desc')->get();
        }
        //APROBADAS
        elseif($status == 2){
            $reviews = Posproceso::where('created_at', '>=', $desde." 00:00:00")->where('created_at', '<=', $hasta." 23:59:59")->where('tipo_proceso','=','compra')->where('status','=',2)->orderBy('created_at', 'desc')->get();
        }

        $sistema = Configuracion::where('id', '=', 1)->firstOrFail();
        $columns = array("#","Code","Registered by","Customer", "Subtotal (tax free)", "Taxes", "Total (with tax)","Discount (%)", "Discounted amount","NET TO PAY","Products", "Type of payment", "Date", "Status", "Commentary");
    
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

                //TEXTO STATUS
               if($review->status == 1){
                  $str_st = __('idioma.rep_ven_md_pen');
               }
               elseif($review->status == 2){
                  $str_st = __('idioma.rep_ven_md_apr');
               }
               elseif($review->status == 0){
                  $str_st = __('idioma.rep_ven_md_rec');
               }

                fputcsv($file, array(++$key, $review->codigo_proceso , $review->usuario->cedula, $review->cliente->cedula, $total_sin_impuestos, round($total_impuesto,2), $review->subtotal, $review->descuento, round($monto_descuento,2), $review->total, $review->items_totales, $review->tipo_pago, date("Y/m/d", strtotime($review->created_at)), $str_st, $review->comentario),';');
                
            }
            fclose($file);

        };
        return Response::stream($callback, 200, $headers);

    }

    /*
        *******************************************************************
        *******************************************************************
                              FIN REPORTE: COMPRAS
        *******************************************************************
        *******************************************************************
    */

    
    /*
        *******************************************************************
        *******************************************************************
                                REPORTE: GASTOS
        *******************************************************************
        *******************************************************************
    */

    //Resultado del filtrado
    public function modal_reporte_gastos_filtrar(Request $request)
    {

        $sistema        = Configuracion::where('id', '=', 1)->firstOrFail();
        $desde          = $request->get('modal_reporte_gasto_inicio');
        $hasta          = $request->get('modal_reporte_gasto_final');

        $datos = Gasto::where('fecha', '>=', $desde." 00:00:00")->where('fecha', '<=', $hasta." 23:59:59")->orderBy('fecha', 'desc')->get();

        $gran_total       = 0;// Totales sumados con impuestos y descuentos 

        //Bucle principal, recorriendo los datos de la tabla de GASTOS
        foreach ($datos as $key => $d) {

            $gran_total      += $d->monto;

        }//Cierre Foreach 1

        return view('Back.reporte.gastos.show_gasto', compact('sistema','datos','gran_total','desde','hasta'));

    }

    public function pdf_reporte_gastos($desde, $hasta)
    {
        
        $sistema        = Configuracion::where('id', '=', 1)->firstOrFail();

        $datos = Gasto::where('fecha', '>=', $desde." 00:00:00")->where('fecha', '<=', $hasta." 23:59:59")->orderBy('fecha', 'desc')->get();

        $gran_total       = 0;// Totales sumados con impuestos y descuentos 

        //Bucle principal, recorriendo los datos de la tabla de GASTOS
        foreach ($datos as $key => $d) {

            $gran_total      += $d->monto;

        }//Cierre Foreach 1

        //Variables para imprimir PDF

        $pdf = PDF::loadView('Back.reporte.gastos.pdf_reporte_gasto', compact('sistema','datos','gran_total','desde','hasta'));
        
        return $pdf->download('expenses_report_'.$desde.'_to_'.$hasta.'.pdf');
        
    }

    
    /*Impresiones CSV*/
    public function csv_reporte_gastos($desde, $hasta)
    {        

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=expenses_report_".$desde."_to_".$hasta.".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        

        $reviews = Gasto::where('fecha', '>=', $desde." 00:00:00")->where('fecha', '<=', $hasta." 23:59:59")->orderBy('fecha', 'desc')->get();
        
       
        $sistema = Configuracion::where('id', '=', 1)->firstOrFail();
        $columns = array("#","Code","Registered by", "Amount ($sistema->moneda)", "Concept", "Date", "Observation");
    
        $callback = function() use ($reviews, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns,';');
    
            foreach($reviews as $key => $review) {

                fputcsv($file, array(++$key, $review->codigo, $review->usuario->cedula, $review->monto, $review->concepto, date("Y/m/d", strtotime($review->fecha)), $review->observacion),';');
                
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);

    }



    /*
        *******************************************************************
        *******************************************************************
                              FIN REPORTE: GASTOS
        *******************************************************************
        *******************************************************************
    */


}
