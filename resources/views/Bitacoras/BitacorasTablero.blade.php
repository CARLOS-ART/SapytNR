@extends('main_template')

@section('handsontable')
<link href="{{asset('assets/plugins/jquery-datatable/media/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/plugins/jquery-datatable/extensions/FixedColumns/css/dataTables.fixedColumns.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css')}}" rel="stylesheet" type="text/css" media="screen">
<link href="{{asset('assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css')}}" rel="stylesheet" type="text/css" media="screen">
<link href="{{asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" media="screen">
<link href="{{asset('pages/css/pages-icons.css')}}" rel="stylesheet" type="text/css">

@stop
  @section('WorkArea')
<div class="content">
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
                                  <div class="card-title">Iniciar
                                  </div>
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
          <input type="text" class="form-control" name="txtFecha" id="txtFecha" value="" type="text" autocomplete="off">
          <div class="input-group-append ">
              <span class="input-group-text"><i class="fa fa-calendar"></i></span>
          </div>
      </div>
      <div class="input-group date col-md-6 p-l-0">
          <input type="text" class="form-control" name="txtFecha2" id="txtFecha2" value="" type="text" autocomplete="off">
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


</div>




@stop
@section('js')
<script type="text/javascript" src="{{asset('js/Bitacoras.Tablero.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/summernote/js/summernote.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-typehead/typeahead.bundle.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-typehead/typeahead.jquery.min.js')}}"></script>
<script src="{{asset('assets/plugins/handlebars/handlebars-v4.0.5.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#txtFecha").datepicker();
    $("#txtFecha2").datepicker();
  })
</script>
@stop
