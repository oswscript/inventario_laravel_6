@extends('Back.venta.pos.master_pos')
@section('title', __('idioma.pos_titulo'))
{{-- @section('class_active_home', 'active') --}}
@section('content')

<div class="wrapper">
    <div class="container">
        <div class="row">
            <!--
            *******************************************************************
            *******************************************************************
                                LISTA PRODUCTOS PRINCIPAL
            *******************************************************************
            *******************************************************************
            -->
            <div class="col-md-8">
                <div class="panel panel-default sombra_caja_producto">
                    <div class="panel-body">
                        <div class="clearfix">
                            <div class="pull-left">
                                <h3>{{$sistema->nombre_empresa}}</h3>
                                <span>{{$sistema->slogan}}</span>
                            </div>
                            <div class="pull-right"> 
                                <h1>@lang('idioma.pos_titulo') #<span id="codigo">{{$datos['n_factura']}}</span></h1>
                            </div>
                        </div>
                        <hr>
                        <div class="row">

                                <div class="col-md-12 col-xs-12">
                                    <div class="col-md-6 pull-left">
                                        <a class="tn btn-info btn-lg waves-effect btn-agregar" data-toggle="modal" id="agregar_productos" data-target=".bs-example-modal-lg"> @lang('idioma.pos_agregar') <i class="fa fa-plus-circle" ></i></a>
                                        <a class="tn btn-danger btn-lg waves-effect btn-agregar" data-toggle="modal" data-target="#modal_vaciar"> @lang('idioma.pos_vaciar') <i class="fa fa-trash" ></i></a>
                                    </div>
                                </div>

                                <div class="m-t-20 col-md-12 col-xs-12">
                                    <label for="cliente">@lang('idioma.pos_escoja_cli')</label>
                                    <select class="form-control" id="cliente">
                                       @foreach($datos['clientes'] as $c)

                                            @if($c->empresa == "")
                                                <option value="{{$c->id}}">{{$c->apellido.", ".$c->nombre}}</option>
                                            @else
                                                <option value="{{$c->id}}">{{$c->apellido.", ".$c->nombre." - ".$c->empresa}}</option>
                                            @endif
                                           
                                       
                                       @endforeach
                                    </select>
                                </div>
                        </div>
                        <!-- end row -->

                        <div class="m-t-20"></div>

                        <div class="row" style="font-size:10pt;">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table m-t-30" id="lista_productos_temporal">
                                        <thead>
                                            <tr>
                                                <th>@lang('idioma.pos_cod')</th>
                                                <th style="width:40px;">@lang('idioma.pos_pro')</th>
                                                <th>@lang('idioma.pos_cnt')</th>
                                                <th>@lang('idioma.pos_pre') U.</th>
                                                <th>@lang('idioma.pos_imp')</th>
                                                <th>@lang('idioma.pos_timp')</th>
                                                <th>@lang('idioma.pos_total')<small> (@lang('idioma.pos_con_imp')) </small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--
            *******************************************************************
            *******************************************************************
                             FINAL LISTA PRODUCTOS PRINCIPAL
            *******************************************************************
            *******************************************************************
            -->

            <!--
            *******************************************************************
            *******************************************************************
                                        MONTOS
            *******************************************************************
            *******************************************************************
            -->

            <!--Datos Montos-->
            <div class="col-md-4">
                <div class="panel panel-default sombra_caja_producto">
                    <!-- <div class="panel-heading">
                        <h4>Invoice</h4>
                    </div> -->
                    <div class="panel-body">
                        <div class="m-h-50"></div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <label for="subTotal">Subtotal <small>(@lang('idioma.pos_sin_imp'))</small></label>
                                    <input type="text" readonly id="subtotal_general_si" name="subtotal_general_si" class="form-control" value="0.00">
                                </div>
                                <div class="col-md-12">&nbsp;</div>
                                <div class="col-md-12">
                                    <label for="impuestosTotales">@lang('idioma.pos_total_imp')</label>
                                    <input type="text" readonly="readonly" id="impuestos_totales" class="form-control" value="0.00">
                                </div>
                                <div class="col-md-12">&nbsp;</div>
                                <div class="col-md-12">
                                    <label for="subTotal">Total <small>(@lang('idioma.pos_con_imp'))</small></label>
                                    <input type="text" readonly id="subtotal_general" name="subtotal_general" class="form-control" value="0.00">
                                    <input type="hidden" id="subtotal_general_sf" name="subtotal_general_sf" class="form-control" value="0.00">
                                </div>
                                <div class="col-md-12">&nbsp;</div>
                                <div class="col-md-12">
                                    <label for="pagoPrevio">@lang('idioma.pos_descuento') (%)</label>
                                    <select class="form-control" id="descuento">
                                        @for($i = 0; $i <= 100; $i++)

                                            <option value="{{$i}}">{{$i}}</option>
                                            
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-12">&nbsp;</div>
                                <div class="col-md-12">
                                    <label for="FormaPago">@lang('idioma.pos_forma_pago')</label>
                                    <select name="forma_pago" class="form-control" id="forma_pago">
                                        <option value="efectivo">@lang('idioma.pos_efectivo')</option>
                                        <option value="transferencia">@lang('idioma.pos_trans')</option>
                                        <option value="tdc">@lang('idioma.pos_tdc')</option>
                                        <option value="tdd">@lang('idioma.pos_debito')</option>
                                        <option value="cheque">@lang('idioma.pos_cheque')</option>
                                        <option value="otros">@lang('idioma.pos_otros')</option>
                                    </select>
                                </div>
                                <br>
                            </div>
                        </div>
                        <div class="col-md-12">&nbsp;</div>
                        <div class="col-md-12">
                            <label for="pagoPrevio">@lang('idioma.pos_cant_total')</label>
                            <input type="text" readonly="readonly" id="cantidad_total" class="form-control" value="0">
                            <input type="hidden" id="items_totales">
                            <input type="hidden" id="registros_totales">
                        </div>
                        <div class="col-md-12">&nbsp;</div>
                        <div class="col-md-12">    
                                <label for="total"class="text-left">@lang('idioma.pos_a_pagar') ({{$sistema->moneda}}):</label>
                                <div class="col-md-12 letra_calculator_total text-center" id="div_total">0.00</div>
                                <input type="hidden" name="total" id="total" value="0.00">
                                
                        </div>
                        <div class="col-md-12">
                            <div class="text-center">
                                <a style="width:100%; padding-top:0.5em; padding-bottom: 0.5em; font-size: 18pt;"  href="javascript:void" class="btn btn-info waves-effect waves-light" id="pagar"> @lang('idioma.pos_pagar') <i class="fa fa-credit-card"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--
            *******************************************************************
            *******************************************************************
                                    FINAL MONTOS
            *******************************************************************
            *******************************************************************
            -->
        </div>

        <!--
            *******************************************************************
            *******************************************************************
                                MODAL LISTADO PRODUCTOS
            *******************************************************************
            *******************************************************************
        -->

            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg" style="width:80%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                            <div class="col-md-8">
                                <h4 class="modal-title" id="myLargeModalLabel">@lang('idioma.pos_pros')</h4>
                                <small>@lang('idioma.pos_detall_pro')</small>
                            </div>
                            <div class="col-md-4">
                                <div class="col-sm-12">
                                    <input type="text" placeholder="@lang('idioma.pos_name_code')"class="form-control" name="buscar_producto" id="buscar_producto"> 
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <table id="tabla_productos_pos" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>@lang('idioma.pos_codigo')</th>
                                        <th>@lang('idioma.pos_nombre')</th>
                                        <th>@lang('idioma.pos_cnt')</th>
                                        <th>@lang('idioma.pos_pre') U.({{$sistema->moneda}})</th>
                                        <th>@lang('idioma.pos_agregar')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--LISTADO DE PRODUCTOS AJAX-->
                                </tbody>
                            </table>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <!--
            *******************************************************************
            *******************************************************************
                                FINAL MODAL LISTADO PRODUCTOS
            *******************************************************************
            *******************************************************************
            -->


            <!--
            *******************************************************************
            *******************************************************************
                                  MODAL PROCESAR VENTA
            *******************************************************************
            *******************************************************************
            -->
            <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                            <h4 class="modal-title">@lang('idioma.pos_ti_md_pro')</h4>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="numeroProceso" class="control-label">@lang('idioma.pos_cod_venta')</label>
                                        <input type="text" readonly="readonly" class="form-control" id="codigo_proceso" value="{{$datos['n_factura']}}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cantidadProductos" class="control-label">@lang('idioma.pos_cant_pro')</label>
                                        <input type="text" readonly="readonly" class="form-control" id="modal_cantidad_productos">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="descuento" class="control-label">@lang('idioma.pos_descuento') (%)</label>
                                        <input type="text" readonly="readonly" class="form-control" id="modal_descuento">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formaPago" class="control-label">@lang('idioma.pos_forma_pago')</label>
                                        <input type="text" readonly="readonly" class="form-control" id="modal_forma_pago">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="subtotal" class="control-label">Total <small>(@lang('idioma.pos_con_imp'))</small></label>
                                        <input type="text" readonly="readonly" class="form-control" id="modal_subtotal_cf">
                                        <input type="hidden" readonly="readonly" class="form-control" id="modal_subtotal_sf">
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row text-center">
                                <div class="col-md-12">
                                    <label for="total"class="text-left"><h2>@lang('idioma.pos_a_pagar') ({{$sistema->moneda}})</h2></label>
                                    <div class="col-md-12 letra_calculator_total text-center" id="modal_div_total_modal_cf">0.00</div>
                                    <input type="hidden" id="modal_total_sf">
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group no-margin">
                                        <label for="comentario" class="control-label">@lang('idioma.pos_alg_comen') (@lang('idioma.pos_opcional'))</label>
                                        <textarea class="form-control autogrow" id="modal_comentario" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px; resize: none;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">@lang('idioma.gral_cancelar')</button>
                            <button type="button" class="btn btn-success waves-effect waves-light" id="procesarAhora">@lang('idioma.pos_procesar')! <span id="loading_modal"></span></button>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal -->

            <!--
            *******************************************************************
            *******************************************************************
                                 FIN MODAL PROCESAR VENTA
            *******************************************************************
            *******************************************************************
            -->

            <!--
            *******************************************************************
            *******************************************************************
                                 MODAL ALERTA VALOR CERO
            *******************************************************************
            *******************************************************************
            -->

            <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;" id="modal_cero">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                            <h2 class="modal-title" id="mySmallModalLabel" style="color: red;">@lang('idioma.pos_importante')</h2>
                        </div>
                        <div class="modal-body">
                          @lang('idioma.pos_imp_text')
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <!--
            *******************************************************************
            *******************************************************************
                                FIN MODAL ALERTA VALOR CERO
            *******************************************************************
            *******************************************************************
            -->

            <!--
            *******************************************************************
            *******************************************************************
                                 MODAL ALERTA VACIAR
            *******************************************************************
            *******************************************************************
            -->

            <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;" id="modal_vaciar">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                            <h2 class="modal-title" id="mySmallModalLabel">@lang('idioma.pos_aviso')</h2>
                        </div>
                        <div class="modal-body text-center">
                          @lang('idioma.pos_conf_borra')
                            <button type="button" class="btn btn-danger" data-dismiss="modal" style="font-size: 12pt"><i class="fa fa-thumbs-down"></i></button>
                             <button type="button" class="btn btn-success" id="confirmar_vaciar" style="font-size: 12pt"><i class="fa fa-thumbs-up"></i></button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <!--
            *******************************************************************
            *******************************************************************
                                FIN MODAL ALERTA VACIAR
            *******************************************************************
            *******************************************************************
            -->


              <!--
            *******************************************************************
            *******************************************************************
                                 MODAL PROCESO EXITOSO
            *******************************************************************
            *******************************************************************
            -->

            
            <div id="proceso_exitoso" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content p-0 b-0">
                        <div class="panel panel-color panel-primary">
                            <div class="panel-heading text-center">
                                <h3 class="panel-title">@lang('idioma.pos_tit_succes')</h3>
                            </div>
                            <div class="panel-body">
                               
                                <div class="account-content">
                                    <div class="text-center m-b-20">
                                        <div class="m-b-20">
                                            <div class="checkmark">
                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                                                  <circle class="path circle" fill="none" stroke="#4bd396" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                                                  <polyline class="path check" fill="none" stroke="#4bd396" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                                                </svg>
                                            </div>
                                        </div>

                                        <h3>@lang('idioma.pos_msg_succes')</h3>

                                        <button type="button" class="btn btn-success" id="continuar" style="font-size: 12pt"> @lang('idioma.pos_btn_succes') <i class="fa fa-thumbs-up"></i></button>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <!--
            *******************************************************************
            *******************************************************************
                                FIN MODAL PROCESO EXITOSO
            *******************************************************************
            *******************************************************************
            -->
@endsection