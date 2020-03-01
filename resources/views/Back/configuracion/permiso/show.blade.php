@extends('Back.master')
@section('title', $permisos->rol->nombre )
@section('active-configuracion', 'active')
@section('active-configuracion-permisos', 'active')
@section('content')

 <!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">
  <!-- Start content -->
  <div class="content">
    <div class="container">

      <div class="row">
          <div class="col-xs-12">
              <div class="page-title-box">
                  <h4 class="page-title">@lang('idioma.perm_permi_de'): <i> {{$permisos->rol->nombre}} </i> </h4>
                  <ol class="breadcrumb p-0 m-0">
                      <li>
                          <a href="{{ url('/dash') }}">{{$sistema->nombre_empresa}}</a>
                      </li>
                      <li>
                          <a href="{{ url('/permsisos') }}">@lang('idioma.nav_sys_per')</a>
                      </li>
                      <li class="active">
                        @lang('idioma.perm_permi_de'): {{ $permisos->rol->nombre }}
                      </li>
                  </ol>
                  <div class="clearfix"></div>
              </div>
          </div>
      </div>
      <!-- end row -->

      <div class="row">
        <div class="col-sm-12">

          @foreach($errors->all() as $error)
            <p class="alert alert-danger">{{$error}}</p>
          @endforeach

          @if (session('status'))
            <div class="alert alert-success">
              {{session('status')}}
            </div>
          @endif

          @if (session('error'))
            <div class="alert alert-danger">
              {{session('error')}}
            </div>
          @endif

            <div class="card-box">
              <div class="row">
                <div class="col-md-12">
                  <div class="demo-box">
                    <h4 class="m-t-0 header-title"><b>@lang('idioma.perm_titulo3')</b></h4>
                    <p class="text-muted font-13 m-b-20">
                        @lang('idioma.perm_detalle2')
                    </p>

                    <form class="form-horizontal" method="POST">
                      <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="table-responsive">
                          <table class="table m-0 table-colored table-primary">
                              <thead>
                                  <tr>
                                      <th>@lang('idioma.perm_col_mod')</th>
                                      <th>@lang('idioma.perm_col_lis')</th>
                                      <th>@lang('idioma.perm_col_mod')</th>
                                      <th>@lang('idioma.perm_col_edi')</th>
                                      <th>@lang('idioma.perm_col_bor')</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <th scope="row">@lang('idioma.perm_fil_cat')</th>
                                      <td>
                                        @if($permisos->catego_i == 0)
                                          <input value="1" name="catego_i" type="checkbox" id="switch1" data-switch="bool" />
                                          <label for="switch1" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @else
                                        <input value="1" name="catego_i" type="checkbox" id="switch1" data-switch="bool" checked />
                                          <label for="switch1" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @endif
                                      </td>
                                      <td>
                                        @if($permisos->catego_r == 0)
                                          <input value="1" name="catego_r" type="checkbox" id="switch2" data-switch="bool" />
                                            <label for="switch2" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                      @else
                                          <input value="1" name="catego_r" type="checkbox" id="switch2" data-switch="bool" checked />
                                        <label for="switch2" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                      @endif
                                      </td>
                                      <td>
                                        @if($permisos->catego_e == 0)
                                          <input value="1" name="catego_e" type="checkbox" id="switch3" data-switch="bool" />
                                        <label for="switch3" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @else
                                          <input value="1" name="catego_e" type="checkbox" id="switch3" data-switch="bool" checked />
                                          <label for="switch3" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @endif
                                      </td>
                                      <td>
                                        @if($permisos->catego_b == 0)
                                          <input value="1" name="catego_b" type="checkbox" id="switch4" data-switch="bool" />
                                          <label for="switch4" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @else
                                          <input value="1" name="catego_b" type="checkbox" id="switch4" data-switch="bool" checked />
                                          <label for="switch4" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @endif
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row">@lang('idioma.perm_fil_scat')</th>
                                      <td>
                                        @if($permisos->subcatego_i == 0)
                                          <input value="1" name="subcatego_i" type="checkbox" id="switch5" data-switch="bool" />
                                          <label for="switch5" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @else
                                          <input value="1" name="subcatego_i" type="checkbox" id="switch5" data-switch="bool" checked />
                                          <label for="switch5" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @endif
                                      </td>
                                      <td>
                                        @if($permisos->subcatego_r == 0)
                                          <input value="1" name="subcatego_r" type="checkbox" id="switch6" data-switch="bool" />
                                          <label for="switch6" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @else
                                          <input value="1" name="subcatego_r" type="checkbox" id="switch6" data-switch="bool" checked />
                                          <label for="switch6" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @endif
                                      </td>
                                      <td>
                                        @if($permisos->subcatego_e == 0)
                                          <input value="1" name="subcatego_e" type="checkbox" id="switch7" data-switch="bool" />
                                          <label for="switch7" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @else
                                          <input value="1" name="subcatego_e" type="checkbox" id="switch7" data-switch="bool" checked />
                                          <label for="switch7" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @endif
                                      </td>
                                      <td>
                                        @if($permisos->subcatego_b == 0)
                                          <input value="1" name="subcatego_b" type="checkbox" id="switch8" data-switch="bool" />
                                          <label for="switch8" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @else
                                          <input value="1" name="subcatego_b" type="checkbox" id="switch8" data-switch="bool" checked />
                                          <label for="switch8" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @endif
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row">@lang('idioma.perm_fil_pro')</th>
                                      <td>
                                        @if($permisos->producto_i == 0)
                                          <input value="1" name="producto_i" type="checkbox" id="switch9" data-switch="bool" />
                                          <label for="switch9" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @else
                                          <input value="1" name="producto_i" type="checkbox" id="switch9" data-switch="bool" checked />
                                          <label for="switch9" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @endif
                                      </td>
                                      <td>
                                        @if($permisos->producto_r == 0)
                                          <input value="1" name="producto_r" type="checkbox" id="switch10" data-switch="bool" />
                                          <label for="switch10" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @else
                                          <input value="1" name="producto_r" type="checkbox" id="switch10" data-switch="bool" checked />
                                          <label for="switch10" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @endif
                                      </td>
                                      <td>
                                        @if($permisos->producto_e == 0)
                                          <input value="1" name="producto_e" type="checkbox" id="switch11" data-switch="bool" />
                                          <label for="switch11" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @else
                                          <input value="1" name="producto_e" type="checkbox" id="switch11" data-switch="bool" checked />
                                          <label for="switch11" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @endif
                                      </td>
                                      <td>
                                        @if($permisos->producto_b == 0)
                                          <input value="1" name="producto_b" type="checkbox" id="switch12" data-switch="bool" />
                                          <label for="switch12" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @else
                                          <input value="1" name="producto_b" type="checkbox" id="switch12" data-switch="bool" checked />
                                          <label for="switch12" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @endif
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row">@lang('idioma.perm_fil_gas')</th>
                                      <td>
                                        @if($permisos->gasto_i == 0)
                                          <input value="1" name="gasto_i" type="checkbox" id="switch13" data-switch="bool" />
                                          <label for="switch13" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @else
                                          <input value="1" name="gasto_i" type="checkbox" id="switch13" data-switch="bool" checked />
                                          <label for="switch13" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @endif
                                      </td>
                                      <td>
                                        @if($permisos->gasto_r == 0)
                                          <input value="1" name="gasto_r" type="checkbox" id="switch14" data-switch="bool" />
                                          <label for="switch14" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @else
                                          <input value="1" name="gasto_r" type="checkbox" id="switch14" data-switch="bool" checked />
                                          <label for="switch14" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @endif
                                      </td>
                                      <td>
                                        @if($permisos->gasto_e == 0)
                                          <input value="1" name="gasto_e" type="checkbox" id="switch15" data-switch="bool" />
                                          <label for="switch15" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @else
                                          <input value="1" name="gasto_e" type="checkbox" id="switch15" data-switch="bool" checked />
                                          <label for="switch15" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @endif
                                      </td>
                                      <td>
                                        @if($permisos->gasto_b == 0)
                                          <input value="1" name="gasto_b" type="checkbox" id="switch16" data-switch="bool" />
                                          <label for="switch16" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @else
                                          <input value="1" name="gasto_b" type="checkbox" id="switch16" data-switch="bool" checked />
                                          <label for="switch16" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @endif
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row">{{" KARDEX "}}</th>
                                      <td colspan="4">
                                        @if($permisos->kardex_i == 0)
                                          <input value="1" name="kardex_i" type="checkbox" id="switch17" data-switch="bool" />
                                          <label for="switch17" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @else
                                          <input value="1" name="kardex_i" type="checkbox" id="switch17" data-switch="bool" checked />
                                          <label for="switch17" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @endif
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row">@lang('idioma.perm_fil_ven')</th>
                                      <td>
                                        @if($permisos->venta_i == 0)
                                          <input value="1" name="venta_i" type="checkbox" id="switch18" data-switch="bool" />
                                          <label for="switch18" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @else
                                          <input value="1" name="venta_i" type="checkbox" id="switch18" data-switch="bool" checked />
                                          <label for="switch18" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @endif
                                      </td>
                                      <td colspan="2">
                                        @if($permisos->venta_r == 0)
                                          <input value="1" name="venta_r" type="checkbox" id="switch19" data-switch="bool" />
                                          <label for="switch19" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @else
                                          <input value="1" name="venta_r" type="checkbox" id="switch19" data-switch="bool" checked />
                                          <label for="switch19" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @endif
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row">@lang('idioma.perm_fil_com')</th>
                                      <td>
                                        @if($permisos->compra_i == 0)
                                          <input value="1" name="compra_i" type="checkbox" id="switch20" data-switch="bool" />
                                          <label for="switch20" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @else
                                          <input value="1" name="compra_i" type="checkbox" id="switch20" data-switch="bool" checked />
                                          <label for="switch20" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @endif
                                      </td>
                                      <td colspan="3">
                                        @if($permisos->compra_r == 0)
                                          <input value="1" name="compra_r" type="checkbox" id="switch21" data-switch="bool" />
                                          <label for="switch21" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                          @else
                                            <input value="1" name="compra_r" type="checkbox" id="switch21" data-switch="bool" checked />
                                            <label for="switch21" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                          @endif
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row">@lang('idioma.perm_fil_per')</th>
                                      <td colspan="3">
                                        @if($permisos->persona_i == 0)
                                          <input value="1" name="persona_i" type="checkbox" id="switch22" data-switch="bool" />
                                          <label for="switch22" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @else
                                          <input value="1" name="persona_i" type="checkbox" id="switch22" data-switch="bool" checked />
                                          <label for="switch22" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @endif
                                      </td>
                                  </tr>
                                  <tr>
                                      <th scope="row">@lang('idioma.perm_fil_rep')</th>
                                      <td colspan="3">
                                        @if($permisos->reporte_i == 0)
                                          <input value="1" name="reporte_i" type="checkbox" id="switch23" data-switch="bool" />
                                          <label for="switch23" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @else
                                          <input value="1" name="reporte_i" type="checkbox" id="switch23" data-switch="bool" checked />
                                          <label for="switch23" data-on-label="@lang('idioma.gral_yes')" data-off-label="@lang('idioma.gral_no')"></label>
                                        @endif
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>

                      <div class="box-footer">
                        <a href="{{ url('/configuracion/permisos') }}"><button type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i> @lang('idioma.gral_btn_atras') </button></a>
                        <button type="submit" class="btn btn-info pull-right"><i class="mdi mdi-content-save"></i> @lang('idioma.gral_btn_guar') </button>
                      </div>
                    </form>
                  </div><!--demo box-->
                </div> <!--col-md-->
              </div><!--row-->
            </div><!--card-box-->
        </div><!--col-md-->
      </div><!--row-->
    </div> <!-- container -->
  </div> <!-- content -->
@endsection