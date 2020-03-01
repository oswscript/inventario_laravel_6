@extends('Back.master')
@section('title', __('idioma.nav_dash'))
{{-- @section('class_active_home', 'active') --}}
@section('content')
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">@lang('idioma.nav_dash')</h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{url('/dash')}}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li class="active">
                                @lang('idioma.nav_dash')
                            </li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">

                <!--CLIENTES REGISTRADOS--> 
                <div class="col-lg-4 col-md-6">
                    <div class="card-box widget-box-two widget-two-brown">
                        <i class="fa fa-user widget-two-icon"></i>
                        <div class="wigdet-two-content">
                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="@lang('idioma.dash_clientes_r')">@lang('idioma.nav_clientes')</p>
                            <h2><span data-plugin="counterup">{{$clientes_existencia}} </span></h2>
                            <p class="text-muted m-0">@lang('idioma.dash_clientes_r')</p>
                        </div>
                    </div>
                </div>

                <!--PROVEEDORES REGISTRADOS--> 
                <div class="col-lg-4 col-md-6">
                    <div class="card-box widget-box-two widget-two-danger">
                        <i class="fa fa-user widget-two-icon"></i>
                        <div class="wigdet-two-content">
                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="@lang('idioma.dash_provee_r')">@lang('idioma.nav_proveedores')</p>
                            <h2><span data-plugin="counterup">{{$proveedor_existencia}} </span></h2>
                            <p class="text-muted m-0">@lang('idioma.dash_provee_r')</p>
                        </div>
                    </div>
                </div>

                <!--USUARIOS-->                
                <div class="col-lg-4 col-md-6">
                    <div class="card-box widget-box-two widget-two-primary">
                        <i class="fa fa-users widget-two-icon"></i>
                        <div class="wigdet-two-content">
                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="@lang('idioma.dash_users_r')">@lang('idioma.dash_users_r')</p>
                            <h2><span data-plugin="counterup">{{$usuarios_existencia}}</span></h2>
                            <p class="text-muted m-0">@lang('idioma.dash_users_r')</p>
                        </div>
                    </div>
                </div><!-- end col -->

            </div>
            <?php /*
            <hr>

            <div class="row">

                <!--MONTO TOTAL EN VENTAS-->   
                <div class="col-lg-6 col-md-12">
                    <div class="card-box widget-box-two widget-two-success">
                        <i class="fa fa-arrow-down widget-two-icon"></i>
                        <div class="wigdet-two-content">
                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="@lang('idioma.dash_mont_ap_des_v')">@lang('idioma.dash_monto_apro_v')</p>
                            <h2><span data-plugin="counterup">{{ number_format($total_ventas,2)." ".$sistema->moneda}} </span></h2>
                            <p class="text-muted m-0">@lang('idioma.dash_mont_ap_des_v')</p>
                        </div>
                    </div>
                </div> 
                
                <!--MONTO TOTAL EN COMPRAS--> 
                <div class="col-lg-6 col-md-12">
                    <div class="card-box widget-box-two widget-two-info">
                        <i class="fa fa-arrow-up widget-two-icon"></i>
                        <div class="wigdet-two-content">
                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="@lang('idioma.dash_monto_apro_c')">@lang('idioma.dash_monto_apro_c')</p>
                            <h2><span data-plugin="counterup">{{number_format($total_compras,2)." ".$sistema->moneda}} </span></h2>
                            <p class="text-muted m-0">@lang('idioma.dash_mont_ap_des_c')</p>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end row -->

            <div class="row">
                <!--COMPRAS-->   
                <div class="col-lg-3 col-md-6">
                    <div class="card-box widget-box-two widget-two-default">
                        <i class="fa fa-dollar widget-two-icon"></i>
                        <div class="wigdet-two-content">
                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="@lang('idioma.dash_compr_aprob')">@lang('idioma.dash_compr_aprob')</p>
                            <h2><span data-plugin="counterup">{{$compras_existencia}}</span></h2>
                            <p class="text-muted m-0">&nbsp;</p>
                        </div>
                    </div>
                </div>

                <!--VENTAS-->   
                <div class="col-lg-3 col-md-6">
                    <div class="card-box widget-box-two widget-two-inverse">
                        <i class="fa fa-money widget-two-icon"></i>
                        <div class="wigdet-two-content">
                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="@lang('idioma.dash_vent_aprob')">@lang('idioma.dash_vent_aprob')</p>
                            <h2><span data-plugin="counterup">{{$ventas_existencia}}</span></h2>
                            <p class="text-muted m-0">&nbsp;</p>
                        </div>
                    </div>
                </div>

                <!--GASTOS-->                
                <div class="col-lg-3 col-md-6">
                    <div class="card-box widget-box-two widget-two-primary">
                        <i class="fa fa-users widget-two-icon"></i>
                        <div class="wigdet-two-content">
                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="@lang('idioma.dash_gastos_reg')">@lang('idioma.dash_gastos_reg')</p>
                            <h2><span data-plugin="counterup">{{$gastos_existencia}}</span></h2>
                            <p class="text-muted m-0">&nbsp;</p>
                        </div>
                    </div>
                </div><!-- end col -->

                <!--PRODUCTOS-->   
                <div class="col-lg-3 col-md-6">
                    <div class="card-box widget-box-two widget-two-warning">
                        <i class="fa fa-cubes widget-two-icon"></i>
                        <div class="wigdet-two-content">
                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="@lang('idioma.dash_prod_reg')">@lang('idioma.dash_prod_reg')</p>
                            <h2><span data-plugin="counterup">{{$productos_existencia}} </span></h2>
                            <p class="text-muted m-0">&nbsp;</p>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end row -->
            <hr>
            */?>

            <div class="row">
                
                <!--ULTIMAS COMPRAS-->
                <div class="col-lg-6">
                    <div class="card-box">
                        <h4 class="header-title m-t-0 m-b-30">@lang('idioma.dash_ult_comp')</h4>
                        <div class="table-responsive">
                            <table class="table table table-hover m-0">
                                <thead>
                                    <tr>
                                        <th>{{"#"}}</th>
                                        <th>{{"#"}}@lang('idioma.dash_compra')</th>
                                        <th>{{"Total (".$sistema->moneda.")"}}</th>
                                        <th>@lang('idioma.dash_fecha')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ultimas_compras as $key => $uc)
                                    <tr>
                                        <td>
                                             <p class="m-0 font-16">{{++$key}}</p>
                                        </td>
                                        <td>
                                             <p class="m-0 font-16">{{$uc->codigo_proceso}}</p>
                                        </td>
                                        <td>
                                             <p class="m-0 font-16">{{number_format($uc->total,2)}}</p>
                                        </td>
                                        <td>
                                             <p class="m-0 font-16">{{$uc->created_at}}</p>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div> <!-- table-responsive -->
                    </div> <!-- end card -->
                </div>
                <!-- end col -->

                <!--ULTIMAS VENTAS-->
                <div class="col-lg-6">
                    <div class="card-box">
                        <h4 class="header-title m-t-0 m-b-30">@lang('idioma.dash_ult_vent')</h4>
                        <div class="table-responsive">
                            <table class="table table table-hover m-0">
                                <thead>
                                    <tr>
                                        <th>{{"#"}}</th>
                                        <th>{{"#"}}@lang('idioma.dash_venta')</th>
                                        <th>{{"Total (".$sistema->moneda.")"}}</th>
                                        <th>@lang('idioma.dash_fecha')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ultimas_ventas as $key => $uc)
                                    <tr>
                                        <td>
                                             <p class="m-0 font-16">{{++$key}}</p>
                                        </td>
                                        <td>
                                             <p class="m-0 font-16">{{$uc->codigo_proceso}}</p>
                                        </td>
                                        <td>
                                             <p class="m-0 font-16">{{number_format($uc->total,2)}}</p>
                                        </td>
                                        <td>
                                             <p class="m-0 font-16">{{$uc->created_at}}</p>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- table-responsive -->
                    </div> <!-- end card -->
                </div>
                <!-- end col -->   
            </div>
        </div> <!-- container -->
    </div> <!-- content -->

@endsection
