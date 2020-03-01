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
<div class="titulo"><h3>@lang('idioma.cliente_lista')</h3></div>
<table>
  <thead>
    <tr>
        <th>@lang('idioma.cliente_cr')</th>
        <th>@lang('idioma.gral_nombre')</th>
        <th>@lang('idioma.cliente_empresa')</th>
        <th>@lang('idioma.gral_correo')</th>
        <th>@lang('idioma.cliente_telef')</th>
    </tr>                            
    </thead>
    <tbody>
        @foreach($datos as $d)
        <tr>
            <td><b>{{ $d->cedula }}</b></td>
            <td>{{ $d->nombre.", ".$d->apellido }}</td>
            <td>{{ $d->empresa }}</td>
            <td>{{ $d->correo }}</td>
            <td>{{ $d->telefono }}</td>
        </tr>
        @endforeach
    </tbody>
</table>