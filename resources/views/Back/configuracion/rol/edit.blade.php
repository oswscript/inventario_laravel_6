@extends('Back.master')
@section('title', __('idioma.gral_actuali').": ".$rol->nombre )
@section('active-configuracion', 'active')
@section('active-configuracion-roles', 'active')
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
                        <h4 class="page-title">@lang('idioma.gral_actuali'): <i> {{ $rol->nombre }} </i> </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ url('/dash') }}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li>
                                <a href="{{ url('/roles') }}">@lang('idioma.nav_sys_roles')</a>
                            </li>
                            <li class="active">
                                @lang('idioma.gral_actuali') {{ $rol->nombre }}
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
                               <form class="form-horizontal" method="POST">
			                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
			                        <div class="box-body">
			                            <div class="form-group">
			                                <label for="nombre" class="col-sm-2 control-label">@lang('idioma.gral_nombre')</label>
			                                <div class="col-sm-10">
			                                    <input type="text"  class="form-control {{ ($errors->first('nombre')) ? 'error' : '' }}" value="{{ $rol->nombre }}" id="nombre" name="nombre" maxlength="30"/>
                                             @if($errors->first('nombre'))
                                                <div class="alert alert-danger">{{ $errors->first('nombre') }}</div>
                                             @endif
			                                </div>
			                            </div>
			                        </div>
			                      <div class="box-footer">
			                        <a href="{{ url('/configuracion/roles') }}"><button type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i> @lang('idioma.gral_btn_atras') </button></a>
			                        <button type="submit" class="btn btn-info pull-right"><i class="mdi mdi-content-save"></i> @lang('idioma.gral_btn_guar') </button>
			                      </div>
			                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container -->
    </div> <!-- content -->
@endsection