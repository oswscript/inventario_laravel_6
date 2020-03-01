<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoFormRequest;
use App\Http\Requests\UpdateProductoFormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Producto;
use App\Configuracion;
use App\Categoria;
use App\SubCategoria;
use App\Tributo;
use App\DetalleProceso;
use Barryvdh\DomPDF\Facade as PDF;

class ProductoController extends Controller {

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

        $datos    =  Producto::all();
        $sistema  =  Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.producto.index', compact('datos','sistema'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $datos   =  Categoria::all();
        $datos2  =  Tributo::all();
        $sistema =  Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.producto.create', compact('sistema','datos','datos2'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductoFormRequest $request) {
        //
        $nombre          = strtoupper($request->get('nombre'));
        $codigo          = $request->get('codigo');
        $categoria       = $request->get('categoria');
        $sub_categoria   = $request->get('sub_categoria');
        $cantidad        = $request->get('cantidad');
        $precio_costo    = $request->get('precio_costo');
        $precio_publico  = $request->get('precio_publico');
        $tributo         = $request->get('tributo');
        $descripcion     = $request->get('descripcion');
        $status          = $request->get('status');
        $slug            = uniqid();    

         //CARGA DE IMAGEN
         if($request->hasFile('file') ){ 

           $file = $request->file('file');

           //extension del archivo
           $extension = substr(strrchr($file->getClientOriginalName(), "."), 1); 

           //obtenemos el nombre del archivo
           $imagen = $slug.".".$extension;
     
           //indicamos que queremos guardar un nuevo archivo en el disco local
           \Storage::disk('imagenes_productos')->put($imagen,  \File::get($file));

        }else{

            $imagen = "";

        }
       
        //REGISTRO DATOS
        $datos = new Producto(array(
            'nombre'           => $nombre,
            'codigo'           => $codigo,
            'categoria_id'     => $categoria,
            'subcategoria_id'  => $sub_categoria,
            'cantidad'         => $cantidad,
            'precio_costo'     => $precio_costo,
            'precio_publico'   => $precio_publico,
            'tributo_id'       => $tributo,
            'descripcion'      => $descripcion,
            'status'           => $status,
            'imagen'           => $imagen
        ));

        $datos->save();

        return redirect('/productos')->with('status', __('idioma.alert_registro'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
        $datos   = Producto::whereId($id)->firstOrFail();
        $sistema = Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.producto.show', compact('datos','sistema'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
        $datos   =  Producto::whereId($id)->firstOrFail();
        $datos2  =  Categoria::where('id','!=',$datos->categoria_id)->get();
        $datos3  =  Tributo::where('id','!=',$datos->tributo_id)->get();
        $datos4  =  SubCategoria::where('categoria_id','=',$datos->categoria_id)->get();
        $sistema =  Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.producto.edit', compact('datos','datos2','datos3','datos4','sistema'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductoFormRequest $request, $id) {
        
        //CAPTURAR EL ITEM
        $datos           = Producto::find($id);

        //dd($request->all());
        $nombre          = strtoupper($request->get('nombre'));
        $codigo          = $request->get('codigo');
        $categoria       = $request->get('categoria');
        $cantidad        = $request->get('cantidad');
        $precio_costo    = $request->get('precio_costo');
        $precio_publico  = $request->get('precio_publico');
        $tributo         = $request->get('tributo');
        $descripcion     = $request->get('descripcion');
        $status          = $request->get('status');
        $slug            = uniqid();

        //SUBCATEGORIA DINAMICA
        if($request->get('sub_categoria_inicial')){ $subcategoria   = $request->get('sub_categoria_inicial');}
        if($request->get('sub_categoria_resultado')){ $subcategoria = $request->get('sub_categoria_resultado');}
        if($request->get('campo_subcategoria')){ $subcategoria      = "";}


        //ACTUALIZANDO IMAGEN SI VIENE CON CONTENIDO
        if($request->hasFile('file') ){ 

           $file = $request->file('file');

           //extension del archivo
           $extension = substr(strrchr($file->getClientOriginalName(), "."), 1); 

           //obtenemos el nombre del archivo
           $imagen = $slug.".".$extension;

            //ruta de las imagenes con el nombre de la imagen
           $image_path =  public_path()."/storage/img_productos/".$datos->imagen;  

           //si el archivo existe que sea eliminado antes de registrar otro
           if(\File::exists($image_path)) {
                \File::delete($image_path);
           }
     
           //indicamos que queremos guardar un nuevo archivo en el disco local
           \Storage::disk('imagenes_productos')->put($imagen,  \File::get($file));

        //si no se cambia la imagen, se deja la que tenia
        }else{
            $imagen= $datos->imagen;
        }

        $datos                    = Producto::whereId($id)->firstOrFail();
        $datos->nombre            = $nombre;
        $datos->codigo            = $codigo;
        $datos->categoria_id      = $categoria;
        $datos->subcategoria_id   = $subcategoria;
        $datos->cantidad          = $cantidad;
        $datos->precio_costo      = $precio_costo;
        $datos->precio_publico    = $precio_publico;
        $datos->tributo_id        = $tributo;
        $datos->descripcion       = $descripcion;
        $datos->imagen            = $imagen;
        $datos->status            = $status;
        $datos->save();

        return redirect()->action('ProductoController@show', $datos->id)->with('status', __('idioma.alert_actua'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {


        $dato_consulta =  DetalleProceso::where('producto_id', '=', $id)->count();

        if($dato_consulta > 0){

            return redirect("/show_producto/$id")->with('error',  __('idioma.alert_ya_uso'));
           
        }else{
            
            //BORRADO DEIMAGEN
            $imagen = Producto::where('id', $id)->first();

            if($imagen->imagen != ""){

                Storage::disk('imagenes_productos')->delete($imagen->imagen);

            }


            //ELIMINAR DATO
            $datos = Producto::whereId($id)->firstOrFail();
            $datos->delete();

            return redirect("/productos")->with('status', __('idioma.alert_borrar'));

        }
    }

    public function cargar_subcategoria(Request $request){

        $id        = $request->get('categoria');
        $datos     = SubCategoria::whereCategoriaId($id)->get();

        echo json_encode($datos);


    }

    public function cargar_subcategoria2(Request $request){

        $id                      = $request->get('categoria');
        $subcatego_id_ajax       = $request->get('subcatego_id_ajax');
        $seleccionada            = Subcategoria::whereId($subcatego_id_ajax)->firstOrFail();
        $matriz['id_selec']      = $seleccionada->id;
        $matriz['nombre_selec']  = $seleccionada->nombre;
        //$matriz['data']          = SubCategoria::whereCategoriaId($id)->where('id','!=',$seleccionada->id)->get();
        $matriz['data']          = SubCategoria::whereCategoriaId($id)->get();
        echo json_encode($matriz);


    }

    /*Impresiones PDF*/
    public function pdf()
    {        

        $datos    = Producto::all(); 
        $sistema  = Configuracion::where('id', '=', 1)->firstOrFail();

        $pdf = PDF::loadView('Back.pdf.productos.lista', compact('datos', 'sistema'));
        return $pdf->download(__('idioma.product_titulo').'.pdf');
    }

    public function un_producto_pdf($id)
    {        

        $datos    = Producto::where('id', '=', $id)->firstOrFail(); 
        $sistema  = Configuracion::where('id', '=', 1)->firstOrFail();

        $pdf = PDF::loadView('Back.pdf.productos.individual', compact('datos', 'sistema'));
        return $pdf->download(__('idioma.nav_produc').'_'.$datos->codigo.'.pdf');
    }

    public function csv()
    {        
      $sistema = Configuracion::where('id', '=', 1)->firstOrFail();

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=List of products.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array("#","Name","Code","Category","Sub category","Quantity","Production price ($sistema->moneda)","Public price ($sistema->moneda)","Tax (%)","Status");
        
        $reviews = Producto::all();
    
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
                fputcsv($file, array(++$key, $review->nombre ,$review->codigo, $review->categoria->nombre, $review->subcategoria->nombre, $review->cantidad, $review->precio_costo, $review->precio_publico, $review->tributo->monto,$status),';');
                
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);

    }//Cierre CSV



}
