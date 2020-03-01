<style type="text/css">
.invoice-box {
    max-width: 800px;
    margin: auto;
    padding: 30px;
    border: 1px solid #eee;
    box-shadow: 0 0 10px rgba(0, 0, 0, .15);
    font-size: 16px;
    line-height: 24px;
    font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    color: #555;
}

.invoice-box table {
    width: 100%;
    line-height: normal;
    text-align: left;
}

.invoice-box table td {
    padding: 5px;
    vertical-align: top;
}

.invoice-box table tr td:nth-child(2) {
    text-align: right;
}

.invoice-box table tr.top table td {
    padding-bottom: 20px;
}

.invoice-box table tr.top table td.title {
    font-size: 45px;
    line-height: 45px;
    color: #333;
}

.invoice-box table tr.information table td {
    padding-bottom: 40px;
    text-align: left;
}

.invoice-box table tr.heading td {
    background: #eee;
    border-bottom: 1px solid #ddd;
    font-weight: bold;
}

.invoice-box table tr.details td {
    padding-bottom: 20px;
}

.invoice-box table tr.item td{
    border-bottom: 1px solid #eee;
}

.invoice-box table tr.item.last td {
    border-bottom: none;
}

.invoice-box table tr.total td:nth-child(2) {
    border-top: 2px solid #eee;
    font-weight: bold;
    text-align: right;
}

@media only screen and (max-width: 600px) {
    .invoice-box table tr.top table td {
        width: 100%;
        display: block;
        text-align: center;
    }
    
    .invoice-box table tr.information table td {
        width: 100%;
        display: block;
        text-align: center;
    }
}

/** RTL **/
.rtl {
    direction: rtl;
    font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
}

.rtl table {
    text-align: right;
}

.rtl table tr td:nth-child(2) {
    text-align: left;
}

.resaltar_codigo{

    color:green;
    font-size: 12pt;
    font-weight: bold;
    text-align: left;

}

.rango_titulo{

    color:black;
    font-size: 12pt;
    text-align: center;

}

</style>

<div class="invoice-box">
    <table cellpadding="0" cellspacing="0" style="width: 100%">
        <tr class="top">
            <td colspan="6" >
                <table  style="text-align:left">
                    <tr>
                        <td class="title">
                             @if($sistema->logo)
                                  <a href="" class="dropdown-toggle waves-effect user-link" data-toggle="dropdown" aria-expanded="true">
                                      <img src="{{ url('/storage/img_sistema/'.$sistema->imagen) }}" alt="user-img" class="img-circle user-img">
                                  </a>
                              @else
                                  <a href="" class="dropdown-toggle waves-effect user-link" data-toggle="dropdown" aria-expanded="true">
                                      <img src="{{ url('/storage/img_sistema/default_logo.jpg') }}" alt="user-img" class="img-circle user-img">
                                  </a>
                              @endif
                        </td>

                        <td style="text-align:left">
                           {{ $sistema->nombre_empresa}}
                           <br>
                           {{ $sistema->codigo_empresa }}
                        </td>
                    </tr>
                    <tr>
                    </tr
                </table>
            </td>
        </tr>
        <tr><td colspan="7" style="text-align:center; font-weight:bold;font-size:14pt">@lang('idioma.rep_ven_tit')</td></tr>
        <tr><td colspan="7" class="rango_titulo"><u>{{$str_status}}</u> @lang('idioma.rep_ven_md_des') <u>{{$desde}}</u> @lang('idioma.rep_ven_md_has') <u>{{$hasta}}</u></td></tr>
        <tr><td colspan="7">&nbsp;</td></tr>
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
        
        @foreach($datos as $key => $d)

            <tr class="item" style="font-size: 10pt">

                <td>
                    {{++$key}}
                </td>

                <td style="text-align:left;">
                    {{$d->codigo_proceso}}
                </td>

                <td>
                    {{$d->cliente->cedula}}
                </td>

                <td>
                    {{number_format($d->total,2)}}
                </td>

                <td>
                    {{$d->tipo_pago}}
                </td>
                @if($d->status == 1)
                    <td>
                      @lang('idioma.nav_pendientes')
                    </td>
                @elseif($d->status == 2)
                    <td>
                     @lang('idioma.nav_aprobadas')
                    </td>
                @else
                    <td>
                     @lang('idioma.nav_rechazadas')
                    </td>
                @endif
                <td>
                    {{date('Y-m-d', strtotime($d->created_at))}}
                </td>

            </tr>

        @endforeach
    
        <tr class="total">
            <td colspan="7">
                <br>
                <table style="width: 100%">
                    <tr style="font-size: 11pt">
                        <td style="text-align:right">@lang('idioma.rep_ven_produc') :</td>
                        <td>{{$registros_total}}</td>
                    </tr>
                    <tr style="font-size: 11pt">
                        <td style="text-align:right">@lang('idioma.rep_ven_facts'):</td>
                        <td>{{count($datos)}}</td>
                    </tr>
                    <tr style="font-size: 11pt">
                        <td style="text-align:right">SUBTOTAL:</td>
                        <td>{{number_format($total_bruto,2)." ".$sistema->moneda}}</td>
                    </tr>
                    <tr style="font-size: 11pt">
                        <td style="text-align:right">@lang('idioma.rep_ven_imp'):</td>
                        <td>{{number_format($total_impuestos,2)." ".$sistema->moneda}}</td>
                    </tr>
                    <tr style="font-size: 11pt">
                        <td style="text-align:right">TOTAL:</td>
                        <td>{{number_format($total_sd,2)." ".$sistema->moneda}}</td>
                    </tr>
                    <tr style="font-size: 11pt">
                        <td style="text-align:right">@lang('idioma.rep_ven_mont'):</td>
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