@extends('Back.master')
@section('title', __('idioma.rep_gas_tit'))
@section('active-reportes', 'active')
@section('active-reportes-gastos', 'active')
@section('content')

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">@lang('idioma.rep_gas_tit') </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ url('/dash') }}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li>
                                <a href="{{ url('/gastos') }}">@lang('idioma.rep_gas_tit')</a>
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
                            <a href="{{url('/pdf_reporte_gastos',array('desde'=>$desde,'hasta'=>$hasta))}}" class="btn btn-danger"><i class="fa fa-print"></i>{{" PDF "}}</a>
                            <a href="{{url('/csv_reporte_gastos',array('desde'=>$desde,'hasta'=>$hasta))}}" class="btn btn-success pull-left"><i class="fa fa-file-excel-o"></i> {{"CSV"}} </a>
                        @else

                            <!--NADA-->

                        @endif
                        <br/><br/>
                        <div class="invoice-box">
                            <table cellpadding="0" cellspacing="0" style="width: 100%">

                                <tr><td colspan="4" class="rango_titulo">@lang('idioma.rep_ven_md_des') <u>{{$desde}}</u> @lang('idioma.rep_ven_md_has') <u>{{$hasta}}</u></td></tr>

                                <tr class="heading" style="font-size: 10pt">
                                    <td>
                                        #
                                    </td>

                                    <td style="text-align:left;">
                                        # @lang('idioma.rep_gas_cod')
                                    </td>
                                    
                                    <td>
                                       @lang('idioma.rep_gas_mon') {{"(".$sistema->moneda.")"}}
                                    </td>

                                    <td>
                                       @lang('idioma.rep_gas_fec') 
                                    </td>
                                </tr>
                                
                                @if(count($datos) != 0)
                                    @foreach($datos as $key => $d)

                                        <tr class="item">

                                            <td>
                                                {{++$key}}
                                            </td>

                                            <td class="resaltar_codigo" style="text-align:left;">
                                                {{$d->codigo}}
                                            </td>

                                            <td>
                                                {{number_format($d->monto,2)}}
                                            </td>

                                            <td>
                                                {{date('Y-m-d', strtotime($d->fecha))}}
                                            </td>
                                        </tr>

                                    @endforeach
                                @else
                                        <tr ><td colspan="4" class="text-center no_datos_reporte">@lang('idioma.dat_record')</td></tr>

                                @endif
                                
                                <tr class="total">
                                    <td colspan="4">
                                        <br>
                                        <table style="width: 100%">
                                            <tr style="font-size: 11pt">
                                                <td style="text-align:right">@lang('idioma.rep_gas_enc')</td>
                                                <td>{{count($datos)}}</td>
                                            </tr>
                                            <tr class="heading">
                                                <td style="text-align:right"><h3>TOTAL:</h3></td>
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