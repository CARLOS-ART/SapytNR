@extends('main_template')
@section('handsontable')
<script src="{{asset('handsontable/jquery.min.js')}}"></script>
<script src="{{asset('handsontable/jquery.handsontable.full2.js')}}"></script>
<link rel="stylesheet" media="screen" href="{{asset('handsontable/jquery.handsontable.full.css')}}">
@stop



@section('WorkArea')

          <!-- START PAGE CONTENT -->
          <div class="content full-height">
              <div class="container-fluid full-height no-padding">
                  <div class="row full-height no-margin">

                      <div class="col-md-9 no-padding full-height">
                          <div class="placeholder full-height">
                            <div class="col-sm-12">
                            <div class="card card-default">
                              <div class="card-header  separator">
                                <div class="card-title">  <h5>
                                  <span class="semi-bold">PRIMARIOS</span> </h5>
                                </div>
                              </div>
                              <div class="card-body">
                                <div id="primarios" style="width:100%"></div>
                              </div>
                            </div>
                            </div>

                            <div class="col-sm-12">
                              <div class="card card-default">
                                <div class="card-header  separator">
                                  <div class="card-title">  <h5>
                                    <span class="semi-bold">PINTURA</span> </h5>
                                  </div>
                                </div>
                                <div class="card-body">
                                  <div id="pintura" style="width:100%"></div>
                                </div>
                              </div>
                            </div>

                            <div class="col-sm-12">
                            <div class="card card-default">
                              <div class="card-header  separator">
                                <div class="card-title">  <h5>
                                  <span class="semi-bold">TRANSPARENTE</span> </h5>
                                </div>
                              </div>
                              <div class="card-body">
                                      <div id="transparente" style="width:100%"></div>
                              </div>
                            </div>
                            </div>

                            <div class="col-sm-12">
                            <div class="card card-default">
                              <div class="card-header  separator">
                                <div class="card-title">  <h5>
                                  <span class="semi-bold">ADICIONALES</span> </h5>
                                </div>
                              </div>
                              <div class="card-body">

                                      <div id="adicionales" style="width:100%"></div>

                              </div>
                            </div>
                            </div>

                            <div class="col-sm-12">
                            <div class="card card-default">
                              <div class="card-header  separator">
                                <div class="card-title">  <h5>
                                  <span class="semi-bold">COMPLEMENTOS (ALIADOS)</span> </h5>
                                </div>
                              </div>
                              <div class="card-body">

                                      <div id="complementos" style="width:100%"></div>

                              </div>
                            </div>
                            </div>
                          </div>
                      </div>
                      <div class="col-md-3 no-padding b-r b-grey sm-b-b full-height"  >
                          <div class="bg-white full-height" style="position:fixed;">
                            <div class="col-md-12 col-sm-12 col-lg-12" id="dVehiculos">
                              <div class="card card-default" >
                                <div class="card-header  separator">
                                  <div class="card-title">
                                  </div>
                                </div>
                                <div class="card-body">
                                  <h3><span class="semi-bold">Orden</span> de Trabajo</h3>

                                  <div >
                                   @if(request()->cookie('Bitacora_ID') == true)
                                    <ul class="list-inline text-right">
                                      <li class="hint-text" style="color: #CD4945">Número de orden: <b>{{$Bitacoras[0]->OT}}</b> </li>
                                      <li class="hint-text" style="color:#000000">Fecha Ingreso: <b>{{date('d/m/Y',strtotime($Bitacoras[0]->FECHA))}} </b> </li>
                                      <li class="hint-text" style="color:#000000">Vehículo: <b>{{$Bitacoras[0]->VEHICULO}} {{$Bitacoras[0]->MODELO}}</b> </li>
                                    </ul>
                                    @endif
                                  </div>

                                <div class="form-group form-group-default form-group-default-select2 required">
                                  <label class="">OPERARIOS</label>
                                    <select class="full-width" data-placeholder="Selecione operario a asignar productos" data-init-plugin="select2" name="cmbOperarios" id="cmbOperarios">
                                      @foreach($Operarios as $S)
                                        <option value="{{$S->PERSONA_ID}}">
                                          {{$S->NOMBRE}}
                                        </option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>



                                <hr>
                                <button type="button" class="btn btn-white btn-sm" name="btnGuardar" id="btnGuardar" data-pos="0" data-pieza="0" onclick="FinalizarCaptura()"><i class="fa fa-save"></i><span> Guardar</button>
                                <button type="button" class="btn btn-white btn-sm"  id="tableWithSearch" onclick="ReportBitacora({{request()->cookie('Bitacora_ID')}});" ><i class="fa fa-print"></i><span> Imprimir</button>
                                <a href="/Bitacoras/Bitacoras" class="btn btn-white btn-sm" name="btnRegresar" id="btnRegresar" data-pos="0" data-pieza="0"><i class="fa fa-mail-reply"></i><span> Regresar al menú</a>


                                </div>
                              </div>


                            </div>
                          </div>
                      </div>
                  </div>
                  </div>

{{csrf_field()}}


<div class="modal fade fill-in" id="ModalGuardar" tabindex="-1" role="dialog" aria-hidden="true">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        <i class="pg-close"></i>
    </button>
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">

                <h5>  <span class="semi-bold">Estamos validando y guardando los productos</span></h5>
                <h6>
                  <table class="table table-hover dataTable no-footer">
                    <thead>
                      <tr>
                        <td></td>
                        <td></td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td id="cellPrimarios"> <img src="{{asset('img/icon-done.png')}}" alt="Listo" height="27"> </td>
                        <td>PRIMARIOS</td>
                      </tr>
                      <tr>
                        <td id="cellTransparentes"><div class="progress-circle-indeterminate m-t-27" data-color="primary" height="27"></div></td>
                        <td>TRANSPARENTE</td>
                      </tr>
                      <tr>
                        <td id="cellAdicionales"><img src="{{asset('img/icon-warning.png')}}" alt="Listo" height="27"></td>
                        <td>ADICIONALES (BASF)</td>
                      </tr>
                      <tr>
                        <td id="cellComplementos"></td>
                        <td>COMPLEMENTOS (ALIADOS)</td>
                      </tr>
                    </tbody>
                  </table>
              </h6>
            </div><br><br>
            <div class="modal-body">
              <input type="text" name="Bitacora1" id="Bitacora1" hidden>
              <div class="col-sm-12 text-center">
                <button class="btn btn-complete" id="btnAgregar" name="btnAgregar" type="button" onclick="CancelarBitacora(Bitacora1.value);" data-dismiss="modal">Si, Continuar</button>
                <button class="btn btn-danger" id="cancelar" name="Cancelar" type="button" data-dismiss="modal">No, Cancelar</button>

              </div>
            </div>

        </div>
        <div class="modal-footer">
        </div>
    </div>
    <!-- /.modal-content -->
</div>


<div>
  <link href="{{asset('css/loading.css')}}" rel="stylesheet">
  <script src="{{asset('js/loading.js')}}"></script>
  <script src="{{asset('js/Funciones_Basicas.js')}}"></script>
  <script src="{{asset('js/Bitacoras.Tablero.js')}}"></script>
  <script src="{{asset('js/Bitacoras.js')}}"></script>
  <script src="{{asset('js/Bitacoras.Pintura.js')}}"></script>
  <script src="{{asset('js/Bitacoras.Transparente.js')}}"></script>
  <script src="{{asset('js/Bitacoras.Adicionales.js')}}"></script>
  <script src="{{asset('js/Bitacoras.Complementos.js')}}"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      CargaProductoBitacoraPrimarios();
      CargaProductoBitacoraTransparentes();
      CargaProductoBitacoraComplementos();
      CargaProductoBitacoraAdicionales();
    });
  </script>
</div>
@stop
