@extends('Back.master')
@section('title', __('idioma.nav_sys_per'))
@section('active-configuracion', 'active subdrop')
@section('active-configuracion-permisos', 'active')
@section('content')

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">@lang('idioma.perm_titulo')</h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                              <a href="{{ url('/dash') }}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li class="active">
                              @lang('idioma.nav_sys_per')
                            </li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->
       
            <div class="row">
                <div class="col-sm-12">
                    
                    <div class="card-box table-responsive"><h3 class="box-title"></h3>
                        <h4 class="m-t-0 header-title"><b>@lang('idioma.nav_sys_per')</b></h4>
                        <p class="text-muted font-13 m-b-30">
                          @lang('idioma.perm_detalle')
                        </p>
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{session('status')}}
                                </div>
                            @endif
                        <table id="datatable" class="table table-striped table-bordered informacion">
                            <thead>
                            <tr>
                                <th>{{'#'}}</th>
                                <th>@lang('idioma.perm_th_roles')</th>
                            </tr>
                            </thead>
                            <tbody>
	                            @foreach($permisos as $key => $p)

                                <tr>
                                  <td><a href="{{url('/configuracion/permiso/show_permiso',$p->id)}}">{{ ++$key }}</a></td>
                                  <td><a href="{{url('/configuracion/permiso/show_permiso',$p->id)}}">{{ $p->rol->nombre }}</a></td>
                                </tr>

                              @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- container -->
    </div> <!-- content -->
@endsection