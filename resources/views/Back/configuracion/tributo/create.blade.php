@extends('Back.master')
@section('title', __('idioma.gral_nuevo'))
@section('active-configuracion', 'active')
@section('active-configuracion-tributos', 'active')
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
                        <h4 class="page-title">@lang('idioma.gral_nuevo')</i> </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ url('/dash') }}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li>
                                <a href="{{ url('/configuracion/tributos') }}">@lang('idioma.nav_sys_tribu')</a>
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
                <div class="col-sm-6">
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
                                <form method="POST">
                                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                    <div class="form-group">
                                        <label for="nombreTributo">@lang('idioma.gral_nombre')</label>
                                        <input type="text" value="{{old('nombre')}}" class="form-control {{ ($errors->first('nombre')) ? 'error' : '' }}" id="nombre" maxlength="30" name="nombre" />
                                      @if($errors->first('nombre'))
                                       <div class="alert alert-danger">{{ $errors->first('nombre') }}</div>
                                      @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="tipo">@lang('idioma.gral_tipo')</label>
                                        <select name="tipo" class="form-control {{ ($errors->first('nombre')) ? 'error' : '' }}">
                                            <option value="PORCENTAJE">@lang('idioma.tax_porcen') (%)</option>
                                        </select>
                                      @if($errors->first('tipo'))
                                       <div class="alert alert-danger">{{ $errors->first('tipo') }}</div>
                                      @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="monto">@lang('idioma.tax_valor')</label>
                                        <input type="text" value="{{old('monto')}}" class="form-control {{ ($errors->first('monto')) ? 'error' : '' }}" id="monto" maxlength="8" name="monto" onkeypress="return filterFloat(event,this);" />
                                      @if($errors->first('monto'))
                                       <div class="alert alert-danger">{{ $errors->first('monto') }}</div>
                                      @endif
                                    </div>
                                     <a href="{{ url('/configuracion/tributos') }}"><button type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i> @lang('idioma.gral_btn_atras') </button></a>
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


@endsection