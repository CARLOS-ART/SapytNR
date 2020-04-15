@if(request()->cookie('Inventario_ID')==false) {{redirect()->to('/InventarioInicial/Tablero')->send()}} @endif
@extends('main_template')

@section('handsontable')
<script src="{{asset('jquery.min.js')}}"></script>
<script src="{{asset('jquery.handsontable.full2.js')}}"></script>
<link rel="stylesheet" media="screen" href="{{asset('jquery.handsontable.full.css')}}">
@stop
@section('WorkArea')
<div class="content">
  <!-- START MODAL DERECHO CON BOTONES -->
  <div class="modal fade slide-right" id="modalSlideLeft" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
          <div class="modal-content-wrapper">
              <div class="modal-content">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                  </button>
                  <div class="container-xs-height full-height">
                      <div class="row-xs-height">
                          <div class="modal-body col-xs-height col-middle text-center   ">
                              <h5 class="text-primary ">Seleccione las lineas de producto que desea agregar al inventario:</h5>
                              <br>
                              <div class="row" id="">

                                  <div class="col-sm-6 LineaProducto" data-brand="Linea90">
                                      <button type="button" class="btn btn-complete" data-toggle="button" aria-pressed="true" style="width:130px; height:35px" id="Linea90" data-linea="1" data-seleccion="0" data-dismiss="modal"> Linea 90</button>
                                  </div>
                                  <div class="col-sm-6">
                                      <img src="/img/GlasuritLogo.png" height="35">
                                  </div>
                                  <br>
                                  <br>

                                  <div class="col-sm-6 LineaProducto" data-brand="Linea55">
                                      <button type="button" class="btn btn-complete" data-toggle="button" aria-pressed="true" style="width:130px; height:35px" id="Linea55" data-linea="2" data-seleccion="0" data-dismiss="modal"> Linea 55</button>
                                  </div>
                                  <div class="col-sm-6 LineaProducto">
                                      <img src="/img/GlasuritLogo.png" height="35">
                                  </div>
                                  <br>
                                  <br>
                                  <div class="col-sm-6 LineaProducto" data-brand="RM">
                                      <button type="button" class="btn btn-complete" data-toggle="button" aria-pressed="true" style="width:130px; height:35px" id="RM" data-linea="8" data-seleccion="0" data-dismiss="modal"> RM</button>
                                  </div>
                                  <div class="col-sm-6">
                                      <img src="/img/RMLogo.png" height="35">
                                  </div>
                                  <br>
                                  <br>
                                  <div class="col-sm-6 LineaProducto" data-brand="Diamont">
                                      <button type="button" class="btn btn-complete" data-toggle="button" aria-pressed="true" style="width:130px; height:35px" id="Diamont" data-linea="4" data-seleccion="0" data-dismiss="modal"> DIAMONT</button>
                                  </div>
                                  <div class="col-sm-6">
                                      <img src="/img/RMLogo.png" height="35">
                                  </div>
                                  <br>
                                  <br>
                                  <div class="col-sm-6 LineaProducto" data-brand="UnoHD">
                                      <button type="button" class="btn btn-complete" data-toggle="button" aria-pressed="true" style="width:130px; height:35px" id="UnoHD" data-linea="10" data-seleccion="0" data-dismiss="modal"> UNO HD</button>
                                  </div>
                                  <div class="col-sm-6">
                                      <img src="/img/RMLogo.png" height="35">
                                  </div>
                                  <br>
                                  <br>
                                  <div class="col-sm-6 LineaProducto" data-brand="OnyxHD">
                                      <button type="button" class="btn btn-complete" data-toggle="button" aria-pressed="true" style="width:130px; height:35px" id="OnyxHD" data-linea="7" data-seleccion="0" data-dismiss="modal"> OnyxHD</button>
                                  </div>
                                  <div class="col-sm-6">
                                      <img src="/img/RMLogo.png" height="35">
                                  </div>
                                  <br>
                                  <br>
                                  <div class="col-sm-6 LineaProducto" data-brand="Limco">
                                      <button type="button" class="btn btn-complete" data-toggle="button" aria-pressed="true" style="width:130px; height:35px" id="Limco" data-linea="5" data-seleccion="0" data-dismiss="modal"> LIMCO</button>
                                  </div>
                                  <div class="col-sm-6">
                                      <img src="/img/LimcoLogo.png" height="35">
                                  </div>
                                  <br>
                                  <br>
                                  <div class="col-sm-6 LineaProducto" data-brand="Norbin">
                                      <button type="button" class="btn btn-complete" data-toggle="button" aria-pressed="true" style="width:130px; height:35px" id="Norbin" data-linea="11" data-seleccion="0" data-dismiss="modal"> NORBIN</button>
                                  </div>
                                  <div class="col-sm-6">
                                      <img src="/img/NorbinLogo.png" height="35">
                                  </div>

                              </div>

                              <br>

                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>
  <!-- END MODAL DERECHO CON BOTONES -->
  <br>
  <!-- START JUMBOTRON -->
  <div class="jumbotron" data-pages="parallax">
      <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
          <div class="inner">
              <!-- START BREADCRUMB -->
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                  <li class="breadcrumb-item active">Formato Inventario inicial</li>
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
                              <h3>Formato Inventario Inicial</h3>
                              <p>Ingrese la información de precio de compra y venta, existencia (Bote sellado) y gramos (Bote abierto)</p>
                              <p class="small hint-text m-t-5">Haga click en el boton para elejir lineas de producto</p>
                              <br>
                              <button class="btn btn-success btn-lg pull-left" data-target="#modalSlideLeft" data-toggle="modal">Lineas de producto</button>

                          </div>

                          <!-- END card -->
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
                                  <input class="form-control form-control-sm rounded bright" placeholder="Buscar" type="text" name="txtBuscar" id="txtBuscar" onkeyup="Busqueda_Productos(event,this.value)">
                              </div>
                          </div>
                          <br>
                          <div class="row">
                              <div class="col-lg-12 col-sm-12">
                                  <div id="example1" style="width:100%"></div>
                                  <p style="display:none">
                                      <button name="load" id="btnLoad">Load</button>
                                      <button name="save" id="btnSave">Save</button>
                                  </p>
                              </div>
                          </div>
                      </div>
                      <hr>
                      <button class="btn btn-success btn-lg pull-left" onclick="SubirInventario();">Terminar y cargar</button>
                  </div>
              </div>
          </div>
      </div>

      {{csrf_field()}}

  </div><br>

  <div>
      <link href="{{asset('js/loading.css')}}" rel="stylesheet">
      <script src="{{asset('js/loading.js')}}"></script>
      <script src="{{asset('js/InventarioIni.js?v=3')}}"></script>
      <script src="{{asset('js/Funciones_Basicas.js')}}"></script>
      <script src="{{asset('js/Global.js?v=3')}}"></script>

  </div>

</div>



@stop
@section('js')
<script src="pages/js/pages.js"></script>

<script src="{{asset('assets/js/notifications.js')}}" type="text/javascript"></script>

<script src="{{asset('assets/js/scripts.js')}}" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function() {
        CargarDatos();
    });
</script>
@stop
