@extends('main_template')
@section('handsontable')
<script src="{{asset('handsontable/jquery.min.js')}}"></script>
<script src="{{asset('handsontable/jquery.handsontable.full2.js')}}"></script>
<link rel="stylesheet" media="screen" href="{{asset('handsontable/jquery.handsontable.full.css')}}">
@stop

@section('Fijo')

    <div class="gallery" style="position: relative; width: 1000px; ">
    <div class="gallery-filters p-t-20 p-b-10">
     @if(request()->cookie('Bitacora_ID') == true)
      <ul class="list-inline text-right">
        <li class="hint-text">Número de orden: </li>
        <li class="hint-text" style="color: #CD4945"><b>{{$Bitacoras[0]->OT}}</b> </li>

        <li class="hint-text">Vehículo: </li>
        <li class="hint-text" style="color:#000000"><b>{{$Bitacoras[0]->VEHICULO}} {{$Bitacoras[0]->MODELO}}</b> </li>

        <li class="hint-text col-sm-3" style="color: #000000"><div class="form-group form-group-default form-group-default-select2 required">
          <label class="">Operario</label>
          <select class="full-width" data-placeholder="Selecione operario a asignar productos" data-init-plugin="select2" name="cmbOperarios" id="cmbOperarios">
            @foreach($Operarios as $S)
              <option value="{{$S->PERSONA_ID}}">
                {{$S->NOMBRE}}
              </option>
            @endforeach
          </select>
        </div> </li>

        <li ><a class="btn btn-white btn-sm" href="#" onclick="FinalizarCaptura()"> <i class="fa fa-save"></i><span> Guardar</span></a></li>
      </ul>
      @endif
    </div>
  </div>

@stop

@section('WorkArea')
{{csrf_field()}}
  <div class="content">
      <div class="row">
        <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">

      <div class="col-sm-8">
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

      <div class="col-sm-8">
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


      <div class="col-sm-8">
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

      <div class="col-sm-8">
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

      <div class="col-sm-8">
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


</div>

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
