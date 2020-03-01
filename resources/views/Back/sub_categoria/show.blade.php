@extends('Back.master')
@section('title', $datos->nombre )
@section('active-clasificacion', 'active')<!--ACTIVE DROP-->
@section('active-clasificacion-subcategoria', 'active')<!--ACTIVE LINK-->
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
                        <h4 class="page-title">@lang('idioma.gral_op_par'): <i> {{ $datos->nombre }} </i> </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ url('/dash') }}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li>
                                <a href="{{ url('/subcategorias') }}">@lang('idioma.subcateg_titulo')</a>
                            </li>
                            <li class="active">
                              @lang('idioma.gral_viendo'): {{ $datos->nombre }}
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
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{session('error')}}
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="nombreCategoria">@lang('idioma.categ_titulo')</label>
                                    <input type="text" value="{{ $datos->categoria->nombre }}" class="form-control" readonly></input>
                                </div>
                                <div class="form-group">
                                    <label for="nombreSubCategoria">@lang('idioma.gral_nombre')</label>
                                    <input type="text" value="{{ $datos->nombre }}" class="form-control" readonly></input>
                                </div>
                                <a href="{{ url('/subcategorias') }}"><button type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i> @lang('idioma.gral_btn_atras') </button></a>

                                @if(Session::get("rol_id"))
                                    @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->subcatego_e == 1)
                                        <a href="{{ url('/editar_subcategoria',$datos->id) }}"><button type="submit" class="btn btn-info"><i class="fa fa-edit"></i> @lang('idioma.gral_btn_edit') </button></a>
                                    @endif

                                    @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->subcatego_b == 1)
                                        <a href="{{ url('/borrar_subcategoria',$datos->id) }}"><button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> @lang('idioma.gral_btn_borr') </button></a>
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