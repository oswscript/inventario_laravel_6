@extends('Back.master')
@section('title', $datos->nombre )
@section('active-producto', 'active')
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
                        <h4 class="page-title">@lang('idioma.gral_actuali'): <i> {{ $datos->codigo }} </i> </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ url('/dash') }}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li>
                                <a href="{{ url('/productos') }}">@lang('idioma.product_titulo')</a>
                            </li>
                            <li class="active">
                                @lang('idioma.gral_actuali'): {{ $datos->codigo }}
                            </li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->

        <form method="POST"  class="form-horizontal" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <div class="row">
                 <!--IMAGEN-->
                <div class="col-sm-4 text-center">
                    <div class="card-box">
                        <h4 class="m-t-0 header-title"><b></b></h4>
                        <div class="row">
                            <div class="col-md-12">
                              <div class="box-body">
                                 <div class="form-group m-b-0">
                                    <label class="control-label">{{'Img'}}</label>
                                    @if($datos->imagen != "")
                                       <img style="width:100%;height:auto" src="{{ url('storage/img_productos/'.$datos->imagen) }}" alt="{{$datos->nombre}}">
                                    @else
                                      <img style="width:100%; height:auto" src="{{ url('storage/img_productos/default_producto.png') }}" alt="{{$datos->nombre}}">
                                    @endif
                                </div>
                                <hr>
                                <div class="form-group m-b-0">
                                    <input type="file" name="file" class="filestyle" id="files" data-buttonname="btn-primary">
                                        <div id="lista_imagenes"></div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--FIN IMAGEN-->

                <!--FORMULARIO-->
                <div class="col-sm-8">
                    <div class="card-box">
                        <h4 class="m-t-0 header-title"><b></b></h4>
                        <p class="text-muted m-b-30 font-13">
                          
                        </p>
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
                                 @if($datos->status == 1)
                                   <div class="form-group">
                                        <label for="statusProducto">{{"Status"}}</label>
                                        <select name="status" class="form-control">
                                            <option class="dato_previo" value="1">@lang('idioma.gral_activo')</option>
                                            <option value="0">@lang('idioma.gral_in_activo')</option>
                                        </select>
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label for="statusProducto">{{"Status"}} </label>
                                        <select name="status" class="form-control">
                                            <option class="dato_previo" value="0">"@lang('idioma.gral_in_activo')</option>
                                            <option value="1">@lang('idioma.gral_in_activo')</option>
                                        </select>
                                    </div>
                                @endif
                               <div class="form-group">
                                    <label for="nombreProducto">@lang('idioma.gral_nombre')</label>
                                    <textarea type="text" class="form-control {{ ($errors->first('nombre')) ? 'error' : '' }}" id="nombre" name="nombre"/>{{ $datos->nombre }}</textarea>
                                    @if($errors->first('nombre'))
                                       <div class="alert alert-danger">{{ $errors->first('nombre') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="codigoProducto">@lang('idioma.gral_codigo')</label>
                                    <input type="text" value="{{ $datos->codigo }}" class="form-control {{ ($errors->first('codigo')) ? 'error' : '' }}" id="codigo" maxlength="30" name="codigo"/>
                                    @if($errors->first('codigo'))
                                       <div class="alert alert-danger">{{ $errors->first('codigo') }}</div>
                                    @endif
                                </div>
                               <div class="form-group">
                                    <label for="categoriaProducto">@lang('idioma.categ_titulo')</label>
                                    <select name="categoria" class="form-control {{ ($errors->first('categoria')) ? 'error' : '' }}" id="categoria_cargar2">
                                        <optgroup label="@lang('idioma.products_seleci')">
                                            <option class="dato_previo" value="{{$datos->categoria->id}}">{{$datos->categoria->nombre}}</option>
                                        </optgroup>
                                        <optgroup label="@lang('idioma.products_sel_otr')">
                                            @foreach($datos2 as $d2)
                                                <option value="{{$d2->id}}">{{$d2->nombre}}</option>
                                            @endforeach
                                        </optgroup>

                                    </select>
                                    @if($errors->first('categoria'))
                                       <div class="alert alert-danger">{{ $errors->first('categoria') }}</div>
                                    @endif
                                </div>
                               <div class="form-group">
                                    <label for="subcategoriaProducto">@lang('idioma.subcateg_titulo')</label>
                                    <input type="hidden" name="subcatego_id_ajax" id="subcatego_id_ajax" value="{{$datos->subcategoria->id}}">

                                     <!--1. DATOS CARGA INICIAL-->
                                    <select name="sub_categoria_inicial" class="form-control" id="subcategoria_cargar2">
                                        <optgroup label="@lang('idioma.products_seleci')">
                                            <option class="dato_previo" value="{{$datos->subcategoria->id}}">{{$datos->subcategoria->nombre}}</option>
                                        </optgroup>
                                        <optgroup label="@lang('idioma.products_sel_otr')">
                                            @foreach($datos4 as $d4)
                                                 <option value="{{$d4->id}}">{{$d4->nombre}}</option>
                                            @endforeach
                                        </optgroup>

                                    </select>
                                   
                                    <!--2. DATOS RESULTADO SELECCION-->
                                    <select name="sub_categoria_resultado" class="form-control" id="subcategoria_cargar3" style="display: none">
                                        <option></option>
                                    </select>

                                    <!--3. NO HAY DATOS-->
                                    <select name="campo_subcategoria" class="form-control" id="subcategoria_cargar4" style="display: none">
                                    </select>

                                </div>
                               <div class="form-group">
                                    <label for="cantidadProducto">@lang('idioma.gral_cantidad')</label>
                                    <input name="cantidad" type="text" value="{{ $datos->cantidad }}" class="form-control {{ ($errors->first('cantidad')) ? 'error' : '' }}" onkeypress="return valida(event)">
                                    @if($errors->first('cantidad'))
                                       <div class="alert alert-danger">{{ $errors->first('cantidad') }}</div>
                                    @endif
                                </div>
                               <div class="form-group">
                                    <label for="preciocostoProducto"> @lang('idioma.products_pr_cos') {{ '( '.$sistema->moneda.' )' }} <i class="fa fa-info-circle estilo_tool" data-toggle="tooltip" data-placement="right" title="" data-original-title="@lang('idioma.products_inf_cos')"></i></label>
                                    <input type="text" name="precio_costo" value="{{ $datos->precio_costo }}" class="form-control {{ ($errors->first('precio_costo')) ? 'error' : '' }}" onkeypress="return filterFloat(event,this);">
                                    @if($errors->first('precio_costo'))
                                       <div class="alert alert-danger">{{ $errors->first('precio_costo') }}</div>
                                    @endif
                                </div>
                               <div class="form-group">
                                    <label for="preciopublicoProducto">@lang('idioma.products_pr_pub') {{ '( '.$sistema->moneda.' )' }} <i class="fa fa-info-circle estilo_tool" data-toggle="tooltip" data-placement="right" title="" data-original-title="@lang('idioma.products_inf_pub')"></i></label>
                                    <input type="text" name="precio_publico" value="{{ $datos->precio_publico }}" class="form-control {{ ($errors->first('precio_publico')) ? 'error' : '' }}" onkeypress="return filterFloat(event,this);">
                                    @if($errors->first('precio_publico'))
                                       <div class="alert alert-danger">{{ $errors->first('precio_publico') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="tributoProducto">@lang('idioma.nav_sys_tribu')</label>
                                    <select name="tributo" class="form-control {{ ($errors->first('tributo')) ? 'error' : '' }}">
                                        <optgroup label="@lang('idioma.products_seleci')">
                                            <option class="dato_previo" value="{{$datos->tributo->id}}">{{$datos->tributo->nombre." | ".$datos->tributo->monto." | ".$datos->tributo->tipo}}</option>
                                        </optgroup>
                                        <optgroup label="@lang('idioma.products_sel_otr')">
                                            @foreach($datos3 as $d3)
                                                <option value="{{$d3->id}}">{{$d3->nombre." | ".$d3->monto." | ".$d3->tipo}}</option>
                                            @endforeach
                                         </optgroup>
                                    </select>
                                    @if($errors->first('tributo'))
                                       <div class="alert alert-danger">{{ $errors->first('tributo') }}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="descripcionProducto">@lang('idioma.product_descrip') (@lang('idioma.gral_opcional'))</label>
                                    <textarea name="descripcion" rows="10" class="form-control" placeholder="Descripción del producto">{{$datos->descripcion}}</textarea>
                                </div>
                                <a href="{{ url('/show_producto',$datos->id) }}" class="btn btn-default"><i class="fa fa-chevron-left"></i> @lang('idioma.gral_btn_atras') </a>
                                <button type="submit" class="btn btn-info pull-right"><i class="mdi mdi-content-save"></i> @lang('idioma.gral_btn_guar') </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--FIN FORMULARIO-->
            </form>
        </div> <!-- container -->
    </div> <!-- content -->
    <!--VALIDAR SOLO NUMEROS EN EL INPUT-->
        <script type="text/javascript">

            function filterFloat(evt,input){
                // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
                var key = window.Event ? evt.which : evt.keyCode;    
                var chark = String.fromCharCode(key);
                var tempValue = input.value+chark;
                if(key >= 48 && key <= 57){
                    if(filter(tempValue)=== false){
                        return false;
                    }else{       
                        return true;
                    }
                }else{
                      if(key == 8 || key == 13 || key == 0) {     
                          return true;              
                      }else if(key == 46){
                            if(filter(tempValue)=== false){
                                return false;
                            }else{       
                                return true;
                            }
                      }else{
                          return false;
                      }
                }
            }
            function filter(__val__){
                var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
                if(preg.test(__val__) === true){
                    return true;
                }else{
                   return false;
                }
                
            }

        </script>
        
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

        <!--SUBIR IMAGEN-->
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