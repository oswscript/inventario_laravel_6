<?php 

$permisos     = \DB::table('permisos')->where('rol_id', Session::get("rol_id"))->first();//PERMISOS
$img_usuario  = \DB::table('users')->where('id', Session::get("usuario_id"))->first();//IMAGEN DE USUARIO
$sistema      = \DB::table('configuracion')->where('id', 1)->first();//CONFIGURACION DEL SISTEMA
$u_pendientes = \DB::table('users')->where('status', 2)->count();//CANTIDAD DE USUARIOS PENDIENTES
$f_c_pen =      \DB::table('posprocesos')->where('status', 1)->where('tipo_proceso', 'compra')->count();//C.PENDIENTES
$f_v_pen =      \DB::table('posprocesos')->where('status', 1)->where('tipo_proceso', 'venta')->count();//C.PENDIENTES
$usuario_id   = Session::get("usuario_id");//ID DEL USUARIO EN LA SESSIOn

//Cambiar idioma
\App::setLocale($sistema->idioma);

?>
<!DOCTYPE html>
<html>
     <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Inventario POO">
        <meta name="author" content="Oswaldo Gerardino">

        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!-- App favicon -->
        @if($sistema->logo)
            <link rel="shortcut icon" href="{{ url('storage/img_sistema/'.$sistema->logo) }}">
        @else
            <link rel="shortcut icon" href="{{ url('storage/img_sistema/default_logo.jpg') }}">
        @endif
        <!-- App title -->
        <title>@yield('title')</title>

        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="{{ url('Back/assets/plugins/morris/morris.css') }}">

        <!--Jquery UI-->
        <link rel="stylesheet" href="{{ url('Back/assets/css/jquery-ui.css') }}">

        <!-- Plugins css-->
        <link href="{{ url('Back/assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet" />
        <link href="{{ url('Back/assets/plugins/multiselect/css/multi-select.css') }}"  rel="stylesheet" type="text/css" />
        <link href="{{ url('Back/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('Back/assets/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" />
        <link href="{{ url('Back/assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />

        <!-- App css -->
        <link href="{{ url('Back/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('Back/assets/css/core.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('Back/assets/css/components.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('Back/assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('Back/assets/css/pages.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('Back/assets/css/menu.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('Back/assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ url('Back/assets/plugins/switchery/switchery.min.css') }}">


        <!-- DataTables -->
        <link href="{{ url('Back/assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('Back/assets/plugins/datatables/buttons.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('Back/assets/plugins/datatables/fixedHeader.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('Back/assets/plugins/datatables/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('Back/assets/plugins/datatables/scroller.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('Back/assets/plugins/datatables/dataTables.colVis.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('Back/assets/plugins/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('Back/assets/plugins/datatables/fixedColumns.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>

        <script src="{{ url('Back/assets/js/modernizr.min.js') }}"></script>

        <!--Estilos Custom-->
        <link href="{{ url('Back/assets/css/estilos.css') }}" rel="stylesheet" type="text/css" />

        <!--Estilos Factura y Reportes-->
        <link href="{{ url('Back/assets/css/estilos_factura.css') }}" rel="stylesheet" type="text/css" />

    </head>
    <body class="fixed-left">
        <!-- Begin page -->
        <div id="wrapper">
            @include('Back.header')

                @yield('content')
            
            @include('Back.footer')
        </div>

        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="{{ url('Back/assets/js/jquery.min.js') }}"></script>
        <script src="{{ url('Back/assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ url('Back/assets/js/detect.js') }}"></script>
        <script src="{{ url('Back/assets/js/fastclick.js') }}"></script>
        <script src="{{ url('Back/assets/js/jquery.blockUI.js') }}"></script>
        <script src="{{ url('Back/assets/js/waves.js') }}"></script>
        <script src="{{ url('Back/assets/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ url('Back/assets/js/jquery.scrollTo.min.js') }}"></script>
        <script src="{{ url('Back/assets/plugins/switchery/switchery.min.js') }}"></script>

        <!-- Counter js  -->
        <script src=".{{ url('Back/assets/plugins/waypoints/jquery.waypoints.min.js') }}"></script>
        <script src=".{{ url('Back/assets/plugins/counterup/jquery.counterup.min.js') }}"></script>

        <!--Morris Chart-->
        <script src="{{ url('Back/assets/plugins/morris/morris.min.js') }}"></script>
        <script src="{{ url('Back/assets/plugins/raphael/raphael-min.js') }}"></script>

        <!-- Dashboard init -->
        <script src="{{ url('Back/assets/pages/jquery.dashboard.js') }}"></script>

        <!-- App js -->
        <script src="{{ url('Back/assets/js/jquery.core.js') }}"></script>
        <script src="{{ url('Back/assets/js/jquery.app.js') }}"></script>

        <script src="{{ url('Back/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ url('Back/assets/plugins/datatables/dataTables.bootstrap.js') }}"></script>

        <script src="{{ url('Back/assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
        <script src="{{ url('Back/assets/plugins/datatables/buttons.bootstrap.min.js') }}"></script>
        <script src="{{ url('Back/assets/plugins/datatables/jszip.min.js') }}"></script>
        <script src="{{ url('Back/assets/plugins/datatables/pdfmake.min.js') }}"></script>
        <script src="{{ url('Back/assets/plugins/datatables/vfs_fonts.js') }}"></script>
        <script src="{{ url('Back/assets/plugins/datatables/buttons.html5.min.js') }}"></script>
        <script src="{{ url('Back/assets/plugins/datatables/buttons.print.min.js') }}"></script>
        <script src="{{ url('Back/assets/plugins/datatables/dataTables.fixedHeader.min.js') }}"></script>
        <script src="{{ url('Back/assets/plugins/datatables/dataTables.keyTable.min.js') }}"></script>
        <script src="{{ url('Back/assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
        <script src="{{ url('Back/assets/plugins/datatables/responsive.bootstrap.min.js') }}"></script>
        <script src="{{ url('Back/assets/plugins/datatables/dataTables.scroller.min.js') }}"></script>
        <script src="{{ url('Back/assets/plugins/datatables/dataTables.colVis.js') }}"></script>
        <script src="{{ url('Back/assets/plugins/datatables/dataTables.fixedColumns.min.js') }}"></script>

        <!--Plugins extras-->

        <script src="{{ url('Back/assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js') }}"></script>
        <script src="{{ url('Back/assets/plugins/multiselect/js/jquery.multi-select.js') }}"></script>
        <script src="{{ url('Back/assets/plugins/jquery-quicksearch/jquery.quicksearch.js') }}"></script>
        <script src="{{ url('Back/assets/plugins/select2/js/select2.min.js') }}"></script>
        <script src="{{ url('Back/assets/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
        <script src="{{ url('Back/assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}"></script>
        <script src="{{ url('Back/assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js') }}"></script>
        <script src="{{ url('Back/assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>

        <!-- init -->
        <script src="{{ url('Back/assets/pages/jquery.datatables.init.js') }}"></script>
        
        <!--Datepicker-->
        <script type="text/javascript" src="{{ url('Back/assets/js/jquery-ui.js') }}"></script>

         <script>
            var resizefunc = [];
         </script>
        <!--
        ************************************************************************************
        ************************************************************************************
                                   _____           _       _       
                                  / ____|         (_)     | |      
                                 | (___   ___ _ __ _ _ __ | |_ ___ 
                                  \___ \ / __| '__| | '_ \| __/ __|
                                  ____) | (__| |  | | |_) | |_\__ \
                                 |_____/ \___|_|  |_| .__/ \__|___/
                                                    | |            
                                                    |_|

        Descripción: Códigos RAMDOM para la funcionalidad general del sistema.         
        ************************************************************************************
        ************************************************************************************
        -->
        
        <!--Date picker de la modal de reporte de venta-->
        <script type="text/javascript">
          $( function() {
            $( "#modal_reporte_venta_inicio, #modal_reporte_venta_final, #modal_reporte_compra_inicio, #modal_reporte_compra_final, #modal_reporte_gasto_inicio, #modal_reporte_gasto_final, #fecha_gasto" ).datepicker({
                dateFormat: "yy-mm-dd",
                dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
                

            });
          });
        </script>

        <script>
            $(document).ready(function () {
                $('#datatable').dataTable({
                    
                    "language": {
                        "sProcessing":    "@lang('idioma.dat_procesa')...",
                        "sLengthMenu":    "@lang('idioma.dat_menu')",
                        "sZeroRecords":   "@lang('idioma.dat_record')",
                        "sEmptyTable":    "@lang('idioma.dat_emp_table')",
                        "sInfo":          "@lang('idioma.dat_info')",
                        "sInfoEmpty":     "@lang('idioma.dat_in_empty')",
                        "sInfoFiltered":  "@lang('idioma.dat_filtered')",
                        "sInfoPostFix":   "",
                        "sSearch":        "@lang('idioma.dat_buscar'):",
                        "sUrl":           "",
                        "sInfoThousands":  ",",
                        "sLoadingRecords": "@lang('idioma.dat_cargando')...",
                        "oPaginate": {
                            "sFirst":    "@lang('idioma.dat_ultimo')",
                            "sLast":    "@lang('idioma.dat_first')",
                            "sNext":    "@lang('idioma.dat_siguiente')",
                            "sPrevious": "@lang('idioma.dat_anterior')"
                        },
                        "oAria": {
                            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    }
                });
                $('#datatable-keytable').DataTable({keys: true});
                $('#datatable-responsive').DataTable();
                $('#datatable-colvid').DataTable({
                    "dom": 'C<"clear">lfrtip',
                    "colVis": {
                        "buttonText": "Change columns"
                    },
                });
            });
            TableManageButtons.init();

        </script>

        <!--Evitar introducir letras-->
        <script type="text/javascript">
            function controltag(e) {
                tecla = (document.all) ? e.keyCode : e.which; 
                if (tecla==8) return true; // para la tecla de retroseso
                else if (tecla==0||tecla==9)  return true; //<-- PARA EL TABULADOR-> su keyCode es 9 pero en tecla se esta transformando a 0 asi que porsiacaso los dos
                patron =/[0-9\s]/;// -> solo numeros
                te = String.fromCharCode(tecla);
                return patron.test(te); 
            }
        </script>
        <!--
        ************************************************************************************
        ************************************************************************************
                             
                      ______ _             _    _____           _       _       
                     |  ____(_)           | |  / ____|         (_)     | |      
                     | |__   _ _ __   __ _| | | (___   ___ _ __ _ _ __ | |_ ___ 
                     |  __| | | '_ \ / _` | |  \___ \ / __| '__| | '_ \| __/ __|
                     | |    | | | | | (_| | |  ____) | (__| |  | | |_) | |_\__ \
                     |_|    |_|_| |_|\__,_|_| |_____/ \___|_|  |_| .__/ \__|___/
                                                                 | |            
                                                                 |_|            

        ************************************************************************************
        ************************************************************************************
        -->


        <!--
        ************************************************************************************
        ************************************************************************************       
                                               _                
                                         /\   (_)               
                                        /  \   _  __ ___  _____ 
                                       / /\ \ | |/ _` \ \/ / __|
                                      / ____ \| | (_| |>  <\__ \
                                     /_/    \_\ |\__,_/_/\_\___/
                                             _/ |               
                                            |__/                
      
        Descripción: Funciones ajax del sistema.
        ************************************************************************************
        ************************************************************************************
        -->

        <!--MODULO PRODUCTOS: CATEGORIA Y SUBCATEGORIA AUTOLOAD-->
        
        <!--AJAX VERIFICACION DE DATOS REGISTRO DE PRODUCTO-->
        <script type="text/javascript">

            $(document).ready(function() {

                $('#categoria_cargar').change(function (e) {

                    e.preventDefault();
                    var categoria = $( "select#categoria_cargar option:selected" ).val();
                    var token     = $('input[name=_token]').val();

                    $.ajax({

                        type: 'POST',
                        url: "{{url('/cargar_subcategoria')}}",
                        data: {
                            '_token'        : token,
                            'categoria'     : categoria,
                        },

                        beforeSend: function(){
                           
                            $('#subcategoria_cargar').empty();//VARIAR LOS ELEMENTOS
                        },
                        success: function(data) {

                            var  opts = $.parseJSON(data);
                            // Use jQuery's each to iterate over the opts value
                            
                            if(opts.length > 0){
                                $.each(opts, function(i, d) {
                                    $('#subcategoria_cargar').append('<option value="' + d.id + '">' + d.nombre + '</option>');
                                });
                            }else{
                                    $('#subcategoria_cargar').append('<option value="">No hay Datos</option>');//LLENAR CON NUEVAS OPCIONES
                            }

                        },
                        complete:function(data){
                            // Hide image container
                            //$("#loader-4").fadeOut("slow");
                        }

                    });

                });

            });

        </script>

         <!--AJAX VERIFICACION DE DATOS EDICION DE PRODUCTO-->
        <script type="text/javascript">

            $(document).ready(function() {

                $('#categoria_cargar2').change(function (e) {

                    e.preventDefault();
                    var categoria         = $( "select#categoria_cargar2 option:selected" ).val();
                    var subcatego_id_ajax = $('#subcatego_id_ajax').val();
                    var token     = $('input[name=_token]').val();
                    
                    $.ajax({

                        type: 'POST',
                        url: "{{url('/cargar_subcategoria2')}}",
                        data: {
                            '_token'           : token,
                            'categoria'        : categoria,
                            'subcatego_id_ajax': subcatego_id_ajax,
                        },

                        beforeSend: function(){

                           $('#subcategoria_cargar3').empty();//VACIAR LOS ELEMENTOS
                            
                        },
                        success: function(data) {
                            var  opts = $.parseJSON(data);

                            if(opts.data == ""){

                                    $('#subcategoria_cargar4').empty();//VACIAR LOS ELEMENTOS
                                    $('#subcategoria_cargar2').css('display', 'none');
                                    $('#subcategoria_cargar3').css('display', 'none');
                                    $('#subcategoria_cargar4').css('display', '');
                                    $('#subcategoria_cargar4').attr('required','required');
                                    $('#subcategoria_cargar4').append('<option value="">No hay Datos</option>');//LLENAR CON NUEVAS OPCIONES

                            }else{
                                    $('#subcategoria_cargar2').css('display', 'none');
                                    $('#subcategoria_cargar4').css('display', 'none');
                                    $('#subcategoria_cargar3').css('display', '');
                                    $('#subcategoria_cargar4').removeAttr('required');

                                    $.each(opts.data, function(i, d) {
                                        $('#subcategoria_cargar3').append('<option value="' + d.id + '">' + d.nombre + '</option>');
                                    });

                                    
                            }

                        },
                        complete:function(data){
                            // Hide image container
                            //$("#loader-4").fadeOut("slow");
                        }

                    });

                });

            });

        </script>
        <!--
            *******************************************************************
            *******************************************************************
                                    REPORTE: VENTAS
            *******************************************************************
            *******************************************************************
        -->

        

            <!--Carga de datos para la modal de reporte de ventas-->
            <script type="text/javascript">

            $(document).ready(function() {

                //Boton modal reporte ventas
                $('#btn_modal_reporte_ventas').click(function (e) {

                    $('#modal_reporte_ventas').modal({
                        show: 'true'
                    });           

                });

            });//Final funcion ready

            </script>

        <!--
            *******************************************************************
            *******************************************************************
                                  FINAL REPORTE: VENTAS
            *******************************************************************
            *******************************************************************
        -->


        <!--
            *******************************************************************
            *******************************************************************
                                    REPORTE: COMPRAS
            *******************************************************************
            *******************************************************************
        -->

            <!--Carga de datos para la modal de reporte de compras-->
            <script type="text/javascript">

            $(document).ready(function() {

                //Boton modal reporte compras
                $('#btn_modal_reporte_compras').click(function (e) {

                    $('#modal_reporte_compras').modal({
                        show: 'true'
                    });           

                });

            });//Final funcion ready

            </script>

        <!--
            *******************************************************************
            *******************************************************************
                                  FINAL REPORTE: COMPRAS
            *******************************************************************
            *******************************************************************
        -->

        <!--
            *******************************************************************
            *******************************************************************
                                    REPORTE: GASTOS
            *******************************************************************
            *******************************************************************
        -->

            <!--Carga de datos para la modal de reporte de vengastostas-->
            <script type="text/javascript">

            $(document).ready(function() {

                //Boton modal reporte gastos
                $('#btn_modal_reporte_gastos').click(function (e) {

                    $('#modal_reporte_gastos').modal({
                        show: 'true'
                    });           

                });

            });

            </script>

        <!--
            *******************************************************************
            *******************************************************************
                                  FINAL REPORTE: GASTOS
            *******************************************************************
            *******************************************************************
        -->

    

        <!--
        ************************************************************************************
        ************************************************************************************                          
                          ______ _             _            _            
                         |  ____(_)           | |     /\   (_)           
                         | |__   _ _ __   __ _| |    /  \   _  __ ___  __
                         |  __| | | '_ \ / _` | |   / /\ \ | |/ _` \ \/ /
                         | |    | | | | | (_| | |  / ____ \| | (_| |>  < 
                         |_|    |_|_| |_|\__,_|_| /_/    \_\ |\__,_/_/\_\
                                                          _/ |           
                                                         |__/           
        ************************************************************************************
        ************************************************************************************
        -->

    </body>
</html>
