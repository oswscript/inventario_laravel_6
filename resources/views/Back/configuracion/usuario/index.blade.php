@extends('Back.master')
@section('title', __('idioma.nav_sys_usu'))
@section('active-configuracion', 'active subdrop')
@section('active-configuracion-usuarios', 'active')
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
                        <h4 class="page-title">@lang('idioma.nav_sys_usu')</h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{url('/')}}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li class="active">
                                @lang('idioma.nav_sys_usu')
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
                            <h3 class="box-title"><a href="{{url ('configuracion/usuario/nuevo-usuario')}}" class="btn btn-primary" style="float:right;"><i class="fa fa-plus-circle"></i> @lang('idioma.gral_nuevo') </a></h3>
                            <!--<h3 class="box-title"><a href="{{url('/pdf_usuarios')}}" class="btn btn-default pull-right"><i class="mdi mdi-download"></i>{{"PDF"}}</a></h3>-->
                        @endif

                        <h4 class="m-t-0 header-title"><b>@lang('idioma.usr_list')</b></h4>
                        <p class="text-muted font-13 m-b-30">
                            @lang('idioma.usr_detal')
                        </p>
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{session('status')}}
                                </div>
                            @endif
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                 <th>{{'#'}}</th>
                                 <th>@lang('idioma.usr_img')</th>
                                 <th>@lang('idioma.gral_nombre')</th>
                                 <th>@lang('idioma.gral_correo')</th>
                                 <th>{{'Status'}}</th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($datos as $key => $dato)
                                    <tr>
                                        <td><a href="{!! action('UsuarioController@show', $dato->id) !!}">{{ ++$key }}</a></td>
                                        @if($dato->imagen)
                                            <td align="center"><img src="{{url('storage/img_usuarios/'.$dato->imagen) }}" alt="user" class="thumb-sm img-circle" /></td>
                                        @else
                                            <td align="center"><img src="{{url('storage/img_usuarios/default.png') }}" alt="user" class="thumb-sm img-circle" /></td>
                                        @endif
                                        <td><a href="{!! action('UsuarioController@show', $dato->id) !!}">{{ $dato->nombre }}</a></td>
                                        <td><a href="{!! action('UsuarioController@show', $dato->id) !!}">{{ $dato->email }}</a></td>
                                        @if($dato->status == 1)
                                            <td><a href="{!! action('UsuarioController@show', $dato->id) !!}"><font color="green"><b>@lang('idioma.gral_activo')</b></font></a></td>
                                        @else
                                            <td><a href="{!! action('UsuarioController@show', $dato->id) !!}"><font color="red"><b>@lang('idioma.gral_in_activo')</b></font></a></td>
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