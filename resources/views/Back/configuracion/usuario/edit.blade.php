@extends('Back.master')
@section('title', __('idioma.gral_actuali').": ".$datos->nombre)
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
                        <h4 class="page-title">@lang('idioma.gral_actuali'): <i> {{ $datos->nombre }} </i> </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{url('/')}}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li>
                                <a href="{{ url('/usuarios') }}">@lang('idioma.nav_sys_usu')</a>
                            </li>
                            <li class="active">
											@lang('idioma.gral_actuali') {{ $datos->nombre }}
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
               <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                  <div class="col-sm-4">
                     <div class="card-box">
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
                                 <hr>
                                 <div class="form-group m-b-0">
                                    <input type="file" name="file" class="filestyle" id="files" data-buttonname="btn-primary">
                                    <div id="lista_imagenes"></div>
                                 </div>
                                 <br/>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

	            	<!--Configuracion de los datos de usuario-->
	                <div class="col-sm-8">
	                    <div class="card-box">
	                        <div class="row">
	                            <div class="col-md-12">
				                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
				                        <div class="box-body">
				                            <div class="form-group">
				                                <label for="nombre" class="col-sm-2 control-label">@lang('idioma.gral_nombre')</label>
				                                <div class="col-sm-10">
				                                    <input type="text"  class="form-control {{ ($errors->first('nombre')) ? 'error' : '' }}" id="nombre" name="nombre" value="{{$datos->nombre}}"/>
                                                @if($errors->first('nombre'))
                                                <div class="alert alert-danger">{{ $errors->first('nombre') }}</div>
                                                @endif
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="email" class="col-sm-2 control-label">@lang('idioma.gral_apellido')</label>
				                                <div class="col-sm-10">
				                                    <input type="text"  class="form-control {{ ($errors->first('apellido')) ? 'error' : '' }}" id="apellido" name="apellido" value="{{$datos->apellido}}" />
                                                @if($errors->first('apellido'))
                                                <div class="alert alert-danger">{{ $errors->first('apellido') }}</div>
                                                @endif
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="email" class="col-sm-2 control-label {{ ($errors->first('cedula')) ? 'error' : '' }}">@lang('idioma.cliente_cr')</label>
				                                <div class="col-sm-10">
				                                    <input type="text"  class="form-control" id="cedula" name="cedula" value="{{$datos->cedula}}" onkeypress="return valida(event)"/>
                                                @if($errors->first('cedula'))
                                                <div class="alert alert-danger">{{ $errors->first('cedula') }}</div>
                                                @endif
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="email" class="col-sm-2 control-label">@lang('idioma.gral_correo')</label>
				                                <div class="col-sm-10">
				                                    <input type="email"  class="form-control {{ ($errors->first('email')) ? 'error' : '' }}" id="email" name="email" value="{{$datos->email}}" />
                                                @if($errors->first('email'))
                                                <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                                                @endif
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="sexo" class="col-sm-2 control-label">@lang('idioma.usr_sex')</label>
				                                <div class="col-sm-10">
				                                    <select name="sexo" id="sexo" class="form-control">
				                                    	@if($datos->sexo == "M")
				                                    		<option value="M">@lang('idioma.usr_hombre')</option>
				                                    		<option value="F">@lang('idioma.usr_mujer')</option>
				                                    	@elseif($datos->sexo == "F")
				                                    		<option value="F">@lang('idioma.usr_mujer')</option>
				                                    		<option value="M">@lang('idioma.usr_hombre')</option>
				                                    	@else			            
				                                    		<option value="M">@lang('idioma.usr_hombre')</option>
				                                    		<option value="F">@lang('idioma.usr_mujer')</option>
				                                    	@endif
				                                    </select>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="rol" class="col-sm-2 control-label">{{'Rol'}}</label>
				                                <div class="col-sm-10">
				                                    <select name="rol" id="rol" class="form-control {{ ($errors->first('rol')) ? 'error' : '' }}">
				                                        <option style="background-color:green; color:white;" value="{{ isset($datos->rol->id) ? $datos->rol->id : ' ' }}">{{ isset($datos->rol->nombre) ? $datos->rol->nombre : 'Seleccione una opcion' }}</option>
				                                        @foreach ($roles as $rol)
																		@if($rol->id != $datos->rol->id)
				                                            	<option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
																		@endif
				                                        @endforeach
				                                    </select>
                                                @if($errors->first('rol'))
                                                   <div class="alert alert-danger">{{ $errors->first('rol') }}</div>
                                                @endif
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="telefono" class="col-sm-2 control-label">@lang('idioma.cliente_telef')</label>
				                                <div class="col-sm-10">
				                                    <input type="telefono" class="form-control" id="telefono" name="telefono" value="{{$datos->telefono}}" />
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="direccion" class="col-sm-2 control-label">@lang('idioma.gral_direcci')</label>
				                                <div class="col-sm-10">
				                                	<textarea class="form-control" name="direccion">{{$datos->direccion}}</textarea>
				                                </div>
				                            </div>
				                            <div class="form-group">
				                                <label for="clave" class="col-sm-2 control-label">@lang('idioma.usr_clave')</label>
				                                <div class="col-sm-10">
				                                    <input autocomplete="off" type="text"  class="form-control" id="clave" name="clave" placeholder="@lang('idioma.usr_clave_detal')"  />
				                                </div>
				                            </div>
				                        </div>
				                      <div class="box-footer">
				                        <a class="btn btn-default" href="{{ url('/configuracion/usuario') }}"><i class="fa fa-chevron-left"></i> @lang('idioma.gral_btn_atras') </a>
				                        <button type="submit" class="btn btn-info pull-right"><i class="mdi mdi-content-save"></i> @lang('idioma.gral_btn_guar') </button>
				                      </div>
				                    </form>
	                            </div>
	                        </div>
	                    </div>
	                </div>
            	</form>
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