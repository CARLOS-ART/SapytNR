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
                    <li class="breadcrumb-item active">Inventario Inicial aliados</li>
                  </ol>
                  <!-- END BREADCRUMB -->
                  <div class="row">
                    <div class="col-xl-7 col-lg-6 ">
                      <!-- START card -->
                      <div class="full-height">
                        <div class="card-body text-center">
                          <img class="image-responsive-height demo-mw-600" src="{{asset('assets/img/productos/aliados.png')}}" alt="">
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
                          <h3>Inventario inicial aliados</h3>
                          <p>En este modulo podrá cargar un nuevo inventario de aliados</p>
                          <p class="small hint-text m-t-5">Haga click en el boton para generar inventario</p>
                          <br>
                          <button class="btn btn-primary" onclick="window.location.href='/InventarioInicial/Aliados'"href=""  >Nueva carga de inventario</button>
                        </div>
                      </div>
                      <!-- END card -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- END JUMBOTRON -->{{csrf_field()}}

            <div class=" container-fluid   container-fixed-lg bg-white">

              <div class="card card-transparent">
                <div class="element-box">
                      <div class="card-header ">
                        <div class="card-title">Historial de inventario inicial aliados
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
                              <th class="v-align-middle semi-bold sorting_1">FECHA:</th>
                              <th class="v-align-middle semi-bold sorting_1">TALLER:</th>
                              <th class="v-align-middle semi-bold sorting_1">REALIZADO POR:</th>
                              <th class="v-align-middle semi-bold sorting_1">ESTATUS:</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($Info as $I)
                            <tr>
                              <td class="v-align-middle semi-bold sorting_1">{{date('d/m/Y',strtotime($I->FECHA))}}</td>
                              <td class="v-align-middle "><p>{{$I->TALLER}}</p></td>
                              <td class="v-align-middle "><p>{{$I->USUARIO}}</p></td>
                              @if($I->ESTATUS_ID == 1)
                                <td><span class="label label-inverse ">{{$I->ESTATUS}}</span></td>
                              @elseif($I->ESTATUS_ID == 2)
                                <td><span class="label label-warning">{{$I->ESTATUS}}</span></td>
                              @elseif($I->ESTATUS_ID == 3)
                                <td><span class="label label-important">{{$I->ESTATUS}}</span></td>
                              @else
                                <td>{{N/A}}</td>
                              @endif

                              @if($I->ESTATUS_ID == 1)
                                <td><div class="dropdown dropdown-default">
                                    <button class="btn dropdown-toggle text-center" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Opcipones
                                    </button>
                                    <div class="dropdown-menu">
                                      <a class="dropdown-item" href="#" onclick="ReportInventario(1,{{$I->INVENTARIO_ID}});">
                                        Imprimir
                                      </a>
                                    </div>
                                  </div>
                                </td>
                              @elseif($I->ESTATUS_ID == 2)
                                <td>  <div class="dropdown dropdown-default">
                                      <button class="btn dropdown-toggle text-center" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Opcipones
                                      </button>
                                      <div class="dropdown-menu">
                                         <a class="dropdown-item" href="#" onclick="EditarFormato({{$I->INVENTARIO_ID}})">
                                               Continuar
                                         </a>
                                         <a class="dropdown-item" href="#" onclick="CancelarInventario({{$I->INVENTARIO_ID}});">
                                               Cancelar
                                         </a>
                                         <a class="dropdown-item" href="#" onclick="ReportInventario(1,{{$I->INVENTARIO_ID}});">
                                               Imprimir
                                         </a>
                                      </div>
                                    </div></td>
                              @elseif($I->ESTATUS_ID == 3)
                              <td>  <div class="dropdown dropdown-default">
                                    <button class="btn dropdown-toggle text-center" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Opcipones
                                    </button>
                                    <div class="dropdown-menu">
                                       <a class="dropdown-item" href="#" onclick="ReportInventario(1,{{$I->INVENTARIO_ID}});">
                                             Imprimir
                                       </a>
                                    </div>
                                  </div></td>
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

  <div class="">
    <script src="{{asset('js/Funciones_Basicas.js')}}"></script>
    <script src="{{asset('js/InventarioTablero.js')}}"></script>
    <script src="{{asset('js/Global.js?v=3')}}"></script>
  </div>

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

 <script src="{{asset('assets/js/notifications.js')}}" type="text/javascript"></script>

 <script src="{{asset('assets/js/scripts.js')}}" type="text/javascript"></script>

 <script src="{{asset('assets/js/datatables.js')}}" type="text/javascript"></script>
@stop
