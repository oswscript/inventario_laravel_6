@extends('Back.master')
@section('title', __('idioma.nav_sys_config') )
@section('active-configuracion', 'active subdrop')
@section('active-configuracion-configuracion', 'active')
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
                        <h4 class="page-title">@lang('idioma.nav_sys_config')</h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ url('/dash') }}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li class="active">
                              @lang('idioma.nav_sys_config')
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
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="col-sm-12 text-center">
                        <div class="card-box">
                            <h4 class="m-t-0 header-title"><b></b></h4>
                            <div class="row">
                                <div class="col-md-12">
                                  <div class="box-body">
                                     <div class="form-group m-b-0">
                                        <label class="control-label">@lang('idioma.config_titu_logo')</label>
                                        @if($logo)
                                           <img style="width:200px; height:200px" src="{{ url('storage/img_sistema/'.$logo) }}" alt="{{$nombre_empresa}}">
                                        @else
                                          <img style="width:200px; height:200px" src="{{ url('storage/img_sistema/default_logo.jpg') }}" alt="{{$nombre_empresa}}">
                                        @endif
                                    </div>
                                    <hr>
                                    <div class="form-group m-b-0 ">
                                        <input type="file" name="file" class="filestyle" id="files" data-buttonname="btn-primary">
                                            <div id="lista_imagenes"></div>
                                     </div>
                                    <br/>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <!--SECCION DE DATOS-->
                <div class="col-sm-12">
                    <div class="card-box">
                        <h4 class="m-t-0 header-title"><b>@lang('idioma.config_titu_data')</b></h4>
                        <p class="text-muted m-b-30 font-13">
                          @lang('idioma.config_det_data')
                        </p>
                        <div class="row">
                            <div class="col-md-12">
                              <!--INPUT-->
                              <div class="form-group">
                                  <label class="col-md-4 control-label">@lang('idioma.config_nom_sist')</label>
                                  <div class="col-md-8">
                                      <input type="text"  class="form-control {{ ($errors->first('nombre')) ? 'error' : '' }}" maxlength="100" value="{{ $nombre_empresa }}" id="nombreempresa" name="nombre"/>
                                       @if($errors->first('nombre'))
                                          <div class="alert alert-danger">{{ $errors->first('nombre') }}</div>
                                       @endif
                                  </div>
                              </div>
                              <!--INPUT-->
                              <div class="form-group">
                                  <label class="col-md-4 control-label">@lang('idioma.config_slogan')</label>
                                  <div class="col-md-8">
                                      <input type="text"  class="form-control {{ ($errors->first('slogan')) ? 'error' : '' }}"  maxlength="100" value="{{ $slogan }}" id="slogan" name="slogan"/>
                                       @if($errors->first('slogan'))
                                          <div class="alert alert-danger">{{ $errors->first('slogan') }}</div>
                                       @endif
                                  </div>
                              </div>
                              <!--INPUT-->
                              <div class="form-group">
                                  <label class="col-md-4 control-label">@lang('idioma.config_cod_emp')</label>
                                  <div class="col-md-8">
                                      <input type="text"   maxlength="30" class="form-control {{ ($errors->first('codigo')) ? 'error' : '' }}" value="{{ $codigo_empresa }}" id="codigo" name="codigo" />
                                       @if($errors->first('codigo'))
                                          <div class="alert alert-danger">{{ $errors->first('codigo') }}</div>
                                       @endif
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-md-4 control-label">@lang('idioma.config_telefono')</label>
                                  <div class="col-md-8">
                                      <input type="text"  maxlength="15" class="form-control {{ ($errors->first('telefono')) ? 'error' : '' }}" value="{{ $telefono }}" id="telefono" name="telefono" />
                                       @if($errors->first('telefono'))
                                          <div class="alert alert-danger">{{ $errors->first('telefono') }}</div>
                                       @endif
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-md-4 control-label">@lang('idioma.gral_correo')</label>
                                  <div class="col-md-8">
                                      <input type="text"  maxlength="50" class="form-control {{ ($errors->first('correo')) ? 'error' : '' }}" value="{{ $correo }}" id="correo" name="correo" />
                                       @if($errors->first('correo'))
                                          <div class="alert alert-danger">{{ $errors->first('correo') }}</div>
                                       @endif
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-md-4 control-label">@lang('idioma.config_moneda')</label>
                                  <div class="col-md-8">
                                      <input type="text"  maxlength="10" class="form-control {{ ($errors->first('moneda')) ? 'error' : '' }}" value="{{ $moneda }}" id="moneda" name="moneda" placeholder="Moneda de la empresa" />
                                       @if($errors->first('moneda'))
                                          <div class="alert alert-danger">{{ $errors->first('moneda') }}</div>
                                       @endif
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-md-4 control-label">@lang('idioma.nav_sys_tribu')</label>
                                  <div class="col-md-8">
                                      @if($tributo=="ACTIVO")
                                      <select name="tributo" class="form-control {{ ($errors->first('tributo')) ? 'error' : '' }}">
                                          <option value="ACTIVO">@lang('idioma.gral_activo')</option>
                                          <option value="INACTIVO">@lang('idioma.gral_in_activo')</option>
                                      </select>
                                      @else
                                      <select name="tributo" class="form-control {{ ($errors->first('tributo')) ? 'error' : '' }}">
                                          <option value="INACTIVO">@lang('idioma.gral_in_activo')</option>
                                          <option value="ACTIVO">@lang('idioma.gral_activo')</option>
                                      </select>
                                      @endif
                                      @if($errors->first('tributo'))
                                       <div class="alert alert-danger">{{ $errors->first('tributo') }}</div>
                                      @endif
                                  </div>
                              </div>
                              <button type="submit" class="btn btn-info pull-right"><i class="mdi mdi-content-save"></i>  @lang('idioma.gral_btn_guar') </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--SECCION DE DATOS-->
                <div class="col-sm-12">
                    <div class="card-box">
                        <h4 class="m-t-0 header-title"><b>@lang('idioma.config_titu_secc')</b> <i class="fa fa-info-circle estilo_tool" data-toggle="tooltip" data-placement="right" title="" data-original-title="@lang('idioma.config_tool_secc')"></i></h4>
                        <p class="text-muted m-b-30 font-13">
                          @lang('idioma.config_det_secc')
                        </p>
                        <div class="row">
                            <div class="col-md-12">
                              <!--INPUT-->
                              <div class="form-group">
                                  <label class="col-md-6 control-label">@lang('idioma.config_reg_usu') <i class="fa fa-info-circle estilo_tool" data-toggle="tooltip" data-placement="top" title="" data-original-title="@lang('idioma.config_tool_rec')"></i></label>
                                  <div class="col-md-6">
                                      @if($r_u_login == "on")
                                          <input name="registro_usuario_login" type="checkbox" id="switch1" checked data-switch="none"/>
                                      @else
                                          <input name="registro_usuario_login" type="checkbox" id="switch1" data-switch="none"/>
                                      @endif
                                      <label for="switch1" data-on-label="On" data-off-label="Off"></label>
                                  </div>
                              </div>

                                <div class="form-group">
                                  <label class="col-md-6 control-label">@lang('idioma.config_rec_clav') <i class="fa fa-info-circle estilo_tool" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="@lang('idioma.config_tool_clav')"></i></label>
                                  <div class="col-md-6">
                                        @if($r_c_login == "on")
                                          <input name="recuperar_clave_login" type="checkbox" id="switch2" checked data-switch="none"/>
                                      @else
                                          <input name="recuperar_clave_login" type="checkbox" id="switch2" data-switch="none"/>
                                      @endif
                                      <label for="switch2" data-on-label="On" data-off-label="Off"></label>
                                  </div>
                              </div>
                              <button type="submit" class="btn btn-info pull-right"><i class="mdi mdi-content-save"></i> @lang('idioma.gral_btn_guar')</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--IDIOMA-->
                <div class="col-sm-12">
                    <div class="card-box">
                        <h4 class="m-t-0 header-title"><b>@lang('idioma.config_titu_lang')</b> <i class="fa fa-info-circle estilo_tool" data-toggle="tooltip" data-placement="right" title="" data-original-title="@lang('idioma.config_tool_lang')"></i></h4>
                        <p class="text-muted m-b-30 font-13">
                          @lang('idioma.config_det_lang')
                        </p>
                        <div class="row">
                            <div class="col-md-4">
                              <!--INPUT-->
                              <div class="form-group">
                                  <select name="idioma" class="form-control">
                                  @if($sistema->idioma == "es")
                                      <option value="es">Spanish</option>
                                      <option value="en">English</option>
                                  @else
                                      <option value="en">English</option>
                                      <option value="es">Spanish</option>
                                  @endif
                                  </select>
                              </div>
                            </div>
                              <button type="submit" class="btn btn-info pull-right"><i class="mdi mdi-content-save"></i> @lang('idioma.gral_btn_guar') </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- end row -->
    </div> <!-- container -->
</div> <!-- content -->
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
                 document.getElementById("lista_imagenes").innerHTML = ['<img width="100%"" height="auto" class="thumb imagen_previa" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
                };
            })(f);

            reader.readAsDataURL(f);
          }
      }

      document.getElementById('files').addEventListener('change', archivo, true);
</script>
@endsection