@extends('main_template')

@section('handsontable')
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
        <div class="inner">
            <!-- START BREADCRUMB -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                <li class="breadcrumb-item active">Eficiencia del taller</li>
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
                            <h3>Eficiencia del taller</h3>
                            <p>En este modulo podrá consultar el reporte de la eficiencia del taller</p>
                            <p class="small hint-text m-t-5">Seleccione el tipo de taller, el mes y el año a consultar</p>
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
        <div class="col-lg-12">
                        <!-- START card -->
          <div class="card card-default">
            <form method="post" onsubmit="" action="">
              <input type="hidden" name="_token" value="0LGnesXNN31RXyhlZJYzofDoncQe4tbQcrKNyhOX">
            <div class="card-header ">
              <div class="card-title">
                <h5>Reportes de eficiencia del taller</h5>
              </div>
            </div><br>
            <div class="card-body">
            <div class="row">
              <br>
              <div class="col-lg-3">
                <p class="col-sm-5">TALLERES</p>
                <select class="full-width" data-init-plugin="select2" name="cmbTaller" id="cmbTaller">
                    <option value="0">SELECCIONE TALLER</option>
                  @foreach($Taller as $T)
                    <option value="{{$T->TALLER_ID}}">{{$T->NOMBRE}}</option>
                @endforeach
                </select>
              </div>
              <div class="col-lg-3">
                <p class="col-sm-5">MES</p>
                <select class="full-width" data-init-plugin="select2" name="cmbMes" id="cmbMes">
                    <option value="0">SELECCIONE MES</option>
                    <option value="1">ENERO</option>
                    <option value="2">FEBRERO</option>
                    <option value="3">MARZO</option>
                    <option value="4">ABRIL</option>
                    <option value="5">MAYO</option>
                    <option value="6">JUNIO</option>
                    <option value="7">JULIO</option>
                    <option value="8">AGOSTO</option>
                    <option value="9">SEPTIEMBRE</option>
                    <option value="10">OCTUBRE</option>
                    <option value="11">NOVIEMBRE</option>
                    <option value="12">DICIEMBRE</option>
                </select>
              </div>
              <div class="col-lg-3">
                <p class="col-sm-5">AÑO</p>
                <select class="full-width" data-init-plugin="select2" name="cmbAnio" id="cmbAnio">
                    <option value="2019">SELECCIONE AÑO</option>

                    <option value=""></option>

                </select>
              </div>
              <div class="col-lg-3">
                <p class="col-sm-5 p-l-1"></p>
                    <button class="btn btn-primary ladda-button" data-style="expand-left" data-enviar="false"
                    id="btnVerRpt" name="btnVerRpt" type="button" onclick="RptEficienciaTaller(cmbTaller.value,cmbMes.value,cmbAnio.value);">Ver Reporte</button>
              </div>
              <br>
            </div>
          </div>
        </form>
      </div>
        <!-- END card -->
    </div>
  </div>

<div>
  <script src="{{asset('js/Estadisticas.js')}}"></script>
  <script src="{{asset('js/Funciones_Basicas.js')}}"></script>
  <script src="{{asset('js/Global.js?v=3')}}"></script>
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
    <script src="{{asset('assets/js/form_elements.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $("#txtFecha").datepicker();
        $("#txtFecha2").datepicker();
      })
    </script>

@stop
