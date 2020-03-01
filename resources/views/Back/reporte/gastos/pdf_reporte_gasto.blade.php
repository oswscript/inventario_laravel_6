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
            <td colspan="4" >
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
        <tr><td colspan="4" style="text-align:center; font-weight:bold;font-size:14pt">@lang('idioma.rep_gas_tit')</td></tr>
        <tr><td colspan="4" class="rango_titulo">@lang('idioma.rep_gas_gas') @lang('idioma.rep_ven_md_des') <u>{{$desde}}</u> <span> @lang('idioma.rep_ven_md_has') </span> <u>{{$hasta}}</u></td></tr>
        <tr><td colspan="4">&nbsp;</td></tr>
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
        
        @foreach($datos as $key => $d)

        <tr class="item">

            <td>
                {{++$key}}
            </td>

            <td style="text-align:left;">
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