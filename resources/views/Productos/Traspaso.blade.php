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
                    <li class="breadcrumb-item active">Traspaso de productos</li>
                  </ol>
                  <!-- END BREADCRUMB -->
                  <div class="row">
                    <div class="col-xl-7 col-lg-6 ">
                      <!-- START card -->
                      <div class="full-height">
                        <div class="card-body text-center">
                          <img class="image-responsive-height demo-mw-600" src="{{asset('assets/img/Transferencia/transfer.png')}}" alt="">
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
                          <p>En este modulo podra realizar el traspaso de productos del almacén al laboratorio (bote sellado a bote abierto)</p>
                          <p class="small hint-text m-t-5">Ingrese la información requerida</p>
                        </div>
                      </div>
                      <!-- END card -->
                      <div class="input-group transparent col-lg-8 ">
                          <input class="form-control form-control-sm rounded bright" placeholder="Ingrese Clave o Codigo SAP" type="text" name="txtBuscar" id="txtBuscar" onkeyup="Busqueda_Productos(event,this.value)">
                          <div class="input-group-append ">
                              <span class="input-group-text transparent"> <i class="pg-search"></i></span>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- END JUMBOTRON -->







</div>
@stop
