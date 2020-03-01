@extends('Back.master')
@section('title', __('idioma.nav_clientes'))
@section('active-personas', 'active subdrop')<!--ACTIVE DROP-->
@section('active-personas-clientes', 'active')<!--ACTIVE LINK-->
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
                        <h4 class="page-title">@lang('idioma.nav_clientes')</h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ url('/dash') }}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li class="active">
                                @lang('idioma.nav_clientes')
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
                            <h3 class="box-title"><a href="{{url ('/nuevo-cliente')}}" class="btn btn-primary" style="float:right;"><i class="fa fa-plus-circle"></i> @lang('idioma.gral_nuevo') </a></h3>
                            <h3 class="box-title"><a href="{{url('/pdf_clientes')}}" class="btn btn-danger pull-right"><i class="fa fa-file-pdf-o"></i>{{" PDF "}}</a></h3>
                            <h3 class="box-title"><a href="{{url('/csv_clientes')}}" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i>{{" CSV "}}</a></h3>
                        @endif

                        <h4 class="m-t-0 header-title"><b>@lang('idioma.cliente_lista')</b></h4>
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
                                <th>@lang('idioma.gral_nombre')</th>
                                <th>@lang('idioma.gral_apellido')</th>
                                <th>@lang('idioma.cliente_cr')</th>
                                <th>@lang('idioma.cliente_empresa')</th>
                                <th>@lang('idioma.gral_status')</th>
                            </tr>
                            </thead>


                            <tbody>
                            @foreach($datos as $key => $d)
                                <tr>
                                   <td>{{++$key}}</td>
                                   <td><a href="{!! action('ClienteController@show', $d->id) !!}">{{ $d->nombre }}</a></td>
                                   <td><a href="{!! action('ClienteController@show', $d->id) !!}">{{ $d->apellido }}</a></td>
                                   <td><a href="{!! action('ClienteController@show', $d->id) !!}">{{ $d->cedula }}</a></td>
                                   <td><a href="{!! action('ClienteController@show', $d->id) !!}">{{ $d->empresa }}</a></td>
                                   @if($d->status == 1)
                                        <td><a class="status_activo_letra" href="{!! action('ClienteController@show', $d->id) !!}">@lang('idioma.gral_activo')</a></td>
                                   @else
                                        <td><a class="status_inactivo_letra" href="{!! action('ClienteController@show', $d->id) !!}">@lang('idioma.gral_in_activo')</a></td>
                                   @endif
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