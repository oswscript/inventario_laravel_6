<?php $configuracion = \DB::table('configuracion')->where('id', 1)->first(); ?>
<!DOCTYPE html>
<html lang="es">
    <head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
        <meta charset="utf-8" />
        <title>@lang('idioma.auth_tit_camb')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Desarrollado por Oswaldo Gerardino"name="description"/>
        <meta content="Oswaldo Geovanny - oswaldogeovanny@gmail.com" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        @if($configuracion->logo)
            <link rel="shortcut icon" href="{{ url('storage/img_sistema/'.$configuracion->logo) }}">
        @else
            <link rel="shortcut icon" href="{{ url('storage/img_sistema/default_logo.jpg') }}">
        @endif

        <!-- App css -->
        <link href="{{url('/Back/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('/Back/assets/css/core.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('/Back/assets/css/components.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('/Back/assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('/Back/assets/css/pages.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('/Back/assets/css/menu.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('/Back/assets/css/responsive.css')}}" rel="stylesheet" type="text/css" />
        <script src="{{url('/Back/assets/js/modernizr.min.js')}}"></script>

        <!--ALERTAS-->
        <link rel="stylesheet" href="{{url('/Back/alertifyjs/css/alertify.css')}}"></link>
        <link rel="stylesheet" href="{{url('/Back/alertifyjs/css/themes/bootstrap.css')}}"></link>

        <!--PRELOADER-->
        <link rel="stylesheet" href="{{url('/Back/preloader/css_loader.css')}}"></link>

    </head>
    <body  class="bg-transparent">
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
                                    <div class="text-center m-b-20">
                                        <p class="text-muted m-b-0 font-13">@lang('idioma.auth_det_rec_cl')</p>
                                    </div>
                                    <form class="form-horizontal">
                                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <input class="form-control" type="text" name="emailaddress" id="emailaddress" placeholder="@lang('idioma.auth_pl_correo')">
                                            </div>
                                        </div>

                                        <div class="form-group account-btn text-center m-t-10">
                                            <div class="col-xs-12">
                                                <button class="btn w-md btn-bordered btn-danger waves-effect waves-light"
                                                        type="submit" id="submit">@lang('idioma.auth_btn_recup')
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
                                     <p class="text-muted">@lang('idioma.auth_volver') <a href="{{url('/')}}" class="text-dark ml-1"><b>{{'Login'}}</b></a></p>
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
        <script src="{{url('/Back/assets/js/jquery.min.js')}}"></script>
        <script src="{{url('/Back/assets/js/bootstrap.min.js')}}"></script>
        <script src="{{url('/Back/assets/js/detect.js')}}"></script>
        <script src="{{url('/Back/assets/js/fastclick.js')}}"></script>
        <script src="{{url('/Back/assets/js/jquery.blockUI.js')}}"></script>
        <script src="{{url('/Back/assets/js/waves.js')}}"></script>
        <script src="{{url('/Back/assets/js/jquery.slimscroll.js')}}"></script>
        <script src="{{url('/Back/assets/js/jquery.scrollTo.min.js')}}"></script>

        <!-- App js -->
        <script src="{{url('/Back/assets/js/jquery.core.js')}}"></script>
        <script src="{{url('/Back/assets/js/jquery.app.js')}}"></script>

        <!--ALERTAS-->
        <script src="{{url('/Back/alertifyjs/alertify.min.js')}}"></script>

        <!--AJAX VERIFICACION DE DATOS-->
        <script type="text/javascript">

            $(document).ready(function() {

                $('#submit').click('submit', function (e) {

                    e.preventDefault();

                    var correo         = $('#emailaddress').val();
                    var token          = $('input[name=_token]').val();

                    $.ajax({

                        type: 'POST',
                        url: "{{url('/reset_pass')}}",
                        data: {

                            '_token'        : token,
                            'email'         : correo,
                            
                        },

                        beforeSend: function(){
                            // Show image container
                            $("#loader-4").fadeIn("slow");
                        },
                        success: function(data) {

                           console.log(data);

                           if(data==0){

                              alertify.error("@lang('idioma.auth_obliga')");

                           }
                           else{

                                if(data==1){

                                      alertify.alert("@lang('idioma.auth_instrucci')", function(){
                                       });
                                      setTimeout(function () {window.location.href = "{{url('/')}}";}, 4000);

                                }

                                else if(data==2){

                                 alertify.error("@lang('idioma.auth_corr_valid')");

                                }

                                else if(data==3){

                                    alertify.error("@lang('idioma.auth_no_exis')");

                                }

                                else if(data==4){

                                     alertify
                                      .alert("@lang('idioma.auth_ya_solc')", function(){
                                      });
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