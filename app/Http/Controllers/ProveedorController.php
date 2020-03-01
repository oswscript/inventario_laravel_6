<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteFormRequest;
use App\Http\Requests\UpdateClienteFormRequest;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Cliente;
use App\Configuracion;
use Barryvdh\DomPDF\Facade as PDF;

class ProveedorController extends Controller {


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

        $datos    =  Cliente::where('tipo_cliente', '=', 'PROVEEDOR')->get();
        $sistema  =  Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.proveedor.index', compact('datos','sistema'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $sistema =  Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.proveedor.create', compact('sistema'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClienteFormRequest $request) {
        //


        $nombre          = strtoupper($request->get('nombre'));
        $apellido        = strtoupper($request->get('apellido'));
        $empresa         = strtoupper($request->get('empresa'));
        $cedula          = $request->get('cedula');
        $correo          = $request->get('correo');
        $telefono        = $request->get('telefono');
        $direccion       = $request->get('direccion');
        $status          = $request->get('status');
        $tipo_cliente    = 'PROVEEDOR';

        //REGISTRO DATOS
        $datos = new Cliente(array(
            'nombre'       => $nombre,
            'apellido'     => $apellido,
            'empresa'      => $empresa,
            'cedula'       => $cedula,
            'correo'       => $correo,
            'telefono'     => $telefono,
            'tipo_cliente' => $tipo_cliente,
            'direccion'    => $direccion,
            'status'       => $status
        ));

        $datos->save();

        return redirect('/proveedores')->with('status', __('idioma.alert_registro'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
        $datos   = Cliente::whereId($id)->firstOrFail();
        $sistema = Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.proveedor.show', compact('datos','sistema'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
        $datos   = Cliente::whereId($id)->firstOrFail();
        $sistema = Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.proveedor.edit', compact('datos','sistema'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClienteFormRequest $request, $id) {
        //

        $datos     = Cliente::whereId($id)->firstOrFail();
        $nombre    = strtoupper($request->get('nombre'));
        $apellido  = strtoupper($request->get('apellido'));
        $empresa   = strtoupper($request->get('empresa'));
        $cedula    = $request->get('cedula');
        $correo    = $request->get('correo');
        $telefono  = $request->get('telefono');
        $direccion = $request->get('direccion');
        $status    = $request->get('status');

        $datos->nombre    = $nombre;
        $datos->apellido  = $apellido;
        $datos->empresa   = $empresa;
        $datos->cedula    = $cedula;
        $datos->correo    = $correo;
        $datos->telefono  = $telefono;
        $datos->direccion = $direccion;
        $datos->status    = $status;
        $datos->save();

        return redirect()->action('ProveedorController@show', $datos->id)->with('status',  __('idioma.alert_actua'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        //$dato_consulta =  Producto::where('tributo_id', '=', $id)->count();
        $dato_consulta =  0;
        //dd($clientes_existencia);

        if($dato_consulta > 0){

            return redirect("/show_proveedor/$id")->with('error', __('idioma.alert_ya_uso'));
           
        }else{
                        
            //ELIMINAR DATO
            $datos = Cliente::whereId($id)->firstOrFail();
            $datos->delete();

            return redirect("/proveedores")->with('status', __('idioma.alert_borrar'));

        }
    }

    public function pdf()
    {        

        $datos    = Cliente::where('tipo_cliente','=','PROVEEDOR')->orderBy('cedula', 'desc')->get(); 
        $sistema  = Configuracion::where('id', '=', 1)->firstOrFail();

        $pdf = PDF::loadView('Back.pdf.personas.proveedores.lista', compact('datos', 'sistema'));
        return $pdf->download(__('idioma.nav_proveedores').'.pdf');
    }

    public function csv()
    {        

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=Suppliers.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
    
        $reviews = Cliente::where("tipo_cliente","=","PROVEEDOR")->orderBy('cedula', 'desc')->get();
        $sistema = Configuracion::where('id', '=', 1)->firstOrFail();
        $columns = array("#","Name","Last name","Company","Identification n.","Email","Phone","Status","Registration date","Address");
    
        $callback = function() use ($reviews, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns,';');
    
            foreach($reviews as $key => $review) {

                //Asignar Status
                if($review->status == 1){

                    $status = __('idioma.gral_activo');

                }else{

                    $status = __('idioma.gral_inactivo');

                }
                fputcsv($file, array(++$key, $review->nombre , $review->apellido, $review->empresa, $review->cedula, $review->correo, $review->telefono, $status, date("Y/m/d", strtotime($review->created_at)), $review->direccion),';');
                
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);

    }
}
