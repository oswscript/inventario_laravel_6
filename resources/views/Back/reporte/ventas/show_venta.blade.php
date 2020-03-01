@extends('Back.master')
@section('title',  __('idioma.rep_ven_tit'))
@section('active-reportes', 'active')
@section('active-reportes-ventas', 'active')
@section('content')

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">@lang('idioma.rep_ven_tit') </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ url('/dash') }}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li>
                                <a href="{{ url('/clientes') }}">@lang('idioma.rep_ven_tit')</a>
                            </li>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">

                        @if(count($datos) != 0)
                            <a href="{{url('/pdf_reporte_ventas',array('desde'=>$desde,'hasta'=>$hasta, 'status' => $status))}}" class="btn btn-danger"><i class="fa fa-print"></i>{{" PDF "}}</a>
                            <a href="{{url('/csv_reporte_ventas',array('desde'=>$desde,'hasta'=>$hasta, 'status' => $status))}}" class="btn btn-success pull-left"><i class="fa fa-file-excel-o"></i> {{"CSV"}} </a>

                        @else

                            <!--NADA-->

                        @endif
                        <br/><br/>
                        <div class="invoice-box">
                            <table cellpadding="0" cellspacing="0" style="width: 100%">

                                <tr><td colspan="7" class="rango_titulo"><u>{{$str_status}}</u> @lang('idioma.rep_ven_md_des') <u>{{$desde}}</u> @lang('idioma.rep_ven_md_has') <u>{{$hasta}}</u></td></tr>

                                <tr class="heading" style="font-size: 10pt">
                                    <td>
                                        #
                                    </td>

                                    <td style="text-align:left;">
                                        # @lang('idioma.rep_ven_factura')
                                    </td>
                                    
                                    <td>
                                       @lang('idioma.rep_ven_cliente')
                                    </td>

                                    <td>
                                        TOTAL {{"(".$sistema->moneda.")"}}
                                    </td>

                                    <td>
                                       @lang('idioma.rep_ven_tipo')
                                    </td>

                                    <td>
                                       @lang('idioma.rep_ven_fecha')
                                    </td>

                                    <td>
                                        STATUS
                                    </td>
                                </tr>
                                
                                @if(count($datos) != 0)
                                    @foreach($datos as $key => $d)

                                        <tr class="item">

                                            <td>
                                                {{++$key}}
                                            </td>

                                            <td class="resaltar_codigo" style="text-align:left;">
                                                {{$d->codigo_proceso}}
                                            </td>

                                            <td>
                                                {{$d->cliente->cedula}}
                                            </td>

                                            <td>
                                                {{number_format($d->total,2)}}
                                            </td>

                                            <td>
                                                {{strtoupper($d->tipo_pago)}}
                                            </td>

                                            <td>
                                                {{date('Y-m-d', strtotime($d->created_at))}}
                                            </td>
                                            @if($d->status == 2)
                                                <td class="status_rep_apro">
                                                   @lang('idioma.rep_ven_md_apr')
                                                </td>
                                            @elseif($d->status == 1)
                                                <td class="status_rep_pen">
                                                   @lang('idioma.rep_ven_md_pen')
                                                </td>   
                                            @else
                                                <td class="status_rep_rec">
                                                   @lang('idioma.rep_ven_md_rec')
                                                </td>   
                                            @endif

                                        </tr>

                                    @endforeach
                                @else
                                        <tr ><td colspan="7" class="text-center no_datos_reporte">@lang('idioma.dat_record')</td></tr>

                                @endif
                                
                                <tr class="total">
                                    <td colspan="7">
                                        <br>
                                        <table style="width: 100%">
                                            <tr style="font-size: 11pt">
                                                <td style="text-align:right">@lang('idioma.rep_ven_produc')  <i class="fa fa-info-circle estilo_tool" data-toggle="tooltip" data-placement="right" title="" data-original-title="@lang('idioma.rep_ven_produc_to')"></i></td>
                                                <td>{{$registros_total}}</td>
                                            </tr>
                                            <tr style="font-size: 11pt">
                                                <td style="text-align:right">@lang('idioma.rep_ven_facts') <i class="fa fa-info-circle estilo_tool" data-toggle="tooltip" data-placement="right" title="" data-original-title="@lang('idioma.rep_ven_facts_tol')"></i></td>
                                                <td>{{count($datos)}}</td>
                                            </tr>
                                            <tr style="font-size: 11pt">
                                                <td style="text-align:right">SUBTOTAL <i class="fa fa-info-circle estilo_tool" data-toggle="tooltip" data-placement="right" title="" data-original-title="@lang('idioma.rep_ven_sub_tol')"></i></td>
                                                <td>{{number_format($total_bruto,2)." ".$sistema->moneda}}</td>
                                            </tr>
                                            <tr style="font-size: 11pt">
                                                <td style="text-align:right">@lang('idioma.rep_ven_imp') <i class="fa fa-info-circle estilo_tool" data-toggle="tooltip" data-placement="right" title="" data-original-title="@lang('idioma.rep_ven_imp_tol')"></i></td>
                                                <td>{{number_format($total_impuestos,2)." ".$sistema->moneda}}</td>
                                            </tr>
                                            <tr style="font-size: 11pt">
                                                <td style="text-align:right">TOTAL <i class="fa fa-info-circle estilo_tool" data-toggle="tooltip" data-placement="right" title="" data-original-title="@lang('idioma.rep_ven_tot_tol')"></i></td>
                                                <td>{{number_format($total_sd,2)." ".$sistema->moneda}}</td>
                                            </tr>
                                            <tr style="font-size: 11pt">
                                                <td style="text-align:right">@lang('idioma.rep_ven_mont') <i class="fa fa-info-circle estilo_tool" data-toggle="tooltip" data-placement="right" title="" data-original-title="@lang('idioma.rep_ven_mont_tol')"></i></td>
                                                <td>{{number_format($total_descuentos,2)." ".$sistema->moneda}}</td>
                                            </tr>
                                            <tr class="heading">
                                                <td style="text-align:right"><h3>@lang('idioma.rep_ven_neto'):</h3></td>
                                                <td><h3>{{number_format($gran_total,2)." ".$sistema->moneda}}</h3></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container -->

    </div> <!-- content -->
@endsection