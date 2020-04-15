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
                  <li class="breadcrumb-item active">Crear usuarios</li>
              </ol>
              <!-- END BREADCRUMB -->
              <div class="row">
                  <div class="col-xl-7 col-lg-6 ">
                      <!-- START card -->
                      <div class="full-height">
                          <div class="card-body text-center">
                              <img class="image-responsive-height demo-mw-600" src="{{asset('assets/img/usuarios/usuarios.png')}}" alt="">
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
                              <h3>Crear usuarios</h3>
                              <p>En este módulo podra crea usuarios para ingresar al sistema y asignarles un perfil para restringir el accesos a ciertos módulos</p>
                              <p class="small hint-text m-t-5">ingrese la información requerida</p>
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
  {{csrf_field()}}
  <div class="row">
    <div class="col-md-6">

      <form class="" role="form">
          <div class="form-group form-group-default required ">
            <label>Nombre Completo</label>
            <input type="text" class="form-control" required placeholder="Nombre Completo" name="txtNombrePersona" id="txtNombrePersona">
          </div>
          <div class="form-group form-group-default required">
            <label>Usuario</label>
            <input type="text" class="form-control" required placeholder="ej. carlos.alejandro" name="txtUsuario" id="txtUsuario">
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group form-group-default required">
                <label>Contraseña</label>
                <input type="password" class="form-control" required placeholder="password" name="txtContra" id="txtContra">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group form-group-default required">
                <label>Confirmar contraseña</label>
                <input type="password" class="form-control" required placeholder="password" name="txtContra2" id="txtContra2">
              </div>
            </div>
          </div>
          <div class="form-group form-group-default form-group-default-select2 required">
            <label class="">Perfiles</label>
            <select class="full-width" data-init-plugin="select2" name="CmbPerfil" id="CmbPerfil">
              @foreach($Perfiles as $P)
              <option value="{{$P->PERFIL_ID}}">{{$P->PERFIL}}</option>
              @endforeach
            </select>

          </div>
        </form>
      </div>
    </div>

  <br><hr>
  <button class="btn btn-primary" type="button" data-target="#modalSlideLeft" data-toggle="modal">Seleccione talleres</button>
  <hr>
                      <div class="modal fade slide-right" id="modalSlideLeft" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content-wrapper">
                            <div class="modal-content">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                              </button>
                              <div class="container-sm-height full-height">
                                <div class="row-xs-height">
                                  <div class="modal-body col-sm-height col-middle">
                                    <fieldset class="form-group">
                                    <legend><span>Acceso a talleres</span></legend>
                                    <hr>
                                    @foreach($Talleres as $T)
                                     <div class="card-body Talleres" data-brand="Taller{{$T->TALLER_ID}}">
                                      <div id="Talleres">
                                        <label class="btn btn-default btn-sm m-t-2 "   data-toggle="buttons">
                                          <img src="/img/Sucu.png" height="35" >
                                          <div class="row">
                                            <div class="col-6 checkbox-circle" id="checkbox">
                                              <input type="checkbox"  data-size="small" data-color="primary" value="{{$T->TALLER_ID}}" />{{$T->NOMBRE}}
                                            </div>
                                          </div>
                                        </label>
                                      </div>
                                     </div>
                                     @endforeach
                                     <hr>
                                     <div class="form-buttons-w">
                                    <button class="btn btn-primary " id="CrearUsuario" type="button" onclick="GuardarUsuario()" data-dismiss="modal">Crear</button>
                                    </div>
                                  </fieldset>
                                   </div>

                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
</div>
 <div>
   <script src="{{asset('js/Funciones_Basicas.js')}}"></script>
   <script src="{{asset('js/Usuarios.js?v=1.1')}}"></script>
   <script src="{{asset('js/Global.js?v=3')}}"></script>
 </div>

@stop
@section('js')
<script type="text/javascript" src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<!--<script src="{{asset('assets/js/form_elements.js')}}" type="text/javascript"></script>-->

<script src="{{asset('assets/js/notifications.js')}}" type="text/javascript"></script>
<script src="{{asset('pages/js/pages.js')}}"></script>
<!-- END CORE TEMPLATE JS -->
<!-- BEGIN PAGE LEVEL JS -->
<script src="{{asset('assets/js/scripts.js')}}" type="text/javascript"></script>
@stop
