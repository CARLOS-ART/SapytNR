@extends('main_template')


@section('WorkArea')
<div class="content">
  {{csrf_field()}}
  <!-- START JUMBOTRON -->
            <div class="jumbotron" data-pages="parallax">
              <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
                <div class="inner">
                  <!-- START BREADCRUMB -->
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Cambio de precios - Porcentaje</li>
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
                          <h3>Cambio de precios - Porcentaje</h3>
                          <p>En este modulo podrá cambiar los precios añadiendo un porcentaje <br> por linea de producto</p>
                          <p class="small hint-text m-t-5"> Elija una linea de producto e ingrese el porcentaje </p>
                          <br>

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

            <div class="col-lg-6">
                  <!-- START card -->
                  <div class="card card-default">
                    <div class="card-body">
                      <h5>
  							Cambio de precios - Porcentaje
  						</h5>
              <div class="card-header ">
                <div class="card-title">
                  Elija linea de productos
                </div>
              </div>
              <form role="form">
                        <div class="form-group ">
                          <select class="full-width" data-init-plugin="select2">
                            <optgroup label="Lineas">
                              @foreach($Lineas as $L)
                              <option value="{{$L->LINEA_ID}}">{{$L->LINEA}}</option>
                              @endforeach
                            </optgroup>
                          </select>
                        </div>
                      </form>
                      <form class="" role="form">
                        <div class="form-group form-group-default required">
                          <label>Ingrese porcentaje</label>
                          <input  class="form-control" required="" onkeypress="return justDecimals(event,'txtPorcentaje',7)" name="txtPorcentaje" id="txtPorcentaje">
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <button class="btn btn-success ladda-button" data-style="expand-left" data-enviar="false" id="btnVerRpt" name="btnVerRpt" type="button" onclick="ActualizarPreciosPorcent(cmbLineas.value,txtPorcentaje.value);">
                                          <span class="ladda-label"> Actualizar Precios</span>
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <!-- END card -->
                </div>

</div>


@stop
@section('js')
<script type="text/javascript" src="{{asset('js/Precios.Porcentaje.js?version=1.0')}}"></script>
<link href="{{asset('js/loading.css')}}" rel="stylesheet">
<script src="{{asset('js/loading.js')}}"></script>
@stop
