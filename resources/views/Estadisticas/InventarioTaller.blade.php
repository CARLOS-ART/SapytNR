
@extends('main_template')


@section('WorkArea')
<div class="content">

<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
            <!-- START BREADCRUMB -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                <li class="breadcrumb-item active">Inventario</li>
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
                            <h3>Inventario</h3>
                            <p>En este modulo podrá consultar el inventario disponible en almacen (bote sellado), y laboratorio (bote abierto)</p>
                            <p class="small hint-text m-t-5">haga clic en alguno de los botones para consultar</p>
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
<br>
    <div class="col-lg-12">
                    <!-- START card -->
      <div class="card card-default">
        <div class="card-header ">
          <div class="card-title">Elija Tipo reporte:
          </div>
        </div>
        <div class="card-body">
        <div class="row">
          <br>
          <div class="col-lg-6">
            <button class="btn btn-block btn-primary" type="button" onclick="ReportViewer(7);">
                <span class="bold">Almacén</span>
              </button>
          </div>
          <div class="col-lg-6">
            <button class="btn btn-block btn-danger" type="button" onclick="ReportViewer(8);">
              <span class="bold">Laboratorio</span>
            </button>
          </div>
          <br>
        </div>
      </div>
    </div>
    <!-- END card -->
  </div>
</div>

<div>
    <link href="{{asset('js/loading.css')}}" rel="stylesheet">
    <script src="{{asset('js/loading.js')}}"></script>
    <script src="{{asset('js/InventarioIni.js?v=3')}}"></script>
    <script src="{{asset('js/Funciones_Basicas.js')}}"></script>
    <script src="{{asset('js/Global.js?v=3')}}"></script>

</div>
@stop
