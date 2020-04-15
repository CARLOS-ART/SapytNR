@extends('main_template')

@section('handsontable')
<link href="{{asset('assets/plugins/jquery-datatable/media/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
   <link href="{{asset('assets/plugins/jquery-datatable/extensions/FixedColumns/css/dataTables.fixedColumns.min.css')}}" rel="stylesheet" type="text/css" />
   <link href="{{asset('assets/plugins/datatables-responsive/css/datatables.responsive.css')}}" rel="stylesheet" type="text/css" media="screen" />

<link href="{{asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css')}}" rel="stylesheet" type="text/css" media="screen">
<link href="{{asset('assets/plugins/summernote/css/summernote.css')}}" rel="stylesheet" type="text/css" media="screen">
<link href="{{asset('assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css')}}" rel="stylesheet" type="text/css" media="screen">
<link href="{{asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" media="screen">
<link href="{{asset('pages/css/pages-icons.css')}}" rel="stylesheet" type="text/css">
<link class="main-stylesheet" href="{{asset('pages/css/themes/light.css')}}" rel="stylesheet" type="text/css" />

@stop

@section('WorkArea')
<div class="content">
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
      {{csrf_field()}}
        <div class="inner">
            <!-- START BREADCRUMB -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                <li class="breadcrumb-item active">Soporte SAPYT</li>
            </ol>
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-7 col-lg-6 ">
                    <!-- START card -->
                    <div class="full-height">
                        <div class="card-body text-center">
                            <img class="image-responsive-height demo-mw-600" src="{{asset('assets/img/estadisticas/inventario.png')}}" alt="">
                        </div>
                    </div>
                    <!-- END card -->
                </div>
                <div class="col-xl-5 col-lg-6 ">
                    <!-- START card -->
                    <div class="card card-transparent">
                        <div class="card-header ">
                            <div class="card-title">Iniciar
                            </div>
                        </div>
                        <div class="card-body">
                            <h3>Soporte tecnico</h3>
                            <p></p>
                            <p class="small hint-text m-t-5">Elija un taller, una opción y un rango de fecha para consultar y dar soporte</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>

  <div class="col-lg-12">
                  <!-- START card -->
    <div class="card card-default">
      <div class="card-header ">
        <div class="card-title">
          <h5>Opciones de soporte SAPYT</h5>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <br>
          <div class="col-lg-3">
            <p class="col-sm-5">Talleres</p>
            <select class="full-width" data-init-plugin="select2" id="cmbTaller" name="cmbTaller" onchange="MostrarDTaller(cmbTaller.value)">
              <option value="0">SELECCIONE UN TALLER</option>
              @foreach($Talleres as $T)
                       <option value="{{$T->TALLER_ID}}">{{$T->NOMBRE}}</option>
                       @endforeach
            </select>
          </div>
          <div class="col-lg-3">
            <p class="col-sm-5">Opciones</p>
            <select id="cmbOperacion" name="cmbOperacion" class="full-width" data-init-plugin="select2" onchange="" >
              <option value="1">AUDITORIAS</option>
              <option value="2">BITACORAS</option>
              <option value="3">CAMBIOS DE PRECIOS</option>
              <option value="4">CARGA DE ALIADOS</option>
              <option value="5">COMPRAS</option>
              <option value="6">INVENTARIO INICIAL</option>
              <option value="7">USUARIOS</option>
              <option value="8">ACTIVAR PRODUCTOS</option>
              <option value="9">ESTADISTICAS</option>
            </select>
          </div>
          <div class="col-lg-3">
            <p class="col-sm-4">Fecha 1:</p>
            <div class="input-group date col-md-10 p-l-0">
              <input type="text" class="form-control" id="txtFecha"  name="txtFecha" value="{{date('d/m/Y')}}">
              <div class="input-group-append ">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
              </div>
            </div>
          </div>
          <div class="col-lg-3">
            <p class="col-sm-4">Fecha 2:</p>
            <div class="input-group date col-md-10 p-l-0">
              <input type="text" class="form-control" id="txtFecha2"  name="txtFecha2" value="{{date('d/m/Y')}}">
              <div class="input-group-append ">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
              </div>
            </div>
          </div>
          <div class="col-lg-3">
            <p class="col-sm-5 p-l-0"></p>
                <button class="btn btn-primary ladda-button" data-style="expand-left" data-enviar="false"
                id="btnVerRpt" name="btnVerRpt" type="button" onclick="Tablero(cmbTaller.value, cmbOperacion.value, txtFecha.value, txtFecha2.value)">Ver Reporte</button>
          </div>
        </div>
    </div>
  </div>
  <!-- END card -->
  </div>

        <div class=" container-fluid   container-fixed-lg bg-white">
          <div class="card card-transparent">
            <div class="element-box">
              <div class="row">
                <div class="col-sm-4">
                  <div id="TableroInfoTaller" style="width: 100%">
                  </div>
                </div>
              </div>
              <div id="Tablero"></div>
              <div id="Tablero2"></div>
            </div>
          </div>
        </div>
      </div>
<div>
  <script src="{{asset('js/Funciones_Basicas.js')}}"></script>
  <script src="{{asset('js/Estadisticas.js?version=2')}}"></script>
  <script src="{{asset('js/Global.js?v=3')}}"></script>
  <script src="{{asset('js/Funciones_Basicas.js')}}"></script>
  <script src="{{asset('js/Soporte.js')}}"></script>
  <script src="{{asset('js/Auditorias.Tablero.js')}}"></script>
  <script src="{{asset('js/Bitacoras.Tablero.js')}}"></script>
  <script src="{{asset('js/Compras.Tablero.js')}}"></script>
  <script src="{{asset('js/Productos.Aliados.Tablero.js')}}"></script>
  <script src="{{asset('js/InventarioTablero.js')}}"></script>
</div>
@stop
@section('js')
<script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/summernote/js/summernote.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap-typehead/typeahead.bundle.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap-typehead/typeahead.jquery.min.js')}}"></script>
    <script src="{{asset('assets/plugins/handlebars/handlebars-v4.0.5.js')}}"></script>
    <!-- END VENDOR JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="{{asset('pages/js/pages.js')}}"></script>
    <!-- END CORE TEMPLATE JS -->
    <!-- BEGIN PAGE LEVEL JS -->
    <script src="{{asset('assets/js/scripts.js')}}" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS -->
    <!-- END CORE TEMPLATE JS -->
    <!-- BEGIN PAGE LEVEL JS -->
    <script src="{{asset('assets/js/notifications.js')}}" type="text/javascript"></script>

    <script src="{{asset('assets/js/form_elements.js')}}" type="text/javascript"></script>

    <script src="{{asset('assets/plugins/jquery-datatable/media/js/jquery.dataTables.min.js')}}" type="text/javascript"></script>
     <script src="{{asset('assets/plugins/jquery-datatable/extensions/TableTools/js/dataTables.tableTools.min.js')}}" type="text/javascript"></script>
     <script src="{{asset('assets/plugins/jquery-datatable/media/js/dataTables.bootstrap.js')}}" type="text/javascript"></script>
     <script src="{{asset('assets/plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js')}}" type="text/javascript"></script>
     <script type="text/javascript" src="{{asset('assets/plugins/datatables-responsive/js/datatables.responsive.js')}}"></script>
     <script type="text/javascript" src="{{asset('assets/plugins/datatables-responsive/js/lodash.min.js')}}"></script>
     <script src="{{asset('assets/js/datatables.js')}}" type="text/javascript"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        $("#txtFecha").datepicker();
        $("#txtFecha2").datepicker();
      })
    </script>

    <script type="text/javascript">
      $(document).ready(function(){
        $("#TablaAuditoria").dataTable();
      });
    </script>
    <script type="text/javascript">
      function ActivarBasf(SAP){
        swal({
            title: "¿Esta seguro que desea Activar esta producto?",
            text: 'Si desea activar el producto, haga click en "Si, Activar" , de lo contrario presione "No, Cancelar!"',
            type: "question",
            showCancelButton: true,
            confirmButtonText: "Si, Activar!",
            cancelButtonText: "No, cancelar!",
        }).then(function(isConfirm){
            if (isConfirm) {
              var _token = $('input[name="_token"]').val();

              $.ajax({
                url:'/Productos/ProductosBASF/Activar',
                type:'post',
                data:{_token:_token,SAP:SAP},
                beforeSend:function(){

                },
                success:function(data){
                  swal(data.Titulo,data.Mensaje,data.TMensaje);
                  if (data.TMensaje == 'success'){
                    $("#divEstatus"+SAP).removeClass("yellow").addClass('green');
                    $("#divEstatus"+SAP).data('title',"Terminado");
                    document.getElementById('Activar'+SAP).innerHTML = '';
                  }
                },
                error:function(){
                  swal("Error!","Ha ocurrido un error, no se han realizado la activación del producto","error");
                }
              });
            }
        });
      }
    </script>
@stop
