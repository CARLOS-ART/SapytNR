<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Bitacoras_Factory_Controller extends Controller
{

    public function TableroActividades(){
      $DatosBitacora = \DB::table('VW_BITACORA_ESPECIAL')
                      ->where("BIESP_ID","=",request()->cookie('Bitacora_ID'))
                      ->get();

      $Actividades = \DB::table('VW_BITACORAS_ACTIVIDAD')
                      ->where("BIESP_ID","=",request()->cookie('Bitacora_ID'))
                      ->get();

      $ActividadesCatalogo = \DB::table('ACTIVIDADES')
	                         ->where("TALLER_ID","=",request()->cookie('Taller_ID'))
                             ->orderBy('ACTIVIDAD')
                             ->get();

      $Zonas = \DB::table('ZONAS_ACTIVIDADES')
                              ->where("TALLER_ID","=",request()->cookie('Taller_ID'))
                              ->orderBy('ZONA_ACTIVIDAD')
                              ->get();

      $Personal = \DB::select('SELECT * FROM PERSONAS WHERE PERSONA_ID IN(SELECT PERSONA_ID FROM BITACORA_ESP_PERSONAL WHERE BIESP_ID = '.request()->cookie('Bitacora_ID').')');
      return view('BitacorasFactory.BitacorasActividad',compact('Actividades','ActividadesCatalogo','Zonas','Personal','DatosBitacora'));
    }

    /*==========================================================================*/

    public function BitacoraSteeps(){
      $BitacoraInfo = \DB::table('VW_BITACORA_ESPECIAL')
                       ->where("BIESP_ID","=",request()->cookie('Bitacora_ID'))
                       ->get();
      return view('BitacorasFactory.Steeps',compact('BitacoraInfo'));
    }

    /*==========================================================================*/

    public function BitacoraInfo(){
      $Cuadrillas = \DB::table('CUADRILLAS')
					->where("TALLER_ID","=",request()->cookie('Taller_ID'))
                    ->orderBy('Grupo')
                    ->get();

                    $Marcas = \DB::table('MARCA_VEHICULAR')
                                 ->orderBy('MARCA')
                                 ->get();

                    $x = 0;
                    foreach ($Marcas as $M) {
                      if($x == 0){
                        $MarcaId = $M->MARCA_ID;
                        break;
                      }
                      $x++;
                    }



                    if(request()->cookie('Bitacora_ID') == false)
                      {
                      //  $BitacoraInfo = '';
                        $Vehiculos = \DB::table('VEHICULOS')
                                     ->where("MARCA_ID","=",$MarcaId)
                                     ->get();
                      }else{
                        $BitacoraInfo = \DB::table('VW_BITACORAS_FACTORY_TABLERO')
                                        ->where(['Bitacora_ID'=> request()->cookie('Bitacora_ID')])
                                        ->get();
                        $Vehiculos = \DB::table('VEHICULOS')
                                     ->where("MARCA_ID","=",$BitacoraInfo[0]->MARCA_ID)
                                     ->get();
                       }
      return view('BitacorasFactory.BitacoraInfo',compact('Cuadrillas','Marcas','Vehiculos','BitacoraInfo'));
    }

    /*=========================================================================*/

    public function IntegrantesCuadrilla(Request $r){
      $Integrantes = \DB::table('VW_INTEGRANTES_CUADRILLA')
                        ->where("CUADRILLA_ID","=",$r->input('Cuadrilla'))
                        ->get();

      $Filas = '';
      $x = 1;
      foreach ($Integrantes as $I) {
        $Filas .= '<tr>';
        $Filas .= '<td>'.$x.".- ".$I->NOMBRE_INTEGRANTE.'</td>';
        $Filas .= '</tr>';
        $x++;
      }
     $Filas = '<table>'.$Filas."</table>";
      return response()->json(["Info"=>$Filas]);
    }

    /*==========================================================================*/

    public function GuardarInfo(Request $r){
      require_once('C-Funciones.php');
      $Fecha = TransformaFecha($r->input('txtFecha')).'T00:00:00';
      if(request()->cookie('Bitacora_ID')){
        $Biesp = request()->cookie('Bitacora_ID');
      }else{
        $Biesp = 0;
      }
      $Validar = \DB::table('BITACORAS_ESPECIAL')
                 ->where(["TALLER_ID"=>request()->cookie('Taller_ID'),"OT"=>$r->input('OT')])
                 //->whereNotIn("Bitacora_ID",array(request()->cookie('Bitacora_ID')))
                 ->get();

      if(sizeof($Validar) >= 1){
        return response()->json([
          "Titulo"=>"Número de orden existente!",
          "Mensaje"=>"El número de orden ingresado ya esta registrado en una bitacora, no es posible repetir esta información",
          "TMensaje"=>"warning"
        ]);}

      $Query = "EXEC P_BITACORA_ESPECIAL ".request()->cookie('Taller_ID').",".$r->input('cmbVehiculo').",2,'".$r->input('txtNumOrden')."','".$Fecha."',".$r->input('cmbCuadrilla').",'".$r->input('txtCliente')."',".$Biesp;
      $Guardar = \DB::select($Query);
      $BitID = $Guardar[0]->BIT_ID;
//      return response()->json(["Titulo"=>"Completado","Mensaje"=>"Información guardada correctamente","TMensaje"=>"success"]);



      return redirect('/Factory/Bitacoras/Crear')->with("Bitacora_Creada")->cookie('Bitacora_ID',$BitID);
    }

    /*=========================================================================*/

    public function ActividadBitacora(Request $r){
      $Query = "EXEC P_AGREGA_ACTIVIDAD_ZONA ".request()->cookie('Bitacora_ID').",".$r->input('Actividad').",'".$r->input('ZonaID')."'";
      $Guardar = \DB::statement($Query);

      $DatosBitacora = \DB::table('VW_BITACORAS_ACTIVIDAD')
                ->where(["BIESP_ID"=>request()->cookie('Bitacora_ID'),
                         "ACTIVIDAD_ID"=>$r->input('Actividad'),
                         "ZONA_ID"=>$r->input('ZonaID')
                        ])->get();
      $Fila = '';
      foreach ($DatosBitacora as $A) {
        $Fila .= '<tr>
          <td class="nowrap">
            <span class="status-pill smaller';
          if ($A->ESTATUS_ID == 1) {$Fila .='green';}
          elseif($A->ESTATUS_ID == 5){ $Fila .='blue';}
          elseif($A->ESTATUS_ID == 6){$Fila .= 'yellow';}
          elseif($A->ESTATUS_ID == 3){ $Fila .= 'red';}
          $Fila .= '"></span>
            <span>'.$A->ESTATUS.'</span>
          </td>
          <td>
            <span>'.date('d/m/Y',strtotime($A->FECHA_INICIAL)).'</span>
            <span class="smaller lighter">'.date('H:i:s',strtotime($A->FECHA_INICIAL)).'</span>
          </td>
          <td class="cell-with-media">
            <img alt="" src="/img/company1.png" style="height: 25px;">
              <span>'.$A->ACTIVIDAD.'</span>
            </td>
            <td class="text-center">
              <a class="badge badge-success" href="">'.$A->ZONA_ACTIVIDAD.'</a>
            </td>
            <td class="text-right bolder nowrap">
              <span class="text-success">$ '.number_format($A->IMPORTE,2).'</span>
            </td>
            <td><a class="btn btn-grey d-none d-sm-inline-block btn-sm" href="/Factory/Bitacoras/Productos/'.$A->ACTIVIDAD_ID.'/'.$A->ZONA_ID.'"><i class="os-icon os-icon-plus-circle"></i><span>Productos</span></a></td>
          </tr>';
      }

      return response()->json(["Titulo"=>"Agregado correctamente!",
                               "Mensaje"=>"Actividad agregada a la bitácora correctamente, por favor asigne productos",
                               "TMensaje"=>"success",
                               "Filas"=>$Fila
                             ]);

    }

    /*==========================================================================*/

    public function ProductosBitacora($Actividad,$Zona){
      $DatosBitacora = \DB::table('VW_BITACORA_ESPECIAL')
                ->where("BIESP_ID","=",request()->cookie('Bitacora_ID'))
                ->get();

      $Personal = \DB::select('SELECT * FROM PERSONAS WHERE PERSONA_ID IN(SELECT PERSONA_ID FROM BITACORA_ESP_PERSONAL WHERE BIESP_ID = '.request()->cookie('Bitacora_ID').')');

      return view('BitacorasFactory.BitacoraProducto',compact('DatosBitacora','Personal','Actividad','Zona'));
    }

    /*===============================================================================*/

    public function ConsultarCatalogo(Request $r){
      $Obtener = \DB::table('VW_TALLER_PRODUCTO')
                  ->where([
                    ["TALLER_ID","=",request()->cookie('Taller_ID')],
                    ["CLAVE","like","%".$r->input('Filtro')."%"]
                  ])
                  ->orWhere([
                      ["TALLER_ID","=",request()->cookie('Taller_ID')],
                      ["PRODUCTO","like","%".$r->input('Filtro')."%"]
                      ])->get();

      $Rows = '<thead><tr><td>CLAVE</td><td>PRODUCTO</td><td>PRECIO</td><td>LINEA</td></tr></thead>';
      if (sizeof($Obtener) >= 1) {
        foreach ($Obtener as $O) {
          $Rows .= '<tr onclick="useItem('.$O->PRODUCTO_ID.','.$O->PRESENTACION_ID.')" style="cursor:pointer">';
          $Rows .= '<td>'.$O->CLAVE.'</td>';
          $Rows .= '<td>'.$O->PRODUCTO.'</td>';
          $Rows .= '<td>$ '.number_format ($O->PVENTA,2).'</td>';
          $Rows .= '<td>'.$O->LINEA.'</td>';
          $Rows .= '</tr>';
        }
      }else {
        $Rows .= '<tr><td colspan="6">No se encontraron coincidencias</td></tr>';
      }

      $Table = '<table class="table table-lightborder table-striped">'.$Rows.'</table>';
      return response()->json(["TMensaje"=>"success","Table"=>$Table]);

    }

    /*===============================================================================*/

    public function UseItem(Request $r){
      $Obtener = \DB::table('VW_TALLER_PRODUCTO')
                  ->where([
                    ["TALLER_ID","=",request()->cookie('Taller_ID')],
                    ["PRODUCTO_ID","=",$r->input('Pro')]
                  ])->get();

      $Card = '';

      foreach ($Obtener as $O) {
          if(in_array( $O->LINEA_ID , array(1,2,3) )){
            $Logo = '/img/GlasuritLogo.png';
          }elseif (in_array($O->LINEA_ID,array(4,7,8,10))) {
            $Logo = '/img/RMLogo.png';
          }elseif (in_array($O->LINEA_ID,array(5,6))) {
            $Logo = '/img/LimcoLogo.png';
          }elseif (in_array($O->LINEA_ID,array(11))) {
            $Logo = '/img/NorbinLogo.png';
          }else{
            $Logo = '/img/cta-pattern-light.png';
          }

          if ($O->PRESENTACION_ID == $r->input('Pre')) {
            $CardPrincipal = '
                      <div class="col-sm-12">
                       <div class="post-box">
                        <div class="post-media" style="background-image: url('.$Logo.'); background-size:90px 90px; background-repeat:no-repeat;"></div>
                        <div class="post-content text-center">
                        <button class="btn badge badge-light LineaProducto" id="btnProducto" data-presentacion="'.$O->PRESENTACION_ID.'" data-producto="'.$O->PRODUCTO_ID.'" data-seleccion="1">
                        Has seleccionado:
                        </button>
                           '.$O->CLAVE.'
                           <h5 class="post-title" style="font-size:26px; font-weight:bold">
                              '.$O->UM.'
                           </h5>
                           <div class="post-foot text-center">
                              <div class="post-tags text-center">
                                 <button class="btn badge badge-success LineaProducto" id="btnRM" data-presentacion="'.$O->PRESENTACION_ID.'" data-producto="'.$O->PRODUCTO_ID.'" data-seleccion="1">
                                 Seleccionado
                                 </button>
                              </div>
                           </div>
                        </div>
                     </div>
                     <hr>
                     <small>Otras presentaciones disponibles:</small>
                   </div>

                 ';
          }else{
            $Card .= '<div class="col-sm-12">
                       <div class="post-box">
                        <div class="post-media" style="background-image: url('.$Logo.'); background-size:30px 30px; background-repeat:no-repeat;"></div>
                        <div class="post-content text-center">
                           <h5 class="post-title" style="font-size:14px;">
                            '.$O->CLAVE.'  '.$O->UM.'
                           </h5>
                        </div>
                     </div>
                   </div>';
          }

      }

      $Card = '<div class="row">
                <div class="col-sm-4">
                '.$CardPrincipal.$Card.'
                </div>
                <div class="col-sm-8 form-producto">
                  <div class="row">
                    <div class="col-sm-10">
                          <div class="form-group">
                            <label for=""> Cantidad</label><input class="form-control" placeholder="Cantidad" autocomplete="off" onkeypress="return justDecimals(event,'."'txtCant'".',9);" type="text" name="txtCant" id="txtCant">
                          </div>
                    </div>
                    <div class="col-sm-4">
                          <div class="form-group">
                             <label for="">Unidad</label>
                             <select class="form-control" name="cmbUnidad" id="cmbUnidad">
                               <option value="1"> ML </option>
                               <option value="2"> GR </option>
                               <option value="3">PZA </option>
                               <option value="4"> OZ </option>
                             </select>
                           </div>

                    </div>

                    <div class="col-sm-6">
                       <label for=""> </label>
                      <button class="btn btn-primary" type="button" name="btnAddItem" id="btnAddItem" onclick="AgregarProducto();">Agregar</button>
                    </div>
                  </div>

                </div>
                </div>';

      return response()->json(["InfoProducto"=>$Card]);

    }

    /*==========================================================================*/

    public function AgregarProducto(Request $r){
      $SQL = "EXEC [P_BITACORA_FACTORY_PRODUCTO] ".request()->cookie('Bitacora_ID').",".$r->input('Activity1').",".$r->input('Zona').",".$r->input('Pro').",".$r->input('Pre').",";
      $SQL .= $r->input('Can').",".$r->input('Um').",".request()->cookie('Taller_ID');

      $Guardar = \DB::statement($SQL);

      return response()->json(["TMensaje"=>"success"]);
      /*
      var Pro = $("#btnProducto").data('producto');
      var Pre = $("#btnProducto").data('presentacion');
      var Um = document.getElementById('cmbUnidad').value;
      var Can = document.getElementById('txtCant').value;
      */
      //request()->cookie('Taller_ID')
    }

    /*==========================================================================*/

    public function EliminarItem(Request $r){
\DB::statement('EXEC P_ELIMINAR_ITEM '.$r->input('Item').",".request()->cookie('Taller_ID'));

      $Eliminar = \DB::table('BITACORA_ESP_ACTIVIDAD')
                   ->where("BIESP_ID","=",request()->cookie('Bitacora_ID'))
                   ->where("ITEM","=",$r->input("Item"))
                   ->delete();
      return response()->json(["TMensaje"=>"Ok"]);
    }

    /*==========================================================================*/

    public function Preview(Request $r){

      $Info = self::ObtenerItems($r->input('Activity1'),$r->input('Zona'));

      return response()->json([
          "Titulo"=>"OK",
          "Mensaje"=>"READY",
          "TMensaje"=>"success",
          "Info"=>$Info
        ]);

    }

    /*==========================================================================*/

    private function ObtenerItems($Actividad,$Zona){
      $Obtener = \DB::table('VW_BITACORA_PRODUCTO_ACTIVIDAD')
                  ->where(["ACTIVIDAD_ID"=>$Actividad, "ZONA_ID"=>$Zona,"BIESP_ID"=>request()->cookie('Bitacora_ID')])
                  ->get();

      $Datos = array();
      $Items = array();
      $x = 0;

      foreach ($Obtener as $Info) {
        $Items[0] = $Info->CLAVE;
        $Items[1] = $Info->PRODUCTO;
        $Items[2] = number_format($Info->CANTIDAD,2);
        $Items[3] = $Info->UM;
        $Items[4] = "$ ".number_format($Info->PRECIOV,2);
        $Items[5] = "$ ".number_format($Info->IMPORTE,2);
        $Items[6] = $Info->ITEM;
        $Datos[$x] = $Items;
        $x++;
      }

      $Info = array();

      if(sizeof($Datos) == 0){
        $Datos[0] = array('','','','','','');
      }

      return $Datos;
    }

    /*==========================================================================*/

    public function BuscarLPA(Request $r){
      $SQL = \DB::select("SELECT * FROM KITS WHERE CLAVE_KIT LIKE '%".$r->input('Filtro')."%' AND TALLER_ID = ".request()->cookie('Taller_ID'));
      $Tabla = '<table class="table table-striped table-lightfont dataTable no-footer">';
      if(sizeof($SQL)>=1){
        foreach ($SQL as $S) {
          $Tabla .= '<tr onclick="MezclarLPA('.$S->FORMULA_ID.','."'".$S->PRECIO_BASE."'".')" style="cursor:pointer">';
            $Tabla .= '<td>'.$S->CLAVE_KIT.'</td>';
            $Tabla .= '<td>'.$S->DESCRIPCION_KIT.'</td>';
            $Tabla .= '<td align="right">$ '.number_format($S->PRECIO_BASE,2).'</td>';
          $Tabla .= '</tr>';

        }
      }else{
        $Tabla .=  '<tr><td colspan="3">No existe información relacionada con la clave que indicó</td></tr>';
      }
      $Tabla .= '</table>';

      return response()->json(["Tabla"=>$Tabla]);
    }

    /*========================================================*/

    public function PrepararMezcla(Request $r){
      $Formula = \DB::select("EXEC P_REALIZAR_MEZCLADO_LPA ".$r->input('Formula').",".$r->input('Cantidad'));
      $Tabla = '<table class="table table-striped table-lightfont dataTable no-footer"><thead><tr><th>CLAVE</th><th>PRODUCTO</th><th>CANTIDAD</th></tr></thead><tbody>';
      foreach ($Formula as $F) {
        $Tabla .= '<tr style="cursor:pointer">';
          $Tabla .= '<td>'.$F->CLAVE.'</td>';
          $Tabla .= '<td>'.$F->PRODUCTO.'</td>';
          $Tabla .= '<td align="right">'.number_format($F->NUEVA_CANT,2).'</td>';
        $Tabla .= '</tr>';
      }
      $Tabla .= '</tbody></table><button class="btn btn-primary btn-sm" id="btnPrepararLPA" onclick="LpaToBitacora('.$r->input('Formula').','.$r->input('PrecioBase').','.$r->input('Cantidad').')"><i class="icon-chemistry"></i><span>Agregar LPA a bitacora </span></button><hr><button class="btn btn-outline-danger btn-sm" onclick="CancelarMezcla()" ><i class="icon-chemistry"></i><span>Cancelar</span></button>';

      return response()->json(["Tabla"=>$Tabla]);
    }

    /*==========================================================================*/

    public function LpaToBitacora(Request $r){
      $PrecioUnitario = \DB::select('EXEC P_CALCULAR_PRECIO_LPA '.$r->input('PrecioBase').','.$r->input('Cantidad'));
      \DB::table('BITACORA_ESP_KIT')
      ->insert([
        "BIESP_ID"=>request()->cookie('Bitacora_ID'),
        "ACTIVIDAD_ID"=>$r->input('Activity1'),
        "ZONA_ID"=> $r->input('Zona'),
        "FORMULA_ID"=> $r->input('Formula'),
        "CANTIDAD"=>$r->input('Cantidad'),
        "PRECIOC"=>$PrecioUnitario[0]->PRECIO_UNITARIO_PROPORCIONAL,
        "PRECIOV"=>$PrecioUnitario[0]->PRECIO_UNITARIO_PROPORCIONAL,
        "UNIDAD_ID"=>1
      ]);

      return response()->json(["TMensaje"=>"success"]);
    }

    /*==========================================================================*/

    public function BitacorasTablero(){
      return view('BitacorasFactory.BitacorasFactoryTablero');
    }
    /*==========================================================================*/

    public function MostrarBitacoras(Request $r){
      require_once('C-Funciones.php');
      $Fe1 = TransformaFecha($r->input('txtFecha')).'T00:00:00';
      $Fe2 = TransformaFecha($r->input('txtFecha2')).'T23:59:00';

      $Buscar = \DB::table('VW_BITACORAS_FACTORY_TABLERO')
                   ->where('TALLER_ID',"=",request()->cookie('Taller_ID'))
                   ->whereBetween('FECHA',[$Fe1,$Fe2])
                   ->orderBy('FECHA')
                   ->get();

     $Fe1 = $r->input('txtFecha');
     $Fe2 = $r->input('txtFecha2');
   return view('BitacorasFactory.HistorialFactory',compact('Buscar','Fe1','Fe2'));
    }
    /*====================================================================*/

    public function IrBitacora($Bit){
      \Cookie::queue('Bitacora_ID',$Bit);
      return redirect('/Factory/Bitacoras/Crear');
    }

    /*======================================================================*/

    public function CerrarOT(Request $r){
      $EstatusBit = \DB::table('BITACORAS_ESPECIAL')
                 ->where("Biesp_id","=",$r->input('Bit'))
                 ->get();
      if (sizeof($EstatusBit)>0) {
        $Estatus = $EstatusBit[0]->ESTATUS_ID;
        if ($Estatus == 2) {
          $Cerrar = \DB::table('BITACORAS_ESPECIAL')
          ->where("Biesp_id","=",$r->input('Bit'))
          ->update(["ESTATUS_ID"=>1]);
          $Titulo = "Cerrado correctamente";
          $Mensaje= "Se ha cerrado exitosamente la orden de trabajo seleccionada";
          $TMensaje="success";
        }else{
          $Titulo = "No es posible cerrar OT";
          $Mensaje= "El estatus actual de la orden de trabajo no permite hacer un cierre";
          $TMensaje="success";
        }
      }else{
        $Titulo = "Orden de trabajo no valida";
        $Mensaje= "No fue posible cerrar la orden de trabajo que seleccionó";
        $TMensaje="info";
      }

      return response()->json(["Titulo"=>$Titulo,"Mensaje"=>$Mensaje,"TMensaje"=>$TMensaje]);
    }
    /*======================================================================*/

    public function CancelarOT(Request $r){


          $Cerrar = \DB::table('BITACORAS_ESPECIAL')
          ->where("Biesp_id","=",$r->input('Bit'))
          ->update(["ESTATUS_ID"=>3]);

          $Titulo = "Cancelado correctamente";
          $Mensaje= "Se ha cerrado exitosamente la orden de trabajo seleccionada";
          $TMensaje="success";



      return response()->json(["Titulo"=>$Titulo,"Mensaje"=>$Mensaje,"TMensaje"=>$TMensaje]);
    }

    /*==========================================================================*/

    public function TerminarCaptura(){
      \Cookie::queue(\Cookie::forget('Bitacora_ID'));
      return redirect('/Factory/Bitacoras/Crear');
    }

    /*==========================================================================*/

    public function GuardarArticulos(Request $r){
//
    }
}
