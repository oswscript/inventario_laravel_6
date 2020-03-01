@extends('Back.master')
@section('title', __('idioma.gral_nueva'))
@section('active-personas', 'active')<!--ACTIVE DROP-->
@section('active-personas-clientes', 'active')<!--ACTIVE LINK-->
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
                        <h4 class="page-title">@lang('idioma.gral_nueva')</i> </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ url('/dash') }}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li>
                                <a href="{{ url('/clientes') }}">@lang('idioma.nav_clientes')</a>
                            </li>
                            <li class="active">
                                @lang('idioma.gral_nueva')
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
                                <form method="POST">
                                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                    <div class="form-group">
                                        <label for="nombreCliente">@lang('idioma.gral_nombre')</label>
                                        <input type="text" value="{{old('nombre')}}" class="form-control {{ ($errors->first('nombre')) ? 'error' : '' }}" id="nombre" maxlength="30" name="nombre" />
                                        @if($errors->first('nombre'))
                                          <div class="alert alert-danger">{{ $errors->first('nombre') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="apellidoCliente">@lang('idioma.gral_apellido')</label>
                                        <input type="text" value="{{old('apellido')}}" class="form-control {{ ($errors->first('apellido')) ? 'error' : '' }}" id="apellido" maxlength="30" name="apellido" />
                                        @if($errors->first('apellido'))
                                          <div class="alert alert-danger">{{ $errors->first('apellido') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="cedulaCliente">@lang('idioma.cliente_cr')</label>
                                        <input type="text" value="{{old('cedula')}}" class="form-control {{ ($errors->first('cedula')) ? 'error' : '' }}" id="cedula" name="cedula" maxlength="10" onkeypress="return valida(event)" />
                                        @if($errors->first('cedula'))
                                          <div class="alert alert-danger">{{ $errors->first('cedula') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="empresaCliente">@lang('idioma.cliente_empresa') (@lang('idioma.pos_opcional'))</label>
                                        <input type="text" value="{{old('empresa')}}" class="form-control" id="empresa" maxlength="50" name="empresa" />
                                    </div>
                                    <div class="form-group">
                                        <label for="correoCliente">@lang('idioma.gral_correo')</label>
                                        <input type="text" value="{{old('correo')}}" class="form-control {{ ($errors->first('correo')) ? 'error' : '' }}" id="correo" maxlength="50" name="correo" />
                                        @if($errors->first('correo'))
                                          <div class="alert alert-danger">{{ $errors->first('correo') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="telefonoCliente">@lang('idioma.cliente_telef') (@lang('idioma.pos_opcional'))</label>
                                        <input type="text" value="{{old('telefono')}}"  class="form-control" id="telefono" maxlength="50" name="telefono" />
                                    </div>
                                    <div class="form-group">
                                        <label for="status">{{"Status"}}</label>
                                        <select name="status" class="form-control">
                                            <option value="1">@lang('idioma.gral_activo')</option>
                                            <option value="0">@lang('idioma.gral_in_activo')</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="direccionCliente">@lang('idioma.gral_direcci') (@lang('idioma.pos_opcional'))</label>
                                        <textarea name="direccion" class="form-control" id="direccion" name="direccion" >{{old('direccion')}}</textarea>
                                    </div>
                                     <a href="{{ url('/clientes') }}"><button type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i> @lang('idioma.gral_btn_atras') </button></a>
                                    <button type="submit" class="btn btn-info pull-right"><i class="mdi mdi-content-save"></i> @lang('idioma.gral_btn_guar') </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container -->

    </div> <!-- content -->

        <!--VALIDAR SOLO NUMEROS EN EL INPUT-->
        <script type="text/javascript">
            function valida(e){
                tecla = (document.all) ? e.keyCode : e.which;

                //Tecla de retroceso para borrar, siempre la permite
                if (tecla==8){
                    return true;
                }
                    
                // Patron de entrada, en este caso solo acepta numeros
                patron =/[0-9]/;
                tecla_final = String.fromCharCode(tecla);
                return patron.test(tecla_final);
            }
        </script>


@endsection