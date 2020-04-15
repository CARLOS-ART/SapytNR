<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Bitacoras_Igualado_Controller extends Controller
{
    public function Igualados(){
      $SQL = 'SELECT * FROM LINEAS WHERE LINEA_ID IN(SELECT LINEA_ID FROM PRODUCTOS WHERE PRODUCTO_ID IN(SELECT PRODUCTO_ID FROM TALLER_PRODUCTO WHERE TALLER_ID = '.request()->cookie('Taller_ID').')) AND LINEA_ID <12';
      $Lineas = \DB::select($SQL);
      return view('Bitacoras.IgualadoColor',compact('Lineas'));
    }

    /*===========================================================================*/

    public function ColorManual(Request $r){
      if(request()->cookie('Bitacora_ID') != false){
        $NumOT = \DB::table('BITACORAS')
                  ->where('BITACORA_ID',"=",request()->cookie('Bitacora_ID'))
                  ->get();

        $OT = $NumOT[0]->OT;
      }

      $SQL = 'SELECT * FROM PERSONAS WHERE PERSONA_ID IN(SELECT PERSONA_ID FROM OPERARIOS WHERE TALLER_ID = '.request()->cookie('Taller_ID').' AND ACTIVO = 1) ';
      $Operarios = \DB::select($SQL);
      $TipoColor = $r->input('TipoColor');
      $TipoIgualado = $r->input('TipoIgualado');
      $LineaPintura = $r->input('LineaColor');
	  
      return view('Bitacoras.ColorManual',compact('OT','Operarios','TipoColor','TipoIgualado','LineaPintura'));
    }

    /*===========================================================================*/

    public function ProductosIgualado(Request $r){
      $Obtener = \DB::table('VW_TALLER_PRODUCTO')
                  ->where([
                    ["TALLER_ID","=",request()->cookie('Taller_ID')],
                    ["CLAVE","like","%".$r->input('Filtro')."%"],
                    ["BASF","=",1]
                  ])
                  ->whereIn("CLASIFICACION_ID",array(7,3,10))
                  ->get();

      $Rows = '<thead><tr><td>CLAVE</td><td>PRODUCTO</td><td>EXISTENCIA</td><td>GRAMOS</td><td>PRECIO</td><td>LINEA</td></tr></thead>';
      if (sizeof($Obtener) >= 1) {
        foreach ($Obtener as $O) {
          $Rows .= '<tr onclick="useItemColor('.$O->PRODUCTO_ID.','.$O->PRESENTACION_ID.')" style="cursor:pointer">';
          $Rows .= '<td>'.$O->CLAVE.'</td>';
          $Rows .= '<td>'.$O->PRODUCTO.'</td>';
          $Rows .= '<td>'.number_format($O->SELLADO,2).'</td>';
          $Rows .= '<td>'.number_format($O->GRAMOS_DESTARE,2).'</td>';
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

    public function UseItemColor(Request $r){
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
                            <label for=""> Cantidad</label><input class="form-control" placeholder="Cantidad" autocomplete="off" onkeypress="AddItemColorEnter(event);return justDecimals(event,'."'txtCant'".',9);" type="text" name="txtCant" id="txtCant">
                          </div>
                    </div>
                    <div class="col-sm-4">
                          <div class="form-group">
                             <label for="">Unidad</label>
                             <select class="form-control" name="cmbUnidad" id="cmbUnidad">
                               <option value="2"> GR </option>
                             </select>
                           </div>
                    </div>
                    <div class="col-sm-2">
                       <label for=""> </label>
                      <button class="btn btn-primary" type="button" name="btnAddItem" id="btnAddItem" onclick="AddItemColor();">Agregar</button>
                    </div>
                  </div>

                </div>
                </div>';

      return response()->json(["InfoProducto"=>$Card]);

    }

    /*==========================================================================*/
    public function MostrarItemsColor(Request $r){


      $Componentes = \DB::table('VW_PEDIDO_COLOR_BITACORA')
                      ->where(["PERSONA_ID"=> request()->cookie('Persona_ID')])
                      ->orderBy('ITEM')
                      ->get();

      $Datos = array();
      $Items = array();
      $x = 0;

      foreach ($Componentes as $Info) {
        $Items[0] = $Info->CLAVE;
        $Items[1] = $Info->PRODUCTO;
        $Items[2] = number_format($Info->CANTIDAD,2);
        $Items[3] = $Info->UM;
        $Items[4] = "$ ".number_format($Info->PRECIO,2);
        $Items[5] = "$ ".number_format($Info->IMPORTE,2);
        $Items[6] = $Info->ITEM;
        $Datos[$x] = $Items;
        $x++;
      }

      $Info = array();

      if(sizeof($Datos) == 0){
        $Datos[0] = array('','','','','','');
      }
      $Info = $Datos;


      return response()->json(["TMensaje"=>"success","Info"=>$Info]);
    }

    /*==========================================================================*/
    public function AddItemColor(Request $r){
      $Insertar = \DB::table('PEDIDO_COLOR_BITACORA')
                   ->insert([
                      "PRODUCTO_ID"=>  $r->input('Pro'),
                      "PERSONA_ID"=> request()->cookie('Persona_ID'),
                      "PRESENTACION_ID"=>  $r->input('Pre'),
                      "UNIDAD_ID"=> $r->input('Um'),
                      "CANTIDAD"=> $r->input('Can'),
                      "PRECIO"=> 1,
                   ]);
      $SQL = 'EXEC P_IMPORTES_PEDIDO_COLOR_BITACORA '.request()->cookie('Persona_ID').','.request()->cookie('Taller_ID');
      $Calcular = \DB::statement($SQL);

      $Componentes = \DB::table('VW_PEDIDO_COLOR_BITACORA')
                      ->where(["PERSONA_ID"=> request()->cookie('Persona_ID')])
                      ->orderBy('ITEM')
                      ->get();

      $Datos = array();
      $Items = array();
      $x = 0;

      foreach ($Componentes as $Info) {
        $Items[0] = $Info->CLAVE;
        $Items[1] = $Info->PRODUCTO;
        $Items[2] = number_format($Info->CANTIDAD,2);
        $Items[3] = $Info->UM;
        $Items[4] = "$ ".number_format($Info->PRECIO,2);
        $Items[5] = "$ ".number_format($Info->IMPORTE,2);
        $Items[6] = $Info->ITEM;
        $Datos[$x] = $Items;
        $x++;
      }

      $Info = array();

      if(sizeof($Datos) == 0){
        $Datos[0] = array('','','','','','');
      }
      $Info = $Datos;


      return response()->json(["TMensaje"=>"success","Info"=>$Info]);
    }

    /*==========================================================================*/

    public function EliminarItemColor(Request $r){
        $Eliminar = \DB::table('PEDIDO_COLOR_BITACORA')
                         ->where('ITEM',"=",$r->input('Item'))
                         ->delete();
                         $Componentes = \DB::table('VW_PEDIDO_COLOR_BITACORA')
                                         ->where(["PERSONA_ID"=> request()->cookie('Persona_ID')])
                                         ->get();

                         $Datos = array();
                         $Items = array();
                         $x = 0;

                         foreach ($Componentes as $Info) {
                           $Items[0] = $Info->CLAVE;
                           $Items[1] = $Info->PRODUCTO;
                           $Items[2] = number_format($Info->CANTIDAD,2);
                           $Items[3] = $Info->UM;
                           $Items[4] = "$ ".number_format($Info->PRECIO,2);
                           $Items[5] = "$ ".number_format($Info->IMPORTE,2);
                           $Items[6] = $Info->ITEM;
                           $Datos[$x] = $Items;
                           $x++;
                         }

                         $Info = array();

                         if(sizeof($Datos) == 0){
                           $Datos[0] = array('','','','','','');
                         }
                         $Info = $Datos;


                         return response()->json(["TMensaje"=>"success","Info"=>$Info]);
    }

    /*==========================================================================*/

    public function validarItems($Items){
      $ItemsCount = sizeof($Items)-1;
      $Fila = 1;
      $SQL = '';

      foreach ($Items as $i) {
        if($Fila>$ItemsCount){
             break;
        }

        if(!in_array(strtoupper($i[3]),array('PZA','ML','GR','OZ'))){
          return array(1,
                       "Error en la fila ".$Fila.", Columna UM",
                       "El valor ".$i[3]." para la unidad de medida no es valido.",
                       "warning");
        }else{
          switch (strtoupper($i[3])) {
            case 'ML': $UM = 1 ;  break;
            case 'GR': $UM = 2 ;  break;
            case 'PZA': $UM = 3;  break;
            case 'OZ': $UM = 4 ;  break;
          }
        }

        $Valor = str_replace(',','',$i[2]);

        if(!is_numeric($Valor)){
          return array(2,"Dato incorrecto","Se esperaba un valor numerico en la fila ".$Fila.", el valor recibido es:".$i[2]." para la Columna Cantidad.","warning");
        }

        $SQL .= "UPDATE PEDIDO_COLOR_BITACORA SET CANTIDAD = ".$Valor.", UNIDAD_ID = ".$UM." WHERE ITEM = ".$i[6].";";

        $Fila++;
      }


      $SQL .= 'EXEC P_IMPORTES_PEDIDO_COLOR_BITACORA '.request()->cookie('Persona_ID').','.request()->cookie('Taller_ID');
      $Calcular = \DB::statement($SQL);

      return array(3,"Proceso correcto!",'',"success");
    }

    /*==========================================================================*/

    public function GuardarColor(Request $r){
      //Esta funcion es la que inserta finalmente en la bitacora los productos agregados
      $Items = $r->input('Info');
      $Comprobar = self::validarItems($Items);

      if($Comprobar[3] != "success"){
        return response()->json([
          "Titulo"=>$Comprobar[1],
          "Mensaje"=>$Comprobar[2],
          "TMensaje"=>$Comprobar[3]
        ]);
      }

      // Validacion Nivel 2

      $CompararExistencias = \DB::select('SELECT * FROM F_VALIDAR_EXISTENCIAS_COLOR('.request()->cookie('Taller_ID').','.request()->cookie('Persona_ID').')');


      foreach ($CompararExistencias as $C) {
        if($C->UNIDAD_ID == 3){
          $Existencia = $C->SELLADO;
        }else{
          $Existencia = $C->GRAMOS_DESTARE;
        }

        if ( $C->DESCONTAR_GR > $Existencia) {
          return response()->json([
            "Titulo"=>"No hay producto suficiente!",
            "Mensaje"=>"El producto ".$C->CLAVE.' '.$C->PRODUCTO." no tiene existencia suficiente para agregarlo al color igualado",
            "TMensaje"=>"warning"
          ]);
        }



      }

      $SQL = "EXEC P_GUARDAR_COLOR ";
      $SQL .= request()->cookie('Persona_ID').",".request()->cookie('Bitacora_ID').",".$r->input('LineaColor').",".$r->input('TipoColor').",";
      $SQL .= "'".$r->input('CodColor')."','".$r->input('NomColor')."','',".$r->input('Operario');

      $GuardarColor = \DB::statement($SQL);

      $Query = "DELETE FROM PEDIDO_COLOR_BITACORA WHERE PERSONA_ID = ". request()->cookie('Persona_ID');

      $Guardar = \DB::statement($Query);

      return response()->json([
        "Titulo"=>"Productos cargados correctamente!",
        "Mensaje"=>"Se han cargado los productos correctamente a la bitacora",
        "TMensaje"=>"success"
      ]);

    }

    /*===========================================================================*/

    public function ColorFormula(Request $r){
      if(request()->cookie('Bitacora_ID') != false){
        $NumOT = \DB::table('BITACORAS')
                  ->where('BITACORA_ID',"=",request()->cookie('Bitacora_ID'))
                  ->get();

        $OT = $NumOT[0]->OT;
      }

      $SQL = 'SELECT * FROM PERSONAS WHERE PERSONA_ID IN(SELECT PERSONA_ID FROM OPERARIOS WHERE TALLER_ID = '.request()->cookie('Taller_ID').' AND ACTIVO = 1) ';

      $Operarios = \DB::select($SQL);
      $TipoColor = $r->input('TipoColor');
      $TipoIgualado = $r->input('TipoIgualado');
      $LineaPintura = $r->input('LineaColor');

      return view('Bitacoras.ColorFormula',compact('OT','Operarios','TipoColor','TipoIgualado','LineaPintura'));

    }

    /*===========================================================================*/

    public function BuscarFormula(Request $r){
      $Formulas = \DB::table('FORMULAS')
      ->where('CODIGO','like','%'.$r->input('Filtro').'%')
      ->get();

      $Resultados = '<table class="table table-striped table-condensed">';
      if (sizeof($Formulas)>=1){
        foreach ($Formulas as $F) {
          $Resultados .='<tr>';
          $Resultados .='<td>'.$F->CODIGO.'</td>';
          $Resultados .='<td>'.$F->NOMBRE_COLOR.'</td>';
          $Resultados .='<td><button class="btn btn-sm btn-primary" onclick="usarLPA('.$F->FORMULA_ID.','."'".$F->CODIGO."'".','."'".$F->NOMBRE_COLOR."'".')">Usar formula</button></td>';
          $Resultados .='</tr>';
        }
      }else{
        $Resultados .= '<tr><td>No se encontraron resultados</td></tr>';
      }
      $Resultados .='</table>';

      return response()->json(["Resultados"=>$Resultados]);
    }

    /*==========================================================================*/

    public function PrepararMezcla(Request $r){
      $Formula = \DB::select("EXEC P_REALIZAR_MEZCLADO_LPA ".$r->input('Formula').",".$r->input('Cantidad'));
      $Tabla = '<div class="col-sm-3"></div><div class="col-sm-6"><table class="table table-striped table-lightfont dataTable no-footer"><thead><tr><th>CLAVE</th><th>PRODUCTO</th><th>CANTIDAD</th></tr></thead><tbody>';
      $Datos = array();
      $DatosJson = array();
      $x = 0;
      foreach ($Formula as $F) {
        $Tabla .= '<tr style="cursor:pointer">';
          $Tabla .= '<td>'.$F->CLAVE.'</td>';

          //Agregar las presentaciones del disponibles del producto que se encuentran disponibles en el taller
          $Presentaciones = \DB::table('VW_TALLER_PRODUCTO')
                            ->where('PRODUCTO_ID',"=",$F->PRODUCTO_ID)
                            ->where('TALLER_ID',"=",request()->cookie('Taller_ID'))
                            ->get();
          $Combo = '<select data-producto="'.$F->PRODUCTO_ID.'" name="cmbPresentacion'.$F->PRODUCTO_ID.'" id="cmbPresentacion'.$F->PRODUCTO_ID.'">';
          foreach ($Presentaciones as $P) {
            $Combo .= '<option value="'.$P->PRESENTACION_ID.'">'.$P->UM.'</option>';
          }
          $Combo .='</select>';
          $Tabla .= '<td>'.$F->PRODUCTO.' '.$Combo.'</td>';

          $Tabla .= '<td align="right">'.number_format($F->NUEVA_CANT,2).'</td>';
        $Tabla .= '</tr>';
        $Datos['PRODUCTO_ID'] = $F->PRODUCTO_ID;
        $Datos['CANTIDAD'] = number_format($F->NUEVA_CANT,2);
        $Datos['CLAVE'] = ($F->CLAVE);

        $DatosJson[$x] = $Datos;
        $x++;
      }

      
	  
	  if($r->input('TipoMezcla') == -1){
		$Tabla .= '</tbody></table><button class="btn btn-success btn-sm" id="btnPrepararLPA" onclick="LpaBitacoraProducto()"><i class="icon-chemistry"></i><span>Agregar LPA a bitacora </span></button><hr><button class="btn btn-outline-danger btn-sm" onclick="CancelarMezcla()" ><i class="icon-chemistry"></i><span>Cancelar</span></button></div>';  
	  }else{
		  
		  $Tabla .='<tr><td>Operario</td><td colspan="2"><select name="cmbOperario" id="cmbOperario">';
		  $SQL = 'SELECT * FROM PERSONAS WHERE PERSONA_ID IN(SELECT PERSONA_ID FROM OPERARIOS WHERE TALLER_ID = '.request()->cookie('Taller_ID').' AND ACTIVO = 1) ';
		  $Operarios = \DB::select($SQL);
		  foreach ($Operarios as $P) {
			$Tabla .='<option value="'.$P->PERSONA_ID.'">'.$P->NOMBRE.'</option>';
		  }
		  $Tabla .= '</select></td></tr>';
		  
		$Tabla .= '</tbody></table><button class="btn btn-success btn-sm" id="btnPrepararLPA" onclick="LpaToBitacora()"><i class="icon-chemistry"></i><span>Agregar Color a bitacora </span></button><hr><button class="btn btn-outline-danger btn-sm" onclick="CancelarMezcla()" ><i class="icon-chemistry"></i><span>Cancelar</span></button></div>';  
	  }

      
      $DatosJson = json_encode($DatosJson);
      return response()->json(["Tabla"=>$Tabla,"DatosJson"=>$DatosJson]);
    }

    /*==========================================================================*/

    public function InsertaLPA(Request $r){
      //Eliminar datos temporales anteriores
      \DB::table('PEDIDO_COLOR_BITACORA')
           ->where(["PERSONA_ID"=> request()->cookie('Persona_ID')])
           ->delete();
      // debemos validar si el cliente tiene stock suficiente en cada item para agregar el LPA
      $Productos = ($r->input('NJson'));

      foreach ($Productos as $J) {

        $ObtenerInfoInventario = \DB::table('VW_TALLER_PRODUCTO')
                                   ->where("TALLER_ID","=",request()->cookie('Taller_ID'))
                                   ->where("PRODUCTO_ID","=",$J['PRODUCTO_ID'])
                                   ->where('PRESENTACION_ID',"=",$J['PRESENTACION_ID'])
                                   ->get();
        if( $J['CANTIDAD'] > $ObtenerInfoInventario[0]->GRAMOS_DESTARE ){
          \DB::table('PEDIDO_COLOR_BITACORA')
               ->where(["PERSONA_ID"=> request()->cookie('Persona_ID')])
               ->delete();
          return response()->json(["Titulo"=>"No es posible agregar","Mensaje"=>"No es posible agregar el igualado a la bitacora, ya que no cuenta con stock suficiente en el producto ".$J['CLAVE'].", verifique sus datos e intentelo nuevamente","TMensaje"=>"warning"]);
        }else{
          $Insertar = \DB::table('PEDIDO_COLOR_BITACORA')
                       ->insert([
                          "PRODUCTO_ID"=>  $J['PRODUCTO_ID'],
                          "PERSONA_ID"=> request()->cookie('Persona_ID'),
                          "PRESENTACION_ID"=>  $J['PRESENTACION_ID'],
                          "UNIDAD_ID"=> 2, // La unidad_id 2 corresponde a gramos
                          "CANTIDAD"=> $J['CANTIDAD'],
                          "PRECIO"=> 1,
                       ]);
        }



      }



      $SQL = 'EXEC P_IMPORTES_PEDIDO_COLOR_BITACORA '.request()->cookie('Persona_ID').','.request()->cookie('Taller_ID');
      $Calcular = \DB::statement($SQL);

      //Insertar el igualado
	  if($r->input('TipoIgualado')== -1){
	/*$SQL = "EXEC P_GUARDAR_COLOR ";
      $SQL .= request()->cookie('Persona_ID').",".request()->cookie('Bitacora_ID').",".$r->input('LineaColor').",".$r->input('TipoColor').",";
      $SQL .= "'".$r->input('CodColor')."','".$r->input('NomColor')."','',".$r->input('Operario');*/
	  
	  $SQL = "INSERT INTO PEDIDO_BITACORA SELECT PRODUCTO_ID,PERSONA_ID,PRESENTACION_ID,UNIDAD_ID,CANTIDAD,PRECIO,DESCONTAR_GR,1 FROM PEDIDO_COLOR_BITACORA WHERE PERSONA_ID = ".request()->cookie('Persona_ID');
	  $GuardarColor = \DB::statement($SQL);
	  
      $SQL = "DELETE FROM PEDIDO_COLOR_BITACORA WHERE PERSONA_ID = ".request()->cookie('Persona_ID');

      $GuardarColor = \DB::statement($SQL);
	  }else{
      $SQL = "EXEC P_GUARDAR_COLOR ";
      $SQL .= request()->cookie('Persona_ID').",".request()->cookie('Bitacora_ID').",".$r->input('LineaColor').",".$r->input('TipoColor').",";
      $SQL .= "'".$r->input('CodColor')."','".$r->input('NomColor')."','',".$r->input('Operario');

      $GuardarColor = \DB::statement($SQL);		  
	  }


      return response()->json(["Titulo"=>"Agregado correctamente","Mensaje"=>"Has agregado correctamente el igualado a la bitacora","TMensaje"=>"success"]);

    /* require_once('C-Funciones.php');
     EscribirTXT('ArrayProd.txt',json_encode($arrayIDProducto));*/

    }

}
