@extends('Back.master')
@section('title',  __('idioma.gral_nuevo'))
@section('active-configuracion', 'active')
@section('active-configuracion-usuarios', 'active')
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
                        <h4 class="page-title">@lang('idioma.nav_sys_usu')</i> </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{url('/')}}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li>
                                <a href="{{ url('/configuracion/usuario') }}">@lang('idioma.nav_sys_usu')</a>
                            </li>
                            <li class="active">
											@lang('idioma.gral_nuevo')
                            </li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
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
                <form class="form-horizontal" method="POST"  enctype="multipart/form-data">
		            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
	                <div class="col-sm-4">
		                    <div class="card-box">
		                        <h4 class="m-t-0 header-title"><b></b></h4>
		                        <div class="row">
		                            <div class="col-md-12">
			                          <div class="box-body">
			                             <div class="form-group m-b-0">
		                                    <label class="control-label">@lang('idioma.usr_img')</label>
		                                    <input type="file" name="file" class="filestyle" id="files" data-buttonname="btn-primary">
		                              		<div id="lista_imagenes"></div>
		                                </div>
		                                <br/>
			                          </div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		                <div class="col-sm-8">
		                    <div class="card-box">
		                        <h4 class="m-t-0 header-title"><b></b></h4>
		                        <p class="text-muted m-b-30 font-13">
		                          &nbsp;
		                        </p>
		                        <div class="row">
		                            <div class="col-md-12">
				                            <div class="box-body">
				                                <div class="form-group">
				                                    <label for="nombre" class="col-sm-2 control-label">@lang('idioma.gral_nombre')</label>
				                                    <div class="col-sm-10">
				                                        <input type="text" autocomplete="off" class="form-control {{ ($errors->first('nombre')) ? 'error' : '' }}" id="nombre" name="nombre" maxlength="30" value="{{old('nombre')}}" />
                                                    @if($errors->first('nombre'))
                                                      <div class="alert alert-danger">{{ $errors->first('nombre') }}</div>
                                                    @endif
				                                    </div>
				                                </div>
				                                <div class="form-group">
				                                    <label for="apellido" class="col-sm-2 control-label">@lang('idioma.gral_apellido')</label>
				                                    <div class="col-sm-10">
				                                        <input type="text" autocomplete="off" maxlength="30" class="form-control {{ ($errors->first('apellido')) ? 'error' : '' }}" id="apellido" name="apellido" value="{{old('apellido')}}" />
                                                    @if($errors->first('apellido'))
                                                      <div class="alert alert-danger">{{ $errors->first('apellido') }}</div>
                                                    @endif
				                                    </div>
				                                </div>
				                                <div class="form-group">
				                                    <label for="cedula" class="col-sm-2 control-label">@lang('idioma.cliente_cr')</label>
				                                    <div class="col-sm-10">
		                                              <input class="form-control {{ ($errors->first('cedula')) ? 'error' : '' }}" maxlength="10" type="text" id="cedula" name="cedula" value="{{old('cedula')}}" onkeypress="return valida(event)">
                                                    @if($errors->first('cedula'))
                                                      <div class="alert alert-danger">{{ $errors->first('cedula') }}</div>
                                                    @endif
				                                    </div>
				                                </div>
				                                <div class="form-group">
				                                    <label for="email" class="col-sm-2 control-label">@lang('idioma.gral_correo')</label>
				                                    <div class="col-sm-10">
				                                        <input type="text" autocomplete="off" maxlength="50" class="form-control {{ ($errors->first('email')) ? 'error' : '' }}" id="email" name="email" value="{{old('email')}}"/>
                                                    @if($errors->first('email'))
                                                      <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                                                    @endif
				                                    </div>
				                                </div>
				                                <div class="form-group">
				                                    <label for="sexo" class="col-sm-2 control-label">@lang('idioma.usr_sex')</label>
				                                    <div class="col-sm-10">
				                                    	<select name="sexo" class="form-control">
				                                    		<option value="M">@lang('idioma.usr_hombre')</option>
				                                    		<option value="F">@lang('idioma.usr_mujer')</option>
				                                    	</select>
				                                    </div>
				                                </div>
				                                <div class="form-group">
				                                    <label for="telefono" class="col-sm-2 control-label">@lang('idioma.cliente_telef')</label>
				                                    <div class="col-sm-10">
				                                        <input type="text" maxlength="20" autocomplete="off" class="form-control" id="telefono" name="telefono" value="{{old('telefono')}}" />
				                                    </div>
				                                </div>
				                                <div class="form-group">
				                                    <label for="clave" class="col-sm-2 control-label">@lang('idioma.usr_clave')</label>
				                                    <div class="col-sm-10">
				                                        <input type="password" autocomplete="off" class="form-control {{ ($errors->first('clave')) ? 'error' : '' }}" id="clave" name="clave"/>
                                                    @if($errors->first('clave'))
                                                      <div class="alert alert-danger">{{ $errors->first('clave') }}</div>
                                                    @endif
				                                    </div>
				                                </div>
				                                <div class="form-group">
				                                    <label for="rol" class="col-sm-2 control-label">{{'Rol'}}</label>
				                                    <div class="col-sm-10">
				                                        <select name="rol" id="rol" class="form-control {{ ($errors->first('rol')) ? 'error' : '' }}">
				                                            @foreach ($roles as $rol)
				                                                <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
				                                            @endforeach
				                                        </select>
                                                    @if($errors->first('rol'))
                                                      <div class="alert alert-danger">{{ $errors->first('rol') }}</div>
                                                    @endif
				                                    </div>
				                                </div>
				                                <div class="form-group">
				                                    <label for="direccion" class="col-sm-2 control-label">@lang('idioma.gral_direcci')</label>
				                                    <div class="col-sm-10">
				                                        <textarea  class="form-control" id="direccion" name="direccion"/>{{old('direccion')}}</textarea>
				                                    </div>
				                                </div>
				                            </div>
				                          <div class="box-footer">
				                            <a href="{{ url('/configuracion/usuario') }}"><button type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i> @lang('idioma.gral_btn_atras') </button></a>
				                            <button type="submit" class="btn btn-info pull-right"><i class="mdi mdi-content-save"></i> @lang('idioma.gral_btn_guar') </button>
				                          </div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
        		</form>
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

         <script>
		      function archivo(evt) {
		          var files = evt.target.files; // FileList object

		          // Obtenemos la imagen del campo "file".
		          for (var i = 0, f; f = files[i]; i++) {
		            //Solo admitimos imágenes.
		            if (!f.type.match('image.*')) {
		                continue;
		            }

		            var reader = new FileReader();

		            reader.onload = (function(theFile) {
		                return function(e) {
		                  // Insertamos la imagen
		                 document.getElementById("lista_imagenes").innerHTML = ['<img width="100%"" height="auto" class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
		                };
		            })(f);

		            reader.readAsDataURL(f);
		          }
		      }

		      document.getElementById('files').addEventListener('change', archivo, true);
		</script>


@endsection