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

table {
  text-align: center;
  border-collapse: separate;
  border-spacing: 0;
  border: 2px solid #36404E;
  width: 90%;
  margin: 20px auto;
  border-radius: .25rem;
}

thead tr:first-child {
  background: #36404E;
  color: #fff;
  border: none;
}

th:first-child,
td:first-child {
  padding: 0 5px 0 10px;
}

th {
  font-weight: 500;
}

tbody tr:hover {
  background-color: #f2f2f2;
  cursor: default;
}


tbody td {
  border-bottom: 1px solid #ddd;
  font-size:10pt;
}

</style>

<!--ESTILOS CABEZERA-->
<style type="text/css">
  .titulo{
    text-align: center;
    margin-top: 20px;
  }
</style>

<!--Titulo-->
<div class="titulo"><h3>Kardex</h3></div>
<table>
  <thead>
    <tr style="font-size:11pt">
      <th>{{"#"}}</th>
      <th>@lang('idioma.gral_codigo')</th>
      <th>@lang('idioma.nav_sys_tribu') (%)</th>
      <th>@lang('idioma.gral_br_cant')</th>
      <th>{{"Sub. ".$sistema->moneda}}</th>
      <th>@lang('idioma.gral_precio') {{"u /( ".$sistema->moneda." )"}}</th>
      <th>@lang('idioma.kx_pago') {{"( ".$sistema->moneda." )"}}</th>
      <th>@lang('idioma.gral_tipo')</th>
      <th>@lang('idioma.dash_fecha')</th>
    </tr>                            
    </thead>
    <tbody>
        @foreach($datos as $d)
        <tr>
          <td>{{ $d->codigo_proceso }}</td>
          <td>{{ $d->producto->codigo }}</td>
          <td>{{ $d->tributo->monto }}</td>
          <td>{{ $d->cantidad }}</td>
          <td>{{ $d->subtotal }}</td>
          <td>{{ $d->costo_publico_vendido }}</td>
          <td>{{ \DB::table('posprocesos')->where('codigo_proceso',$d->codigo_proceso)->value('tipo_pago') }}</td>
          <td>{{ \DB::table('posprocesos')->where('codigo_proceso',$d->codigo_proceso)->value('tipo_proceso') }}</td>
          <td>{{ $d->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>