@extends('main_template')
@section('WorkArea')
<div class="content">
<div class=" container-fluid   container-fixed-lg bg-white">
    <div class="card card-transparent">
        <div class="element-box">
            <div class="card-header ">
                <div class="card-title"><h4>Administrar Partidas</h4></div>
                <h5>En este modulo podras eliminar o modificar el operario de los productos que se encuentran en la bitácora</h5>
                <div class="pull-right">
                </div>
                <div class="clearfix"></div>
            </div>
            <br><br>
            <div class="col-sm-3">
              <input class="form-control form-control-sm rounded bright" placeholder="Buscar" type="text" name="txtBuscar" id="txtBuscar" onkeyup="Busqueda_Productos(event,this.value)">

            </div>
            <div class="card-body">
              <table class="table table-hover demo-table-search table-responsive-block" id="tableWithSearch">
                <thead>
                  <tr>
                    <th>SAP:</th>
                    <th>CLAVE:</th>
                    <th>VEHICULO</th>
                    <th>PRODUCTO:</th>
                    <th>CANTIDAD</th>
                    <th>PRECIO</th>
                    <th>IMPORTE</th>
                    <th>OPERARIO</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($Partidas as $P)
                                 <tr id="row{{$P->PARTIDA}}">
                                   <td>{{$P->CLAVE}}</td>
                                   <td>{{$P->CLAVE}}</td>
                                   <td>{{$P->PRODUCTO}}</td>
                                   <td align="right">{{number_format($P->CANTIDAD,2)}} {{$P->UM}}</td>
                                   <td>$ {{number_format($P->PRECIOV,4)}}</td>
                                   <td>$ {{number_format($P->PRECIOV*$P->CANTIDAD,2)}}</td>
                                   <td>

                                   <select class="form-control form-control-sm rounded" style="max-width:170px" name="cmbOperario{{$P->PERSONA_ID_OPERARIO}}" id="cmbOperario{{$P->PERSONA_ID_OPERARIO}}" onchange="EditarOperario({{$P->PARTIDA}},this.value);">
                                     @foreach($Operarios as $P1)
                                     <option value="{{$P1->PERSONA_ID}}" @if($P->PERSONA_ID_OPERARIO == $P1->PERSONA_ID) selected @endif>
                                       {{$P1->NOMBRE}}
                                     </option>
                                     @endforeach
                                   </select>
                                 </td>
                                   <td class="text-danger"><a href="#" class="text-danger" onclick="EliminarItem({{$P->PARTIDA}})">Eliminar</a></td>
                                 </tr>
                               @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
@stop
