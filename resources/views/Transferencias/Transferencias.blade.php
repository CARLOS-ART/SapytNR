@extends('main_template')
@section('handsontable')
<link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" media="screen" />
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
                    <li class="breadcrumb-item active">Envío de productos</li>
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
                          <h3>Envío de productos</h3>
                          <p>En este modulo podrá enviar productos del inventrio del taller a otro taller, este se descontara del inventario para añadirse
                          al inventario del taller destino</p>
                          <p class="small hint-text m-t-5">Ingrese la información requerida</p>

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
  {{csrf_field()}}
  <div class="card card-default">
    <div class="card-header">
      <div class="card-title">
  <label for="">Herramienta diseñada para transferir productos de un taller a otro</label>
      </div>

    </div>
    <div class="card-body">
      <div class="row">
        <div class="form-group col-sm-4">
            <label for="">Busqueda de productos</label>
            <input class="form-control form-control-sm rounded bright" placeholder="Buscar..." type="text" name="BuscarProd" id="BuscarProd" onkeyup="BusquedaProd(event,this.value, cmbTallerOrigen.value)">
        </div>
        <div class="form-group col-md-4">

            <label for="">Seleccione el taller origen</label>
            <select class="full-width" data-init-plugin="select2" name="CmbPerfil" id="CmbPerfil">
              @foreach($Taller as $T)
              <option value="{{$T->TALLER_ID}}">{{$T->NOMBRE}}</option>
            @endforeach
            </select>


        </div>
        <div class="form-group col-md-4">
          <label for="">Seleccione el taller destino</label>
          <select class="full-width" data-init-plugin="select2" name="CmbPerfil" id="CmbPerfil">
            @foreach($Taller as $T)
            <option value="{{$T->TALLER_ID}}">{{$T->NOMBRE}}</option>
          @endforeach
          </select>
        </div>

          <div class="form-group col-md-4">
            <label for="">Fecha</label>
    <input class="single-daterange form-control" placeholder="Seleccione fecha" type="text" value="{{date('d/m/Y')}}" name="txtFecha" id="txtFecha" disabled>
      </div>

  <div class="form-group col-md-4">

    <button class="btn btn-primary btn-cons" id="btnver" onclick="GuardarTraspaso(txtFecha.value,cmbTallerOrigen.value, cmbTallerDestino.value, btnProducto.value, btnRM.value, txtCant.value, txtPrecio.value)">Enviar</button>
  </div>
      </div>
    </div>
  </div>
  <div class="card-body">
    <table class="table table-hover demo-table-search table-responsive-block" id="tableWithSearch">
      <thead>
        <tr>
          <th>SAP:</th>
          <th>CLAVE:</th>
          <th>PRODUCTO:</th>
          <th>CANTIDAD:</th>
          <th>PRECIO COMPRA:</th>
          <th>IMPORTE:</th>
        </tr>
      </thead>
      <tbody>

        <tr >
          <td class="v-align-middle semi-bold sorting_1"><p></p></td>
          <td class="v-align-middle"></td>
          <td class="v-align-middle"><p></p></td>
          <td class="v-align-middle"><p></p></td>
          <td class="v-align-middle"><p></p></td>
          <td class="v-align-middle"><p></p></td>
          <td class="text-danger"><a href="#" class="text-danger" onclick="">Eliminar</a></td>
        </tr>

      </tbody>
    </table>
  </div>


</div>

<script src="{{asset('js/Transfer.js')}}"></script>
@stop
@section('js')
<script type="text/javascript" src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('pages/js/pages.js')}}"></script>
@stop
