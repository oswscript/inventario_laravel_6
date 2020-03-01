@extends('Back.master')
@section('title', __('idioma.gral_actuali').": ".$datos->nombre )
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
                        <h4 class="page-title">@lang('idioma.gral_actuali'): <i> {{ $datos->nombre }} </i> </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ url('/dash') }}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li>
                                <a href="{{ url('/tributos') }}">@lang('idioma.nav_sys_tribu')</a>
                            </li>
                            <li class="active">
                                @lang('idioma.gral_actuali'): {{ $datos->nombre }}
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
                               <form class="form-horizontal" method="POST">
			                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
			                        <div class="box-body">
			                           <div class="form-group">
                                       <label for="nombre" class="col-sm-2 control-label">@lang('idioma.gral_nombre')</label>
                                       <div class="col-sm-10">
                                          <input type="text"  class="form-control {{ ($errors->first('nombre')) ? 'error' : '' }}" value="{{ $datos->nombre }}" id="nombre" name="nombre" maxlength="30" />
                                          @if($errors->first('nombre'))
                                             <div class="alert alert-danger">{{ $errors->first('nombre') }}</div>
                                          @endif
                                       </div>
			                           </div>
                                    <div class="form-group">
                                       <label for="tipo" class="col-sm-2 control-label">@lang('idioma.gral_tipo')</label>
                                       <div class="col-sm-10">
                                          <select name="tipo" class="form-control {{ ($errors->first('tipo')) ? 'error' : '' }}">
                                                <option value="PORCENTAJE">@lang('idioma.tax_porcen') (%)</option>
                                          </select>
                                          @if($errors->first('tipo'))
                                             <div class="alert alert-danger">{{ $errors->first('tipo') }}</div>
                                          @endif
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label for="monto" class="col-sm-2 control-label">@lang('idioma.tax_valor')</label>
                                       <div class="col-sm-10">
                                          <input type="text" maxlength="8" class="form-control {{ ($errors->first('monto')) ? 'error' : '' }}" value="{{ $datos->monto }}" id="monto" name="monto" maxlength="8" onkeypress="return filterFloat(event,this);" />
                                          @if($errors->first('monto'))
                                             <div class="alert alert-danger">{{ $errors->first('monto') }}</div>
                                          @endif
                                       </div>
                                    </div>
			                        </div>
			                      <div class="box-footer">
			                        <a href="{{ url('/configuracion/tributo',$datos->id) }}"><button type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i> @lang('idioma.gral_btn_atras') </button></a>
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