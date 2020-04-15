<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Productos_Controller extends Controller
{

  public function MenuMaker($M,$Mk,$Mks){
        $MenuMaker = new Menu_Maker_Controller;
        $MenuPrincipal = $MenuMaker->JsonToMenu($M,$Mk,$Mks);
        return $MenuPrincipal;
      }

  /*=======================================================================*/
   public function VAliados(){
     $MenuPrincipal = self::MenuMaker(0,-1,0);
       $Historico = \DB::table('VW_SOLICITUD_ALIADOS')
                    ->where("TALLER_ID","=",request()->cookie('Taller_ID'))
                    ->orderBy("Fecha")
                    ->get();

       return view('Productos.TableroAliados',compact('Historico','MenuPrincipal'));
   }

   /*===========================================================================*/

   public function EditarFormatoAliados(Request $r){
     \Cookie::queue('Solicitud_ID',$r->input('Formato'));
     return "success";
   }

   /*===========================================================================*/

   public function Traspaso(){
     $MenuPrincipal = self::MenuMaker(0,-1,0);
     return view('Productos.Traspaso',compact('MenuPrincipal'));
   }

   /*===========================================================================*/

   public function CargarDatosFormato(Request $r){
     $ObtenerItems = \DB::table('ITEMS_ALIADOS')
                                ->where(['SOLICITUD_ID'=>request()->cookie('Solicitud_ID')])
                                ->get();
     $Datos = array();
     $Items = array();
     $x = 0;

     foreach ($ObtenerItems as $Info) {
       $Items[0] = $Info->CLAVE;
       $Items[1] = $Info->DESCRIPCION;
       $Items[2] = number_format($Info->PRECIOC,2);
       $Items[3] = number_format($Info->PRECIOV,2);
       $Items[4] = number_format($Info->EXISTENCIA_INI,2);
       $Datos[$x] = $Items;
       $x++;
     }

     $Info = array();

     if(sizeof($Datos) == 0){
       $Datos[0] = array('','','','','');
     }
     $Info = $Datos;
     return response()->json(["TMensaje"=>"success","Info"=>$Info]);
   }

   /*===========================================================================*/

   public function CancelarFormatoAliados(Request $r){
     $Formato = \DB::table('SOLICITUD_ALIADOS')
                 ->where('SOLICITUD_ID',"=",$r->input('Formato'))
                 ->update(["ESTATUS_ID"=>3]);
     return response()->json(["Titulo"=>"Cancelación exitosa","Mensaje"=>"Se ha realizado la cancelación del formato de carga de productos aliados","TMensaje"=>"success"]);
   }

   /*===========================================================================*/

   public function VFormatoAliados(){
    $NuevoID = \DB::table('SOLICITUD_ALIADOS')
                 ->insertGetId([
                    "PERSONA_ID"=>request()->cookie('Persona_ID'),
                    "ESTATUS_ID"=>2,
                    "TALLER_ID"=>request()->cookie('Taller_ID'),
                    "FECHA"=>date('Y-m-d')."T".date('h:i:s')
                 ]);

    return redirect('/Productos/FormatoAliados/Captura')
                 ->with('Datos',"Correcto")
                 ->cookie('Solicitud_ID',$NuevoID);
    //return view('Productos.FormatoAliados',compact('NuevoID'))->cookie('Solicitud_ID',$NuevoID);
   }

   /**========================================================================= */

   public function VCapturaAliados(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
       return view('Productos.FormatoAliados',compact('MenuPrincipal'));
   }

   /*==========================================================================*/

   public function GuardarAliados(Request $r){

    $Quit = \DB::table('ITEMS_ALIADOS')
    ->where("SOLICITUD_ID","=",request()->cookie('Solicitud_ID'))
    ->delete();

    $Aliados = $r->input('Aliados');
    $Fila = 1;

    $QueryFinal = '';
    $ItemsCount = sizeof($Aliados)-1;

    foreach($Aliados as $I){

       if($Fila>$ItemsCount){
            break;
       }

       $Clave = $I[0];
       $Descripcion = $I[1];

      for($A=2;$A<=4;$A++){

          $Valor = str_replace(',','',$I[$A]);

          if(!is_numeric($Valor)){
            switch($A){
              case 2: $Columna = 'PRECIO COMPRA'; break;
              case 3: $Columna = 'PRECIO VENTA';  break;
              case 4: $Columna = 'EXISTENCIA INICIAL';    break;
            }
            return response()->json(["Titulo"=>"Algún dato proporcionado es erroneo","TMensaje"=>"warning","Mensaje"=>"Se esperaba un dato numerico para el dato ".$Columna." de la fila ".$Fila]);
          }else{
            switch($A){
              case 2: $PrecioC = $Valor;  break;
              case 3: $PrecioV = $Valor;  break;
              case 4: $Sellado = $Valor;  break;
            }
          }

      }

      $QueryFinal .= "INSERT INTO ITEMS_ALIADOS VALUES(".request()->cookie('Solicitud_ID').",upper('".$Clave."'),upper('".$Descripcion."'),".$PrecioC.",".$PrecioV.",".$Sellado.",'');";
      $Fila++;

    }

    $Guardar = \DB::statement($QueryFinal);



    return response()->json([
        "Titulo"=>"Guardado correctamente",
        "Mensaje"=>"Se han guardado los cambios realizados a su captura, es importante mencionar que este proceso no ha cargado los productos indicados en su inventario",
        "TMensaje"=>"info"]);
   }

   /*==========================================================================*/

   public function TerminarYCargar(Request $r){

    $Verificar = \DB::table('SOLICITUD_ALIADOS')
                  ->where("SOLICITUD_ID","=",request()->cookie('Solicitud_ID'))
                  ->get();

    $Estatus = $Verificar[0]->ESTATUS_ID;

    switch($Estatus){
        case 1:
        return response()->json([
            "Titulo"=>"Esta solicituda ya fue cargarda",
            "Mensaje"=>"No es posible cargar la misma solicitud mas de una vez. Esta solicitud ya fue cargada a su inventario",
            "TMensaje"=>"warning"
        ]);
        break;
        case 3:
        return response()->json([
            "Titulo"=>"Solicitud Cancelada",
            "Mensaje"=>"No es posible cargar una solicitud cancelada.",
            "TMensaje"=>"warning"
        ]);
        break;
    }

    $Quit = \DB::table('ITEMS_ALIADOS')
    ->where("SOLICITUD_ID","=",request()->cookie('Solicitud_ID'))
    ->delete();

    $Aliados = $r->input('Aliados');
    $Fila = 1;

    $QueryFinal = '';
    $ItemsCount = sizeof($Aliados)-1;

    foreach($Aliados as $I){

       if($Fila>$ItemsCount){
            break;
       }

       $Clave = $I[0];
       $Descripcion = $I[1];

       //Verificar Productos NO BASF en el taller

       $NoBasf = \DB::table('VW_TALLER_PRODUCTO')
                  ->where("BASF","=",0)
                  ->where("CLAVE","=",$Clave)
                  ->where('TALLER_ID',"=",request()->cookie('Taller_ID'))
                  ->get();

       if(sizeof($NoBasf)>=1){
        return response()->json(["Titulo"=>"La clave ya existe","TMensaje"=>"warning","Mensaje"=>"Ya existe un producto con la clave ".$Clave." encontrado en la fila ".$Fila]);
       }

       // Verificar Producto del catalogo BASF

       $Basf = \DB::table('VW_PRODUCTO_PRESENTACION')
                  ->where("BASF","=",1)
                  ->where("CLAVE","=",$Clave)
                  ->get();

        if(sizeof($Basf)>=1){
            return response()->json(["Titulo"=>"La clave ya existe","TMensaje"=>"warning","Mensaje"=>"La clave ".$Clave." encontrado en la fila ".$Fila." pertenece a un producto oficial de BASF, por lo que usted no puede utilizarla para un producto Aliado"]);
         }

      for($A=2;$A<=4;$A++){

          $Valor = str_replace(',','',$I[$A]);

          if(!is_numeric($Valor)){
            switch($A){
              case 2: $Columna = 'PRECIO COMPRA'; break;
              case 3: $Columna = 'PRECIO VENTA';  break;
              case 4: $Columna = 'EXISTENCIA INICIAL';    break;
            }
            return response()->json(["Titulo"=>"Algún dato proporcionado es erroneo","TMensaje"=>"warning","Mensaje"=>"Se esperaba un dato numerico para el dato ".$Columna." de la fila ".$Fila]);
          }else{
            switch($A){
              case 2: $PrecioC = $Valor;  break;
              case 3: $PrecioV = $Valor;  break;
              case 4: $Sellado = $Valor;  break;
            }
          }

      }

      $RandomSAP = uniqid();
      $RandomSAP = substr($RandomSAP,0,8);
      $QueryFinal .= "INSERT INTO ITEMS_ALIADOS VALUES(".request()->cookie('Solicitud_ID').",upper('".$Clave."'),upper('".$Descripcion."'),".$PrecioC.",".$PrecioV.",".$Sellado.",'".$RandomSAP."');";
      $Fila++;

    }

    $Guardar = \DB::statement($QueryFinal);

    $Terminar = \DB::statement("EXEC P_TERMINA_CARGA_ALIADOS ".request()->cookie('Solicitud_ID'));



    return response()->json([
        "Titulo"=>"Proceso existoso!",
        "Mensaje"=>"Los productos aliados han sido cargados a su inventario exitosamente",
        "TMensaje"=>"success"
    ]);
   }

   /*============================================================================*/

   public function VCambiarPrecios(){
     $MenuPrincipal = self::MenuMaker(0,-1,0);
     if(request()->cookie('CambiarPrecios') == false){
       $SQL = 'DELETE FROM PRECIOS_TALLER_PRODUCTO WHERE TALLER_ID = '.request()->cookie('Taller_ID').";";
       $SQL .= 'INSERT INTO PRECIOS_TALLER_PRODUCTO SELECT TALLER_ID,PRODUCTO_ID,PRESENTACION_ID,PCOMPRA,PVENTA,PCOMPRA,PVENTA FROM TALLER_PRODUCTO WHERE TALLER_ID = '.request()->cookie('Taller_ID');

       $Precios = \DB::statement($SQL);
       \Cookie::queue('CambiarPrecios','ON');
     }


     return view('Productos.CambioPrecios',compact('MenuPrincipal'));
   }

   /*============================================================================*/

   public function VCambiarPreciosPorcentaje(){
       $MenuPrincipal = self::MenuMaker(0,-1,0);
     $Lineas = \DB::table('LINEAS')->get();
     return view('Productos.CambioPrecioPorcentaje',compact('Lineas','MenuPrincipal'));
   }

   /*============================================================================*/

   public function CambiarPreciosPorcentaje(Request $r){
     $Porcentaje = $r->input('Porcentaje') / 100;
     $Porcentaje = $Porcentaje + 1;
    \DB::statement('INSERT INTO PRECIOS_TALLER_PRODUCTO SELECT TALLER_ID,PRODUCTO_ID,PRESENTACION_ID,PCOMPRA,PVENTA,PCOMPRA*'.$Porcentaje.',PVENTA*'.$Porcentaje.' FROM TALLER_PRODUCTO WHERE PRODUCTO_ID IN (SELECT PRODUCTO_ID FROM PRODUCTOS WHERE LINEA_ID = '.$r->input('Linea').') AND TALLER_ID ='.request()->cookie('Taller_ID'));
    $SQL = 'EXEC P_CAMBIAR_PRECIOS '.request()->cookie('Persona_ID').','.request()->cookie('Taller_ID');
    $Actualizar = \DB::statement($SQL);


    return response()->json(["Titulo"=>"Proceso satisfactorio!","TMensaje"=>"success","Mensaje"=>"Los precios se han actualizado correctamente de acuerdo a la información proporcionada"]);

   }

   /*============================================================================*/

   public function CargarInventario(){
     $Inventario = \DB::table('VW_PRECIOS_TALLER_PRODUCTO')
                        ->where("TALLER_ID","=",request()->cookie('Taller_ID'))
                        ->get();

     $Datos = array();
     $Items = array();
     $x = 0;

     foreach ($Inventario as $Info) {
       $Items[0] = $Info->CODIGO_SAP;
       $Items[1] = $Info->CLAVE;
       $Items[2] = $Info->PRODUCTO;
       $Items[3] = number_format($Info->PCOMPRA_NVO,2);
       $Items[4] = number_format($Info->PVENTA_NVO,2);
       $Datos[$x] = $Items;
       $x++;
     }

     $Info = array();

     if(sizeof($Datos) == 0){
       $Datos[0] = array('','','','','');
     }
     $Info = $Datos;
     return response()->json(["TMensaje"=>"success","Info"=>$Info]);
   }

   /*============================================================================*/

   public function FiltrarProductos(Request $r){
     $Inventario = json_decode($r->input('Inventario'));
     $x = 1;

     $QueryFinal = '';

     foreach($Inventario as $I){

       for($A=3;$A<=4;$A++){

           $Valor = str_replace(',','',$I[$A]);

           if(!is_numeric($Valor)){
             switch($A){
               case 3: $Columna = 'PRECIO COMPRA'; break;
               case 4: $Columna = 'PRECIO VENTA';  break;

             }
             return response()->json(["Titulo"=>"Algún dato proporcionado es erroneo","TMensaje"=>"warning","Mensaje"=>"Se esperaba un dato numerico para el dato ".$Columna." de la fila ".$x]);
           }else{
             switch($A){
               case 3: $PrecioC = $Valor;  break;
               case 4: $PrecioV = $Valor;  break;
             }
           }

       }

       $QueryFinal .= "UPDATE VW_PRECIOS_TALLER_PRODUCTO SET PCOMPRA_NVO=".$PrecioC.", PVENTA_NVO=".$PrecioV." WHERE TALLER_ID = ".request()->cookie('Taller_ID')." AND CODIGO_SAP = '".$I[0]."';";
       $x++;

     }

     $Guardar = \DB::statement($QueryFinal);

     $Inventario = \DB::table('VW_PRECIOS_TALLER_PRODUCTO')
                        ->where([["TALLER_ID","=",request()->cookie('Taller_ID')],["CLAVE","LIKE","%".$r->input('Filtro')."%"]])
                        ->orWhere([["TALLER_ID","=",request()->cookie('Taller_ID')],["CODIGO_SAP","LIKE","%".$r->input('Filtro')."%"]])
                        ->get();

     if(sizeof($Inventario) == 0){
       $TMensaje = "warning";
       $Titulo = "Busqueda sin resultados";
       $Mensaje = "Lo sentimos, no encontramos resultados con la palabra o clave ingresada";
     }else{
       $TMensaje = "success";
       $Titulo = "";
       $Mensaje = "";
     }

     $Datos = array();
     $Items = array();
     $x = 0;

     foreach ($Inventario as $Info) {
       $Items[0] = $Info->CODIGO_SAP;
       $Items[1] = $Info->CLAVE;
       $Items[2] = $Info->PRODUCTO;
       $Items[3] = number_format($Info->PCOMPRA_NVO,2);
       $Items[4] = number_format($Info->PVENTA_NVO,2);
       $Datos[$x] = $Items;
       $x++;
     }

     $Info = array();

     if(sizeof($Datos) == 0){
       $Datos[0] = array('','','','','');
     }
     $Info = $Datos;
     return response()->json(["Titulo"=>$Titulo,"Mensaje"=>$Mensaje,"TMensaje"=>$TMensaje,"Info"=>$Info]);
   }

   /*===========================================================================*/

   public function ActualizarPrecios(Request $r){
     $Inventario = json_decode($r->input('Inventario'));
     $x = 1;

     $QueryFinal = '';

     foreach($Inventario as $I){

       for($A=3;$A<=4;$A++){

           $Valor = str_replace(',','',$I[$A]);

           if(!is_numeric($Valor)){
             switch($A){
               case 3: $Columna = 'PRECIO COMPRA'; break;
               case 4: $Columna = 'PRECIO VENTA';  break;

             }
             return response()->json(["Titulo"=>"Algún dato proporcionado es erroneo","TMensaje"=>"warning","Mensaje"=>"Se esperaba un dato numerico para el dato ".$Columna." de la fila ".$x]);
           }else{
             switch($A){
               case 3: $PrecioC = $Valor;  break;
               case 4: $PrecioV = $Valor;  break;

             }
           }

       }

       $QueryFinal .= "UPDATE VW_PRECIOS_TALLER_PRODUCTO SET PCOMPRA_NVO=".$PrecioC.", PVENTA_NVO=".$PrecioV." WHERE TALLER_ID = ".request()->cookie('Taller_ID')." AND CODIGO_SAP = '".$I[0]."';";
       $x++;

     }

     $Guardar = \DB::statement($QueryFinal);

     $SQL = 'EXEC P_CAMBIAR_PRECIOS '.request()->cookie('Persona_ID').','.request()->cookie('Taller_ID');
     $Actualizar = \DB::statement($SQL);
     \Cookie::queue(\Cookie::forget('CambiarPrecios'));

     return response()->json(["Titulo"=>"Proceso satisfactorio!","TMensaje"=>"success","Mensaje"=>"Los precios se han actualizado correctamente de acuerdo a la información proporcionada"]);

   }

   /*===========================================================================*/

   public function ProductosBASF(){
     $MenuPrincipal = self::MenuMaker(0,-1,0);
     $Productos = \DB::select('SELECT * FROM F_PRODUCTOS_BASF('.request()->cookie('Taller_ID').')');
     return view('Productos.ProductosBasf',compact('Productos','MenuPrincipal'));
   }

   /*===========================================================================*/

   public function ProductosBASF_Activar(Request $r){
$Activar = \DB::statement("EXEC P_ACTIVAR_PRODUCTOS_BASF '".$r->input('SAP')."',".request()->cookie('Taller_ID').",".$r->input('ActivarDesactivar'));
     return response()->json(["Titulo"=>"Proceso satisfactorio!","TMensaje"=>"success","Mensaje"=>"Se ha realizado el movimiento correctamente producto correctamente"]);
   }

   /*===========================================================================*/

   public function Busqueda_Productos(Request $r){
     $Inventario = \DB::table('VW_TALLER_PRODUCTO')
                        ->where([["TALLER_ID","=",request()->cookie('Taller_ID')],["CLAVE","LIKE","%".$r->input('Filtro')."%"]])
                        ->orWhere([["TALLER_ID","=",request()->cookie('Taller_ID')],["CODIGO_SAP","LIKE","%".$r->input('Filtro')."%"]])
                        ->get();

     $Datos = '<thead><tr><td>SAP</td><td>CLAVE</td><td>PRODUCTO</td><td>EXISTENCIA</td><td>P. COMPRA</td><td>P. VENTA</td></tr></thead><tbody>';

     foreach ($Inventario as $Info) {
       $Datos .= '<tr onclick="useItem('.$Info->PRODUCTO_ID.','.$Info->PRESENTACION_ID.')" style="cursor:pointer">';
       $Datos .= '<td>'. $Info->CODIGO_SAP.'</td>';
       $Datos .= '<td>'. $Info->CLAVE.'</td>';
       $Datos .= '<td>'. $Info->PRODUCTO.'</td>';
       $Datos .= '<td>'. number_format($Info->SELLADO,2).'</td>';
       $Datos .= '<td>$ '. number_format($Info->PCOMPRA,2).'</td>';
       $Datos .= '<td>$ '. number_format($Info->PVENTA,2).'</td>';
       $Datos .= '</tr>';
       }

       $Info = '<table class="table table-striped table-lightfont dataTable no-footer">'.$Datos.'</tbody></table>';


     return response()->json(["TMensaje"=>"success","Info"=>$Info]);
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
                   <div class="col-sm-7">
                         <div class="form-group">
                           <label for=""> Cantidad</label><input class="form-control" placeholder="Cantidad" autocomplete="off" onkeypress="return justDecimals(event,'."'txtCant'".',9);" type="text" name="txtCant" id="txtCant">
                         </div>
                   </div>
                   <div class="col-sm-4">
                         <div class="form-group">
                            <label for="">Unidad</label>
                            <select class="form-control" name="cmbUnidad" id="cmbUnidad">
                              <option value="3">PZA </option>
                            </select>
                          </div>
                   </div>

                   <div class="col-sm-2">
                      <label for=""> </label>
                     <button class="btn btn-primary" type="button" name="btnAddItem" id="btnAddItem" onclick="TraspasoProducto();">Realizar traspaso</button>
                   </div>
                 </div>

               </div>
               </div>';

     return response()->json(["InfoProducto"=>$Card]);

   }

   /*===============================================================================*/

   public function TraspasoProducto(Request $r){
     if($r->input('Cant')<=0){
       return response()->json([
         "Titulo"=>"Cantidad invalida",
         "Mensaje"=>"Por favor proporcione un valor valido para realizar una transferencia",
         "TMensaje"=>"warning"
       ]);
     }

     $Obtener = \DB::table('VW_TALLER_PRODUCTO')
                 ->where([
                   ["TALLER_ID","=",request()->cookie('Taller_ID')],
                   ["PRODUCTO_ID","=",$r->input('Pro')],
                   ["PRESENTACION_ID","=",$r->input('Pre')]
                 ])->get();

    if ($Obtener[0]->SELLADO < $r->input('Cant')) {
      return response()->json([
        "Titulo"=>"No es posible traspasar",
        "Mensaje"=>"NO cuentas con stock suficiente para realizar un traspaso de producto",
        "TMensaje"=>"warning"
      ]);
    }

     $SQL = "EXEC P_TRASPASAR_PRODUCTO ".request()->cookie('Taller_ID').",".request()->cookie('Persona_ID').",".$r->input('Pro').",".$r->input('Pre').",".$r->input('Cant');
     $Traspasar = \DB::statement($SQL);
     return response()->json([
       "Titulo"=>"Traspaso Exitoso",
       "Mensaje"=>"Se ha realizado existosamente la transferencia del producto al Laboratorio de Pintura",
       "TMensaje"=>"success"
     ]);
   }
}
