
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
        text-align: left;
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
    </style>

    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">

            <tr class="top">
                <td colspan="5">
                    <table>
                        <tr>
                            <td class="title">
                                 @if($sistema->logo != "")
                                      <a href="" class="dropdown-toggle waves-effect user-link" data-toggle="dropdown" aria-expanded="true">
                                          <img src="{{ url('/storage/img_sistema/'.$sistema->logo) }}" alt="user-img" class="img-circle user-img" style="width:200px; height:150px;">
                                      </a>
                                  @else
                                      <a href="" class="dropdown-toggle waves-effect user-link" data-toggle="dropdown" aria-expanded="true">
                                          <img src="{{ url('/storage/img_sistema/default_logo.jpg') }}" alt="user-img" class="img-circle user-img">
                                      </a>
                                  @endif
                            </td>
                            
                             <td>
                                <strong>@lang('idioma.dash_compra') #: {{ $datos->codigo_proceso }}<br></strong>
                                @lang('idioma.dash_fecha'): {{ $fecha }}<br>
        
                                    @if($datos->status == 1)
                                        <span style="background-color:orange;">@lang('idioma.vent_fac_pendi')</span>
                                    
                                    @elseif($datos->status == 0)
                                        <span style="background-color:red;color:white">@lang('idioma.vent_fac_rechaza')</span>
                                    
                                    @else
                                        <span style="background-color:green;color:white">@lang('idioma.vent_fac_aproba')</span>
                                    
                                    @endif
                                
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="5">
                    <table>
                        <tr>
                            <td style="font-size: 9pt; width: 60%;">
                                {{ $sistema->nombre_empresa }}<br>
                                {{ $sistema->slogan }}<br>
                                {{ $sistema->correo }}
                            </td>
                            
                            <td style="font-size: 9pt;">
                                <label for=""><b>@lang('idioma.gral_info'):</b></label><br>
                                @lang('idioma.gral_cliente'): {{ $datos->cliente->cedula }}<br>
                                @lang('idioma.gral_correo'): {{ $datos->cliente->correo }}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr><td>&nbsp;</td></tr>

            <tr class="heading" style="font-size: 10pt;">
                
                <td>
                    @lang('idioma.nav_produc')
                </td>

                <td>
                    @lang('idioma.gral_codigo')
                </td>

                <td>
                    @lang('idioma.gral_precio') U.
                </td>
                
                <td>
                    @lang('idioma.gral_br_cant')
                </td>

                <td>
                    @lang('idioma.gral_abr_imp')
                </td>

                <td>
                    Total
                </td>
            </tr>
            <?php

              $total_sin_impuestos    = 0;
              $total_impuesto         = 0;
              $subtotal_por_producto  = 0;

            ?>
            @foreach($detalles as $d)


                <?php

                      //capturar tributo
                      $tributo =\DB::table('tributos')->where('id', $d->tributo_id)->first();

                      //total sin impuestos Suma de precios publico po cantidad

                      $total_sin_impuestos += $d->cantidad * $d->costo_publico_vendido;

                      //Suma de los valores de los impuestos
                      $calculo =  $d->cantidad * $d->costo_publico_vendido;

                      $total_impuesto += $calculo * ($tributo->monto/100);

                      /*if($key == 0){
                        dd($total_impuesto);
                      }*/

                ?>

                <tr class="item" style="font-size: 10pt">

                    <td style="text-align: left;">
                        {{$d->producto->nombre}}
                    </td>

                    <td>
                        {{$d->producto->codigo}}
                    </td>

                    <td>
                        {{number_format($d->costo_publico_vendido,2)}}
                    </td>
                    
                    <td>
                        {{$d->cantidad}}
                    </td>

                    @if($d->tributo->tipo=="PORCENTAJE")
                        <td>
                            {{$d->tributo->monto." %"}}
                        </td>
                    @else
                         <td>
                            {{$d->tributo->monto." ".$sistema->moneda}}
                        </td>
                    @endif

                    <td>
                        {{number_format($d->subtotal,2)}}
                    </td>

                </tr>

            @endforeach
            
            <tr class="total">
                @if($datos->comentario)

                    <td style="width:260px;font-size: 9pt;"><br><strong>@lang('idioma.kx_comentario'):</strong> {{$datos->comentario}}</td>

                @else

                    <td style="width:260px;font-size: 9pt;"><br><strong>@lang('idioma.kx_comentario'):</strong>Sin comentario</td>

                @endif
                <td colspan="5">
                    <br>
                    <table>
                        <tr style="font-size: 11pt">
                            <td>SUBTOTAL:</td>
                            <td>{{number_format($total_sin_impuestos ,2)." ".$sistema->moneda}}</td>
                        </tr>
                        <tr style="font-size: 11pt">
                            <td>@lang('idioma.gral_impuestos'):</td>
                            <td>{{number_format($total_impuesto,2)." ".$sistema->moneda}}</td>
                        </tr>
                        <tr style="font-size: 11pt">
                            <td>Total ( @lang('idioma.gral_con_imp') ):</td>
                            <td>{{number_format($datos->subtotal,2)." ".$sistema->moneda}}</td>
                        </tr>
                        <tr style="font-size: 11pt">
                            <td>@lang('idioma.gral_descuento'):</td>
                            <td>{{$datos->descuento." %"}}</td>
                        </tr>
                        <tr style="font-size: 11pt">
                            <td>@lang('idioma.gral_descontado'):</td>
                            <td>{{number_format($ahorro,2)." ".$sistema->moneda}}</td>
                        </tr>
                        <tr style="font-size: 11pt">
                            <td>@lang('idioma.gral_cantidad')</td>
                            <td>{{$datos->items_totales."(".$datos->registros_totales.")"}}</td>
                        </tr>
                        <tr style="font-size: 11pt">
                            <td>@lang('idioma.kx_tipo_pago'):</td>
                            <td>{{strtoupper($datos->tipo_pago)}}</td>
                        </tr>
                        <tr class="heading">
                            <td><h3>@lang('idioma.gral_a_pagar'):</h3></td>
                            <td><h3>{{number_format($datos->total,2)." ".$sistema->moneda}}</h3></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>