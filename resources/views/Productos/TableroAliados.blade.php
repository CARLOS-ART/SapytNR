@extends('main_template')


@section('handsontable')
<link href="{{asset('assets/plugins/jquery-datatable/media/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
   <link href="{{asset('assets/plugins/jquery-datatable/extensions/FixedColumns/css/dataTables.fixedColumns.min.css')}}" rel="stylesheet" type="text/css" />
   <link href="{{asset('assets/plugins/datatables-responsive/css/datatables.responsive.css')}}" rel="stylesheet" type="text/css" media="screen" />
   <link href="{{asset('pages/css/pages-icons.css')}}" rel="stylesheet" type="text/css">
   <link class="main-stylesheet" href="{{asset('pages/css/themes/light.css')}}" rel="stylesheet" type="text/css" />


@stop

@section('WorkArea')
<br><br>
<!-- START JUMBOTRON -->
          <div class="jumbotron" data-pages="parallax">
            <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
              <div class="inner">
                <!-- START BREADCRUMB -->
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                  <li class="breadcrumb-item active">Aliados y complementos</li>
                </ol>
                <!-- END BREADCRUMB -->
                <div class="row">
                  <div class="col-xl-7 col-lg-6 ">
                    <!-- START card -->
                    <div class="full-height">
                      <div class="card-body text-center">
                        <img class="image-responsive-height demo-mw-600" src="{{asset('assets/img/auditoria/auditoria.png')}}" alt="">
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
                        <h3>Aliados y complementos</h3>
                        <p>En este modulo podrá añadir productos adicionales a su inventario</p>
                        <p class="small hint-text m-t-5">Haga click en el boton para agregar productos</p>
                        <br>
                        <button class="btn btn-success btn-lg pull-left" onclick="window.location.href='/Productos/FormatoAliados'">Añadir aliados</button>
                      </div>
                    </div>
                    <!-- END card -->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END JUMBOTRON -->
          {{csrf_field()}}
<div class=" container-fluid   container-fixed-lg bg-white">
  <div class="card card-transparent">
    <div class="element-box">
          <div class="card-header ">
            <div class="card-title">Historial de Auditorias
            </div>
            <div class="pull-right">
              <div class="col-xs-12">
                <input type="text" id="search-table" class="form-control pull-right" placeholder="Search">
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="card-body">
            <table class="table table-hover demo-table-search table-responsive-block" id="tableWithSearch">
              <thead>
                <tr>
                  <th>TALLER:</th>
                  <th>FECHA:</th>
                  <th>REALIZADO POR:</th>
                  <th>NUMERO PROD. SOLIC</th>
                  <th>ESTATUS</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($Historico as $H)
                <tr>
                  <td class="v-align-middle semi-bold sorting_1"><p>{{$H->TALLER}}</p></td>
                  <td class="v-align-middle">{{date('d/m/Y',strtotime($H->FECHA))}}</td>
                  <td class="v-align-middle"><p>{{$H->NOMBRE}}</p></td>
                  <td class="v-align-middle"><p>{{$H->ITEMS}}</p></td>
                  @if($H->ESTATUS_ID == 1)
                    <td><span class="label label-inverse">{{$H->ESTATUS}}</span></td>
                  @elseif($H->ESTATUS_ID == 2)
                    <td><span class="label label-warning">{{$H->ESTATUS}}</span></td>
                  @elseif($H->ESTATUS_ID == 3)
                    <td><span class="label label-important">{{$H->ESTATUS}}</span></td>
                  @else
                    <td>{{N/A}}</td>
                  @endif

                  @if($H->ESTATUS_ID == 1)
                    <td><div class="dropdown dropdown-default">
                        <button class="btn dropdown-toggle text-center" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Opciones
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="#" onclick="ReportAliados(2,{{$H->SOLICITUD_ID}});">
                            Ver Resultados
                          </a>
                        </div>
                      </div>
                    </td>
                  @elseif($H->ESTATUS_ID == 2)
                    <td>  <div class="dropdown dropdown-default">
                          <button class="btn dropdown-toggle text-center" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Opcipones
                          </button>
                          <div class="dropdown-menu">
                             <a class="dropdown-item" href="#" onclick="EditarFormato({{$H->SOLICITUD_ID}})">
                                   Continuar
                             </a>
                             <a class="dropdown-item" href="#" onclick="CancelarAuditoria({{$H->SOLICITUD_ID}});">
                                   Cancelar
                             </a>
                          </div>
                        </div></td>
                  @elseif($H->ESTATUS_ID == 3)
                    <td></td>
                  @else
                    <td>{{N/A}}</td>
                  @endif
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

          <div>


            <script src="{{asset('js/Funciones_Basicas.js')}}"></script>
            <script src="{{asset('js/Productos.Aliados.Tablero.js?v=1')}}"></script>

          </div>
@stop

@section('js')

<script src="{{asset('assets/plugins/jquery-datatable/media/js/jquery.dataTables.min.js')}}" type="text/javascript"></script>
 <script src="{{asset('assets/plugins/jquery-datatable/extensions/TableTools/js/dataTables.tableTools.min.js')}}" type="text/javascript"></script>
 <script src="{{asset('assets/plugins/jquery-datatable/media/js/dataTables.bootstrap.js')}}" type="text/javascript"></script>
 <script src="{{asset('assets/plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js')}}" type="text/javascript"></script>
 <script type="text/javascript" src="{{asset('assets/plugins/datatables-responsive/js/datatables.responsive.js')}}"></script>
 <script type="text/javascript" src="{{asset('assets/plugins/datatables-responsive/js/lodash.min.js')}}"></script>

 <script src="pages/js/pages.js"></script>
 <!-- END CORE TEMPLATE JS -->
 <!-- BEGIN PAGE LEVEL JS -->
 <script src="{{asset('assets/js/scripts.js')}}" type="text/javascript"></script>
 <!-- END PAGE LEVEL JS -->
 <!-- END CORE TEMPLATE JS -->
 <!-- BEGIN PAGE LEVEL JS -->
 <script src="{{asset('assets/js/datatables.js')}}" type="text/javascript"></script>
 <script src="{{asset('assets/js/scripts.js')}}" type="text/javascript"></script>


@stop
