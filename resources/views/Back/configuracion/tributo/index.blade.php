@extends('Back.master')
@section('title',  __('idioma.nav_sys_tribu'))
@section('active-configuracion', 'active subdrop')
@section('active-configuracion-tributos', 'active')
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
                        <h4 class="page-title">@lang('idioma.tax_titulo')</h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ url('/dash') }}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li class="active">
                              @lang('idioma.nav_sys_tribu')
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

                        <h3 class="box-title"><a href="{{url ('configuracion/tributo/nuevo-tributo')}}" class="btn btn-primary" style="float:right;"><i class="fa fa-plus-circle"></i> @lang('idioma.gral_nuevo') </a></h3>

                        <h4 class="m-t-0 header-title"><b>@lang('idioma.tax_list')</b></h4>
                        <p class="text-muted font-13 m-b-30">
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
                                <th>@lang('idioma.gral_tipo')</th>
                                <th>@lang('idioma.tax_valor')</th>
                            </tr>
                            </thead>


                            <tbody>
                            @foreach($datos as $key => $d)
                                <tr>
                                   <td>{{++$key}}</td>
                                   <td><a href="{!! action('TributoController@show', $d->id) !!}">{{ $d->nombre }}</a></td>
                                   <td><a href="{!! action('TributoController@show', $d->id) !!}">{{ $d->tipo }}</a></td>
                                   <td><a href="{!! action('TributoController@show', $d->id) !!}">{{ $d->monto }}</a></td>
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