@extends('Back.master')
@section('title', "Cod-".$datos->codigo )
@section('active-gastos', 'active')
@section('content')

<!--CONSULTA DE PERMISOS SEGUN EL ROL-->
<?php $permisos = \DB::table('permisos')->where('rol_id', Session::get("rol_id"))->first();?>
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
                        <h4 class="page-title">@lang('idioma.gral_op_par'): <i> {{ strtoupper($datos->codigo) }} </i> </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ url('/dash') }}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li>
                                <a href="{{ url('/gastos') }}">@lang('idioma.gst_titulo')</a>
                            </li>
                            <li class="active">
                                @lang('idioma.gral_viendo'):  {{ strtoupper($datos->codigo) }}
                            </li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-sm-6">
                    <div class="card-box">
                        <h4 class="m-t-0 header-title"><b></b></h4>
                        <p class="text-muted m-b-30 font-13">
                          
                        </p>
                        <div class="row">
                            <div class="col-md-12">
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{session('status')}}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{session('error')}}
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="monto">@lang('idioma.gst_monto') {{ "( ". $sistema->moneda." )" }}</label>
                                    <input type="text" value="{{ number_format($datos->monto,2) }}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="fecha">@lang('idioma.dash_fecha')</label>
                                    <input type="text" value="{{date('Y-m-d', strtotime($datos->fecha))}}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="usuario">@lang('idioma.gral_reg_por')</label>
                                    <input type="text" value="{{ $datos->usuario->apellido.', '.$datos->usuario->nombre }}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="codigo">@lang('idioma.gral_codigo')</label>
                                    <input type="text" value="{{ $datos->codigo }}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="concepto">@lang('idioma.gst_razon')</label>
                                    <textarea type="text" class="form-control" readonly>{{ $datos->concepto }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="observacion">@lang('idioma.gst_observacion')</label>
                                    @if(empty($datos->observacion))
                                        <textarea type="text" class="form-control" readonly>@lang('idioma.gst_sin_observa')</textarea>
                                    @else
                                        <textarea type="text" class="form-control" readonly>{{ $datos->observacion }}</textarea>
                                    @endif
                                </div>
                                <a href="{{ url('/gastos') }}"><button type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i> @lang('idioma.gral_btn_atras') </button></a>

                                @if(Session::get("rol_id"))
                                    @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->gasto_e == 1)
                                        <a href="{{ url('/editar_gasto',$datos->id) }}"><button type="submit" class="btn btn-info"><i class="fa fa-edit"></i>  @lang('idioma.gral_btn_edit') </button></a>
                                    @endif

                                    @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->gasto_b == 1)
                                        <a href="{{ url('/borrar_gasto',$datos->id) }}"><button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>  @lang('idioma.gral_btn_borr') </button></a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container -->

    </div> <!-- content -->
@endsection