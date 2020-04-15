
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
                <li class="breadcrumb-item active">Envio de productos</li>
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
                            <h3>Envio de productos</h3>
                            <p>En este modulo podrá consultar los envios de taller a taller que ha realizado</p>
                            <p class="small hint-text m-t-5">Haga clic en Ver Reporte</p>
                        </div>
                        <!-- END card -->



                    </div>
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
            <div class="card-title">Reportes de tranferencias de productos
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
                  <th>REALIZADO POR:</th>
                  <th>FECHA:</th>
                </tr>
              </thead>
              <tbody>
                @foreach($Report as $R)
                <tr value="{{$R->TRANSFERENCIA_ID}}" id="TREnvioProd">
                  <td class="v-align-middle semi-bold sorting_1"><p>{{$R->NOMBRE}}</p></td>
                  <td class="v-align-middle">{{date('d/m/Y',strtotime($R->FECHA))}}</td>
                  <td><button class="btn btn-primary ladda-button btn-sm" value="{{$R->TRANSFERENCIA_ID}}"  id="btnVerRpt1" name="btnVerRpt1" type="button"
                       onclick="ReportEnvioProd({{$R->TRANSFERENCIA_ID}});">Ver Reporte</button></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>


  <div>
    <script type="text/javascript" src="{{asset('js/Estadisticas.js')}}"></script>
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
