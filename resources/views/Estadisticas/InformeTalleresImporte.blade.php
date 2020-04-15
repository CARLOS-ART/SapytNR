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
                <li class="breadcrumb-item active">Informe de importe taller</li>
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
                    {{csrf_field()}}
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
                            <h3>Informe de importe taller</h3>
                        </div>
                        <!-- END card -->
                        <br>
                        <div class="col-md-4">
                            <button class="btn btn-primary" id="btnTColor1" data-reporte="7" onclick="ReportInformeImporte(24);">Ver reporte</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

    <!-- END JUMBOTRON -->
    <div class="">
      <script type="text/javascript" src="{{asset('js/Estadisticas.js')}}"></script>
      <script src="{{asset('js/Funciones_Basicas.js')}}"></script>
      <script src="{{asset('js/Global.js?v=3')}}"></script>
    </div>
@stop
