@if(request()->cookie('Auditoria_ID')==false) {{redirect()->to('/Auditorias/Tablero')->send()}} @endif
@extends('main_template')
@section('handsontable')
<script src="{{asset('jquery.min.js')}}"></script>
<script src="{{asset('jquery.handsontable.full2.js')}}"></script>
<link rel="stylesheet" media="screen" href="{{asset('jquery.handsontable.full.css')}}">
@stop
@section('WorkArea')
<div class="content">
    <!-- START JUMBOTRON -->
    <div class="jumbotron" data-pages="parallax">
        <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
            <div class="inner">
                <!-- START BREADCRUMB -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/Auditorias/Tablero">Auditorias</a></li>
                    <li class="breadcrumb-item active">Auditoría laboratorio</li>
                </ol>
                <!-- END BREADCRUMB -->
                <div class="row">
                    <div class="col-xl-7 col-lg-6 ">
                        <!-- START card -->
                        <div class="full-height">
                            <div class="card-body text-center">
                                <img class="image-responsive-height demo-mw-600" src="{{asset('assets/img/productos/inventarioini.png')}}" alt="">
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
                                <h3>Auditoría laboratorio</h3>
                                <p>En este modulo podrá una auditoría de los productos abierto, ingrese la clave o codigo SAP del prodcuto en el cuadro de busqueda, despues ingrese los gramos de existencia en la celda de la columna "GR FISICO CON TARA"
                                    <br>al finalizar haga click en el botón "Terminar y Guardar" que se encuentra en la parte inferior de la tabla</p>
                                <p class="small hint-text m-t-5">Ingrese la clave o codigo sap del prodcuto</p>
                            </div>
                            <!-- END card -->
                            <div class="col-md-9">
                                <input class="form-control form-control-sm rounded bright" placeholder="Buscar" type="text" name="txtBuscar" id="txtBuscar" onkeyup="Busqueda_Productos(event,this.value)">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END JUMBOTRON -->
    <br>
    <div class="content-i">
        <div class="content-box">

            <div class="row">
                <div class="col-sm-12">
                    <div class="element-wrapper">



                    <div class="element-content">

                        <div class="row">
                          <div class="col-sm-2">

                          </div>
                            <div class="col-lg-10 col-sm-10">
                                <div id="example1" style="width:100%"></div>
                                <p style="display:none">
                                    <button name="load" id="btnLoad">Load</button>
                                    <button name="save" id="btnSave">Save</button>
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-sm-9"></div>
                            <div class="col-sm-3" id="divBnt">
                                <a class="btn btn-primary" href="#" onclick="TerminarAuditoria();"><span>Terminar y Guardar </span><i class="os-icon os-icon-arrow-right2"></i></a>
                            </div>
                        </div>
                    </div></div>
                </div>
            </div>
        </div>
    </div>
    {{csrf_field()}}
    <br>
    <div>
        <link href="{{asset('js/loading.css')}}" rel="stylesheet">
        <script src="{{asset('js/loading.js')}}"></script>
        <script src="{{asset('js/Auditorias.FormatoLab.js?v=2')}}"></script>
        <script src="{{asset('js/Funciones_Basicas.js')}}"></script>
    </div>
</div>
@stop @section('js')
<script type="text/javascript">
    $(document).ready(function() {
        CargarDatos_Lab();
    });
</script>
@stop
