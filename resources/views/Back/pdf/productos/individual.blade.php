<!--ESTILOS TABLA ITEMS-->
<style type="text/css">
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  color: #333;
}

.tabla_contenido {
  text-align: left;
  border-collapse: separate;
  border-spacing: 0;
  margin: 20px auto;
  border-radius: .25rem;
  padding: 1em;
  width: 100%;
}

.tabla_descripcion{
  width:90%;
}

.status_activo{
  background-color: green;
  color: white;
}
.status_inactivo{
  background-color: red;
  color: white;
}

.imagen{
  text-align: center;
  border-radius: 0.2em;
  width: 100%;
}
</style>

<!--Titulo-->
<table class="tabla_contenido">
    <tbody>
    <tr>
        <td>
            <div class="imagen"><img width="300px" height="280px" src="{{ url('storage/img_productos/'.$datos->imagen) }}" alt="{{$datos->imagen}}"></div>
        </td>    
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td>
          <table class="tabla_descripcion">
            <tr style="text-align: center;"><td colspan="3"><h3><u>@lang('idioma.product_descrip')</u></h3></td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr style="text-align: center;">
              @if($datos->status == 1)
                <td style="text-align: right;"><h4>Status:</h4></td><td>&nbsp;</td><td class="status_activo">@lang('idioma.gral_activo')</td>
              @else
                <td style="text-align: right;"><h4>Status:</h4></td><td>&nbsp;</td><td class="status_inactivo">@lang('idioma.gral_activo')</td>
              @endif
            </tr>
            <tr><td style="text-align: right;"><h4>@lang('idioma.gral_nombre'): </h4></td><td>&nbsp;</td><td>{{$datos->nombre}}</td></tr>
            <tr><td style="text-align: right;"><h4>@lang('idioma.gral_codigo'): </h4></td><td>&nbsp;</td><td>{{$datos->codigo}}</td></tr>
            <tr><td style="text-align: right;"><h4>@lang('idioma.categ_titulo'): </h4></td><td>&nbsp;</td><td>{{$datos->categoria->nombre}}</td></tr>
            <tr><td style="text-align: right;"><h4>@lang('idioma.subcateg_titulo'): </h4></td><td>&nbsp;</td><td>{{$datos->subcategoria->nombre}}</td></tr>
            <tr><td style="text-align: right;"><h4>@lang('idioma.products_pr_cos'): </h4></td><td>&nbsp;</td><td>{{$datos->precio_costo." ".$sistema->moneda}}</td></tr>
            <tr><td style="text-align: right;"><h4>@lang('idioma.products_pr_pub'): </h4></td><td>&nbsp;</td><td>{{$datos->precio_publico." ".$sistema->moneda}}</td></tr>
            @if($datos->tributo->tipo=="PORCENTAJE")
              <tr><td style="text-align: right;"><h4>@lang('idioma.nav_sys_tribu'): </h4></td><td>&nbsp;</td><td>{{$datos->tributo->monto."%"}}</td></tr>
            @else
              <tr><td style="text-align: right;"><h4>@lang('idioma.nav_sys_tribu'): </h4></td><td>&nbsp;</td><td>{{$datos->tributo->monto}} {{$sistema->moneda}}</td></tr>
            @endif
            <tr><td style="text-align: right;"><h4>@lang('idioma.product_descrip'): </h4></td><td>&nbsp;</td><td>{{$datos->descripcion}}</td></tr>
           </table>
        </td>
    </tr>
    </tbody>
</table>