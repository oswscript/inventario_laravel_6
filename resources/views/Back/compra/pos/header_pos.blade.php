<!--CONSULTA DE PERMISOS SEGUN EL ROL-->
<?php 

    $permisos     = \DB::table('permisos')->where('rol_id', Session::get("rol_id"))->first();//PERMISOS
    $img_usuario  = \DB::table('users')->where('id', Session::get("usuario_id"))->first();//IMAGEN DE USUARIO
    $sistema      = \DB::table('configuracion')->where('id', 1)->first();//CONFIGURACION DEL SISTEMA
    $u_pendientes = \DB::table('users')->where('status', 2)->count();//CANTIDAD DE USUARIOS PENDIENTES
    $usuario_id   = Session::get("usuario_id");//ID DEL USUARIO EN LA SESSIOn

?>

<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container">

            <!-- Logo container-->
            <div class="logo">
            <!-- LOGO -->
            <div class="topbar-left">
                <a href="{{url('/dash')}}" class="logo"><span>{{$sistema->nombre_empresa}}</span></a>
            </div>

            </div>
            <!-- End Logo container-->

            <div class="menu-extras">

                @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->compra_r == 1 or $permisos->venta_r == 1)
                    <ul class="nav navbar-nav navbar-left">
                        @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->venta_r == 1)
                            <li>
                                <a href="{{url('/nueva-venta')}}" class="right-bar-toggle right-menu-item btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="VENDER AHORA!">
                                    @lang('idioma.letra_vender')
                                </a>
                            </li>
                        @endif
                        @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->compra_r == 1)
                            <li>
                                <a href="{{url('/nueva-compra')}}" class="right-bar-toggle right-menu-item btn btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="COMPRAR AHORA!">
                                    @lang('idioma.letra_comprar')
                                </a>
                            </li>
                        @endif
                    </ul>
                @endif
                <ul class="nav navbar-nav navbar-right pull-right">
                   
                    <li class="dropdown navbar-c-items">
                        @if($img_usuario->imagen)
                            <a href="" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true"><img src="{{ url('/storage/img_usuarios/'.$img_usuario->imagen) }}" alt="user-img" class="img-circle"> </a>

                        @else
                            <a href="" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true"><img src="{{ url('/storage/img_usuarios/default.png') }}" alt="user-img" class="img-circle"> </a>
                        @endif
                        
                        <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                            <li>
                                <h5>{{Session::get("nombre")}}</h5>
                            </li>
                            <li><a href="{{ url('/configuracion/usuario/editar-usuario',$usuario_id ) }}"><i class="ti-user m-r-5"></i>  {{'Mi Perfíl'}} </a></li>
                            <li><a href="{{ url('/salir') }}"><i class="ti-power-off m-r-5"></i> {{'Salir'}} </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- end menu-extras -->

        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->
</header>
<!-- End Navigation Bar-->


