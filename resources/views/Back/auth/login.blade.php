<?php $configuracion = \DB::table('configuracion')->where('id', 1)->first(); ?>

<!DOCTYPE html>
<html lang="en">
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
        <title>{{'Login'}}</title>

        <!-- App css -->
        <link href="{{ url('Back/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('Back/assets/css/core.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('Back/assets/css/components.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('Back/assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('Back/assets/css/pages.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('Back/assets/css/menu.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('Back/assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="{{ url('Back/assets/js/modernizr.min.js') }}"></script>

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
                                    @if (session('status'))

                                        <div class="alert alert-success">

                                            <p class="login-box-msg">{{session('status')}}</p>

                                        </div>

                                    @endif
                                    <form class="form-horizontal">
                                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                        <div class="form-group ">
                                            <div class="col-xs-12">
                                            <label for="emailaddress">@lang('idioma.auth_correo')</label>
                                            <input id="correo" type="text" class="form-control" name="email" value="{{ old('email')}}" placeholder="@lang('idioma.auth_pl_correo')">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-12">
                                               <label for="password">@lang('idioma.auth_clave')</label>
                                            <input type="password" id="password" class="form-control" name="password" placeholder="@lang('idioma.auth_pl_clave')">
                                            </div>
                                        </div>

                                        @if($configuracion->recuperar_clave_login == "on")
                                        <div class="form-group text-center m-t-30">
                                            <div class="col-sm-12">
                                                <a href="{{url('/reset_pass')}}" class="text-muted"><i class="fa fa-lock m-r-5"></i>@lang('idioma.auth_olv_clave')</a>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="form-group account-btn text-center m-t-10">
                                            <div class="col-xs-12">
                                                <button id="submit" class="btn w-md btn-bordered btn-danger waves-effect waves-light" type="submit">@lang('idioma.auth_entrar')
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="clearfix"></div>

                                </div>
                            </div>
                            <!-- end card-box-->
                            <div class="row m-t-50">
                                @if($configuracion->registro_usuario_login == "on")
                                <div class="col-sm-12 text-center">
                                    <p class="text-muted">@lang('idioma.auth_sin_cuenta')<a href="{{url('/registrar')}}" class="text-primary m-l-5"><b>@lang('idioma.auth_lin_regis')</b></a></p>
                                </div>
                                @endif
                                <!--LOADER-->
                                 <div class="col-xs-12">
                                    <div class="loader" id="loader-4" style='display: none; padding: auto'>
                                      <span></span>
                                      <span></span>
                                      <span></span>
                                    </div>
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
        <script src="{{ url('Back/assets/js/jquery.scrollTo.min.js') }}"></script>

        <!-- App js -->
        <script src="{{ url('Back/assets/js/jquery.core.js') }}"></script>
        <script src="{{ url('Back/assets/js/jquery.app.js') }}"></script>


        <!--ALERTAS-->
        <script src="{{url('/Back/alertifyjs/alertify.min.js')}}"></script>

        <!--AJAX VERIFICACION DE DATOS-->
        <script type="text/javascript">

            $(document).ready(function() {

                $('#submit').click('submit', function (e) {

                    e.preventDefault();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    var correo         = $('#correo').val();
                    var password       = $('#password').val();
                    var token          = $('input[name=_token]').val();
                    $.ajax({

                        type: 'POST',
                        url: "{{url('/autenticar')}}",
                        data: {
                            '_token'        : token,
                            'email'         : correo,
                            'password'      : password,
                        },

                        beforeSend: function(){
                            // Show image container
                            $("#loader-4").fadeIn("slow");
                        },
                        success: function(data) {

                           if(data==0){

                            alertify.error("@lang('idioma.auth_obliga')");

                           }
                           else{

                                if(data==1){

                                    alertify.success("@lang('idioma.auth_permite')");
                                    window.location = '{{url('/dash')}}';

                                }

                                else if(data==2){

                                    alertify.error("@lang('idioma.auth_incorrec')");

                                }

                                else if(data==3){

                                    alertify.error("@lang('idioma.auth_corr_valid')");

                                }

                                else if(data==4){

                                    alertify.error("@lang('idioma.auth_revision')");

                                }

                                else if(data==5){

                                    alertify.error("@lang('idioma.auth_inactiva')");

                                }


                                else if(data==6){

                                    alertify.error("@lang('idioma.auth_no_existe')");

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
    </body>
</html>