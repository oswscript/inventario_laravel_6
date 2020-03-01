@extends('Back.master')
@section('title', 'KARDEX')
@section('active-kardex', 'active')
@section('content')
<!--CONSULTA DE PERMISOS SEGUN EL ROL-->
<?php $permisos = \DB::table('permisos')->where('rol_id', Session::get("rol_id"))->first();?>
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">{{"Kardex"}}</h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ url('/dash') }}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li class="active">
                                {{"Kardex"}}
                            </li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->
       
            <div class="row">
                <div class="col-sm-12">
                    
                    <div class="card-box table-responsive">
                        <h3 class="box-title"><a href="{{url('/pdf_kardex')}}" class="btn btn-danger pull-right"><i class="fa fa-file-pdf-o"></i> {{"PDF"}} </a></h3>
                        <h3 class="box-title"><a href="{{url('/csv_kardex')}}" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> {{"CSV"}} </a></h3>

                        <h4 class="m-t-0 header-title"><b>@lang('idioma.kx_titulo')</b></h4>
                        <p class="text-muted font-13 m-b-30">
                            @lang('idioma.kx_sub_titu')
                        </p>

                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>{{"#"}}</th>
                                <th>@lang('idioma.gral_codigo')</th>
                                <th>{{"#Prod."}}</th>
                                <th>@lang('idioma.nav_sys_tribu') (%)</th>
                                <th>@lang('idioma.gral_br_cant')</th>
                                <th>@lang('idioma.gral_precio') {{"u /( ".$sistema->moneda." )"}}</th>
                                <th>@lang('idioma.kx_pago') {{"( ".$sistema->moneda." )"}}</th>
                                <th>@lang('idioma.gral_tipo')</th>
                                <th>@lang('idioma.dash_fecha')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($datos as $key => $d)
                                <tr>
                                   <td>{{++$key}}</td>
                                   <td>{{ $d->codigo_proceso }}</td>
                                   <td>{{ $d->producto->codigo }}</td>
                                   <td>{{ $d->tributo->monto }}</td>
                                   <td>{{ $d->cantidad }}</td>
                                   <td>{{ $d->costo_publico_vendido }}</td>
                                   <td>{{ \DB::table('posprocesos')->where('codigo_proceso',$d->codigo_proceso)->value('tipo_pago') }}</td>
                                   <td>{{ \DB::table('posprocesos')->where('codigo_proceso',$d->codigo_proceso)->value('tipo_proceso') }}</td>
                                   <td>{{ $d->created_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- container -->
    </div> <!-- content -->
@endsection