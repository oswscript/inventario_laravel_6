@extends('Back.master')
@section('title', __('idioma.gral_viendo').": ".$rol->nombre )
@section('active-configuracion', 'active')
@section('active-configuracion-roles', 'active')
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
                        <h4 class="page-title">@lang('idioma.gral_op_par'): <i> {{ $rol->nombre }} </i> </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ url('/dash') }}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li>
                                <a href="{{ url('/roles') }}">@lang('idioma.nav_sys_roles')</a>
                            </li>
                            <li class="active">
                                @lang('idioma.gral_viendo'):  {{ $rol->nombre }}
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
                        <div class="row">
                            <div class="col-md-12">
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{session('status')}}
                                    </div>
                                @endif
                               <div class="form-group">
                                    <label for="nombreempresa">@lang('idioma.gral_nombre')</label>
                                    <input type="text" value="{{ $rol->nombre }}" class="form-control" readonly></input>
                                </div>
                                <a href="{{ url('/configuracion/roles') }}"><button type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i> @lang('idioma.gral_btn_atras') </button></a>

                                <a href="{{ url('/configuracion/roles/editar-rol',$rol->id) }}"><button type="submit" class="btn btn-info"><i class="fa fa-edit"></i> @lang('idioma.gral_btn_edit') </button></a>
                                <a href="{{ url('/configuracion/roles/destroy',$rol->id) }}"><button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> @lang('idioma.gral_btn_borr') </button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container -->

    </div> <!-- content -->
@endsection