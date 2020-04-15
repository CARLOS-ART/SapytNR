<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class Bitacoras_Controller extends Controller
{


  public function MenuMaker($M,$Mk,$Mks){
        $MenuMaker = new Menu_Maker_Controller;
        $MenuPrincipal = $MenuMaker->JsonToMenu($M,$Mk,$Mks);
        return $MenuPrincipal;
      }

  /*=======================================================================*/

  public function Bitacora_Interface_5_1() {
    /*
     Objetivo: Mostrar la vista para Introducir los datos para una nueva bitacora
    */
    $MenuPrincipal = self::MenuMaker(0,-1,0);

    return view('Bitacoras.Steep',compact('MenuPrincipal'));
   }
   /*===========================================================================*/

   public function ValidarOT(Request $r){
     if(request()->cookie('Bitacora_ID') == false){
       $Validar = \DB::table('Bitacoras')
                  ->where(["TALLER_ID"=>request()->cookie('Taller_ID'),"OT"=>$r->input('OT')])
                  ->get();
     }else{
       $Validar = \DB::table('Bitacoras')
                  ->where(["TALLER_ID"=>request()->cookie('Taller_ID'),"OT"=>$r->input('OT')])
                  ->whereNotIn("Bitacora_ID",array(request()->cookie('Bitacora_ID')))
                  ->get();
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
       ]);
     }else{
       return response()->json([
         "TMensaje"=>"success",
         "Mensaje"=>$r->input('OT')
       ]);
     }
   }

   /*==========================================================================*/

   public function IntroducirInfo(Request $r){
     require_once('C-Funciones.php');
     if(request()->cookie('Bitacora_ID') == false){
       $BitID = \DB::table('BITACORAS')
                    ->insertGetId([
                      "TALLER_ID"=> request()->cookie('Taller_ID'),
                      "TIPOB_ID"=>1,
                      "SEGURO_ID"=>$r->input('cmbSeguro'),
                      "VEHICULO_ID"=>$r->input('txtVehiculo'),
                      "ESTATUS_ID"=>2,
                      "MEDIDA_ID"=>1,
                      "FOLIO"=>0,
                      "OT"=>strtoupper($r->input('txtNumOrden')),
                      "FECHA"=>TransformaFecha($r->input('txtFecha')).'T00:00:00',
                      "VIN"=>strtoupper($r->input('txtVin')),
                      "PLACAS"=>strtoupper($r->input('txtPlacas')),
                      "MODELO"=>$r->input('txtModelo'),
                      "COLOR"=>strtoupper($r->input('txtColor')),
                      "VALUACION_TALLER"=>$r->input('txtValuacionTaller'),
                      "VALUACION_SEGURO"=>$r->input('txtValuacionSeguro'),
                      "COMENTARIOS"=>""
                    ]);

       $Consecutivo = \DB::statement("EXEC P_ASIGNAR_CONSECUTIVO ".$BitID.",".request()->cookie('Taller_ID'));

       //return redirect('/Bitacoras/Bitacoras')->with("Bitacora_Creada")->cookie('Bitacora_ID',$BitID);
       \Cookie::queue('Bitacora_ID',$BitID);
       return response()->json(["Titulo"=>"Se ha creado la","Mensaje"=>"Bitácora correctamente","TMensaje"=>"success"]);
     }else{

       $ActualizaDatos = \DB::table('BITACORAS')
                         ->where('BITACORA_ID',"=",request()->cookie('Bitacora_ID'))
                         ->update(["SEGURO_ID"=>$r->input('cmbSeguro'),
                         "VEHICULO_ID"=>$r->input('txtVehiculo'),
                         "ESTATUS_ID"=>2,
                         "OT"=>strtoupper($r->input('txtNumOrden')),
                         "FECHA"=>TransformaFecha($r->input('txtFecha')).'T00:00:00',
                         "VIN"=>strtoupper($r->input('txtVin')),
                         "PLACAS"=>strtoupper($r->input('txtPlacas')),
                         "MODELO"=>$r->input('txtModelo'),
                         "COLOR"=>strtoupper($r->input('txtColor')),
                         "VALUACION_TALLER"=>$r->input('txtValuacionTaller'),
                         "VALUACION_SEGURO"=>$r->input('txtValuacionSeguro')]);

       return response()->json(["Titulo"=>"Los datos de la Bitácora","Mensaje"=>"han sido actualizados correctamente","TMensaje"=>"success"]);

     }
   }


  /*=======================================================================*/
    public function CargaProductoBitacora(Request $r){

      $Info = DB::table('VW_TALLER_PRODUCTO')
             ->where(['TALLER_ID'=>request()->cookie('Taller_ID')])
             ->whereIn('CLASIFICACION_ID',$r->input('Clasif'))
             ->get();

             if(in_array(9,$r->input('Clasif'))){
               $Unidad = 'PZA';
             }else{
               $Unidad = 'GR';
             }

             $Json = array();

                   $Datos = array();
                   $x = 0;
                   require_once('C-Funciones.php');
                   foreach ($Info as $i) {
                     //$Json[0]=$i->PRODUCTO_ID;
                     $Json[0]=$i->CODIGO_SAP;
                     $Json[1]=utf8_encode(TruncarString(utf8_decode($i->CLAVE),19));
                     $Json[2]=utf8_encode(TruncarString(utf8_decode($i->PRODUCTO),19));
                     $Json[3]=$i->UM;
                     $Json[4]='0.00';
                     $Json[5]=$Unidad;
                     $Json[6]='100.00';
                     $Datos[$x] = $Json;
                     $x++;
                   }

                   $Info = array();
                   $Info=$Datos;

                   $NInfo = ($Datos);

                   return response()->json(["Json"=>$NInfo,"TMensaje"=>"success"]);
      //SELECT * FROM VW_TALLER_PRODUCTO WHERE TALLER_ID = 2005 AND CLASIFICACION_ID = 1
    }
	/*==============================================================================*//*==============================================================================*/

	    public function BitacorasNew(){
        $MenuPrincipal = self::MenuMaker(0,-1,0);
      if(request()->cookie('Bitacora_ID') == false)
      {

        $BitacoraInfo = '';
        $Piezas = '';
        $Pinturas = 0;
        $Productos = 0;
        //$MostrarC = '';
      }else{
        $BitacoraInfo = \DB::table('VW_BITACORAS_TABLERO')
                        ->where(['Bitacora_ID'=> request()->cookie('Bitacora_ID')])
                        ->get();

        $cPiezas = \DB::table('VW_PARTE_BITACORA')
                      ->where(['Bitacora_ID'=> request()->cookie('Bitacora_ID')])
                      ->get();

        $Piezas = '';

        foreach ($cPiezas as $P) {
          $Piezas .= $P->PARTE.', ';
        }

        $SQL = \DB::table('PINTURAS')
        ->where(['Bitacora_ID'=> request()->cookie('Bitacora_ID')])
        ->get();

        $Pinturas = sizeof($SQL);

        $SQL2 = \DB::table('BITACORA_PRODUCTO')
        ->where(['Bitacora_ID'=> request()->cookie('Bitacora_ID')])
        ->get();

        $Productos = sizeof($SQL2);


      }


      return view('Bitacoras.Steep',compact('BitacoraInfo','Piezas','Pinturas','Productos','MenuPrincipal'));
    }

    /*==============================================================================*/
      public function ObtenerVehiculos(Request $r){
        $Vehiculos = \DB::table('VEHICULOS')
                       ->where("MARCA_ID","=",$r->input('Marca'))
                       ->orderBy('VEHICULO')
                       ->get();
        $Lst = '';
        foreach ($Vehiculos as $v) {
          $Lst .= '<option value="'.$v->VEHICULO_ID.'">'.$v->VEHICULO.'</option>';
        }

        $Combo = '<div class="form-group form-group-default form-group-default-select2 required">
          <label class="">Vehículo</label>
          <select class="full-width" name="cmbVehiculo" id="cmbVehiculo">'.$Lst.'<select>';

        return response()->json(["Combo"=>$Combo]);
      }
    /*==============================================================================*/

    public function AddItems(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      $OT = '';
      if(request()->cookie('Bitacora_ID') != false){
        $NumOT = \DB::table('BITACORAS')
                  ->where('BITACORA_ID',"=",request()->cookie('Bitacora_ID'))
                  ->get();

        $OT = $NumOT[0]->OT;
      }

      $SQL = 'SELECT * FROM PERSONAS WHERE PERSONA_ID IN(SELECT PERSONA_ID FROM OPERARIOS WHERE TALLER_ID = '.request()->cookie('Taller_ID').' AND ACTIVO = 1) ';
      $Operarios = \DB::select($SQL);

      $Bitacoras = \DB::table('VW_BITACORAS_TABLERO')->where('BITACORA_ID',"=",request()->cookie('Bitacora_ID'))->get();



      return view('Bitacoras.Productos_Plantilla',compact('Bitacoras','OT','Operarios','MenuPrincipal'));
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

      $Rows = '<thead><tr><td>CLAVE</td><td>PRODUCTO</td><td>EXISTENCIA</td><td>GRAMOS</td><td>PRECIO</td><td>LINEA</td></tr></thead>';
      if (sizeof($Obtener) >= 1) {
        foreach ($Obtener as $O) {
          $Rows .= '<tr onclick="useItem('.$O->PRODUCTO_ID.','.$O->PRESENTACION_ID.')" style="cursor:pointer">';
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
                    <div class="col-sm-4">
                    <div class="form-group">
                       <label for="">Para uso en:</label>
                       <select class="form-control" name="cmbProceso" id="cmbProceso">
                         <option value="1"> HOJALATERIA </option>
                         <option value="2"> PREPARACION </option>
                         <option value="3">PINTURA </option>
                         <option value="4"> OTROS </option>
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
      $Insertar = \DB::table('PEDIDO_BITACORA')
                   ->insert([
                      "PRODUCTO_ID"=>  $r->input('Pro'),
                      "PERSONA_ID"=> request()->cookie('Persona_ID'),
                      "PRESENTACION_ID"=>  $r->input('Pre'),
                      "UNIDAD_ID"=> $r->input('Um'),
                      "CANTIDAD"=> $r->input('Can'),
                      "PRECIO"=> 1,
                      "PROCESO_ID"=>$r->input('Proc')
                   ]);

      $SQL = 'EXEC P_IMPORTES_PEDIDO_BITACORA '.request()->cookie('Persona_ID').','.request()->cookie('Taller_ID');
      $Calcular = \DB::statement($SQL);
      return response()->json(["TMensaje"=>"success"]);
    }

    /*===============================================================================*/

    public function ObtenerProducto(Request $r){
      //Inserta a handsontable
      if(strpos($r->input('Cve'),'=')){
        $Datos = explode('=',$r->input('Cve'));
        $Obtener = \DB::table('VW_TALLER_PRODUCTO')
                    ->where([
                      "TALLER_ID"=>request()->cookie('Taller_ID'),
                      "CLAVE"=>$Datos[0],
                      "UM"=>$Datos[1]
                    ])
                    ->get();

      }else{

        $Obtener = \DB::table('VW_TALLER_PRODUCTO')
                    ->where([
                      "TALLER_ID"=>request()->cookie('Taller_ID'),
                      "CLAVE"=>$r->input('Cve'),
                      "BASF"=>0
                    ])
                    ->get();

      }

      if (sizeof($Obtener)>=1) {
        $Insertar = \DB::table('PEDIDO_BITACORA')
                     ->insert([
                        "PRODUCTO_ID"=> $Obtener[0]->PRODUCTO_ID,
                        "PERSONA_ID"=> request()->cookie('Persona_ID'),
                        "PRESENTACION_ID"=> $Obtener[0]->PRESENTACION_ID,
                        "UNIDAD_ID"=> 1,
                        "CANTIDAD"=> 0,
                        "PRECIO"=> 0,
                     ]);
      }

      $Obtener = \DB::table('VW_PEDIDO_BITACORA')
                  ->where(["PERSONA_ID"=>request()->cookie('Persona_ID')])
                  ->get();

      $Datos = array();
      $Items = array();
      $x = 0;

      foreach ($Obtener as $Info) {
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

    /*===============================================================================*/

    public function validarItems($Items){
      $Items = json_decode($Items);
      $ItemsCount = sizeof($Items)-1;
      $Fila = 1;
      $SQL = '';

      foreach ($Items as $i) {
        if($Fila>$ItemsCount){
             break;
        }

        if(!in_array(strtoupper($i[5]),array('PZA','ML','GR','OZ'))){
          return array(1,
                       "Error en la fila ".$Fila.", Columna UM",
                       "El valor ".$i[5]." para la unidad de medida no es valido.",
                       "warning");
        }else{
          switch (strtoupper($i[5])) {
            case 'ML': $UM = 1 ;  break;
            case 'GR': $UM = 2 ;  break;
            case 'PZA': $UM = 3;  break;
            case 'OZ': $UM = 4 ;  break;
          }
        }

        $Valor = str_replace(',','',$i[4]);

        if(!is_numeric($Valor)){
          return array(2,"Dato incorrecto","Se esperaba un valor numerico en la fila ".$Fila.", el valor recibido es:".$i[2]." para la Columna Cantidad.","warning");
        }

        if($Valor>0){
          $SQL .= "EXEC P_PEDIDO_BITACORA '".$i[0]."',".request()->cookie('Persona_ID').",".$UM.",".$Valor.",".request()->cookie('Taller_ID').";";
        }


        $Fila++;
      }


      $SQL .= 'EXEC P_IMPORTES_PEDIDO_BITACORA '.request()->cookie('Persona_ID').','.request()->cookie('Taller_ID');
      $Calcular = \DB::statement($SQL);

      return array(3,"Proceso correcto!",'',"success");
    }

    /*=============================================================================*/

    public function FinalizarCaptura(Request $r){
      //Primero: Eliminamos cualquier Item del usuario en la tabla "PEDIDO_BITACORA"
      $Eliminar = DB::statement('DELETE FROM PEDIDO_BITACORA WHERE PERSONA_ID = '.request()->cookie('Persona_ID'));

      //Segundo: Validar el dato Cantidad y la existencia solicitada los elementos que se encuentran en cada grupo de productos
      $ProductoGrupo = $r->input('Elementos');
      $Resultados = array();
      $x=0;
      foreach ($ProductoGrupo as $GP) {
        $Comprobar = self::validarItems($GP);
        if($Comprobar[3] != "success"){
          switch ($x) {
            case 0:
              $Seccion = 'SECCION PRIMARIOS: ';
            break;
            case 1:
              $Seccion = 'SECCION TRANSPARENTES: ';
            break;
            case 2:
              $Seccion = 'SECCION ADICIONALES (BASF): ';
            break;
            case 4:
              $Seccion = 'COMPLEMENTOS(ALIADOS): ';
            break;
          }
          return response()->json(["Titulo"=>$Comprobar[1],
                                   "Mensaje"=>$Seccion.$Comprobar[2],
                                   "TMensaje"=>$Comprobar[3]
                                  ]);
        }
        $x++;
      }

      //Validar Existencias y guardar productos

      $ValidaGuardar = self::GuardarProductos($r->input('Operario'));

      return response()->json(["Titulo"=>$ValidaGuardar[0],
      "Mensaje"=>$ValidaGuardar[1],
      "TMensaje"=>$ValidaGuardar[2]]);
    }

    /*=============================================================================*/

    public function PreviewItems(Request $r){
      $Items = $r->input('Info');
      $Comprobar = self::validarItems($Items);

      $Info = '';
      if($Comprobar[3] == "success"){
        $Info = self::ObtenerItems();
      }

      return response()->json([
          "Titulo"=>$Comprobar[1],
          "Mensaje"=>$Comprobar[2],
          "TMensaje"=>$Comprobar[3],
          "Info"=>$Info
        ]);

      }

    /*====================================================================================*/

    public function GuardarProductos($Operario){
      //Esta funcion es la que inserta finalmente en la bitacora los productos agregados
      // Validacion de existencias (Nivel 2)

      $CompararExistencias = \DB::select('SELECT * FROM F_VALIDAR_EXISTENCIAS('.request()->cookie('Taller_ID').','.request()->cookie('Persona_ID').')');
      $Query = '';
      $Descontar = '';
      foreach ($CompararExistencias as $C) {
        if($C->UNIDAD_ID == 3){
          $Existencia = $C->SELLADO;
          $Mensaje = "Usted debe adquirir más de este producto con su proveedor";
        }else{
          $Existencia = $C->GRAMOS_DESTARE;
          $Mensaje = "Usted debe solicitar un producto nuevo al almácen";
        }

        if ($Existencia < $C->DESCONTAR_GR) {
          return array(
                         "No hay producto suficiente!",
                         "El producto ".$C->CLAVE.' '.$C->PRODUCTO." no tiene existencia suficiente para agregarlo a la bitacora. ".$Mensaje,
                         "warning"
                       );
        }

        $Query .= "Insert into Bitacora_Producto Select ".request()->cookie('Bitacora_ID').','.$C->PRODUCTO_ID.','.$C->PRESENTACION_ID.','.$Operario.','.$C->UNIDAD_ID.',';
        $Query .= number_format($C->CANTIDAD,4).','.number_format($C->PRECIO,4).','.number_format($C->PRECIO,4).',1,'.$C->PROCESO_ID.';';

        $Descontar .= "Update Taller_Producto Set ";
        if($C->UNIDAD_ID == 3){
          $Descontar .= "Sellado = Sellado - ".$C->CANTIDAD;
        }else{
          $Descontar .= "Abierto = Abierto - ".$C->DESCONTAR_GR;
        }

        $Descontar .= "Where Taller_ID = ".request()->cookie('Taller_ID')." and Producto_ID = ".$C->PRODUCTO_ID." and Presentacion_ID = ".$C->PRESENTACION_ID.";";

      }

      $Descontar .= "DELETE FROM PEDIDO_BITACORA WHERE PERSONA_ID = ". request()->cookie('Persona_ID');

      $Guardar = \DB::statement($Query);
      $Restar = \DB::statement($Descontar);

      return array(
        "Productos cargados correctamente!",
        "Se han cargado los productos correctamente a la bitacora",
        "success"
      );

    }

    /*====================================================================================*/

    private function ObtenerItems(){
      $Obtener = \DB::table('VW_PEDIDO_BITACORA')
                  ->where(["PERSONA_ID"=>request()->cookie('Persona_ID')])
                  ->orderBy('ITEM')
                  ->get();

      $Datos = array();
      $Items = array();
      $x = 0;

      foreach ($Obtener as $Info) {
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

      return $Datos;
    }

    /*===============================================================================*/

    public function EliminarItemTMP(Request $r){
      $Eliminar = \DB::table('PEDIDO_BITACORA')
                  ->where("ITEM","=",$r->input('Item'))
                  ->delete();

      $Info = self::ObtenerItems();
      return response()->json(["Info"=>$Info]);
    }

    /*===============================================================================*/

    public function BitacorasInfo(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      $Seguros = \DB::table('SEGUROS')
                    ->orderBy('SEGURO')
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
          $BitacoraInfo = '';
          $Vehiculos = \DB::table('VEHICULOS')
                       ->where("MARCA_ID","=",$MarcaId)
                       ->get();
        }else{
          $BitacoraInfo = \DB::table('VW_BITACORAS_TABLERO')
                          ->where(['Bitacora_ID'=> request()->cookie('Bitacora_ID')])
                          ->get();
          $Vehiculos = \DB::table('VEHICULOS')
                       ->where("MARCA_ID","=",$BitacoraInfo[0]->MARCA_ID)
                       ->get();
         }

      return view('Bitacoras.CrearBitacora',compact('Seguros','Marcas','Vehiculos','BitacoraInfo','MenuPrincipal'));
    }

    /*==========================================================================*/

    public function SelectorPiezas(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);

      $Tam = DB::table('MEDIDAS_VEHICULO')->get();

      $BitacoraInfo = \DB::table('VW_BITACORAS_TABLERO')
                      ->where(['Bitacora_ID'=> request()->cookie('Bitacora_ID')])
                      ->get();

      $Medida = $BitacoraInfo[0]->MEDIDA_ID;

      return view('Bitacoras.ReparacionPiezas',compact('Tam','Medida','MenuPrincipal'));
    }

    /*==========================================================================*/

    public function NuevaPza(Request $r){
      $GuardaPza = \DB::table('PARTE_BITACORA')
      ->insert([
        "PARTE_ID"=>0,
        "BITACORA_ID"=>request()->cookie('Bitacora_ID'),
        "CONDICION_ID"=>$r->input('Condicion'),
        "VALOR"=>$r->input('Pieza'),
        "COMENTARIO"=>strtoupper($r->input('NamePza'))
      ]);

      $LeerItems = \DB::table('VW_PARTE_BITACORA')
      ->where(["BITACORA_ID"=>request()->cookie('Bitacora_ID')])
      ->get();

      $Datos = array();
      $Items = array();
      $x = 0;

      foreach ($LeerItems as $Info) {
        $Items[0] = $Info->PARTE_ID;
        $Items[1] = $Info->PARTE;
        $Items[2] = $Info->CONDICION;
        $Items[3] = number_format($Info->VALOR,2);
        $Datos[$x] = $Items;
        $x++;
      }

      $Info = array();

      if(sizeof($Datos) == 0){
        $Datos[0] = array('','','','','','','','');
      }
      $Info = $Datos;


      return response()->json([
        "Titulo"=>"Proceso satisfactorio!",
        "Mensaje"=>"La pieza se ha agregado correctamente a la bitacora actual",
        "TMensaje"=>"success",
        "Piezas"=>$Info
      ]);

    }

    /*==========================================================================*/

     public function GuardaCambios(Request $r){
       //Actualiza el tamaño del vehiculo
       $Actualizar = \DB::table('BITACORAS')
                       ->where(["BITACORA_ID"=>request()->cookie('Bitacora_ID')])
                       ->update(["MEDIDA_ID"=>$r->input('Medida')]);

      $Info = ($r->input('Info'));
      $SQL = '';
      foreach ($Info as $Inf) {
        if ($Inf[0] != 0) {
          $SQL .= 'UPDATE PARTE_BITACORA SET VALOR = '.$Inf[3].' WHERE PARTE_ID = '.$Inf[0].' AND BITACORA_ID = '.request()->cookie('Bitacora_ID').";";
        }else{
          $SQL .= 'UPDATE PARTE_BITACORA SET VALOR = '.$Inf[3].' WHERE PARTE_ID = '.$Inf[0].' AND BITACORA_ID = '.request()->cookie('Bitacora_ID')." AND COMENTARIO = '".trim($Inf[1])."';";
        }

      }

      $Update = \DB::statement($SQL);

       return response()->json(['Url'=>'/Bitacoras/Bitacoras']);
     }

    /*==========================================================================*/

    public function CargarPieza(Request $r){

     $Codigos = \DB::table('PARTES_COLISION')
                 ->where("COD_PARTE","=",$r->input('Pieza'))
                 ->get();

      if(sizeof($Codigos)<=0){
        return response()->json([
          "Titulo"=>"Codigo incorrecto",
          "Mensaje"=>"El codigo de pieza ingresado es incorrecto o no existe",
          "TMensaje"=>"warning"
        ]);
      }

      $Pieza = $Codigos[0]->PARTE_ID;

      $Existe = \DB::table('VW_VALORES_PARTES')
      ->where([
              "PARTE_ID"=>$Pieza,
              "CONDICION_ID"=>$r->input('Condicion'),
              "MEDIDA_ID"=>$r->input('Medida')
              ])
      ->get();


      if(sizeof($Existe)<=0){
        return response()->json([
          "Titulo"=>"Pieza seleccionada no existe",
          "Mensaje"=>"El numero de pieza que usted proporcionó, no existe, por favor verifique su información",
          "TMensaje"=>"warning"
        ]);
      }

      $EnBitacora = \DB::table('PARTE_BITACORA')
      ->where([
        "PARTE_ID"=>$Pieza,
        "BITACORA_ID"=>request()->cookie('Bitacora_ID')
        ])
      ->get();

      if (sizeof($EnBitacora)>=1) {
        return response()->json([
          "Titulo"=>"Agregado previamente",
          "Mensaje"=>"El numero de pieza que usted proporcionó ya fue agregado anteriormente a la bitacora",
          "TMensaje"=>"warning"
        ]);
      }

      $NumPza = $Existe[0]->CANT_DEFAULT;

      $GuardaPza = \DB::table('PARTE_BITACORA')
      ->insert([
        "PARTE_ID"=>$Pieza,
        "BITACORA_ID"=>request()->cookie('Bitacora_ID'),
        "CONDICION_ID"=>$r->input('Condicion'),
        "VALOR"=>$NumPza,
        "COMENTARIO"=>''
      ]);

      $LeerItems = \DB::table('VW_PARTE_BITACORA')
      ->where(["BITACORA_ID"=>request()->cookie('Bitacora_ID')])
      ->get();

      $Datos = array();
      $Items = array();
      $x = 0;

      foreach ($LeerItems as $Info) {
        $Items[0] = $Info->PARTE_ID;
        $Items[1] = $Info->PARTE;
        $Items[2] = $Info->CONDICION;
        $Items[3] = number_format($Info->VALOR,2);
        $Datos[$x] = $Items;
        $x++;
      }

      $Info = array();

      if(sizeof($Datos) == 0){
        $Datos[0] = array('','','','','','','','');
      }
      $Info = $Datos;


      return response()->json([
        "Titulo"=>"Proceso satisfactorio!",
        "Mensaje"=>"La pieza se ha agregado correctamente a la bitacora actual",
        "TMensaje"=>"success",
        "Piezas"=>$Info
      ]);


    }

    /*============================================================================*/

    public function LeerPiezasBitacora(){
      $LeerItems = \DB::table('VW_PARTE_BITACORA')
      ->where(["BITACORA_ID"=>request()->cookie('Bitacora_ID')])
      ->get();

      $Datos = array();
      $Items = array();
      $x = 0;

      foreach ($LeerItems as $Info) {
        $Items[0] = $Info->PARTE_ID;
        $Items[1] = $Info->PARTE;
        $Items[2] = $Info->CONDICION;
        $Items[3] = number_format($Info->VALOR,2);
        $Datos[$x] = $Items;
        $x++;
      }

      $Info = array();

      if(sizeof($Datos) == 0){
        $Datos[0] = array('','','','','','','','');
      }
      $Info = $Datos;

      return response()->json([
        "Titulo"=>"Proceso satisfactorio!",
        "Mensaje"=>"La pieza se ha agregado correctamente a la bitacora actual",
        "TMensaje"=>"success",
        "Piezas"=>$Info
      ]);
    }

    /*============================================================================*/

    public function setCondicion(Request $r){
      $SQL = "UPDATE VW_PARTE_BITACORA SET CONDICION_ID = ".$r->input('Condicion')." WHERE PARTE_ID = ".$r->input('Pieza')." AND BITACORA_ID = ".request()->cookie('Bitacora_ID');
      $Exec = DB::statement($SQL);
      return response()->json(["TMensaje"=>"success"]);
    }

    /*============================================================================*/

    public function EliminarPieza(Request $r){
      if($r->input('Pieza') != 0){
      $Eliminar = \DB::table('PARTE_BITACORA')
                  ->where(["PARTE_ID"=>$r->input('Pieza'),"BITACORA_ID"=>request()->cookie('Bitacora_ID')])
                  ->delete();
      }else{

        $LeerItems = \DB::table('VW_PARTE_BITACORA')
        ->where(["BITACORA_ID"=>request()->cookie('Bitacora_ID')])
        ->get();

        $F = $r->input('Pos');
        $x = 0;

        foreach($LeerItems as $I){
          if($x == $F){
            $Parte = $I->PARTE;
            $Condicion_ID = $I->CONDICION_ID;
            $Valor = $I->VALOR;
            $Eliminar = \DB::table('PARTE_BITACORA')
                  ->where([
                    "PARTE_ID"=>0,
                    "BITACORA_ID"=>request()->cookie('Bitacora_ID'),
                    "CONDICION_ID"=>$Condicion_ID,
                    "VALOR"=>$Valor,
                    "COMENTARIO"=>trim($Parte)])
                  ->delete();

          }
          $x++;
        }

      }

      $LeerItems = \DB::table('VW_PARTE_BITACORA')
      ->where(["BITACORA_ID"=>request()->cookie('Bitacora_ID')])
      ->get();

      $Datos = array();
      $Items = array();
      $x = 0;

      foreach ($LeerItems as $Info) {
        $Items[0] = $Info->PARTE_ID;
        $Items[1] = $Info->PARTE;
        $Items[2] = $Info->CONDICION;
        $Items[3] = number_format($Info->VALOR,2);
        $Datos[$x] = $Items;
        $x++;
      }

      $Info = array();

      if(sizeof($Datos) == 0){
        $Datos[0] = array('','','','','','','','');
      }
      $Info = $Datos;


      return response()->json([
        "Titulo"=>"Proceso satisfactorio!",
        "Mensaje"=>"La pieza se ha eliminado correctamente de la bitacora actual",
        "TMensaje"=>"success",
        "Piezas"=>$Info
      ]);

    }

  /*============================================================================*/

    public function TerminarCaptura(){
      \Cookie::queue(\Cookie::forget('Bitacora_ID'));
      return redirect('/Bitacoras/Bitacoras');
    }

   /*===========================================================================*/

   public function AdministrarPartidas(){
     $MenuPrincipal = self::MenuMaker(0,-1,0);

     $Partidas = \DB::select('EXEC RPT_BITACORA '.request()->cookie('Bitacora_ID'));

     $SQL = 'SELECT * FROM PERSONAS WHERE PERSONA_ID IN(SELECT PERSONA_ID FROM OPERARIOS WHERE TALLER_ID = '.request()->cookie('Taller_ID').' AND ACTIVO = 1) ';
     $Operarios = \DB::select($SQL);
     return view('Bitacoras.AdministrarPartidas',compact('Partidas','Operarios','MenuPrincipal'));
   }

   /*===========================================================================*/

   public function EliminarPartida(Request $r){
     $Eliminar = \DB::statement('EXEC P_ELIMINAR_PARTIDA '.$r->input('Partida'));
     return response()->json(["TMensaje"=>"success"]);
   }

   /*===========================================================================*/

   public function EditarOperario(Request $r){
     $Actualizar = \DB::table('BITACORA_PRODUCTO')
                        ->where('PARTIDA','=',$r->input('Partida'))
                        ->update([
                          "PERSONA_ID"=>$r->input('NOperario')
                        ]);
      return response()->json(["TMensaje"=>"success","Mensaje"=>"Cambio de operario realizado correctamente en partida seleccionada","Titulo"=>"Exito"]);

   }

    /*===========================================================================*/

    public function ActualizarComentario(Request $r) {
      $actualizar = \DB::table('BITACORAS')
                       ->where('BITACORA_ID','=',request()->cookie('Bitacora_ID'))
                       ->update([
                         "COMENTARIOS"=>$r->input('coments')
                       ]);



      //

          return response()->json(["TMensaje"=>"success","Mensaje"=>"El comentario se agregó correctamente.","Titulo"=>"Exito"]);
    }

/*================================================================================*/

    public function MostrarComentario(Request $r) {

      $MostrarC = \DB::table('BITACORAS')
                     ->where('BITACORA_ID','=',request()->cookie('Bitacora_ID'))
                     ->get();

      $Comentario = $MostrarC[0]->COMENTARIOS;

      return response()->json(["Comentario"=>$Comentario]);

    }

}
