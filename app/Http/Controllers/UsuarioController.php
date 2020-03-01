<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserFormRequest;
use App\Http\Requests\UsuarioFormRequest;
use Illuminate\Http\Request;
use App\Rol;
use App\User;
use App\Configuracion;
use App\Posproceso;
use Barryvdh\DomPDF\Facade as PDF;

class UsuarioController extends Controller {
    
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

        $datos   =  User::where('rol_id', '!=', 1)->get();
        $sistema =  Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.configuracion.usuario.index', compact('datos','sistema'));

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create() {

        //

        $roles   =  Rol::where('id', '!=', 1)->get();
        $sistema =  Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.configuracion.usuario.create', compact('roles','sistema'));

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(UsuarioFormRequest $request) {

        //dd($request->all());
        //exit();
        $nombre    = strtoupper($request->get('nombre'));
        $apellido  = strtoupper($request->get('apellido'));
        $cedula    = $request->get('cedula');
        $sexo      = $request->get('sexo');
        $email     = $request->get('email');
        $telefono  = $request->get('telefono');
        $direccion = $request->get('direccion');
        $rol_id    = $request->get('rol');
        $slug      = uniqid();


        if($request->hasFile('file') ){ 

           $file = $request->file('file');

           //extension del archivo
           $extension = substr(strrchr($file->getClientOriginalName(), "."), 1); 

           //obtenemos el nombre del archivo
           $imagen = $slug.".".$extension;
     
           //indicamos que queremos guardar un nuevo archivo en el disco local
           \Storage::disk('imagenes_usuarios')->put($imagen,  \File::get($file));

        }else{

            $imagen = "";

        }

        //dd($request->hasFile('file'));
        //buscando el item por cedula

            $datos = new User(array(

                'nombre'    => $nombre,
                'apellido'  => $apellido,
                'cedula'    => $cedula,
                'email'     => $email,
                'sexo'      => $sexo,
                'telefono'  => $telefono,
                'direccion' => $direccion,
                'imagen'    => $imagen,
                'rol_id'    => $rol_id,
                'password'  => bcrypt($request->get('clave')),

            ));

            $datos->save();

            return redirect('/configuracion/usuario')->with('status', __('idioma.alert_registro'));
    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id) {

        //

        $datos   = User::whereId($id)->firstOrFail();
        $sistema =  Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.configuracion.usuario.show', compact('datos','sistema'));

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id) {

        //

        $roles   = Rol::all();
        $datos   = User::whereId($id)->firstOrFail();
        $sistema =  Configuracion::where('id', '=', 1)->firstOrFail();
        return view('Back.configuracion.usuario.edit', compact('datos', 'roles', 'sistema'));

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(UpdateUserFormRequest $request, $id) {

        //dd($request->all());

        $datos     = User::whereId($id)->firstOrFail();
        $nombre    = strtoupper($request->get('nombre'));
        $apellido  = strtoupper($request->get('apellido'));
        $cedula    = $request->get('cedula');
        $correo    = $request->get('email');
        $sexo      = $request->get('sexo');
        $telefono  = $request->get('telefono');
        $direccion = $request->get('direccion');
        $slug      = uniqid();

        //CONSULTAR EL VALOR DE LA IMAGEN
        $imagen_usuario = User::find($id);

        //ACTUALIZANDO IMAGEN SI VIENE CON CONTENIDO
        if($request->hasFile('file') ){ 

           $file = $request->file('file');

           //extension del archivo
           $extension = substr(strrchr($file->getClientOriginalName(), "."), 1); 

           //obtenemos el nombre del archivo
           $imagen = $slug.".".$extension;

            //ruta de las imagenes con el nombre de la imagen
           $image_path =  public_path()."/storage/img_usuarios/".$imagen_usuario->imagen;  

           //si el archivo existe que sea eliminado antes de registrar otro
           if(\File::exists($image_path)) {
                \File::delete($image_path);
           }
     
           //indicamos que queremos guardar un nuevo archivo en el disco local
           \Storage::disk('imagenes_usuarios')->put($imagen,  \File::get($file));

            //ACTUALIZAR LA FOTO
            $datos->imagen     = $imagen;
            $datos->save();

        }


        if ($request->get('clave') == null) {

            $datos->nombre     = $nombre;
            $datos->apellido   = $apellido;
            $datos->cedula     = $cedula;
            $datos->sexo       = $sexo;
            $datos->telefono   = $telefono;
            $datos->direccion  = $direccion;
            $datos->email      = $correo;
            $datos->rol_id     = $request->get('rol');
            $datos->save();

            return redirect('/configuracion/usuario')->with('status', __('idioma.alert_actua'));

        } else {

            $datos->nombre     = $nombre;
            $datos->apellido   = $apellido;
            $datos->cedula     = $cedula;
            $datos->sexo       = $sexo;
            $datos->telefono   = $telefono;
            $datos->direccion  = $direccion;
            $datos->email      = $correo;
            $datos->rol_id     = $request->get('rol');
            $datos->password   = bcrypt($request->get('clave'));
            $datos->save();

            return redirect('/configuracion/usuario')->with('status', __('idioma.alert_actua'));

        }

    }


    public function status_activar(Request $request, $id) {

        //dd($request->all());

        $datos         = User::whereId($id)->firstOrFail();
        $status        = 1;
        $datos->status = $status;
        $datos->save();
        return redirect('/configuracion/usuario')->with('status', __('idioma.alert_actua'));


    }

    public function status_inactivar(Request $request, $id) {
        //dd($request->all());
        $datos         = User::whereId($id)->firstOrFail();
        $status        = 0;
        $datos->status = $status;
        $datos->save();

        return redirect('/configuracion/usuario')->with('status', __('idioma.alert_actua'));

    }


    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id) {

        
         $dato_consulta =  Posproceso::where('usuario_id', '=', $id)->count();

        if($dato_consulta > 0){

            return redirect("/configuracion/usuario/$id")->with('error', __('idioma.alert_ya_uso'));
           
        }else{
                        
            //ELIMINAR DATO
            $datos = User::whereId($id)->firstOrFail();
            $datos->delete();


            return redirect('/configuracion/usuario')->with('status', __('idioma.alert_borrar'));

        }

    }

    public function pdf()
    {        

        $datos   =  User::where('rol_id', '!=', 1)->where('rol_id', '!=', 2)->get();
        $sistema  = Configuracion::where('id', '=', 1)->firstOrFail();

        $pdf = PDF::loadView('Back.pdf.personas.usuarios.lista', compact('datos', 'sistema'));
        return $pdf->download('listado.pdf');
    }

}

