@extends('Back.master')
@section('title', __('idioma.gral_viendo').": ".$datos->nombre )
@section('active-configuracion', 'active')
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
                        <h4 class="page-title">{{'OPCIONES PARA: '}} <i> {{ $datos->nombre }} </i> </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{url('/')}}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li>
                                <a href="{{ url('/usuarios') }}">@lang('idioma.nav_sys_usu')</a>
                            </li>
                            <li class="active">
                                @lang('idioma.gral_viendo'):  {{ $datos->nombre }}
                            </li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-sm-4">
                    <div class="card-box">
                        <h4 class="m-t-0 header-title"><b></b></h4>
                        <div class="row">
                            <div class="col-md-12">
                              <div class="box-body">
                                 <div class="form-group m-b-0">
                                    <label class="control-label">@lang('idioma.usr_img')</label>
                                    @if($datos->imagen)
                                        <img style="width:100%; height:auto" src="{{ url('storage/img_usuarios/'.$datos->imagen) }}" alt="{{$datos->nombre}}">
                                    @else
                                      <img style="width:100%; height:auto" src="{{ url('storage/img_usuarios/default.png') }}" alt="{{$datos->nombre}}">
                                    @endif
                                    
                                </div>
                                <br/>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
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
                                    <label for="telefono">{{'STATUS'}}</label>
                                    @if($datos->status == 1)
                                        <input style="background-color: green; color: white;" type="text" value="@lang('idioma.gral_activo')" class="form-control" readonly>
                                    @else
                                        <input style="background-color: red; color: black;" type="text" value="@lang('idioma.gral_in_activo')" class="form-control" readonly>
                                    @endif
                               </div>

                               <div class="form-group">
                                    <label for="nombre">@lang('idioma.gral_nombre')</label>
                                    <input type="text" value="{{ $datos->nombre }}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="apellido">@lang('idioma.gral_apellido')</label>
                                    <input type="text" value="{{ $datos->apellido }}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="cedula">@lang('idioma.cliente_cr')</label>
                                    <input type="text" value="{{ $datos->cedula }}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="correo">@lang('idioma.gral_correo')</label>
                                    <input type="text" value="{{ $datos->email }}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="sexo">@lang('idioma.usr_sex')</label>
                                    <input type="text" value="{{ $datos->sexo }}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="telefono">@lang('idioma.cliente_telef')</label>
                                    <input type="text" value="{{ $datos->telefono }}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="direccion">@lang('idioma.gral_direcci')</label>
                                    <textarea class="form-control" readonly style="resize: none;">{{ $datos->direccion }}</textarea>
                                </div>

                                <a href="{{ url('/configuracion/usuario') }}"><button type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i> @lang('idioma.gral_btn_atras') </button></a>

                                <a href="{{ url('/configuracion/usuario/editar-usuario',$datos->id) }}"><button type="submit" class="btn btn-info"><i class="fa fa-edit"></i> @lang('idioma.gral_btn_edit') </button></a>

                                <!--OPCIONES DE STATUS-->

                                <button title="Cambiar Status" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="mdi mdi-account-location"></i>{{'Status'}}</button>

                                <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="mySmallModalLabel">@lang('idioma.usr_sta_tit')</h4>
                                            </div>
                                            <div class="modal-body text-center">
                                                @if($datos->status == 1)
                                                    <a href="{{ url('/configuracion/usuario/status_inactivar',$datos->id) }}"><button type="submit" class="btn btn-danger"> @lang('idioma.usr_desacti') <i class="glyphicon glyphicon-thumbs-down"></i></button></a>
                                                @else
                                                    <a href="{{ url('/configuracion/usuario/status_activar',$datos->id) }}"><button type="submit" class="btn btn-success"> @lang('idioma.usr_activar')  <i class="glyphicon glyphicon-thumbs-up"></i></button></a>
                                                @endif  
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                <a href="{{ url('/configuracion/usuario/destroy',$datos->id) }}"><button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> @lang('idioma.gral_btn_borr') </button></a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container -->

    </div> <!-- content -->
@endsection
