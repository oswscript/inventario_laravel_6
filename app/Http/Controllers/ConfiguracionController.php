<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateConfiguracionFormRequest;
use App\Http\Controllers\Controller;
use App\Configuracion;

class ConfiguracionController extends Controller
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
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {

        $sistema         = Configuracion::where('id', '=', 1)->firstOrFail();
        $configuracion   = Configuracion::find(1);
        $nombre_empresa  = $configuracion->nombre_empresa;
        $slogan          = $configuracion->slogan;
        $codigo_empresa  = $configuracion->codigo_empresa;
        $logo            = $configuracion->logo;
        $telefono        = $configuracion->telefono;
        $correo          = $configuracion->correo;
        $moneda          = $configuracion->moneda;
        $tributo         = $configuracion->tributo;//Activo e Inactivo
        $r_u_login       = $configuracion->registro_usuario_login;
        $r_c_login       = $configuracion->recuperar_clave_login;

        return view('Back.configuracion.configuracion.edit', compact('nombre_empresa','slogan','codigo_empresa','logo','r_u_login','r_c_login','sistema','telefono','correo','moneda','tributo'));
   

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateConfiguracionFormRequest $request)
    {
        //dd($request->all());
        $id        = 1;
        $update    = Configuracion::find($id);
        $slug      = uniqid();

        //ACTUALIZANDO IMAGEN SI VIENE CON CONTENIDO
        if($request->hasFile('file') ){ 

           $file = $request->file('file');

           //extension del archivo
           $extension = substr(strrchr($file->getClientOriginalName(), "."), 1); 

           //obtenemos el nombre del archivo
           $imagen = $slug.".".$extension;

            //ruta de las imagenes con el nombre de la imagen
           $image_path =  public_path()."/storage/img_sistema/".$update->logo;  

           //si el archivo existe que sea eliminado antes de registrar otro
           if(\File::exists($image_path)) {
                \File::delete($image_path);
           }
     
           //indicamos que queremos guardar un nuevo archivo en el disco local
           \Storage::disk('imagenes_sistema')->put($imagen,  \File::get($file));

            //ACTUALIZAR LA FOTO
            $update->logo     = $imagen;
            $update->save();

        }

        $nombre                 = strtoupper($_POST['nombre']);
        $slogan                 = strtoupper($_POST['slogan']);

        if($request->get('recuperar_clave_login')){
            $recuperar_clave_login  = "on";
        }else{
            $recuperar_clave_login  = "off";
        }

        if($request->get('registro_usuario_login')){
            $registro_usuario_login  = "on";
        }else{
            $registro_usuario_login  = "off";
        }

        $update->nombre_empresa         = $nombre;
        $update->slogan                 = $slogan;
        $update->codigo_empresa         = $_POST['codigo'];
        $update->correo                 = $_POST['correo'];
        $update->telefono               = $_POST['telefono'];
        $update->moneda                 = $_POST['moneda'];
        $update->tributo                = $_POST['tributo'];
        $update->recuperar_clave_login  = $recuperar_clave_login;
        $update->registro_usuario_login = $registro_usuario_login;
        $update->idioma                 = $_POST['idioma'];
        $update->save();

        return redirect("configuracion/configuracion")->with('status', __('idioma.alert_actua'));
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
