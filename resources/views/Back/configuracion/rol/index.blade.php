@extends('Back.master')
@section('title', __('idioma.nav_sys_roles'))
@section('active-configuracion', 'active subdrop')
@section('active-configuracion-roles', 'active')
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
                        <h4 class="page-title">@lang('idioma.nav_sys_roles')</h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ url('/dash') }}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li class="active">
                                @lang('idioma.nav_sys_roles')
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
                            <h3 class="box-title"><a href="{{url ('configuracion/roles/nuevo-rol')}}" class="btn btn-primary" style="float:right;"><i class="fa fa-plus-circle"></i> @lang('idioma.gral_nuevo') </a></h3>
                        @endif

                        <h4 class="m-t-0 header-title"><b>@lang('idioma.rol_list')</b></h4>
                        <p class="text-muted font-13 m-b-30">
                            @lang('idioma.rol_detal')
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
                            </tr>
                            </thead>


                            <tbody>
                            @foreach($rols as $key => $rol)
                                <tr>
                                   <td>{{++$key}}</td>
                                   <td><a href="{!! action('RolController@show', $rol->id) !!}">{{ $rol->nombre }}</a></td>
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