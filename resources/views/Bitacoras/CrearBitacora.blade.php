@extends('main_template')

@section('handsontable')
<link href="{{asset('assets/plugins/jquery-datatable/media/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/plugins/jquery-datatable/extensions/FixedColumns/css/dataTables.fixedColumns.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css')}}" rel="stylesheet" type="text/css" media="screen">
<link href="{{asset('assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css')}}" rel="stylesheet" type="text/css" media="screen">
<link href="{{asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" media="screen">
<link href="{{asset('pages/css/pages-icons.css')}}" rel="stylesheet" type="text/css">

@stop

@section('WorkArea')
{{csrf_field()}}
<div class="content">

   <div class="jumbotron" data-pages="parallax">
      <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
         <div class="inner">

            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="#">Inicio</a></li>
               <li class="breadcrumb-item active">Alta de Bitácoras</li>
            </ol>

            <div class="row">
               <div class="col-xl-7 col-lg-6 ">

                  <div class="full-height">
                     <div class="card-body text-center">
                        <img class="image-responsive-height demo-mw-600" src="{{asset('assets/img/bitacoras/bitacoras_nuevo.png')}}" alt="">
                     </div>
                  </div>

               </div>
               <div class="col-xl-5 col-lg-6 ">

                  <div class="card card-transparent">
                     <div class="card-header ">
                        <div class="card-title">PASO #1
                        </div>
                     </div>
                     <div class="card-body">
                        <h3>Crear Bitácoras</h3>
                        <p>En este modulo podrá crear nuevas bitácoras (Ordenes de trabajo)</p>
                        <p class="small hint-text m-t-5">Por favor, introduzca la información solicitada</p>
                     </div>

                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class=" container-fluid   container-fixed-lg">
      <div class="row">
         <div class="col-lg-6">

            <div class="card card-default">
               <div class="card-header ">
                  <div class="card-title">
                     Información de Taller
                  </div>
               </div>
               <div class="card-body">
                 <form method="post" id="Form" action="/Bitacoras/Crear/Info">
                     {{csrf_field()}}
                     <div class="form-group form-group-default required">
                        <label>Número de orden</label>
                        <input type="text" class="form-control" name="txtNumOrden" id="txtNumOrden" @if(request()->cookie('Bitacora_ID')) value="{{$BitacoraInfo[0]->OT}}"  @endif>
                     </div>
                     <div class="form-group form-group-default required">
                        <label>Fecha</label>
                        <input type="text" class="form-control" name="txtFecha" id="txtFecha" @if(request()->cookie('Bitacora_ID')) value="{{date('d/m/Y',strtotime($BitacoraInfo[0]->FECHA))}}"  @endif>
                     </div>

                      <div class="form-group form-group-default form-group-default-select2 required">
                        <label class="">Compañia de Seguro</label>
                        <select class="full-width" data-placeholder="Selecione compañia de seguros" data-init-plugin="select2" name="cmbSeguro" id="cmbSeguro">
                          @foreach($Seguros as $S)
                            <option value="{{$S->SEGURO_ID}}" @if(request()->cookie('Bitacora_ID')) @if($S->SEGURO_ID == $BitacoraInfo[0]->SEGURO_ID)  selected="selected"   @endif  @endif>
                              {{$S->SEGURO}}
                            </option>
                          @endforeach
                        </select>
                      </div>

                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              <label>Valuacion Seguro</label>
                              <input type="text" class="form-control" placeholder="$ 0.00" onkeypress="return justDecimals(event,'txtValuacionSeguro',9)" type="text" name="txtValuacionSeguro" id="txtValuacionSeguro" @if(request()->cookie('Bitacora_ID')) value="{{$BitacoraInfo[0]->VALUACION_SEGURO}}"  @endif>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>Valuacion Taller</label>
                              <input type="text" class="form-control" placeholder="$ 0.00" type="text" onkeypress="return justDecimals(event,'txtValuacionTaller',9)" name="txtValuacionTaller" id="txtValuacionTaller" @if(request()->cookie('Bitacora_ID')) value="{{$BitacoraInfo[0]->VALUACION_TALLER}}"  @endif>
                           </div>
                        </div>
                     </div>

               </div>
            </div>
         </div>
         <div class="col-lg-6">

            <div class="card card-default">
               <div class="card-header ">
                  <div class="card-title">
                     Información del Vehículo
                  </div>
               </div>
               <div class="card-body">
                  <form class="" role="form">
                     <div class="row">
                        <div class="col-md-6">
                          <div class="form-group form-group-default form-group-default-select2 required">
                            <label class="">Marca</label>
                            <select class="full-width" data-placeholder="Selecione Marca de Vehiculo" data-init-plugin="select2" name="cmbMarca" id ="cmbMarca" onchange="mostrarVehiculos(this.value);">
                              @foreach($Marcas as $M)
                                <option value="{{$M->MARCA_ID}}"  @if(request()->cookie('Bitacora_ID')) @if($M->MARCA_ID == $BitacoraInfo[0]->MARCA_ID)  selected="selected" @endif  @endif>
                                  {{$M->MARCA}}
                                </option>
                               @endforeach
                            </select>
                          </div>
                        </div>
                        <input type="hidden" name="txtVehiculo" id="txtVehiculo">
                        <div class="col-md-6" id="dVehiculos">
                          <div class="form-group form-group-default form-group-default-select2 required">
                            <label class="">Vehículo</label>
                            <select class="full-width" data-placeholder="Selecione Marca de Vehiculo" data-init-plugin="select2" name="cmbVehiculo" id="cmbVehiculo">
                              @foreach($Vehiculos as $V)
                              <option value="{{$V->VEHICULO_ID}}" @if(request()->cookie('Bitacora_ID')) @if($V->VEHICULO_ID == $BitacoraInfo[0]->VEHICULO_ID)  selected="selected"   @endif  @endif>
                                {{$V->VEHICULO}}
                              </option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                     </div>
                     <div class="form-group form-group-default required">
                        <label>PLACAS</label>
                        <input type="text" class="form-control" placeholder="Placas" type="text" name="txtPlacas" id="txtPlacas" @if(request()->cookie('Bitacora_ID')) value="{{$BitacoraInfo[0]->PLACAS}}"  @endif>
                     </div>
                     <div class="form-group form-group-default required">
                        <label>Número de Serie (VIN)</label>
                        <input type="text" class="form-control" placeholder="Serie o VIN" type="text" name="txtVin" id="txtVin" @if(request()->cookie('Bitacora_ID')) value="{{$BitacoraInfo[0]->VIN}}"  @endif>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              <label>COLOR</label>
                              <input type="text" class="form-control" placeholder="Color" type="text" name="txtColor" id="txtColor" @if(request()->cookie('Bitacora_ID')) value="{{$BitacoraInfo[0]->COLOR}}"  @endif>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>MODELO (AÑO)</label>
                              <input type="text" class="form-control" onkeypress="return justDecimals(event,'txtModelo',4)"  name="txtModelo" id="txtModelo" @if(request()->cookie('Bitacora_ID')) value="{{$BitacoraInfo[0]->MODELO}}"  @endif>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
         <hr>

         <div class="col-sm-10">
           <button class="btn btn-complete" id="btnGuardar" name="btnGuardar" type="button" onclick="return DatosBitacora();">Guardar</button>
           <a class="btn btn-info" id="btnRegresar" name="btnRegresar" href="/Bitacoras/Bitacoras" >Regresar al menú</a>
         </div>
         </form>
         <hr>
      </div>
   </div>
</div>

<button class="btn btn-primary" type="button" style="display:none" data-toggle="modal" data-target="#myModal">Guardar</button>
<div class="modal fade stick-up" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content-wrapper">
      <div class="modal-content" >
        <div class="modal-header clearfix text-left">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
          </button>
          <h5 id="LbTitulo">¿Crear Bitácora?</h5>
        </div>
        <div class="modal-body">
          <p class="no-margin" id="LbMensaje">¿Se encuentra seguro, que los datos proporcionados son correctos?. Haga clic en "Continuar" si sus datos son correctos</p>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnContinuar" class="btn btn-primary btn-cons  pull-left inline">Continuar</button>
          <button type="button" id="btnCerrarModal" class="btn btn-default btn-cons no-margin pull-left inline" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</div>


@stop

@section('js')
<script type="text/javascript" src="{{asset('js/BitacorasCrear.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/summernote/js/summernote.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-typehead/typeahead.bundle.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-typehead/typeahead.jquery.min.js')}}"></script>
<script src="{{asset('assets/plugins/handlebars/handlebars-v4.0.5.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#txtFecha").datepicker();
    //$("#txtFecha2").datepicker();
  })
</script>
@stop
