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
                  <li class="breadcrumb-item active">Crear Talleres</li>
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
                              <h3>Crear Talleres</h3>
                              <p>En este modulo podrá crear los talleres de su empresa</p>
                              <p class="small hint-text m-t-5">Por favor ingrese la información solicitada para crear el taller</p>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>

  <!-- END JUMBOTRON -->

  <div class="content-i">
      <div class="content-box">
          <div class="row">
              <div class="col-lg-6">
                  <div class="element-wrapper">

                      <div class="element-box">
                              <h5 class="form-header">
                                  Datos del taller
                              </h5>
                              <hr>
                              <div class=" ">
                                <label>NOMBRE DEL TALLER</label>
                              </div>
                              <div class="form-group form-group-default required col-md-12">
                                <input type="text" class="form-control" required placeholder="Nombre del taller" name="txtNombre" id="txtNombre">
                              </div>

                              <div class=" ">
                                <label>CODIGO DE ACCESO</label>
                              </div>
                              <div class="form-group form-group-default required col-md-12">
                                <input type="text" class="form-control" required placeholder="Ingrese el codigo de acceso para el taller" name="txtCodigo" id="txtCodigo">
                              </div>
                              {{csrf_field()}}

                              <div class="form-group form-group-default form-group-default-select2 required">
                                <label class="">EMPRESA</label>
                                <select class="full-width" data-init-plugin="select2" name="CmbPerfil" id="CmbPerfil">
                                  @foreach($Empresas as $Em)
                                  <option value="{{$Em->EMPRESA_ID}}">{{$Em->EMPRESA}}</option>
                                  @endforeach
                                </select>
                              </div>
                              <br>
                              <fieldset class="form-group">
                                
                                <h5 class="form-header">
                                    Datos del administrador
                                </h5>
                                <hr>
                                  <br>
                                  <div class="row">
                                      <div class="col-sm-6">
                                          <div class="form-group form-group-default required col-md-12">
                                              <label for=""> Nombre completo</label>
                                              <input class="form-control" placeholder="Nombre..." type="text" name="txtNombreCompleto" id="txtNombreCompleto">
                                          </div>
                                      </div>
                                      <div class="col-sm-6">
                                          <div class="form-group form-group-default required col-md-12">
                                              <label for="">Correo Electrónico</label>
                                              <input class="form-control" placeholder="hola@sapyt.com" type="text" name="txtCorreoElectronico" id="txtCorreoElectronico">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-sm-6">
                                          <div class="form-group form-group-default required col-md-12">
                                              <label for="">Usuario</label>
                                              <input class="form-control" placeholder="Nombre de usuario" type="text" name="txtUsuario" id="txtUsuario">
                                          </div>
                                      </div>
                                      <div class="col-sm-6">
                                          <div class="form-group form-group-default required col-md-12">
                                              <label>
                                                  <i class="fa fa-key"></i> Contraseña</label>
                                              <p class="input-group">
                                                  <input type="text" name="txtPwd" id="txtPwd" class="form-control" />
                                                  <span class="input-group-btn">
                                                      <button type="button" class="btn btn-default" onclick="RandomPwd();">
                                                          <div class="fa fa-key"></div>
                                                      </button>
                                                  </span>
                                              </p>
                                          </div>
                                      </div>
                                  </div>
                              </fieldset>
                              <div class="form-buttons-w">
                                  <button class="btn btn-primary" type="button" name="btnGuardar" id="btnGuardar" onclick="GuardarTaller();"> Guardar</button>
                              </div>
                      </div>
                  </div>
              </div>
              <div class="col-lg-6">
              <div class="element-wrapper">
                      <h6 class="element-header">

                      </h6>
                      <div class="element-box">

                              <h5 class="form-header">
                                  Operarios
                              </h5>
                              <hr>
                              <div class="form-desc">
                                  Agregue el nombre de los operarios
                              </div>
                              <div class="form-group">
                                  <label for="">Operarios:</label>

                              </div>

                               <div class="col-lg-12 col-sm-12">
                                  <div id="example1" style="width:100%"></div>
                                  <p style="display:none">
                                      <button name="load" id="btnLoad">Load</button>
                                      <button name="save" id="btnSave">Save</button>
                                  </p>
                               </div>
                      </div>
                  </div>
              </div>
            </div>
          </div>
        </div><br>

</div>

      <div class="">
          <script src="{{asset('js/Talleres.js')}}"></script>
          <script src="{{asset('js/Funciones_Basicas.js')}}"></script>
          <script src="{{asset('js/Global.js?v=3')}}"></script>

      </div>

@stop
@section('js')

    <script src="{{asset('pages/js/pages.js')}}"></script>

    <script src="{{asset('assets/js/notifications.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/scripts.js')}}" type="text/javascript"></script>



@stop
