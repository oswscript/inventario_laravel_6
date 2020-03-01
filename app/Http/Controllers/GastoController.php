<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GastoFormRequest;
use App\Http\Requests\UpdateGastoFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\Gasto;
use App\Configuracion;
use Barryvdh\DomPDF\Facade as PDF;

class GastoController extends Controller
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
        $datos     =  Gasto::all();
        $sistema   =  Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.gasto.index', compact('datos','sistema'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sistema =  Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.gasto.create', compact('sistema'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GastoFormRequest $request)
    {
        
        $monto       = $request->get('monto');
        $concepto    = $request->get('concepto');
        $fecha       = $request->get('fecha_gasto');
        $observacion = $request->get('observacion');
        $codigo      = uniqid();
        $usuario     = \Session::get("usuario_id");

        $datos = new Gasto(array(
            'monto'       => $monto,
            'usuario_id'  => $usuario,
            'codigo'      => $codigo,
            'fecha'       => $fecha,
            'concepto'    => $concepto,
            'observacion' => $observacion
        ));

        $datos->save();

        return redirect('/gastos')->with('status', __('idioma.alert_registro'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datos   =  Gasto::whereId($id)->firstOrFail();
        $sistema =  Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.gasto.show', compact('datos','sistema'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datos   = Gasto::whereId($id)->firstOrFail();
        $sistema = Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.gasto.edit', compact('datos','sistema'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGastoFormRequest $request, $id)
    {
        $monto         = $request->get('monto');
        $concepto      = $request->get('concepto');
        $fecha         = $request->get('fecha_gasto');
        $observacion   = $request->get('observacion');

        $datos              = Gasto::whereId($id)->firstOrFail();
        $datos->monto       = $monto;
        $datos->concepto    = $concepto;
        $datos->fecha       = $fecha;
        $datos->observacion = $observacion;
        $datos->save();

        return redirect()->action('GastoController@show', $datos->id)->with('status', __('idioma.alert_actua'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        //ELIMINAR CATEGORIA
        $datos = Gasto::whereId($id)->firstOrFail();
        $datos->delete();

        return redirect('/gastos')->with('status', __('idioma.alert_borrar'));

    }

    /*Impresiones PDF*/
    public function pdf()
    {        

        $datos    = Gasto::all(); 
        $sistema  = Configuracion::where('id', '=', 1)->firstOrFail();

        $pdf = PDF::loadView('Back.pdf.gastos.lista', compact('datos', 'sistema'));
        return $pdf->download(__('idioma.gst_titulo').'.pdf');
    }

    /*Impresiones CSV*/
    public function csv()
    {        

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=Expense list.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
    
        $reviews = Gasto::all();
        $sistema = Configuracion::where('id', '=', 1)->firstOrFail();
        $columns = array("#","Amount"."( ".$sistema->moneda." )","Registered by","Code","By concept of","Observation","Date");
    
        $callback = function() use ($reviews, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns,';');
    
            foreach($reviews as $key => $review) {

               //Status
               if($review->status == 1){

                  $status = __('idioma.gral_activo');

               }else{

                  $status = __('idioma.gral_in_activo');

               }
                fputcsv($file, array(++$key, $review->monto ,$review->usuario->cedula, $review->codigo, $review->concepto, $review->observacion, $review->fecha),';');
                
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);

    }
}
