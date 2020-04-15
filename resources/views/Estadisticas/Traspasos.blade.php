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
      {{csrf_field()}}

        <div class="inner">
            <!-- START BREADCRUMB -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                <li class="breadcrumb-item active">Traspasos</li>
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
                            <h3>Traspaso de productos</h3>
                            <p>En este modulo podrá consultar el historial de traspasos de productos</p>
                            <p class="small hint-text m-t-5">Elija un rango de fecha a consultar</p>
                        </div>
                        <!-- END card -->
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
    <!-- END JUMBOTRON -->
    <div class="col-lg-12">
                    <!-- START card -->
      <div class="card card-default">
        <div class="card-header ">
          <div class="card-title">
            <h5>Reportes de traspasos</h5>
          </div>
        </div>
        <div class="card-body">
        <div class="row">
          <div class="col-lg-4">
            <p class="col-sm-5">Fecha desde:</p>
            <div class="input-group date col-md-10 p-l-0">
              <input type="text" class="form-control" id="txtFecha"  name="txtFecha" value="{{date('d/m/Y')}}">
              <div class="input-group-append ">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <p class="col-sm-5">Fecha hasta:</p>
            <div class="input-group date col-md-10 p-l-0">
              <input type="text" class="form-control" id="txtFecha2"  name="txtFecha2" value="{{date('d/m/Y')}}">
              <div class="input-group-append ">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <p class="col-sm-5 p-l-0"></p>
                <button class="btn btn-primary ladda-button" data-style="expand-left" data-enviar="false"
                id="btnVerRpt" name="btnVerRpt" type="button" onclick="ReportTraspasos(txtFecha.value,txtFecha2.value);">Ver Reporte</button>
          </div>
          <br>
        </div>
      </div>
    </div>
    <!-- END card -->
  </div>
</div>

    <div>
      <script src="{{asset('js/Funciones_Basicas.js')}}"></script>
      <script src="{{asset('js/Estadisticas.js?version=2')}}"></script>
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
