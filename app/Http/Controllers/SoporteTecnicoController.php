<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SoporteTecnicoController extends Controller
{
  public function MenuMaker($M,$Mk,$Mks){
        $MenuMaker = new Menu_Maker_Controller;
        $MenuPrincipal = $MenuMaker->JsonToMenu($M,$Mk,$Mks);
        return $MenuPrincipal;
      }
/*==============================================================================*/
  public function FormularioSoporte(){
    $MenuPrincipal = self::MenuMaker(0,-1,0);

    $Talleres = \DB::table("TALLERES")
                  ->orderby("NOMBRE")
                  ->get();



    return view('Soporte.SoporteTecnico', compact('MenuPrincipal','Talleres'));
  }
/*================================================================================*/
  public function MostrarTableroAuditoria(Request $r){
    require_once('C-Funciones.php');
    $Fe1 = TransformaFecha($r->input('Fecha')).'T00:00:00';
    $Fe2 = TransformaFecha($r->input('Fecha2')).'T23:59:00';

    switch ($r->input('Operacion')) {
      case 1:
          $Auditorias = \DB::table('VW_AUDITORIAS')
                          ->where("TALLER_ID","=",$r->input('TallerID'))
                          ->whereBetween("FECHA",[$Fe1,$Fe2])
                          ->get();

              $Tabla='<div class="card-body">
                    <table class="table table-hover demo-table-search table-responsive-block" id="tableWithSearch">
                      <thead>
                        <tr>
                          <th>TALLER</th>
                          <th>FECHA</th>
                          <th>REALIZADO POR:</th>
                          <th>ÁREA DE AUDITORIA</th>
                          <th>ESTATUS</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>';
                        foreach($Auditorias as $A){
              $Tabla.='<tr>';
              $Tabla.='<td>'.$A->TALLER.'</td>';
              $Tabla.='<td>'.date('d/m/Y',strtotime($A->FECHA)).'</td>';
              $Tabla.='<td>'.$A->USUARIO.'</td>';
              $Tabla.='<td>'.$A->TIPO_AUDIT.'</td>';
              $Tabla.='<td>'.$A->ESTATUS.'</td>';
              $Tabla.='<td><div class="btn-group mr-1 mb-1">
                        <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">ACCIONES</button>
                        <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" style="cursor:pointer" onclick="CambiarEstAudi('.$A->AUDITORIA_ID.')"> CAMBIAR ESTATUS</a>
                        <a class="dropdown-item" style="cursor:pointer" onclick="EditarFormato('.$A->TIPO.','.$A->AUDITORIA_ID.')"> CONTINURAR EDITANDO</a>
                        <a class="dropdown-item" style="cursor:pointer" onclick="CancelarAuditoria('.$A->AUDITORIA_ID.')"> CANCELAR</a>
                        <a class="dropdown-item" style="cursor:pointer" onclick="ReportAuditoria('.$A->TIPO.','.$A->AUDITORIA_ID.')"> VER REPORTE</a>
                        </div>
                        </div>
                        </td>';
              $Tabla.='</tr>';
                      }
              $Tabla.='</tbody>
                      </table>';

              $Fe1 = $r->input('Fecha');
              $Fe2 = $r->input('Fecha2');

              if (sizeof($Auditorias) <=0){
               return response()->json(["Titulo"=>"No se encontraron datos", "Mensaje"=>"El taller no cuenta con registros en las fechas seleccionadas", "TMensaje"=>"warning"]);
             }
              //return response()->json(["Titulo"=>"No se encontraron datos", "Mensaje"=>"El taller no cuenta con registros en las fechas seleccionadas", "TMensaje"=>"success"]);
          break;
        case 2:

              $Bitacoras = \DB::table("VW_BITACORAS_TABLERO")
                             ->where('TALLER_ID',"=",$r->input('TallerID'))
                             ->whereBetween('FECHA',[$Fe1,$Fe2])
                             ->orderby('FECHA')
                             ->get();

                 $Tabla='<div class="card-body">
                       <table class="table table-hover demo-table-search table-responsive-block" id="tableWithSearch">
                         <thead>
                           <tr>
                             <th>ORDEN</th>
                             <th>FECHA</th>
                             <th>VEHICULO</th>
                             <th>PLACAS</th>
                             <th>ESTATUS</th>
                             <th></th>
                           </tr>
                         </thead>
                         <tbody>';
                           foreach($Bitacoras as $B){
                 $Tabla.='<tr>';
                 $Tabla.='<td>'.$B->OT.'</td>';
                 $Tabla.='<td>'.date('d/m/Y',strtotime($B->FECHA)).'</td>';
                 $Tabla.='<td>'.$B->VEHICULO.'</td>';
                 $Tabla.='<td>'.$B->PLACAS.'</td>';
                 $Tabla.='<td>'.$B->ESTATUS.'</td>';
                 $Tabla.='<td><div class="btn-group mr-1 mb-1">
                           <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">ACCIONES</button>
                           <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                           <a class="dropdown-item"  style="cursor:pointer" onclick="CambiarEstBit('.$B->BITACORA_ID.')"> CAMBIAR ESTATUS</a>
                           <a class="dropdown-item"  style="cursor:pointer" onclick="" href="/Bitacoras/Tablero/IrBitacora/'.$B->BITACORA_ID.'"> IR A BITACORA</a>
                           <a class="dropdown-item"  style="cursor:pointer" onclick="CerrarBitacora('.$B->BITACORA_ID.')"> CERRAR BITACORA</a>
                           <a class="dropdown-item"  style="cursor:pointer" onclick="CancelarInventario('.$B->BITACORA_ID.')"> CANCELAR OT</a>
                           <a class="dropdown-item"  style="cursor:pointer" onclick="ReportBitacora('.$B->BITACORA_ID.')"> VER REPORTE</a>
                           </div>
                           </div>
                           </td>';
                 $Tabla.='</tr>';
                         }
                 $Tabla.='</tbody>
                         </table>';

           $Fe1 = $r->input('Fecha');
           $Fe2 = $r->input('Fecha2');

           if (sizeof($Bitacoras) <=0){
            return response()->json(["Titulo"=>"No se encontraron datos", "Mensaje"=>"El taller no cuenta con registros en las fechas seleccionadas", "TMensaje"=>"warning"]);
          }
          break;
        case 3:

            $CamPrecios = \DB::table('VW_CAMBIOS_PRECIO')
                            ->where("TALLER_ID","=",$r->input('TallerID'))

                            ->get();


                $Tabla='<div class="card-body">
                      <table class="table table-hover demo-table-search table-responsive-block" id="tableWithSearch">
                        <thead>
                          <tr>
                            <th>TALLER</th>
                            <th>PERSONA QUE REALIZA EL CAMBIO</th>
                            <th>FECHA</th>

                          </tr>
                        </thead>
                        <tbody>';
                          foreach($CamPrecios as $CP){
                $Tabla.='<tr>';
                $Tabla.='<td>'.$CP->TALLER.'</td>';
                $Tabla.='<td>'.$CP->PERSONA.'</td>';
                $Tabla.='<td>'.$CP->FECHA.'</td>';
                $Tabla.='<td><div class="btn-group mr-1 mb-1">
                          <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">ACCIONES</button>
                          <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                          <a class="dropdown-item"  style="cursor:pointer" name="cambio" onclick="ReportCambioPre('.$CP->TALLER_ID.','.$CP->REGISTRO_ID.')"> VER REPORTE</a>
                          </div>
                          </div>
                          </td>';
                $Tabla.='</tr>';
                        }
                $Tabla.='</tbody>
                        </table>';
        $Fe1 = $r->input('Fecha');
        $Fe2 = $r->input('Fecha2');

        if (sizeof($CamPrecios) <=0){
         return response()->json(["Titulo"=>"No se encontraron datos", "Mensaje"=>"El taller no cuenta con registros en las fechas seleccionadas", "TMensaje"=>"warning"]);
       }
          break;
      case 4:

      $CargAliados = \DB::table("VW_SOLICITUD_ALIADOS")
                       ->where("TALLER_ID","=",$r->input('TallerID'))
                       ->whereBetween("FECHA",[$Fe1,$Fe2])
                       ->orderby("FECHA")
                       ->get();

            $Tabla='<div class="card-body">
                  <table class="table table-hover demo-table-search table-responsive-block" id="tableWithSearch">
                    <thead>
                      <tr>
                        <th>TALLER</th>
                        <th>FECHA</th>
                        <th>SOLICITUD DE:</th>
                        <th>NUMERO PROD. SOLIC</th>
                        <th>ESTATUS</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>';
                      foreach($CargAliados as $cA){
            $Tabla.='<tr>';
            $Tabla.='<td>'.$cA->TALLER.'</td>';
            $Tabla.='<td>'.date('d/m/Y',strtotime($cA->FECHA)).'</td>';
            $Tabla.='<td>'.$cA->NOMBRE.'</td>';
            $Tabla.='<td>'.$cA->ITEMS.'</td>';
            $Tabla.='<td>'.$cA->ESTATUS.'</td>';
            $Tabla.='<td><div class="btn-group mr-1 mb-1">
                      <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">ACCIONES</button>
                      <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                      <a class="dropdown-item"  style="cursor:pointer" onclick="CambiarEstAliados('.$cA->SOLICITUD_ID.')"> CAMBIAR ESTATUS</a>
                      <a class="dropdown-item"  style="cursor:pointer" onclick="EditarFormato('.$cA->SOLICITUD_ID.')"> CONTINUAR EDITANDO</a>
                      <a class="dropdown-item"  style="cursor:pointer" onclick="CancelarFormatoAliados('.$cA->SOLICITUD_ID.')"> CANCELAR </a>
                      <a class="dropdown-item"  style="cursor:pointer" onclick="ReportAliados(2,'.$cA->SOLICITUD_ID.')"> VER REPORTE</a>

                      </div>
                      </div>
                      </td>';
            $Tabla.='</tr>';
            $Tabla.='</tr>';
                    }
            $Tabla.='</tbody>
                    </table>';
      $Fe1 = $r->input('Fecha');
      $Fe2 = $r->input('Fecha2');

      if (sizeof($CargAliados) <=0){
       return response()->json(["Titulo"=>"No se encontraron datos", "Mensaje"=>"El taller no cuenta con registros en las fechas seleccionadas", "TMensaje"=>"warning"]);
     }
        break;
      case 5:
        $Compras = \DB::table("VW_COMPRAS")
                     ->where('TALLER_ID',"=",$r->input('TallerID'))
                     ->whereBetween("FECHA",[$Fe1,$Fe2])
                     ->orderby("FECHA")
                     ->get();

           $Tabla='<div class="card-body">
                 <table class="table table-hover demo-table-search table-responsive-block" id="tableWithSearch">
                   <thead>
                     <tr>
                       <th>FOLIO</th>
                       <th>FECHA</th>
                       <th>USUARIO</th>
                       <th>TALLER</th>
                       <th></th>
                     </tr>
                   </thead>
                   <tbody>';
                     foreach($Compras as $C){
           $Tabla.='<tr>';
           $Tabla.='<td>'.$C->FOLIO.'</td>';
           $Tabla.='<td>'.date('d/m/Y',strtotime($C->FECHA)).'</td>';
           $Tabla.='<td>'.$C->USUARIO.'</td>';
           $Tabla.='<td>'.$C->TALLER.'</td>';
           $Tabla.='<td><div class="btn-group mr-1 mb-1">
                     <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">ACCIONES</button>
                     <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                     <a class="dropdown-item"  style="cursor:pointer" onclick="VerCompra('.$C->COMPRA_ID.')"> VER REPORTE</a>
                     </div>
                     </div>
                     </td>';
           $Tabla.='</tr>';
                   }
           $Tabla.='</tbody>
                   </table>';
       $Fe1 = $r->input('Fecha');
       $Fe2 = $r->input('Fecha2');
       if (sizeof($Compras) <=0){
        return response()->json(["Titulo"=>"No se encontraron datos", "Mensaje"=>"El taller no cuenta con registros en las fechas seleccionadas", "TMensaje"=>"warning"]);
      }
        break;
        case 6:

          $InventarioIni = \DB::table("VW_INVENTARIO_INICIAL")
                             ->where("TALLER_ID","=",$r->input('TallerID'))
                             ->whereBetween("FECHA",[$Fe1,$Fe2])
                             ->orderby("FECHA")
                             ->get();

             $Tabla='<div class="card-body">
                   <table class="table table-hover demo-table-search table-responsive-block" id="tableWithSearch">
                     <thead>
                       <tr>
                         <th>FECHA</th>
                         <th>TALLER</th>
                         <th>CREADO POR:</th>
                         <th>ESTATUS</th>
                         <th></th>
                         <th></th>
                       </tr>
                     </thead>
                     <tbody>';
                       foreach($InventarioIni as $i){
             $Tabla.='<tr>';
             $Tabla.='<td>'.date('d/m/Y',strtotime($i->FECHA)).'</td>';
             $Tabla.='<td>'.$i->TALLER.'</td>';
             $Tabla.='<td>'.$i->PERSONA.'</td>';
             $Tabla.='<td>'.$i->ESTATUS.'</td>';
             $Tabla.='<td><div class="btn-group mr-1 mb-1">
                       <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">ACCIONES</button>
                       <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                       <a class="dropdown-item"  style="cursor:pointer" onclick="CambiarEstInv('.$i->INVENTARIO_ID.')"> CAMBIAR ESTATUS</a>
                       <a class="dropdown-item"  style="cursor:pointer" onclick="EditarFormato('.$i->INVENTARIO_ID.')"> CONTINUAR EDITANDO </a>
                       <a class="dropdown-item"  style="cursor:pointer" onclick="CancelarInventario('.$i->INVENTARIO_ID.')"> CANCELAR </a>
                       <a class="dropdown-item"  style="cursor:pointer" onclick="ReportInventario(1,'.$i->INVENTARIO_ID.')"> VER REPORTE</a>
                       </div>
                       </div>
                       </td>';
             $Tabla.='</tr>';
                     }
             $Tabla.='</tbody>
                     </table>';
         $Fe1 = $r->input('Fecha');
         $Fe2 = $r->input('Fecha2');

         if (sizeof($InventarioIni) ==0){
          return response()->json(["Titulo"=>"No se encontraron datos", "Mensaje"=>"El taller no cuenta con registros en las fechas seleccionadas", "TMensaje"=>"warning"]);
         }
          break;
          case 7:
            $Usuarios = \DB::table("VW_USUARIOS_FRASES")
                          ->where("TALLER_ID","=",$r->input('TallerID'))
                          ->orderby("NOMBRE")
                          ->get();

                $Tabla='<div class="card-body">
                      <table class="table table-hover demo-table-search table-responsive-block" id="tableWithSearch">
                        <thead>
                          <tr>
                            <th>NOMBRE</th>
                            <th>PERFIL</th>
                            <th>TALLER</th>
                            <th>EMPRESA</th>
                            <th>USUARIO</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>';
                          foreach($Usuarios as $U){
                $Tabla.='<tr>';
                $Tabla.='<td>'.$U->NOMBRE.'</td>';
                $Tabla.='<td>'.$U->PERFIL.'</td>';
                $Tabla.='<td>'.$U->TALLER.'</td>';
                $Tabla.='<td>'.$U->EMPRESA.'</td>';
                $Tabla.='<td>'.$U->NUSUARIO.'</td>';
                $Tabla.='</tr>';
                        }
                $Tabla.='</tbody>
                        </table>';
            $Fe1 = $r->input('Fecha');
            $Fe2 = $r->input('Fecha2');
            if (sizeof($Usuarios) <=0){
             return response()->json(["Titulo"=>"No se encontraron datos", "Mensaje"=>"El taller no cuenta con usuarios registrados", "TMensaje"=>"warning"]);
           }
            break;
            case 8:
              $ActProductos = \DB::select('SELECT * FROM F_PRODUCTOS_BASF('.$r->input('TallerID').')');

                  $Tabla='<div class="card-body">
                        <table class="table table-hover demo-table-search table-responsive-block" id="tableWithSearch">
                          <thead>
                            <tr>

                              <th>SAP</th>
                              <th>CLAVE</th>
                              <th>PRODUCTO</th>
                              <th>MARCA</th>
                              <th>CLASIFICACION</th>
                              <th>ESTATUS</th>
                            </tr>
                          </thead>
                          <tbody>';
                            foreach($ActProductos as $aP){
                  $Tabla.='<tr>';
                  //$Tabla.='<td>'.$aP->TALLER.'</td>';
                  $Tabla.='<td>'.$aP->SAP.'</td>';
                  $Tabla.='<td>'.$aP->CLAVE.'</td>';
                  $Tabla.='<td>'.$aP->PRODUCTO.'</td>';
                  $Tabla.='<td>'.$aP->LINEA.'</td>';
                  $Tabla.='<td>'.$aP->CLASIFICACION.'</td>';
                  $Tabla.='<td>'.$aP->ESTATUS.'</td>';
                  $Tabla.='<td><div class="btn-group mr-1 mb-1">
                            <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">ACCIONES</button>
                            <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                            <a class="dropdown-item"  style="cursor:pointer" onclick="ActivarBasf('.$aP->SAP.')"> CAMBIAR ESTATUS</a>
                            </div>
                            </div>
                            </td>';
                  $Tabla.='</tr>';
                          }
                  $Tabla.='</tbody>
                          </table>';
              $Fe1 = $r->input('Fecha');
              $Fe2 = $r->input('Fecha2');
              if (sizeof($ActProductos) <=0){
               return response()->json(["Titulo"=>"No se encontraron datos", "Mensaje"=>"El taller no cuenta con productos", "TMensaje"=>"warning"]);
             }
             break;
             case 9:
             require_once('C-Funciones.php');
             $Fe1 = TransformaFecha($r->input('Fecha')).'T00:00:00';
             $Fe2 = TransformaFecha($r->input('Fecha2')).'T23:59:00';
             $Talleres = \DB::table("TALLERES")->where("TALLER_ID","=",$r->input('TallerID'))->get();

             $Tabla='<div class="card-body">
                   <table class="table table-hover demo-table-search table-responsive-block" id="tableWithSearch" style="width: 50%">
                     <thead>';
                       $Tabla.='<tr>';
                         $Tabla.='<th>OPCIONES</th>';
                         $Tabla.='</tr>';
                         $Tabla.='<tbody>';
                         foreach($Talleres as $T){
                         $Tabla.='<tr>';
                         $Tabla.='<td>INVENTARIO</td>';
                         $Tabla.='<td><div class="btn-group mr-1 mb-1">
                                   <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">ACCIONES</button>
                                   <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                   <a class="dropdown-item"  style="cursor:pointer" data-reporte="7" onclick="ReportViewer(7)"> VER REPORTE ALMACEN</a>
                                   <a class="dropdown-item"  style="cursor:pointer" data-reporte="8" onclick="ReportViewer(8);"> VER REPORTE LABORATORIO</a>
                                   </div>
                                   </div>
                                   </td>';
                         $Tabla.='</tr>';
                         $Tabla.='<tr>';
                         $Tabla.='<td>ESTADISTICAS DE CONSUMO</td>';
                         $Tabla.='<td><div class="btn-group mr-1 mb-1">
                                   <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">ACCIONES</button>
                                   <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                   <a class="dropdown-item" name="opcion" style="cursor:pointer" value="15" onclick="EstadisticaCons()"> SELECCIONAR TIPO REPORTE</a>
                                   </div>
                                   </div>
                                   </td>';
                         $Tabla.='</tr>';
                         $Tabla.='<tr>';
                         $Tabla.='<td>ESTADISTICAS OPERARIOS</td>';
                         $Tabla.='<td><div class="btn-group mr-1 mb-1">
                                   <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">ACCIONES</button>
                                   <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                   <a class="dropdown-item"  style="cursor:pointer" onclick="MostrarReportOperarios(cmbTaller.value)"> SELECCIONAR TIPO REPORTE</a>
                                   </div>
                                   </div>
                                   </td>';
                         $Tabla.='</tr>';
                         $Tabla.='<tr>';
                         $Tabla.='<td>ESTADISTICAS DE PRODUCTIVIDAD</td>';
                         $Tabla.='<td><div class="btn-group mr-1 mb-1">
                                   <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">ACCIONES</button>
                                   <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                   <a class="dropdown-item"  style="cursor:pointer" onclick="MostrarFormProd()"> SELECCIONAR TIPO REPORTE</a>
                                   </div>
                                   </div>
                                   </td>';
                         $Tabla.='</tr>';
                         $Tabla.='<tr>';

                         $Tabla.='</tr>';
                         $Tabla.='<tr>';
                         $Tabla.='<td>ESTADISTICAS PIEZA IMPORTE</td>';
                         $Tabla.='<td><div class="btn-group mr-1 mb-1">
                                   <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">ACCIONES</button>
                                   <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                   <a class="dropdown-item"  style="cursor:pointer" onclick="ReportPiezaImporte(txtFecha.value,txtFecha2.value)" value=""> VER REPORTE</a>
                                   </div>
                                   </div>
                                   </td>';
                         $Tabla.='</tr>';
                         $Tabla.='<tr>';
                         $Tabla.='<td>TALLER CONSUMO MENSUAL</td>';
                         $Tabla.='<td><div class="btn-group mr-1 mb-1">
                                   <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">ACCIONES</button>
                                   <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                   <a class="dropdown-item"  style="cursor:pointer" onclick="ReportTallerConsumoMensual(txtFecha.value,txtFecha2.value);"> VER REPORTE</a>
                                   </div>
                                   </div>
                                   </td>';
                         $Tabla.='</tr>';
                         $Tabla.='<tr>';
                         $Tabla.='<td>INFORME IMPORTE TALLER</td>';
                         $Tabla.='<td><div class="btn-group mr-1 mb-1">
                                   <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">ACCIONES</button>
                                   <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                   <a class="dropdown-item"  style="cursor:pointer" data-reporte="7" onclick="ReportInformeImporte(24)"> VER REPORTE</a>
                                   </div>
                                   </div>
                                   </td>';
                         $Tabla.='</tr>';
                         $Tabla.='<tr>';
                         $Tabla.='<td>TRASPASO</td>';
                         $Tabla.='<td><div class="btn-group mr-1 mb-1">
                                   <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">ACCIONES</button>
                                   <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                   <a class="dropdown-item"  style="cursor:pointer" onclick="ReportTraspasos(txtFecha.value,txtFecha2.value);"> VER REPORTE</a>
                                   </div>
                                   </div>
                                   </td>';
                         $Tabla.='</tr>';
                       }
                         $Tabla.='</tbody>
                                 </table>';
                                 $Fe1 = $r->input('Fecha');
                                 $Fe2 = $r->input('Fecha2');
               break;
      default:
        break;
    }

    return response()->json(["Fecha1"=>$Fe1, "Fecha2"=>$Fe2, "Tabla"=>$Tabla]);
  }

/*================================================================================*/
  public function construirFormOperarios(Request $r)
  {

    require_once('C-Funciones.php');
    $Fe1 = TransformaFecha($r->input('Fecha')).'T00:00:00';
    $Fe2 = TransformaFecha($r->input('Fecha2')).'T23:59:00';

    $Operarios = \DB::table('VW_OPERARIOS')
                 ->where("TALLER_ID","=",$r->input('TallerID'))
                ->orderBy('NOMBRE')
                ->get();

    $form='<div class="element-box" style="width: 50%">
      <form method="post" onsubmit="return DatosBitacora();" action="/Bitacoras/Crear/Info">

        <h5 class="form-header">
          Reporte de consumos
        </h5>
        <div class="form-desc">
          Por favor seleccione los parametros que desea visualizar
        </div>
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Tipo de Reporte</label>
          <div class="col-sm-8">
            <div class="form-check">
              <label class="form-check-label"><input checked="" class="form-check-input" name="optionsRadios" type="radio" value="10">Consumo Operarios (Resumen)</label>
            </div>
            <div class="form-check">
              <label class="form-check-label"><input class="form-check-input" name="optionsRadios" type="radio" value="9">Consumo global Taller</label>
            </div>
            <div class="form-check">
              <label class="form-check-label"><input class="form-check-input" name="optionsRadios" type="radio" value="17">Consumo Operarios por Bitacoras</label>
            </div>
          </div>
        </div>';

          $form.='<div class="form-group row">
              <label class="col-form-label col-sm-4" for=""> Operario</label>
              <div class="col-sm-8">';
          $form.='<select class="form-control" name="cmbOperario" id="cmbOperario">';
                  foreach($Operarios as $O){
          $form.='<option value="'.$O->PERSONA_ID.'">'.$O->NOMBRE.'</option>';
                  }
          $form.='</select>';
          $form.='</div>
            </div>
        <div class="form-buttons-w">
          <button class="btn btn-primary ladda-button" data-style="expand-left" data-enviar="false" id="btnVerRpt" name="btnVerRpt" type="button" onclick="ReportConsumos(optionsRadios.value,txtFecha.value,txtFecha2.value);">
            <span class="ladda-label"> Ver Reporte</span>
          </button>
        </div>
      </form>
    </div>';

    $Fe1 = $r->input('Fecha');
    $Fe2 = $r->input('Fecha2');

      return response()->json(["FormularioOperarios"=>$form]);
  }
/*================================================================================*/

  public function CrearFormularioProductividad(Request $r)
  {
    $form='<div class="element-box" style="width: 50%">
      <form method="post" onsubmit="return DatosBitacora();" action="/Bitacoras/Crear/Info">

        <h5 class="form-header">
          Reportes de productividad
        </h5>
        <div class="form-desc">
          Por favor seleccione los parametros que desea visualizar
        </div>
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Reporte</label>
          <div class="col-sm-8">
            <div class="form-group">

          <div id="dReportes">
            <select class="form-control" name="cmbReporte" id="cmbReporte">
              <option value="11">
                PIEZAS REPARADAS POR CONDICIÓN
              </option>
              <option value="12">
                PRODUCCIÓN POR TIPO DE COLOR
              </option>
              <option value="13">
                PRODUCCIÓN POR TIPO DE COLOR GLOBAL
              </option>
              <option value="14">
              PRODUCCIÓN POR TAMAÑO DEL VEHÍCULO
              </option>
            </select>
          </div>
        </div>
          </div>
        </div>
        <div class="form-buttons-w">
          <button class="btn btn-primary ladda-button" data-style="expand-left" data-enviar="false" id="btnVerRpt" name="btnVerRpt" type="button" onclick="ReportConsumos(cmbReporte.value,txtFecha.value,txtFecha2.value);">
            <span class="ladda-label"> Ver Reporte</span>
          </button>
        </div>
      </form>
    </div>';

    return response()->json(["Productividad"=>$form]);
  }

/*================================================================================*/

/*================================================================================*/

  public function MostrarFormEstConsumo(Request $r)
  {
    $form='<div class="element-box" style="width: 50%">
      <form method="post" onsubmit="return DatosBitacora();" action="/Bitacoras/Crear/Info">

        <h5 class="form-header">
          Reporte de consumos de productos
        </h5>
        <div class="form-desc">
          Por favor seleccione los parametros que desea visualizar
        </div>
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Tipo de Reporte</label>
          <div class="col-sm-8">
            <div class="form-check">
              <label class="form-check-label"><input checked="" class="form-check-input" name="optionsRadios" type="radio" value="15">Consumo Productos</label>
            </div>
            <div class="form-check">
              <label class="form-check-label"><input class="form-check-input" name="optionsRadios" type="radio" value="16">Consumo tintas Igualados</label>
            </div>
          </div>
        </div>
        <div class="form-buttons-w">
          <button class="btn btn-primary ladda-button" data-style="expand-left" data-enviar="false" id="btnVerRpt" name="btnVerRpt" type="button" onclick="ReportConsumos(optionsRadios.value,txtFecha.value,txtFecha2.value);">
            <span class="ladda-label"> Ver Reporte</span>
          </button>
        </div>
      </form>
    </div>';

    return response()->json(["EstConsumo"=>$form]);
  }
/*================================================================================*/

public function MostrarDatosTaller(Request $r)
{


  $DatosTaller = \DB::table("TALLERES AS T")
  ->join('EMPRESAS AS E',"T.EMPRESA_ID","=","E.EMPRESA_ID")
  ->where("T.TALLER_ID","=",$r->input('TallerID'))
  ->select('T.TALLER_ID','NOMBRE AS TALLER','E.EMPRESA AS DISTRIBUIDOR','T.FECHA_ALTA', 'CODIGO', 'CIUDAD','ESTADO')->get();


     $Tabla='<div class="table-responsive">
           <table  class="table" id="TablaCompras">
             <thead>';

               foreach($DatosTaller as $DT){
     $Tabla.='<tr>';
     $Tabla.='<th>NOMBRE: </th>';
     $Tabla.='<td>'.$DT->TALLER.'</td>';
     $Tabla.='</tr>';
     $Tabla.='<tr>';
     $Tabla.='<th>DISTRIBUIDOR: </th>';
     $Tabla.='<td>'.$DT->DISTRIBUIDOR.'</td>';
     $Tabla.='</tr>';
     $Tabla.='<tr>';
     $Tabla.='<th>FECHA DE ALTA: </th>';
     $Tabla.='<td>'.$DT->FECHA_ALTA.'</td>';
     $Tabla.='</tr>';
     $Tabla.='<tr>';
     $Tabla.='<th>CIUDAD: </th>';
     $Tabla.='<td>'.$DT->CIUDAD.'</td>';
     $Tabla.='</tr>';
     $Tabla.='<tr>';
     $Tabla.='<th>ESTADO: </th>';
     $Tabla.='<td>'.$DT->ESTADO.'</td>';
     $Tabla.='</tr>';
             }
     $Tabla.='</tbody>
             </table></div>';

  \Cookie::queue('Taller_ID',$r->input('TallerID'));


    return response()->json(["TablaTaller"=>$Tabla]);
}
/*================================================================================*/
public function CambiarEstatusAuditoria(Request $r)
{
  $EstatusAudi = \DB::table("AUDITORIAS")
                   ->where("AUDITORIA_ID","=",$r->input('AuditoriaID'))
                   ->get();

  if ($EstatusAudi[0]->ESTATUS_ID == 1) {
    $SQL = "UPDATE AUDITORIAS SET ESTATUS_ID = 2 WHERE AUDITORIA_ID ='".$r->input('AuditoriaID')."'";
    $ActualizarBit = \DB::statement($SQL);

  }else{
    $SQL = "UPDATE AUDITORIAS SET ESTATUS_ID = 1 WHERE AUDITORIA_ID ='".$r->input('AuditoriaID')."'";
    $ActualizarBit = \DB::statement($SQL);
  }
  return response()->json(["Titulo"=>"Cambiado Correctamente", "Mensaje"=>"EL cambio de estatus se ha hecho correctamente","TMnesaje"=>"success"]);
}

/*================================================================================*/
  public function CambiarEstatusBitacora(Request $r)
  {
    $EstatusBitacoras = \DB::table("BITACORAS")
                     ->where("BITACORA_ID","=",$r->input('BitacoraID'))
                     ->get();

    if ($EstatusBitacoras[0]->ESTATUS_ID == 1) {
      $SQL = "UPDATE BITACORAS SET ESTATUS_ID = 2 WHERE BITACORA_ID ='".$r->input('BitacoraID')."'";
      $EstatusBitacoras = \DB::statement($SQL);

    }else {
      $SQL = "UPDATE BITACORAS SET ESTATUS_ID = 1 WHERE BITACORA_ID ='".$r->input('BitacoraID')."'";
      $EstatusBitacoras = \DB::statement($SQL);
    }
    return response()->json(["Titulo"=>"Cambiado Correctamente", "Mensaje"=>"EL cambio de estatus se ha hecho correctamente","TMnesaje"=>"success"]);
  }

/*================================================================================*/

  public function CambiarEstatusAliados(Request $r)
  {
    $EstatusSolAliados = \DB::table("SOLICITUD_ALIADOS")
                     ->where("SOLICITUD_ID","=",$r->input('SolicitudID'))
                     ->get();

    if ($EstatusSolAliados[0]->ESTATUS_ID == 1) {
      $SQL = "UPDATE SOLICITUD_ALIADOS SET ESTATUS_ID = 2 WHERE SOLICITUD_ID ='".$r->input('SolicitudID')."'";
      $EstatusSolAliados = \DB::statement($SQL);

    }else {
      $SQL = "UPDATE SOLICITUD_ALIADOS SET ESTATUS_ID = 1 WHERE SOLICITUD_ID ='".$r->input('SolicitudID')."'";
      $EstatusSolAliados = \DB::statement($SQL);
    }
    return response()->json(["Titulo"=>"Cambiado Correctamente", "Mensaje"=>"EL cambio de estatus se ha hecho correctamente","TMnesaje"=>"success"]);
  }

/*================================================================================*/
  public function CambiarEstInventario(Request $r)
  {
    $EstatusInventario = \DB::table("INVENTARIO_INICIAL")
                     ->where("INVENTARIO_ID","=",$r->input('InventarioID'))
                     ->get();

    if ($EstatusInventario[0]->ESTATUS_ID == 1) {
      $SQL = "UPDATE INVENTARIO_INICIAL SET ESTATUS_ID = 2 WHERE INVENTARIO_ID ='".$r->input('InventarioID')."'";
      $EstatusInventario = \DB::statement($SQL);

    }else {
      $SQL = "UPDATE INVENTARIO_INICIAL SET ESTATUS_ID = 1 WHERE INVENTARIO_ID ='".$r->input('InventarioID')."'";
      $EstatusInventario = \DB::statement($SQL);
    }
    return response()->json(["Titulo"=>"Cambiado Correctamente", "Mensaje"=>"EL cambio de estatus se ha hecho correctamente","TMnesaje"=>"success"]);
  }

/*================================================================================*/
  public function ConsumoProductos(){
    return view('Soporte.EstadisticasConsumo');
  }
}
