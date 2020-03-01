<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use App\DetalleProceso;
use App\Posproceso;
use App\Configuracion;
use Barryvdh\DomPDF\Facade as PDF;

class KardexController extends Controller
{

    public function __construct(){

        $sistema = Configuracion::where('id', '=', 1)->firstOrFail();

        \App::setLocale($sistema->idioma);
    }
    
    //Mostra listado de kardex
    public function index()
    {   
        $datos     = DetalleProceso::orderBy('created_at', 'desc')->get();
        $sistema   = Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.kardex.index', compact('sistema','datos'));
    }

    public function pdf()
    {        

        $datos    = DetalleProceso::all(); 
        $sistema  = Configuracion::where('id', '=', 1)->firstOrFail();

        $pdf = PDF::loadView('Back.pdf.kardex.lista', compact('datos', 'sistema'));
        return $pdf->download('kardex.pdf');
    }

    /*Impresiones CSV*/
    public function csv()
    {        

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=Kardex.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
    
        $reviews = DetalleProceso::all();
        $sistema = Configuracion::where('id', '=', 1)->firstOrFail();
        $columns = array("#","Code","Prod.","Customers","Taxes","Quantity","Subtotal ($sistema->moneda)","Price u/".($sistema->moneda),"Type of payment","Process type","Date","Commentary");

        $callback = function() use ($reviews, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns,';');
    
            foreach($reviews as $key => $review) {
                //Capturar Cliente
                $consulta = Posproceso::where('codigo_proceso', '=', $review->codigo_proceso)->firstOrFail();

                fputcsv($file, array(++$key, $review->codigo_proceso ,$review->producto->codigo, $consulta->cliente->cedula, $review->tributo->monto, $review->cantidad, $review->subtotal, $review->costo_publico_vendido, $consulta->tipo_pago, $consulta->tipo_proceso, $review->created_at,$consulta->comentario),';');
                
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);

    }//Cierre CSV


}//Cierre clase
