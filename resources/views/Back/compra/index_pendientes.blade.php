@extends('Back.master')
@section('title',  __('idioma.compra_pendi_titu'))
@section('active-compras', 'active subdrop')
@section('active-compras-pendientes', 'active')
@section('content')
<!--CONSULTA DE PERMISOS SEGUN EL ROL-->
<?php $permisos = \DB::table('permisos')->where('rol_id', Session::get("rol_id"))->first();?>
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">@lang('idioma.compra_pendi_titu')</h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ url('/dash') }}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li class="active">
                                @lang('idioma.compra_pendi_titu')
                            </li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->
       
            <div class="row">
                <div class="col-sm-12">
                
                    <div class="card-box table-responsive">

                        @if(Session::get("rol_id"))
                            <h3 class="box-title"><a href="{{url('/pdf_compras_pendientes')}}" class="btn btn-danger pull-right"><i class="fa fa-file-pdf-o"></i>{{" PDF "}}</a></h3>
                            <h3 class="box-title"><a href="{{url('/csv_compras_pendientes')}}" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i>{{" CSV "}}</a></h3>
                        @endif

                        <h4 class="m-t-0 header-title"><b>@lang('idioma.compra_pendi_list')</b></h4>
                        <p class="text-muted font-13 m-b-30">
                            &nbsp;
                        </p>
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{session('status')}}
                                </div>
                            @endif
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>{{"#"}}</th>
                                <th>@lang('idioma.gral_codigo') @lang('idioma.gral_compra')</th>
                                <th>@lang('idioma.gral_provee')</th>
                                <th>{{"Total ".$sistema->moneda}}</th>
                                <th>@lang('idioma.dash_fecha')</th>
                                <th>@lang('idioma.gral_opcions')</th>
                            </tr>
                            </thead>


                            <tbody>
                            @foreach($datos as $key => $d)
                                <tr>
                                   <td>{{++$key}}</td>
                                   <td class="fac_pendientes">{{ $d->codigo_proceso }}</td>
                                   <td>{{ $d->cliente->cedula }}</td>
                                   <td>{{ number_format($d->total,2) }}</td>
                                   <td>{{ $d->created_at }}</td>
                                   <td>
                                       <a title="@lang('idioma.gral_descargar')" href="{{url('/pdf_compras_factura',$d->id)}}" class="btn btn-primary"><i class="fa fa-file"></i></a>
                                       <a title="@lang('idioma.gral_aprobar')" data-toggle="modal" data-target="#modal_aprobar_compra{{$d->id}}" href="#" class="btn btn-success waves-effect waves-light"><i class="fa fa-check"></i></a>
                                       <a title="@lang('idioma.ven_btn_rechazar')" data-toggle="modal" data-target="#modal_rechazar_compra{{$d->id}}" href="#" class="btn btn-danger waves-effect waves-light"><i class="fa fa-times"></i></a>
                                       
                                        <!--
                                        *******************************************************************
                                        *******************************************************************
                                                            MODULO: MODAL STATUS FACTURAS
                                        *******************************************************************
                                        *******************************************************************
                                        -->
                                    
                                        <!--MODAL APROBAR FACTURA-->
                                        <div id="modal_aprobar_compra{{$d->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content p-0 b-0">
                                                    <div class="panel panel-color panel-success">
                                                        <div class="panel-heading">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            <h3 class="panel-title">@lang('idioma.compra_modal_apro')</h3>
                                                        </div>
                                                        <form role="form" method="post" action="{{action('CompraController@update_aprobar_status')}}">
                                                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                                            <div class="panel-body text-center">
                                                                <input name="id" type="hidden" value="{{$d->id}}">
                                                                <button class="btn btn-default waves-effect" data-dismiss="modal"> @lang('idioma.gral_cancelars') </button>
                                                                <button type="submit" class="btn btn-success waves-effect"> @lang('idioma.gral_aprobar') </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->

                                        <!--MODAL RECHAZAR FACTURA-->
                                        <div id="modal_rechazar_compra{{$d->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content p-0 b-0">
                                                    <div class="panel panel-color panel-danger">
                                                        <div class="panel-heading">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            <h3 class="panel-title">@lang('idioma.compra_modal_rech')</h3>
                                                        </div>
                                                        <form role="form" method="post" action="{{action('CompraController@update_rechazar_status')}}">
                                                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                                            <div class="panel-body text-center">
                                                                <div class="row">
                                                                    <input name="id" type="hidden" value="{{$d->id}}">
                                                                    <div class="col-md-12">
                                                                        <textarea class="form-control" style="width:100%" name="motivo" placeholder="@lang('idioma.ven_rech_motivo')"></textarea>        
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <button class="btn btn-default waves-effect" data-dismiss="modal"> @lang('idioma.gral_cancelar') </button>
                                                                        <button type="submit" class="btn btn-success waves-effect"> @lang('idioma.ven_btn_rechazar') </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->

                                        <!--
                                        *******************************************************************
                                        *******************************************************************
                                                        MODULO: FIN MODAL STATUS FACTURAS
                                        *******************************************************************
                                        *******************************************************************
                                        -->
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- container -->
    </div> <!-- content -->
@endsection