<!-- Top Bar Start -->
<div class="topbar">

    <!-- LOGO -->
    <div class="topbar-left">
        <a href="{{url('/dash')}}" class="logo"><span>{{$sistema->nombre_empresa}}</span><i class="mdi mdi-layers"></i></a>
    </div>

    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">

            <!-- Navbar-left -->

            <ul class="nav navbar-nav navbar-left">
                <li>
                    <button class="button-menu-mobile open-left waves-effect">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </li>
                
            </ul>
            
            @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->compra_r == 1 or $permisos->venta_r == 1)
                <ul class="nav navbar-nav navbar-left">
                    @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->venta_r == 1)
                        <li>
                            <a href="{{url('/nueva-venta')}}" class="right-bar-toggle right-menu-item btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="@lang('idioma.vender_ahora')">
                               @lang('idioma.letra_vender')
                            </a>
                        </li>
                    @endif
                    @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->compra_r == 1)
                        <li>
                            <a href="{{url('/nueva-compra')}}" class="right-bar-toggle right-menu-item btn btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="@lang('idioma.comprar_ahora')">
                                @lang('idioma.letra_comprar')
                            </a>
                        </li>
                    @endif
                </ul>
            @endif
            <!-- LOGIN -->
            <ul class="nav navbar-nav navbar-right">
               
                <li class="dropdown user-box">
                    @if($img_usuario->imagen)
                        <a href="" class="dropdown-toggle waves-effect user-link" data-toggle="dropdown" aria-expanded="true">
                            <img src="{{ url('/storage/img_usuarios/'.$img_usuario->imagen) }}" alt="user-img" class="img-circle user-img">
                        </a>
                    @else
                        <a href="" class="dropdown-toggle waves-effect user-link" data-toggle="dropdown" aria-expanded="true">
                            <img src="{{ url('/storage/img_usuarios/default.png') }}" alt="user-img" class="img-circle user-img">
                        </a>
                    @endif

                    <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                        <li>
                            <h5>{{Session::get("nombre")}}</h5>
                        </li>
                        <li><a href="{{ url('/configuracion/usuario/editar-usuario',$usuario_id ) }}"><i class="ti-user m-r-5"></i> @lang('idioma.mi_perfil') </a></li>
                        <li><a href="{{ url('/salir') }}"><i class="ti-power-off m-r-5"></i> @lang('idioma.salir') </a></li>
                    </ul>
                </li>

            </ul> <!-- end navbar-right -->

        </div><!-- end container -->

    </div><!-- end navbar -->

</div>
<!-- Top Bar End -->


<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul>
                <li class="menu-title"> @lang('idioma.gral_navega') </li>

                <li>
                    <a href="{{ url('/dash') }}" class="waves-effect"><i class="mdi mdi-view-dashboard"></i><span> @lang('idioma.nav_dash')</span></a>
                </li>
                
                {{--CLASIFICACION--}}
                
                @if(Session::get("rol_id"))
                    @if($permisos->catego_i == 1 or $permisos->subcatego_i == 1)
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect @yield('active-clasificacion')"><i class="fa fa-list"></i> <span>@lang('idioma.nav_clasi')</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled"> 

                        {{--CATEGORIAS--}}
                            @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->catego_i == 1)
                                <li class="@yield('active-clasificacion-categoria')">
                                    <a href="{{ url('/categorias') }}" class="waves-effect @yield('active-clasificacion-categoria')"><span>@lang('idioma.nav_categ')<span></a>
                                </li>
                            @endif
                        
                        {{--SUB CATEGORIAS--}}   
                            @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->subcatego_i == 1)
                                <li class="@yield('active-clasificacion-subcategoria')">
                                    <a href="{{ url('/subcategorias') }}" class="waves-effect @yield('active-clasificacion-subcategoria')"><span>@lang('idioma.nav_subcateg')<span></a>
                                </li>
                            @endif

                        </ul>
                    </li>
                    @endif
                @endif

                {{--PRODUCTOS--}}
                @if(Session::get("rol_id"))
                    @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->producto_i == 1)
                    <li class="@yield('active-producto')">
                        <a href="{{ url('/productos') }}" class="waves-effect @yield('active-producto')"><i class="mdi mdi-package-variant"></i><span>@lang('idioma.nav_produc')<span></a>
                    </li>
                    @endif
                @endif
                
                {{--GASTOS--}}
                @if(Session::get("rol_id"))
                    @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->gasto_i == 1)
                    <li class="@yield('active-gastos')">
                        <a href="{{ url('/gastos') }}" class="waves-effect @yield('active-gastos')"><i class="mdi mdi-currency-usd"></i> <span>@lang('idioma.nav_gastos')<span></a>
                    </li>
                    @endif
                @endif

                {{--KARDEX--}}
                @if(Session::get("rol_id"))
                    @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->kardex_i == 1)
                    <li class="@yield('active-kardex')">
                        <a href="{{ url('/kardex') }}" class="waves-effect @yield('active-kardex')"><i class="mdi mdi-library-books"></i> <span>  {{'Kardex'}}  <span></a>
                    </li>
                    @endif
                @endif

                {{--VENTAS--}}
                @if(Session::get("rol_id"))
                    @if($permisos->venta_i == 1 or $permisos->venta_r == 1)
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect @yield('active-ventas')"><i class="fa fa-credit-card"></i> <span>@lang('idioma.nav_ventas')</span> <span class="menu-arrow"></span>
                        
                        @if($f_v_pen > 0)
                            <span class="badge badge-pill badge-warning color_letra_badge">{{$f_v_pen}}</span>
                        @endif
                        </a>
                        <ul class="list-unstyled">                            
                           
                            @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->venta_i == 1)
                            {{--VENTAS PENDIENTES--}}
                            <li class="@yield('active-ventas-pendientes')">
                                <a href="{{ url('/ventas_pendientes') }}" class="waves-effect @yield('active-ventas-pendientes')">
                                    <span> 
                                        @lang('idioma.nav_pendientes')
                                    </span>
                                    @if($f_v_pen > 0)
                                        <span class="badge badge-pill badge-warning color_letra_badge">{{$f_v_pen}}</span>
                                    @endif
                                </a>
                            </li>
                            
                            {{--VENTAS RECHAZADAS--}}
                            <li>
                                <a href="{{ url('/ventas_rechazadas') }}" class="waves-effect @yield('active-ventas-rechazadas')">
                                <span> 
                                    @lang('idioma.nav_rechazadas')
                                </span></a>
                            </li>

                            {{--VENTAS APROBADAS--}}
                            <li>
                                <a href="{{ url('/ventas_aprobadas') }}" class="waves-effect @yield('active-ventas-aprobadas')">
                                <span> 
                                    @lang('idioma.nav_aprobadas')
                                </span></a>
                            </li>
                            @endif

                            {{--NUEVA VENTA--}}
                            @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->venta_r == 1)
                            <li>
                                <a href="{{ url('/nueva-venta') }}" class="waves-effect">
                                <span> 
                                     @lang('idioma.nav_facturar')
                                </span></a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                @endif

                {{--COMPRAS--}}
                @if(Session::get("rol_id"))
                    @if($permisos->compra_i or $permisos->compra_r == 1)
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect @yield('active-compras')"><i class="fa fa-credit-card"></i> <span> @lang('idioma.nav_compras') </span> <span class="menu-arrow"></span>
                    
                        @if($f_c_pen > 0)
                            <span class="badge badge-pill badge-warning color_letra_badge">{{$f_c_pen}}</span>
                        @endif
                        </a>
                        <ul class="list-unstyled">    
                            {{--COMPRAS PENDIENTES--}}
                            @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->compra_i == 1)
                            
                            <li>
                                <a href="{{ url('/compras_pendientes') }}" class="waves-effect  @yield('active-compras-pendientes')">
                                    <span> 
                                       @lang('idioma.nav_pendientes')
                                    </span>
                                    @if($f_c_pen > 0)
                                        <span class="badge badge-pill badge-warning color_letra_badge">{{$f_c_pen}}</span>
                                    @endif
                                </a>
                            </li>
                            {{--COMPRAS RECHAZADAS--}}
                            <li>
                                <a href="{{ url('/compras_rechazadas') }}" class="waves-effect @yield('active-compras-rechazadas')">
                                    <span> 
                                        @lang('idioma.nav_rechazadas')
                                    </span>
                                </a>
                            </li>

                            {{--COMPRAS APROBADAS--}}
                            <li>
                                <a href="{{ url('/compras_aprobadas') }}" class="waves-effect @yield('active-compras-aprobadas')">
                                <span> 
                                    @lang('idioma.nav_aprobadas') 
                                </span></a>
                            </li>
                            @endif

                            {{--NUEVA COMPRA--}}
                            @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->compra_r == 1)
                            <li>
                                <a href="{{ url('/nueva-compra') }}" class="waves-effect">
                                <span> 
                                   @lang('idioma.nav_facturar')
                                </span></a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                @endif

                {{--PERSONAS--}}
                @if(Session::get("rol_id"))
                    @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->persona_i == 1)
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect @yield('active-personas')"><i class="fa fa-users"></i> <span>@lang('idioma.nav_personas')</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">                            
                                {{--CLIENTES--}}
                                <li class="@yield('active-personas-clientes')">
                                    <a href="{{ url('/clientes') }}" class="waves-effect @yield('active-personas-clientes')">
                                    <span> 
                                        @lang('idioma.nav_clientes')
                                    </span></a>
                                </li>

                                {{--PROVEEDORES--}}
                                <li class="@yield('active-personas-proveedores')">
                                    <a href="{{ url('/proveedores') }}" class="waves-effect @yield('active-personas-proveedores')">
                                    <span> 
                                         @lang('idioma.nav_proveedores') 
                                    </span></a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

                {{--REPORTES--}}
                @if(Session::get("rol_id"))
                    @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->reporte_i == 1)
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect @yield('active-reportes')"><i class="mdi mdi-file-multiple"></i> <span>@lang('idioma.nav_reportes') </span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled"> 
                                {{--REPORTE DE VENTAS--}}
                                <li class="@yield('active-reportes-ventas')">
                                    <a href="javascript:void(0)" id="btn_modal_reporte_ventas" class="waves-effect @yield('active-reportes-ventas')">
                                        <span> 
                                           @lang('idioma.nav_rep_ventas') 
                                        </span>
                                    </a>
                                </li>

                                {{--REPORTE DE COMPRAS--}}
                                <li class="@yield('active-reportes-compras')">
                                    <a href="javascript:void(0)" id="btn_modal_reporte_compras" class="waves-effect @yield('active-reportes-compras')">
                                        <span> 
                                            @lang('idioma.nav_rep_compras') 
                                        </span>
                                    </a>
                                </li>
                                
                                {{--REPORTE DE GASTOS--}}
                                <li class="@yield('active-reportes-gastos')">
                                    <a href="javascript:void(0)" id="btn_modal_reporte_gastos" class="waves-effect @yield('active-reportes-gastos')">
                                        <span> 
                                            @lang('idioma.nav_rep_gastos') 
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif
                
                {{--CONFIGURACION DEL SISTEMA: Configuracion y Permisos--}}
                @if(Session::get("rol_id"))
                    @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2)
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect @yield('active-configuracion')"><i class="mdi mdi mdi-settings"></i>
                            <span>@lang('idioma.nav_sistema')</span><span class="menu-arrow"></span>
                            @if($u_pendientes > 0)
                                <span class="badge badge-secondary">{{$u_pendientes}}</span>
                            @endif
                            </a>
                            <ul class="list-unstyled">
                                <li class="@yield('active-configuracion-configuracion')"><a href="{{ url('/configuracion/configuracion') }}">@lang('idioma.nav_sys_config')</a></li>
                                <li class="@yield('active-configuracion-permisos')"><a href="{{ url('/configuracion/permisos') }}">@lang('idioma.nav_sys_per')</a></li>
                                <li class="@yield('active-configuracion-tributos')"><a href="{{ url('/configuracion/tributos') }}">@lang('idioma.nav_sys_tribu')</a></li>
                                <li class="@yield('active-configuracion-roles')"><a href="{{ url('/configuracion/roles') }}">@lang('idioma.nav_sys_roles')</a></li>
                                <li class="@yield('active-configuracion-usuarios')">
                                    <a href="{{ url('/configuracion/usuario') }}">
                                            @lang('idioma.nav_sys_usu') 
                                        <span> 
                                            @if($u_pendientes > 0)
                                                <span class="badge badge-secondary">{{$u_pendientes}}</span>
                                            @endif
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

            </ul>
        </div>
        
    <div class="clearfix"></div>
    <div class="help-box">
       <h5 class="text-muted m-t-0"> @lang('idioma.gral_made'): </h5>
       <p class="" style="font-size:7pt;"><span class="text-custom"> @lang('idioma.gral_correo') :</span> <br/>  {{'contact@oswscript.com'}} </p>
       <p class="" style="font-size:7pt;"><span class="text-custom"> {{'Web'}} :</span> <br/> oswscript.com</p>
    </div>

    </div>
    <!-- Sidebar -left -->
</div>
<!-- Left Sidebar End -->

<!--
    *******************************************************************
    *******************************************************************
                          MODALES DE REPORTES
    *******************************************************************
    *******************************************************************
-->
    <!--MODAL REPORTE VENTAS-->
    <div id="modal_reporte_ventas" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">@lang('idioma.rep_ven_md_tit')</h4>
                </div>
                <div class="modal-body">
                    {{--FORMULARIO--}}
                    {!! Form::open(['url'=>'/modal_reporte_ventas_filtrar','method' => 'post']) !!}
                    <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                                 <div class="row">
                                    <div class="col-md-12">
                                        <label for="status">@lang('idioma.rep_ven_md_sta')</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="todas">@lang('idioma.rep_ven_md_all')</option>
                                            <option value="1">@lang('idioma.rep_ven_md_pen')</option>
                                            <option value="2">@lang('idioma.rep_ven_md_apr')</option>
                                            <option value="0">@lang('idioma.rep_ven_md_rec')</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">&nbsp;</div>
                                    <div class="col-md-6">
                                        <label for="desde">@lang('idioma.rep_ven_md_des') <code>{{'X'}}</code> @lang('idioma.rep_ven_md_fec')</label>
                                        <input type="text" readonly="readonly" class="form-control" id="modal_reporte_venta_inicio" name="modal_reporte_venta_inicio" value="{{date('Y-m-d')}}" onkeypress="return controltag(event)" style="background-color: white;"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="hasta">@lang('idioma.rep_ven_md_has') <code>{{'X'}}</code> @lang('idioma.rep_ven_md_fec')</label>
                                        <input type="text" readonly="readonly" class="form-control" id="modal_reporte_venta_final" name="modal_reporte_venta_final" value="{{date('Y-m-d')}}" onkeypress="return controltag(event)" style="background-color: white;" />
                                    </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">@lang('idioma.rep_ven_md_cer')</button>
                        <button type="submit" class="btn btn-info waves-effect waves-light" id="filtrar_reporte_venta">@lang('idioma.rep_ven_md_gen')</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div><!-- /.final modal reporte ventas -->

    <!--MODAL REPORTE COMPRAS-->
    <div id="modal_reporte_compras" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">@lang('idioma.rep_com_md_tit')</h4>
                </div>
                <div class="modal-body">
                    {{--FORMULARIO--}}
                    {!! Form::open(['url'=>'/modal_reporte_compras_filtrar','method' => 'post']) !!}
                    <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                                 <div class="row">
                                    <div class="col-md-12">
                                        <label for="status">@lang('idioma.rep_ven_md_sta')</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="todas">@lang('idioma.rep_ven_md_all')</option>
                                            <option value="1">@lang('idioma.rep_ven_md_pen')</option>
                                            <option value="2">@lang('idioma.rep_ven_md_apr')</option>
                                            <option value="0">@lang('idioma.rep_ven_md_rec')</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="desde">@lang('idioma.rep_ven_md_des') <code>{{'X'}}</code> @lang('idioma.rep_ven_md_fec')</label>
                                        <input type="text" readonly="readonly" class="form-control" id="modal_reporte_compra_inicio" name="modal_reporte_compra_inicio" value="{{date('Y-m-d')}}" onkeypress="return controltag(event)" style="background-color: white;"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="hasta">@lang('idioma.rep_ven_md_has') <code>{{'X'}}</code> @lang('idioma.rep_ven_md_fec')</label>
                                        <input type="text" readonly="readonly" class="form-control" id="modal_reporte_compra_final" name="modal_reporte_compra_final" value="{{date('Y-m-d')}}" onkeypress="return controltag(event)" style="background-color: white;" />
                                    </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">@lang('idioma.rep_ven_md_cer')</button>
                        <button type="submit" class="btn btn-info waves-effect waves-light" id="filtrar_reporte_compras">@lang('idioma.rep_ven_md_gen')</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div><!-- /.final modal reporte compras -->

    
    <!--MODAL REPORTE GASTOS-->
    <div id="modal_reporte_gastos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">@lang('idioma.rep_gas_md_tit')</h4>
                </div>
                <div class="modal-body">
                    {{--FORMULARIO--}}
                    {!! Form::open(['url'=>'/modal_reporte_gastos_filtrar','method' => 'post']) !!}
                    <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                                 <div class="row">
                                    <div class="col-md-6">
                                        <label for="desde">@lang('idioma.rep_ven_md_des') <code>{{'X'}}</code> @lang('idioma.rep_ven_md_fec')</label>
                                        <input type="text" readonly="readonly" class="form-control" id="modal_reporte_gasto_inicio" name="modal_reporte_gasto_inicio" value="{{date('Y-m-d')}}" onkeypress="return controltag(event)" style="background-color: white;"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="hasta">@lang('idioma.rep_ven_md_has') <code>{{'X'}}</code> @lang('idioma.rep_ven_md_fec')</label>
                                        <input type="text" readonly="readonly" class="form-control" id="modal_reporte_gasto_final" name="modal_reporte_gasto_final" value="{{date('Y-m-d')}}" onkeypress="return controltag(event)" style="background-color: white;" />
                                    </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">@lang('idioma.rep_ven_md_cer')</button>
                        <button type="submit" class="btn btn-info waves-effect waves-light" id="filtrar_reporte_gastos">@lang('idioma.rep_ven_md_gen')</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div><!-- /.final modal reporte gastos -->
 <!--
    *******************************************************************
    *******************************************************************
                       FINAL MODALES DE REPORTES
    *******************************************************************
    *******************************************************************
-->

<script>
   var resizefunc = [];
</script>