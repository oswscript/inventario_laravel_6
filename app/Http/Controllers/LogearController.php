<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Rol;;
use App\Permiso;
use App\Resetpassword;
use App\Configuracion;

class LogearController extends Controller {

   
    public function __construct(){

      $sistema = Configuracion::where('id', '=', 1)->firstOrFail();

      \App::setLocale($sistema->idioma);
    }

    // inicio de sesion
    public function logear(){

      return view('Back.auth.login');

    }
  
    public function authenticate(Request $request) {
      

        $email              = $request->get('email');
        $password           = $request->get('password');
        $remember           = ($request->get('remember')) ? true : false ;
        $comprobar_email    = $this->verificarEmail(htmlentities($email));
        $usuario_status     = User::whereEmail($email)->first();

        if($email=="" || $password=="")
        {
          return 0;
        }

        elseif(!$comprobar_email){

          return 3;

        }

        else{

            if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
                //DATOS DEL USUARIO
                $usuario       = User::whereEmail($email)->firstOrFail();
                $rol           = Rol::whereId($usuario->rol_id)->first();
                $permisos      = Permiso::where('rol_id', $usuario->rol_id)->firstOrFail();

                //VERIFICAR EL STATUS DEL USUARIO
                if($usuario_status->status == 2){

                  return 4;

                }
                elseif($usuario_status->status == 0){

                  return 5;

                }
                else{

                 //VARIABLES DE USUARIO
                 Session::put('correo', $usuario->email);
                 Session::put('nombre', $usuario->nombre);
                 Session::put('rol_id', $usuario->rol_id);
                 Session::put('usuario_id', $usuario->id);
                 Session::put('rol_nombre', $rol->nombre);
                 return 1;

                }

            }else{

               return 2;

            }
        }
              
    
    }
    public function logout() {

        Auth::logout();
        //OLVIDAR VARIABLES DE LA SESSION
        Session::flush();
        return redirect()->intended('/')->with('status', __('idioma.auth_gracias'));
        
    }

    public function show_registrar() {
       
        return view('Back.auth.registro');

    }

    public function create_registrar(Request $request) {
      
        $name               = strtoupper($request->get('name'));
        $lastname           = strtoupper($request->get('lastname'));
        $emailaddress       = $request->get('emailaddress');
        $comprobar_email    = $this->verificarEmail(htmlentities($emailaddress));
        $password           = $request->get('password');
        $confirmpassword    = $request->get('confirmpassword');
        $dni                = $request->get('dni');

        $correo_existencia  =  User::where('email', '=', $emailaddress)->count();
        $dni_existencia     =  User::where('cedula', '=', $dni)->count();


        if($name=="" || $lastname=="" || $emailaddress=="" || $password=="" || $confirmpassword=="" || $dni=="")
        {

          return 0;

        }
        elseif($correo_existencia > 0)
        {

          return 2;

        }

        elseif($dni_existencia > 0)
        {

          return 3;

        }

        elseif($confirmpassword != $password)
        {

          return 4;

        }
        elseif(!$comprobar_email){

          return 5;

        }

        else{

            $registro               = new User;
            $registro->nombre       = $name;
            $registro->apellido     = $lastname;
            $registro->cedula       = $dni;
            $registro->email        = $emailaddress;
            $registro->password     = bcrypt($password);
            $registro->rol_id       = 3;
            $registro->status       = 2;// STATUS PENDIENTE
            $registro->save();

            return 1;

        }

    }

    public function show_reset_password(){

       return view('Back.auth.reset_password');

    }

    public function enviar_reset_password(Request $request){

        $emailaddress       = $request->get('email');
        $comprobar_email    = $this->verificarEmail(htmlentities($emailaddress));        
        $correo_existencia  =  User::where('email', '=', $emailaddress)->count();
        $correo_ex_reset    =  Resetpassword::where('correo', '=', $emailaddress)->count();


        if($emailaddress=="")
        {

            return 0;

        }else{


            if(!$comprobar_email){

             return 2;

            }

            elseif($correo_existencia==0){

              return 3;

            }

            elseif($correo_ex_reset > 0){

              return 4;

            }

            else{

               $para              = $emailaddress;
               $titulo_mail       = __('idioma.auth_correo_titu');
               $mensaje_titulo    = __('idioma.auth_msg_titu').": ".$emailaddress;
               $mensaje_preloader = __('idioma.auth_msg_prelo');
               $mensaje_contenido = __('idioma.auth_msg_cont');

               $this->mail_solicitud_contrasena($para,$titulo_mail,$mensaje_titulo,$mensaje_contenido,$mensaje_preloader);

               $usuario                = User::whereEmail($emailaddress)->firstOrFail();
               $registro               = new Resetpassword;
               $registro->user_id      = $usuario->id;
               $registro->correo       = $emailaddress;
               $registro->save();

               return 1;

            }

        }

    }

    public function edit_reset_password($id){

      $usuario_existencia  =  Resetpassword::where('user_id', '=', $id)->count();

      if($usuario_existencia > 0){

       return view('Back.auth.update_password');

      }else{

       return view('Back.auth.update_password_empty');

      }

    }

    public function update_reset_password(Request $request, $id){

        $password           = $request->get('contrasena');
        $confirmpassword    = $request->get('confirmarclave');
        $usuario            = User::whereId($id)->firstOrFail();


        if($password=="" || $confirmpassword==""){

            return 0;

        }else{

            if($confirmpassword != $password)
            {
              return 2;

            }else{

              $update             = User::find($id);
              $update->password   = bcrypt($password);
              $update->save();

              $resetpassword      = Resetpassword::whereUserId($id)->firstOrFail();
              $resetpassword->delete();


               $para              = $usuario->email;
               $titulo_mail       = __('idioma.auth_upd_clave');
               $mensaje_titulo    = __('idioma.auth_msg_titu').": ".$para;
               $mensaje_preloader = __('idioma.auth_upd_clave');
               $mensaje_contenido = __('idioma.auth_msg_cont2');

               $this->mail_contrasena_success($para,$titulo_mail,$mensaje_titulo,$mensaje_contenido,$mensaje_preloader);

              return 1;

            }

        }

    }

     //FUNCION PARA VERIFICAR EL FORMATO DEL CORREO
     function verificarEmail($direccion) 
     { 
        $sintaxis = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
        if(preg_match($sintaxis,$direccion)) 
           return true; 
        else 
           return false; 
     } 

     /*---------------------------------SECCION DE CORREOS---------------------------------*/

    function mail_solicitud_contrasena($para,$titulo_mail,$mensaje_titulo,$mensaje_contenido,$mensaje_preloader){
    $sistema = Configuracion::where('id', '=', 1)->firstOrFail();
    $usuario    = User::whereEmail($para)->firstOrFail();
    $para_1     = $para;
    $titulo     = $titulo_mail;
    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $cabeceras .= 'From:'.$sistema->correo;
    $mensaje    = '

          <html>
            <head>
              <style>
                /* -------------------------------------
                    GLOBAL RESETS
                ------------------------------------- */
                img {
                  border: none;
                  -ms-interpolation-mode: bicubic;
                  max-width: 100%; }

                body {
                  background-color: #f6f6f6;
                  font-family: sans-serif;
                  -webkit-font-smoothing: antialiased;
                  font-size: 14px;
                  line-height: 1.4;
                  margin: 0;
                  padding: 0;
                  -ms-text-size-adjust: 100%;
                  -webkit-text-size-adjust: 100%; }

                table {
                  border-collapse: separate;
                  mso-table-lspace: 0pt;
                  mso-table-rspace: 0pt;
                  width: 100%; }
                  table td {
                    font-family: sans-serif;
                    font-size: 14px;
                    vertical-align: top; }

                /* -------------------------------------
                    BODY & CONTAINER
                ------------------------------------- */

                .body {
                  background-color: #f6f6f6;
                  width: 100%; }

                /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
                .container {
                  display: block;
                  Margin: 0 auto !important;
                  /* makes it centered */
                  max-width: 580px;
                  padding: 10px;
                  width: 580px; }

                /* This should also be a block element, so that it will fill 100% of the .container */
                .content {
                  box-sizing: border-box;
                  display: block;
                  Margin: 0 auto;
                  max-width: 580px;
                  padding: 10px; }

                /* -------------------------------------
                    HEADER, FOOTER, MAIN
                ------------------------------------- */
                .main {
                  background: #ffffff;
                  border-radius: 3px;
                  width: 100%; }

                .wrapper {
                  box-sizing: border-box;
                  padding: 20px; }

                .content-block {
                  padding-bottom: 10px;
                  padding-top: 10px;
                }

                .footer {
                  clear: both;
                  Margin-top: 10px;
                  text-align: center;
                  width: 100%; }
                  .footer td,
                  .footer p,
                  .footer span,
                  .footer a {
                    color: #999999;
                    font-size: 12px;
                    text-align: center; }

                /* -------------------------------------
                    TYPOGRAPHY
                ------------------------------------- */
                h1,
                h2,
                h3,
                h4 {
                  color: #000000;
                  font-family: sans-serif;
                  font-weight: 400;
                  line-height: 1.4;
                  margin: 0;
                  margin-bottom: 30px; }

                h1 {
                  font-size: 35px;
                  font-weight: 300;
                  text-align: center;
                  text-transform: capitalize; }

                p,
                ul,
                ol {
                  font-family: sans-serif;
                  font-size: 14px;
                  font-weight: normal;
                  margin: 0;
                  margin-bottom: 15px; }
                  p li,
                  ul li,
                  ol li {
                    list-style-position: inside;
                    margin-left: 5px; }

                a {
                  color: #3498db;
                  text-decoration: underline; }

                /* -------------------------------------
                    BUTTONS
                ------------------------------------- */
                .btn {
                  box-sizing: border-box;
                  width: 100%; }
                  .btn > tbody > tr > td {
                    padding-bottom: 15px; }
                  .btn table {
                    width: auto; }
                  .btn table td {
                    background-color: #ffffff;
                    border-radius: 5px;
                    text-align: center; }
                  .btn a {
                    background-color: #ffffff;
                    border: solid 1px #3498db;
                    border-radius: 5px;
                    box-sizing: border-box;
                    color: #3498db;
                    cursor: pointer;
                    display: inline-block;
                    font-size: 14px;
                    font-weight: bold;
                    margin: 0;
                    padding: 12px 25px;
                    text-decoration: none;
                    text-transform: capitalize; }

                .btn-primary table td {
                  background-color: #3498db; }

                .btn-primary a {
                  background-color: #3498db;
                  border-color: #3498db;
                  color: #ffffff; }

                /* -------------------------------------
                    OTHER STYLES THAT MIGHT BE USEFUL
                ------------------------------------- */
                .last {
                  margin-bottom: 0; }

                .first {
                  margin-top: 0; }

                .align-center {
                  text-align: center; }

                .align-right {
                  text-align: right; }

                .align-left {
                  text-align: left; }

                .clear {
                  clear: both; }

                .mt0 {
                  margin-top: 0; }

                .mb0 {
                  margin-bottom: 0; }

                .preheader {
                  color: transparent;
                  display: none;
                  height: 0;
                  max-height: 0;
                  max-width: 0;
                  opacity: 0;
                  overflow: hidden;
                  mso-hide: all;
                  visibility: hidden;
                  width: 0; }

                .powered-by a {
                  text-decoration: none; }

                hr {
                  border: 0;
                  border-bottom: 1px solid #f6f6f6;
                  Margin: 20px 0; }

                /* -------------------------------------
                    RESPONSIVE AND MOBILE FRIENDLY STYLES
                ------------------------------------- */
                @media only screen and (max-width: 620px) {
                  table[class=body] h1 {
                    font-size: 28px !important;
                    margin-bottom: 10px !important; }
                  table[class=body] p,
                  table[class=body] ul,
                  table[class=body] ol,
                  table[class=body] td,
                  table[class=body] span,
                  table[class=body] a {
                    font-size: 16px !important; }
                  table[class=body] .wrapper,
                  table[class=body] .article {
                    padding: 10px !important; }
                  table[class=body] .content {
                    padding: 0 !important; }
                  table[class=body] .container {
                    padding: 0 !important;
                    width: 100% !important; }
                  table[class=body] .main {
                    border-left-width: 0 !important;
                    border-radius: 0 !important;
                    border-right-width: 0 !important; }
                  table[class=body] .btn table {
                    width: 100% !important; }
                  table[class=body] .btn a {
                    width: 100% !important; }
                  table[class=body] .img-responsive {
                    height: auto !important;
                    max-width: 100% !important;
                    width: auto !important; }}

                /* -------------------------------------
                    PRESERVE THESE STYLES IN THE HEAD
                ------------------------------------- */
                @media all {
                  .ExternalClass {
                    width: 100%; }
                  .ExternalClass,
                  .ExternalClass p,
                  .ExternalClass span,
                  .ExternalClass font,
                  .ExternalClass td,
                  .ExternalClass div {
                    line-height: 100%; }
                  .apple-link a {
                    color: inherit !important;
                    font-family: inherit !important;
                    font-size: inherit !important;
                    font-weight: inherit !important;
                    line-height: inherit !important;
                    text-decoration: none !important; }
                  .btn-primary table td:hover {
                    background-color: #34495e !important; }
                  .btn-primary a:hover {
                    background-color: #34495e !important;
                    border-color: #34495e !important; } }

              </style>
            </head>
            <body class="">
              <table border="0" cellpadding="0" cellspacing="0" class="body">
                <tr>
                  <td>&nbsp;</td>
                  <td class="container">
                    <div class="content">

                      <!-- START CENTERED WHITE CONTAINER -->
                      <span class="preheader">'.$mensaje_preloader.'</span>
                      <table class="main">

                        <!-- START MAIN CONTENT AREA -->
                        <tr>
                          <td class="wrapper">
                            <table border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td>
                                  <h2>'.$mensaje_titulo.'</h2>
                                  <p>'.$mensaje_contenido.'</p>
                                  <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                                    <tbody>
                                      <tr>
                                        <td align="left">
                                          <table border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                              <tr>
                                                <td> <a href='.url('/cambio_pass/'.$usuario->id).' target="_blank">'.__('idioma.auth_tit_camb').'</a> </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>

                      <!-- END MAIN CONTENT AREA -->
                      </table>

                      <!-- START FOOTER -->
                      <div class="footer">
                        <table border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td class="content-block">
                              <span class="apple-link">OSWSCRIPT</span>
                              <br><a href="https://oswscript.com">oswscript.com</a>.
                            </td>
                          </tr>
                          <tr>
                            <td class="content-block powered-by">
                              Email: contact@oswscript.com
                            </td>
                          </tr>
                        </table>
                      </div>
                      <!-- END FOOTER -->

                    <!-- END CENTERED WHITE CONTAINER -->
                    </div>
                  </td>
                  <td>&nbsp;</td>
                </tr>
              </table>
            </body>
          </html>

       ';

     mail($para_1, $titulo, $mensaje, $cabeceras);


  }

  function mail_contrasena_success($para,$titulo_mail,$mensaje_titulo,$mensaje_contenido,$mensaje_preloader){
    $sistema = Configuracion::where('id', '=', 1)->firstOrFail();
    $usuario    = User::whereEmail($para)->firstOrFail();
    $para_1     = $para;
    $titulo     = $titulo_mail;
    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $cabeceras .= 'From:'.$sistema->correo;
    $mensaje    = '

          <html>
            <head>
              <style>
                /* -------------------------------------
                    GLOBAL RESETS
                ------------------------------------- */
                img {
                  border: none;
                  -ms-interpolation-mode: bicubic;
                  max-width: 100%; }

                body {
                  background-color: #f6f6f6;
                  font-family: sans-serif;
                  -webkit-font-smoothing: antialiased;
                  font-size: 14px;
                  line-height: 1.4;
                  margin: 0;
                  padding: 0;
                  -ms-text-size-adjust: 100%;
                  -webkit-text-size-adjust: 100%; }

                table {
                  border-collapse: separate;
                  mso-table-lspace: 0pt;
                  mso-table-rspace: 0pt;
                  width: 100%; }
                  table td {
                    font-family: sans-serif;
                    font-size: 14px;
                    vertical-align: top; }

                /* -------------------------------------
                    BODY & CONTAINER
                ------------------------------------- */

                .body {
                  background-color: #f6f6f6;
                  width: 100%; }

                /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
                .container {
                  display: block;
                  Margin: 0 auto !important;
                  /* makes it centered */
                  max-width: 580px;
                  padding: 10px;
                  width: 580px; }

                /* This should also be a block element, so that it will fill 100% of the .container */
                .content {
                  box-sizing: border-box;
                  display: block;
                  Margin: 0 auto;
                  max-width: 580px;
                  padding: 10px; }

                /* -------------------------------------
                    HEADER, FOOTER, MAIN
                ------------------------------------- */
                .main {
                  background: #ffffff;
                  border-radius: 3px;
                  width: 100%; }

                .wrapper {
                  box-sizing: border-box;
                  padding: 20px; }

                .content-block {
                  padding-bottom: 10px;
                  padding-top: 10px;
                }

                .footer {
                  clear: both;
                  Margin-top: 10px;
                  text-align: center;
                  width: 100%; }
                  .footer td,
                  .footer p,
                  .footer span,
                  .footer a {
                    color: #999999;
                    font-size: 12px;
                    text-align: center; }

                /* -------------------------------------
                    TYPOGRAPHY
                ------------------------------------- */
                h1,
                h2,
                h3,
                h4 {
                  color: #000000;
                  font-family: sans-serif;
                  font-weight: 400;
                  line-height: 1.4;
                  margin: 0;
                  margin-bottom: 30px; }

                h1 {
                  font-size: 35px;
                  font-weight: 300;
                  text-align: center;
                  text-transform: capitalize; }

                p,
                ul,
                ol {
                  font-family: sans-serif;
                  font-size: 14px;
                  font-weight: normal;
                  margin: 0;
                  margin-bottom: 15px; }
                  p li,
                  ul li,
                  ol li {
                    list-style-position: inside;
                    margin-left: 5px; }

                a {
                  color: #3498db;
                  text-decoration: underline; }

                /* -------------------------------------
                    BUTTONS
                ------------------------------------- */
                .btn {
                  box-sizing: border-box;
                  width: 100%; }
                  .btn > tbody > tr > td {
                    padding-bottom: 15px; }
                  .btn table {
                    width: auto; }
                  .btn table td {
                    background-color: #ffffff;
                    border-radius: 5px;
                    text-align: center; }
                  .btn a {
                    background-color: #ffffff;
                    border: solid 1px #3498db;
                    border-radius: 5px;
                    box-sizing: border-box;
                    color: #3498db;
                    cursor: pointer;
                    display: inline-block;
                    font-size: 14px;
                    font-weight: bold;
                    margin: 0;
                    padding: 12px 25px;
                    text-decoration: none;
                    text-transform: capitalize; }

                .btn-primary table td {
                  background-color: #3498db; }

                .btn-primary a {
                  background-color: #3498db;
                  border-color: #3498db;
                  color: #ffffff; }

                /* -------------------------------------
                    OTHER STYLES THAT MIGHT BE USEFUL
                ------------------------------------- */
                .last {
                  margin-bottom: 0; }

                .first {
                  margin-top: 0; }

                .align-center {
                  text-align: center; }

                .align-right {
                  text-align: right; }

                .align-left {
                  text-align: left; }

                .clear {
                  clear: both; }

                .mt0 {
                  margin-top: 0; }

                .mb0 {
                  margin-bottom: 0; }

                .preheader {
                  color: transparent;
                  display: none;
                  height: 0;
                  max-height: 0;
                  max-width: 0;
                  opacity: 0;
                  overflow: hidden;
                  mso-hide: all;
                  visibility: hidden;
                  width: 0; }

                .powered-by a {
                  text-decoration: none; }

                hr {
                  border: 0;
                  border-bottom: 1px solid #f6f6f6;
                  Margin: 20px 0; }

                /* -------------------------------------
                    RESPONSIVE AND MOBILE FRIENDLY STYLES
                ------------------------------------- */
                @media only screen and (max-width: 620px) {
                  table[class=body] h1 {
                    font-size: 28px !important;
                    margin-bottom: 10px !important; }
                  table[class=body] p,
                  table[class=body] ul,
                  table[class=body] ol,
                  table[class=body] td,
                  table[class=body] span,
                  table[class=body] a {
                    font-size: 16px !important; }
                  table[class=body] .wrapper,
                  table[class=body] .article {
                    padding: 10px !important; }
                  table[class=body] .content {
                    padding: 0 !important; }
                  table[class=body] .container {
                    padding: 0 !important;
                    width: 100% !important; }
                  table[class=body] .main {
                    border-left-width: 0 !important;
                    border-radius: 0 !important;
                    border-right-width: 0 !important; }
                  table[class=body] .btn table {
                    width: 100% !important; }
                  table[class=body] .btn a {
                    width: 100% !important; }
                  table[class=body] .img-responsive {
                    height: auto !important;
                    max-width: 100% !important;
                    width: auto !important; }}

                /* -------------------------------------
                    PRESERVE THESE STYLES IN THE HEAD
                ------------------------------------- */
                @media all {
                  .ExternalClass {
                    width: 100%; }
                  .ExternalClass,
                  .ExternalClass p,
                  .ExternalClass span,
                  .ExternalClass font,
                  .ExternalClass td,
                  .ExternalClass div {
                    line-height: 100%; }
                  .apple-link a {
                    color: inherit !important;
                    font-family: inherit !important;
                    font-size: inherit !important;
                    font-weight: inherit !important;
                    line-height: inherit !important;
                    text-decoration: none !important; }
                  .btn-primary table td:hover {
                    background-color: #34495e !important; }
                  .btn-primary a:hover {
                    background-color: #34495e !important;
                    border-color: #34495e !important; } }

              </style>
            </head>
            <body class="">
              <table border="0" cellpadding="0" cellspacing="0" class="body">
                <tr>
                  <td>&nbsp;</td>
                  <td class="container">
                    <div class="content">

                      <!-- START CENTERED WHITE CONTAINER -->
                      <span class="preheader">'.$mensaje_preloader.'</span>
                      <table class="main">

                        <!-- START MAIN CONTENT AREA -->
                        <tr>
                          <td class="wrapper">
                            <table border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td>
                                  <h2>'.$mensaje_titulo.'</h2>
                                  <p>'.$mensaje_contenido.'</p>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>

                      <!-- END MAIN CONTENT AREA -->
                      </table>

                      <!-- START FOOTER -->
                      <div class="footer">
                        <table border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td class="content-block">
                              <span class="apple-link">OSWSCRIPT</span>
                              <br><a href="https://oswscript.com">oswscript.com</a>.
                            </td>
                          </tr>
                          <tr>
                            <td class="content-block powered-by">
                              Email: contact@oswscript.com
                            </td>
                          </tr>
                        </table>
                      </div>
                      <!-- END FOOTER -->

                    <!-- END CENTERED WHITE CONTAINER -->
                    </div>
                  </td>
                  <td>&nbsp;</td>
                </tr>
              </table>
            </body>
          </html>

       ';

     mail($para_1, $titulo, $mensaje, $cabeceras);


  }

}
