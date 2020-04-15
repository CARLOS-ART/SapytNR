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
                    <li class="breadcrumb-item active">Alta de distribuidores</li>
                </ol>
                <!-- END BREADCRUMB -->
                <div class="row">
                    <div class="col-xl-7 col-lg-6 ">
                        <!-- START card -->
                        <div class="full-height">
                            <div class="card-body text-center">
                                <img class="image-responsive-height demo-mw-600" src="{{asset('assets/img/productos/compras.png')}}" alt="">
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
                                <h3>Alta de distribuidores</h3>
                                <p>En este modulo podrá dar de alta a los distribuidores</p>
                                <p class="small hint-text m-t-5">Por favor proporcione los datos requeridos para realizar el alta</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END JUMBOTRON -->
    <!-- END card -->
    {{csrf_field()}}
    <form class="" role="form">
        <div class=" ">
            <label>NOMBRE COMERCIAL</label>
        </div>
        <div class="form-group form-group-default required col-md-6">
            <input type="text" class="form-control" required placeholder="Ingrese nombre comercial del distribuidor" name="txtNombre" id="txtNombre">
        </div>
        <div class="">
            <label>RAZON SOCIAL</label>
        </div>
        <div class="form-group form-group-default required col-md-6">
            <input type="text" class="form-control" required placeholder="Ingrese razon social" name="txtRSocial" id="txtRSocial">
        </div>
        <div class="">
            <label>FECHA DE ALTA</label>
        </div>
        <div class="form-group form-group-default required col-md-6">
            <input type="text" class="form-control" id="txtFecha" name="txtFecha" value=" {{date('d/m/Y')}}" readonly>
        </div>
        <br>
        <div class="col-md-4">
            <button class="btn btn-primary" type="button" onclick="GuardarDistribuidor();">Ver compras</button>
        </div>
    </form>
    <br>
</div>
<div>
    <script src="{{asset('js/Funciones_Basicas.js')}}"></script>
    <script src="{{asset('js/Distribuidores.js?v=1')}}"></script>
    <script src="{{asset('js/Global.js?v=3')}}"></script>
</div>
@stop @section('js')
<script src="{{asset('pages/js/pages.js')}}"></script>
<script src="{{asset('assets/js/notifications.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/scripts.js')}}" type="text/javascript"></script>
@stop
