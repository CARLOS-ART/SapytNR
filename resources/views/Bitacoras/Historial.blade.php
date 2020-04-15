@extends('main_template')

@section('handsontable')
<link href="{{asset('assets/plugins/jquery-datatable/media/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/plugins/jquery-datatable/extensions/FixedColumns/css/dataTables.fixedColumns.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/plugins/datatables-responsive/css/datatables.responsive.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('pages/css/pages-icons.css')}}" rel="stylesheet" type="text/css">
<link class="main-stylesheet" href="{{asset('pages/css/themes/light.css')}}" rel="stylesheet" type="text/css" />
@stop
  @section('WorkArea')
<div class="content">
  <!-- START JUMBOTRON -->

      <div class="jumbotron" data-pages="parallax">
          <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
              <div class="inner">
                  <!-- START BREADCRUMB -->
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                      <li class="breadcrumb-item active">Historial de Bitácoras</li>
                  </ol>
                  <!-- END BREADCRUMB -->
                  <div class="row">
                      <div class="col-xl-7 col-lg-6 ">
                          <!-- START card -->
                          <div class="full-height">
                              <div class="card-body text-center">
                                  <img class="image-responsive-height demo-mw-600" src="{{asset('assets/img/bitacoras/bitacoras.png')}}" alt="">
                              </div>
                          </div>
                          <!-- END card -->
                      </div>

                      <div class="col-xl-5 col-lg-6 ">
                          <!-- START card -->
                          <div class="card card-transparent">
                              <div class="card-header ">
                                  <div class="card-title">Iniciar</div>

                              </div>
                              <div class="card-body">
                                  <h3>Historial Bitácoras</h3>
                                  <p>En este modulo podrá consultar el historial de bitácoras realizadas</p>
                                  <p class="small hint-text m-t-5">Elija un rango de fechas que desea consultar</p>
                              </div>
                              <!-- END card -->
<form class="" method="post" action="/Bitacoras/Tablero/Historial">
  {{csrf_field()}}
  <div class="row">
      <div class="input-group date col-md-6 p-l-0">
          <label>FECHA INICIAL</label>
      </div>
      <div class="input-group date col-md-6 p-l-0">
          <label>FECHA FINAL</label>
      </div>
  </div>

  <div class="row">
      <div class="input-group date col-md-6 p-l-0">
          <input type="text" class="form-control" name="txtFecha" id="txtFecha" value="{{$Fe1}}" type="text" autocomplete="off">
          <div class="input-group-append ">
              <span class="input-group-text"><i class="fa fa-calendar"></i></span>
          </div>
      </div>
      <div class="input-group date col-md-6 p-l-0">
          <input type="text" class="form-control" name="txtFecha2" id="txtFecha2" value="{{$Fe2}}" type="text" autocomplete="off">
          <div class="input-group-append ">
              <span class="input-group-text"><i class="fa fa-calendar"></i></span>
          </div>
      </div>
  </div>

  <br>
  <div class="col-md-4">
      <button class="btn btn-primary">Ver bitácoras</button>
  </div>
</form>

                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>

  <!-- END JUMBOTRON -->


  <div class=" container-fluid   container-fixed-lg bg-white">
    <form method="post" onsubmit="" action="">

      <div class="card card-transparent">
          <div class="element-box">
              <div class="card-header ">
                  <div class="card-title">Historial de Bitácora</div>
                  <div class="pull-right">
                      <div class="col-xs-12">
                          <input type="text" id="search-table" class="form-control pull-right" placeholder="Buscar">
                      </div>
                  </div>

                  <div class="clearfix"></div>
              </div>
              <div class="card-body">
                  <table class="table table-hover demo-table-search table-responsive-block" id="tableWithSearch">
                      <thead>
                          <tr>
                              <th>ORDEN:</th>
                              <th>FECHA:</th>
                              <th>VEHICULO</th>
                              <th>PLACAS:</th>
                              <th>ESTATUS</th>
                              <th>OPCIONES</th>
                          </tr>
                      </thead>
                      <tbody>

        @foreach($Buscar as $B)
        <tr>
        <td>{{$B->OT}}</td>
        <td>{{date('d/m/Y',strtotime($B->FECHA))}}</td>
        <td>{{$B->VEHICULO}}</td>
        <td>{{$B->PLACAS}}</td>
        @if($B->ESTATUS_ID == 2)
        <td><span class="label label-warning" id="divEstatus{{$B->BITACORA_ID}}">EN PROCESO</span></td>
        <td>
          <div class="dropdown dropdown-default">
             <button class="btn dropdown-toggle text-center" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             Opciones
             </button>
             <div class="dropdown-menu">
                <a class="dropdown-item" href="/Bitacoras/Tablero/IrBitacora/{{$B->BITACORA_ID}}">Ir a Bitácora</a>
                <a class="dropdown-item" href="#" data-target="#CerrarOT" data-toggle="modal" onclick="MostrarB({{$B->BITACORA_ID}});">Cerrar Bitácora&nbsp;&nbsp;</a>
                <a class="dropdown-item" href="#" onclick="ReportBitacora({{$B->BITACORA_ID}});">Imprimir</a>
                <a class="dropdown-item" href="#" data-target="#CancelarOT" data-toggle="modal" onclick="MostrarBitCancelar({{$B->BITACORA_ID}});">Cancelar OT</a>
             </div>
          </div>
          </td>
        @elseif($B->ESTATUS_ID == 1)
        <td><span class="label label-inverse" id="divEstatus{{$B->BITACORA_ID}}">TERMINADO</span></td>
        <td>
          <div class="dropdown dropdown-default">
             <button class="btn dropdown-toggle text-center" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             Opciones
             </button>
             <div class="dropdown-menu">
                <a class="dropdown-item" href="#" onclick="ReportBitacora({{$B->BITACORA_ID}});">Imprimir</a>
                <a class="dropdown-item" href="#" data-target="#CancelarOT" data-toggle="modal" onclick="MostrarBitCancelar({{$B->BITACORA_ID}});">Cancelar OT</a>
             </div>
          </div>
          </td>
        @else
          <td><span class="label label-important" id="divEstatus{{$B->BITACORA_ID}}">CANCELADO</span></td>
          <td>
            <div class="dropdown dropdown-default">
               <button class="btn dropdown-toggle text-center" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               Opciones
               </button>
               <div class="dropdown-menu">
                  <a class="dropdown-item" href="#" onclick="ReportBitacora({{$B->BITACORA_ID}});">Imprimir</a>
               </div>
            </div>
            </td>
        @endif

        </tr>
        @endforeach

                      </tbody>
                  </table>
              </div>
          </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal -->
<div class="modal fade fill-in" id="CerrarOT" tabindex="-1" role="dialog" aria-hidden="true">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        <i class="pg-close"></i>
    </button>
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">

                <h5>  <span class="semi-bold">¿Esta seguro que desea Cerrar la solicitud y sus Items?</span></h5>
                <h6> Si se encuentra seguro, haga click en "Si, Continuar" , de lo contrario presione "No, Cancelar!"</h6>
            </div><br><br>
            <div class="modal-body">
              <input type="text" name="Bitacora" id="Bitacora" hidden>
              <div class="col-sm-12 text-center">
                <button class="btn btn-complete" id="btnAgregar" name="btnAgregar" type="button" onclick="CerrarBitacora1(Bitacora.value);" data-dismiss="modal">Si, Continuar</button>
                <button class="btn btn-danger" id="cancelar" name="Cancelar" type="button" data-dismiss="modal">No, Cancelar</button>

              </div>
            </div>

        </div>
        <div class="modal-footer">
        </div>
    </div>
    <!-- /.modal-content -->
</div>

<!-- Modal -->
<div class="modal fade fill-in" id="CancelarOT" tabindex="-1" role="dialog" aria-hidden="true">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        <i class="pg-close"></i>
    </button>
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">

                <h5>  <span class="semi-bold">¿Esta seguro que desea Cancelar la solicitud y sus Items?</span></h5>
                <h6> Si se encuentra seguro, haga click en "Si, Continuar" , de lo contrario presione "No, Cancelar!"</h6>
            </div><br><br>
            <div class="modal-body">
              <input type="text" name="Bitacora1" id="Bitacora1" hidden>
              <div class="col-sm-12 text-center">
                <button class="btn btn-complete" id="btnAgregar" name="btnAgregar" type="button" onclick="CancelarBitacora(Bitacora1.value);" data-dismiss="modal">Si, Continuar</button>
                <button class="btn btn-danger" id="cancelar" name="Cancelar" type="button" data-dismiss="modal">No, Cancelar</button>

              </div>
            </div>

        </div>
        <div class="modal-footer">
        </div>
    </div>
    <!-- /.modal-content -->
</div>

<div >
  <script type="text/javascript" src="{{asset('js/Bitacoras.Tablero.js')}}"></script>
  <script src="{{asset('js/Funciones_Basicas.js')}}"></script>
  <script src="{{asset('js/Global.js?v=3')}}"></script>
</div>
@stop


@section('js')
  <script src="{{asset('assets/plugins/jquery-datatable/media/js/jquery.dataTables.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('assets/plugins/jquery-datatable/extensions/TableTools/js/dataTables.tableTools.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('assets/plugins/jquery-datatable/media/js/dataTables.bootstrap.js')}}" type="text/javascript"></script>
  <script src="{{asset('assets/plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js')}}" type="text/javascript"></script>
  <script type="text/javascript" src="{{asset('assets/plugins/datatables-responsive/js/datatables.responsive.js')}}"></script>
  <script type="text/javascript" src="{{asset('assets/plugins/datatables-responsive/js/lodash.min.js')}}"></script>
  <script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}" type="text/javascript"></script>

  <script src="{{asset('assets/js/datatables.js')}}" type="text/javascript"></script>



  <script type="text/javascript">
    $(document).ready(function(){
      $("#txtFecha").datepicker();
      $("#txtFecha2").datepicker();
    })
  </script>
@stop
