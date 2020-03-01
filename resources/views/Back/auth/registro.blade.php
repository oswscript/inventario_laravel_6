<?php $configuracion = \DB::table('configuracion')->where('id', 1)->first(); ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Desarrollado por Oswaldo Gerardino"name="description"/>
        <meta content="Oswaldo Geovanny - oswaldogeovanny@gmail.com" name="author" />
        
        <!-- App favicon -->
        @if($configuracion->logo)
            <link rel="shortcut icon" href="{{ url('storage/img_sistema/'.$configuracion->logo) }}">
        @else
            <link rel="shortcut icon" href="{{ url('storage/img_sistema/default_logo.jpg') }}">
        @endif
        
        <!-- App title -->
        <title>@lang('idioma.auth_lin_regis')</title>

        <!-- App css -->
        <link href="{{url('/Back/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{url('/Back/assets/css/core.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{url('/Back/assets/css/components.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{url('/Back/assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{url('/Back/assets/css/pages.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{url('/Back/assets/css/menu.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{url('/Back/assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="{{url('/Back/assets/js/modernizr.min.js') }}"></script>


        <!--ALERTAS-->
        <link rel="stylesheet" href="{{url('/Back/alertifyjs/css/alertify.css')}}"></link>
        <link rel="stylesheet" href="{{url('/Back/alertifyjs/css/themes/bootstrap.css')}}"></link>

        <!--PRELOADER-->
        <link rel="stylesheet" href="{{url('/Back/preloader/css_loader.css')}}"></link>

    </head>


    <body class="bg-transparent">

        <!-- HOME -->
        <section>
            <div class="container-alt">
                <div class="row">
                    <div class="col-sm-12">

                        <div class="wrapper-page">

                            <div class="m-t-40 account-pages">
                                <div class="text-center account-logo-box">
                                    <h2 class="text-uppercase">
                                        <a href="{{url('/')}}" class="text-success">
                                            <span>

                                                @if($configuracion->logo)
                                                    <img style="width:100px; height:100px" src="{{ url('storage/img_sistema/'.$configuracion->logo) }}">
                                                @else
                                                    <img style="width:100px; height:100px" src="{{ url('storage/img_sistema/default_logo.jpg') }}">
                                                @endif

                                            </span>
                                        </a>
                                    </h2>
                                    <h4 class="text-uppercase font-bold text-white m-b-0">{{$configuracion->nombre_empresa}}</h4>
                                </div>
                                <div class="account-content">
                                    <form>
                                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                        <div class="form-group mb-3">
                                            <label for="name">@lang('idioma.auth_reg_nombre')</label>
                                            <input class="form-control" type="text" id="name">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="lastname">@lang('idioma.auth_reg_apelli')</label>
                                            <input class="form-control" type="text" id="lastname">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="dni">@lang('idioma.cliente_cr')</label>
                                            <input class="form-control" type="text" id="dni" onkeypress="return valida(event)">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="emailaddress">@lang('idioma.auth_correo')</label>
                                            <input class="form-control" type="email" id="emailaddress">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="password">@lang('idioma.auth_clave')</label>
                                            <input class="form-control" type="password" id="password">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="confirmpassword">@lang('idioma.auth_reg_con_cl')</label>
                                            <input class="form-control" type="password" id="confirmpassword">
                                        </div>
                                        <div class="form-group account-btn text-center m-t-10">
                                            <div class="col-xs-12">
                                                <button id="submit" class="btn w-md btn-bordered btn-danger waves-effect waves-light" type="submit">@lang('idioma.auth_btn_reg')

                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="clearfix"></div>

                                </div>
                            </div>
                            <!-- end card-box-->


                            <div class="row m-t-50">
                                <div class="col-sm-12 text-center">
                                    <p class="text-muted">@lang('idioma.auth_ya_cuenta')<a href="{{url('/')}}" class="text-primary m-l-5"><b>@lang('idioma.auth_btn_entra')</b></a></p>
                                </div>

                                <!--LOADER-->
                                <div class="loader" id="loader-4" style='display: none;'>
                                  <span></span>
                                  <span></span>
                                  <span></span>
                                </div>
                            </div>

                        </div>
                        <!-- end wrapper -->

                    </div>
                </div>
            </div>
          </section>
          <!-- END HOME -->

        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="{{ url('Back/assets/js/jquery.min.js') }}"></script>
        <script src="{{ url('Back/assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ url('Back/assets/js/detect.js') }}"></script>
        <script src="{{ url('Back/assets/js/fastclick.js') }}"></script>
        <script src="{{ url('Back/assets/js/jquery.blockUI.js') }}"></script>
        <script src="{{ url('Back/assets/js/waves.js') }}"></script>
        <script src="{{ url('Back/assets/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ url('Back/assets/js/jquery.scrollTo.min.') }}"></script>

        <!-- App js -->
        <script src="{{ url('Back//js/jquery.core.js') }}"></script>
        <script src="{{ url('Back/assets/js/jquery.app.js') }}"></script>


        <!--ALERTAS-->
        <script src="{{url('/Back/alertifyjs/alertify.min.js')}}"></script>

        <!--AJAX VERIFICACION DE DATOS-->
        <script type="text/javascript">

            $(document).ready(function() {

                $('#submit').click('submit', function (e) {

                    e.preventDefault();

                    var name            = $('#name').val(); 
                    var lastname        = $('#lastname').val(); 
                    var dni             = $('#dni').val(); 
                    var emailaddress    = $('#emailaddress').val(); 
                    var password        = $('#password').val(); 
                    var confirmpassword = $('#confirmpassword').val(); 
                    var token           = $('input[name=_token]').val();

                    $.ajax({

                        type: 'POST',
                        url: "{{url('/registrar')}}",
                        data: {
                            '_token'         : token,
                            'name'           : name,
                            'lastname'       : lastname,
                            'dni'            : dni,
                            'emailaddress'   : emailaddress,
                            'password'       : password,
                            'confirmpassword': confirmpassword,
                        },

                        beforeSend: function(){
                            // Show image container
                            $("#loader-4").fadeIn("slow");
                        },
                        success: function(data) {

                           //console.log(data);

                           if(data==0){

                              alertify.error("@lang('idioma.auth_obliga')");

                           }
                           else{

                                if(data==1){

                                    alertify.success("@lang('idioma.auth_regis_ok')");
                                    //window.location = '{{url('/login')}}';
                                    setTimeout(function () {window.location.href = "{{url('/')}}";}, 2000);

                                }
                                else if(data==2){

                                    alertify.error("@lang('idioma.auth_cor_usado')");

                                } 
                                else if(data==3){

                                    alertify.error("@lang('idioma.auth_ide_usado')");

                                }
                                else if(data==4){

                                    alertify.error("@lang('idioma.auth_clav_difer')");

                                }
                                else if(data==5){

                                    alertify.error("@lang('idioma.auth_corr_valid')");

                                }

                            }

                        },
                        complete:function(data){
                            // Hide image container
                            $("#loader-4").fadeOut("slow");
                        }

                    });

                });

            });

        </script>

        <!--VALIDAR SOLO NUMEROS EN EL INPUT-->
        <script type="text/javascript">
            function valida(e){
                tecla = (document.all) ? e.keyCode : e.which;

                //Tecla de retroceso para borrar, siempre la permite
                if (tecla==8){
                    return true;
                }
                    
                // Patron de entrada, en este caso solo acepta numeros
                patron =/[0-9]/;
                tecla_final = String.fromCharCode(tecla);
                return patron.test(tecla_final);
            }
        </script>

    </body>
</html>