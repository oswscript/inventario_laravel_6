@extends('Back.master')
@section('title', __('idioma.gst_titulo'))
@section('active-gastos', 'active')
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
                        <h4 class="page-title">@lang('idioma.gst_titulo')</h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ url('/dash') }}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li class="active">
                                @lang('idioma.gst_titulo')
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

                        @if(Session::get("rol_id"))
                            @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->gasto_r == 1)
                                <h3 class="box-title"><a href="{{url ('/nuevo-gasto')}}" class="btn btn-primary" style="float:right;"><i class="fa fa-plus-circle"></i> @lang('idioma.gral_nuevo') </a></h3>
                            @endif
                                <h3 class="box-title"><a href="{{url('/pdf_gastos')}}" class="btn btn-danger pull-right"><i class="fa fa-file-pdf-o"></i>{{" PDF "}}</a></h3>
                                <h3 class="box-title"><a href="{{url('/csv_gastos')}}" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i>{{" CSV "}}</a></h3>
                        @endif

                        <h4 class="m-t-0 header-title"><b> @lang('idioma.gst_titulo') </b></h4>
                        <p class="text-muted font-13 m-b-30">
                            &nbsp;
                        </p>
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{session('status')}}
                                </div>
                            @endif
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>{{"#"}}</th>
                                <th>@lang('idioma.gst_monto') {{ "( ". $sistema->moneda." )" }}</th>
                                <th>@lang('idioma.dash_fecha')</th>
                                <th>@lang('idioma.gral_codigo')</th>
                            </tr>
                            </thead>


                            <tbody>
                            @foreach($datos as $key => $d)
                                <tr>
                                   <td>{{++$key}}</td>
                                   <td><a href="{{ url('/show_gasto', $d->id) }}">{{ number_format($d->monto,2) }}</a></td>
                                   <td><a href="{{ url('/show_gasto', $d->id) }}">{{date('Y-m-d', strtotime($d->fecha))}}
                                   <td><a href="{{ url('/show_gasto', $d->id) }}">{{ $d->codigo }}</a></td></a></td>
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