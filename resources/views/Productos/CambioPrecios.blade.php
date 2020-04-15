@extends('main_template')
 @section('handsontable')
<script src="{{asset('jquery.min.js')}}"></script>
<script src="{{asset('jquery.handsontable.full.js')}}"></script>
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
                  <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                  <li class="breadcrumb-item active">Cambio de precios</li>
              </ol>
              <!-- END BREADCRUMB -->
              <div class="row">
                  <div class="col-xl-7 col-lg-6 ">
                      <!-- START card -->
                      <div class="full-height">
                          <div class="card-body text-center">
                              <img class="image-responsive-height demo-mw-600" src="{{asset('assets/img/productos/cambioprecios.png')}}" alt="">
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
                              <h3>Cambio de precios</h3>
                              <p>En este modulo podrá cambiar los precios de los productos que tiene en el inventario</p>
                              <p class="small hint-text m-t-5">Ingrese la clave o el código SAP para realizar la busqueda del producto, una vez encontrado el producto ingrese los nuevos valores en las celdas P.COMRA y P.VENTA.
                                  <br> al finalizar el proceso haga click en el botón "Actualizar y Guardar"</p>
                              <br>
                              <div class="input-group transparent col-lg-8 ">
                                  <input class="form-control form-control-sm rounded bright" placeholder="Ingrese Clave o Codigo SAP" type="text" name="txtBuscar" id="txtBuscar" onkeyup="Busqueda_Productos(event,this.value)">
                                  <div class="input-group-append ">
                                      <span class="input-group-text transparent"> <i class="pg-search"></i></span>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <!-- END card -->
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
                  <div>
                      <div class="element-content">
                          <div class="row">
                              <div class="col-lg-12 col-sm-12">
                                  <div id="example1" style="width:100%"></div>
                                  <p style="display:none">
                                      <button name="load" id="btnLoad">Load</button>
                                      <button name="save" id="btnSave">Save</button>
                                      <button name="termina_y_carga" id="btnFinish">Finish</button>
                                  </p>
                              </div>
                          </div>
                      </div>
                      <hr>
                      <div class="row">
                          <div class="col-sm-2">
                              <button type="button" name="btnGuardar" id="btnGuardar" class="btn btn-success">Actualizar y guardar</button>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <br>
       {{csrf_field()}}
  </div>

  <div>
      <link href="{{asset('js/loading.css')}}" rel="stylesheet">
      <script src="{{asset('js/loading.js')}}"></script>
      <script src="{{asset('js/Productos.CambioPrecios.js?v=2')}}"></script>
  </div>
</div>
@stop
@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        CargarInventario();
    })
</script>
@stop
