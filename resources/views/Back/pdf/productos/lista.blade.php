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
  font-size:9pt;
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
<div class="titulo"><h3>@lang('idioma.products_list')</h3></div>
<table>
  <thead>
    <tr>
        <th>Cod.</th>
        <th>Prod.</th>
        <th>@lang('idioma.products_pr_cos')</th>
        <th>@lang('idioma.products_pr_pub')</th>
        <th>Tax</th>
        <th>Stock</th>
        <th>Status</th>
    </tr>                            
    </thead>
    <tbody>
        @foreach($datos as $d)
        
        <tr>
            <td><b>{{ $d->codigo }}</b></td>
            <td>{{ $d->nombre }}</td>
            <td>{{ $d->precio_costo }} {{$sistema->moneda}}</td>
            <td>{{ $d->precio_publico }} {{$sistema->moneda}}</td>
            @if($d->tributo->tipo == "PORCENTAJE")
              <td>{{ $d->tributo->monto }} {{"%"}}</td>
            @else
              <td>{{ $d->tributo->monto }} {{$sistema->moneda}}</td>
            @endif
            <td>{{ $d->cantidad }}</td>

            @if($d->status == 1)
              <td>@lang('idioma.gral_activo')</td>
            @else
              <td>@lang('idioma.gral_in_activo')</td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>