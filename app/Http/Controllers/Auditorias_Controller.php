<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Auditorias_Controller extends Controller
{



  public function MenuMaker($M,$Mk,$Mks){
        $MenuMaker = new Menu_Maker_Controller;
        $MenuPrincipal = $MenuMaker->JsonToMenu($M,$Mk,$Mks);
        return $MenuPrincipal;
      }

  /*=======================================================================*/
    public function Tablero(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      $Auditorias = \DB::table('VW_AUDITORIAS')
                     ->where('TALLER_ID','=',request()->cookie('Taller_ID'))
                     ->get();

      return view('Auditorias.AuditoriasTablero',compact('Auditorias','MenuPrincipal'));
    }

    /*=======================================================================*/

    public function Formato_Almacen(){
$MenuPrincipal = self::MenuMaker(0,-1,0);
      if(request()->cookie('Auditoria_ID') == false){
        $AudID = \DB::table('AUDITORIAS')
                     ->insertGetId([
                       "TALLER_ID"=> request()->cookie('Taller_ID'),
                       "PERSONA_ID"=>request()->cookie('Persona_ID'),
                       "ESTATUS_ID"=>2,
                       "FECHA"=>date('Y-m-d').'T'.date('H:i:s'),
                       "TIPO_AUDIT"=>1
                     ]);
        $Products = \DB::statement('EXEC P_PRODUCTOS_AUDITORIA '.$AudID.','.request()->cookie('Taller_ID').',1');
        return redirect('/Auditorias/Formato/Almacen')->with("Auditoria_Creada")->cookie('Auditoria_ID',$AudID);
      }else{
        return view('Auditorias.FormatoAlmacen',compact('MenuPrincipal'));
      }

    }

    /*=======================================================================*/

    public function CargarDatos_Almacen(){
      $DatosProducto = \DB::table('VW_AUDITORIA_PRODUCTO_ALMACEN')
                ->where('AUDITORIA_ID',"=",request()->cookie('Auditoria_ID') )
                ->get();

                $Datos = array();
                $Items = array();
                $x = 0;

                foreach ($DatosProducto as $Info) {
                  $Items[0] = $Info->CODIGO_SAP;
                  $Items[1] = $Info->CLAVE;
                  $Items[2] = $Info->PRODUCTO;
                  $Items[3] = number_format($Info->PCOMPRA,2);
                  $Items[4] = number_format($Info->PVENTA,2);
                  $Items[5] = number_format($Info->SISTEMA,2);
                  $Items[6] = number_format($Info->FISICO,2);
                  $Datos[$x] = $Items;
                  $x++;
                }

                $Info = array();

                if(sizeof($Datos) == 0){
                  $Datos[0] = array('','','','' ,'','','');
                }
                $Info = $Datos;
                return response()->json(["TMensaje"=>"success","Info"=>$Info]);
    }

    /*=======================================================================*/

    public function Formato_Laboratorio(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      if(request()->cookie('Auditoria_ID') == false){
        $AudID = \DB::table('AUDITORIAS')
                     ->insertGetId([
                       "TALLER_ID"=> request()->cookie('Taller_ID'),
                       "PERSONA_ID"=>request()->cookie('Persona_ID'),
                       "ESTATUS_ID"=>2,
                       "FECHA"=>date('Y-m-d').'T'.date('H:i:s'),
                       "TIPO_AUDIT"=>0
                     ]);
        $Products = \DB::statement('EXEC P_PRODUCTOS_AUDITORIA '.$AudID.','.request()->cookie('Taller_ID').',0');
        return redirect('/Auditorias/Formato/Laboratorio')->with("Auditoria_Creada")->cookie('Auditoria_ID',$AudID);

      }else{
       return view('Auditorias.FormatoLaboratorio',compact('MenuPrincipal'));
      }

    }

    /*=======================================================================*/

    public function CargarDatos_Lab(){
      $DatosProducto = \DB::table('VW_AUDITORIA_PRODUCTO_LAB')
                ->where('AUDITORIA_ID',"=",request()->cookie('Auditoria_ID') )
                ->get();

                $Datos = array();
                $Items = array();
                $x = 0;

                foreach ($DatosProducto as $Info) {
                  $Items[0] = $Info->CODIGO_SAP;
                  $Items[1] = $Info->CLAVE;
                  $Items[2] = $Info->PRODUCTO;
                  $Items[3] = number_format($Info->PCOMPRA,2);
                  $Items[4] = number_format($Info->PVENTA,2);
                  $Items[5] = number_format($Info->SISTEMA_TARA,2);
                  $Items[6] = number_format($Info->SISTEMA_SIN_TARA,2);
                  $Items[7] = number_format($Info->FISICO_TARA,2);
                  $Datos[$x] = $Items;
                  $x++;
                }

                $Info = array();

                if(sizeof($Datos) == 0){
                  $Datos[0] = array('','','','' ,'','','');
                }
                $Info = $Datos;
                return response()->json(["TMensaje"=>"success","Info"=>$Info]);
    }

    /*=======================================================================*/

    public function FiltrarProductos_Lab(Request $r){
      $Inventario = json_decode($r->input('Inventario'));
      $x = 1;

      $QueryFinal = '';

      foreach($Inventario as $I){

        for($A=3;$A<=7;$A++){

            $Valor = str_replace(',','',$I[$A]);

            if(!is_numeric($Valor)){
              switch($A){
                case 3: $Columna = 'PRECIO COMPRA'; break;
                case 4: $Columna = 'PRECIO VENTA';  break;
                case 5: $Columna = 'EXISTENCIA';    break;
                case 6: $Columna = 'EXIST. FISICO'; break;
                case 7: $Columna = 'GR. FISICO CON TARA'; break;
              }
              return response()->json(["Titulo"=>"Algún dato proporcionado es erroneo","TMensaje"=>"warning","Mensaje"=>"Se esperaba un dato numerico para el dato ".$Columna." de la fila ".$x]);
            }else{
              switch($A){
                case 3: $PrecioC = $Valor;  break;
                case 4: $PrecioV = $Valor;  break;
                case 5: $Sellado = $Valor;  break;
                case 6: $Fisico = $Valor;   break;
                case 7: $Fisico = $Valor;   break;

              }
            }

        }

        $QueryFinal .= "UPDATE VW_AUDITORIA_PRODUCTO_LAB SET FISICO = ".$Fisico." WHERE AUDITORIA_ID = ".request()->cookie('Auditoria_ID')." AND CODIGO_SAP = '".$I[0]."';";
        $x++;

      }

      $Guardar = \DB::statement($QueryFinal);

      $ObtenerInventario = \DB::table('VW_AUDITORIA_PRODUCTO_LAB')
                                 ->where([

                                   ['AUDITORIA_ID',"=",request()->cookie('Auditoria_ID')],
                                   ["CLAVE","like","%".$r->input('Filtro')."%"]
                                 ])
                                 ->orWhere([

                                   ['AUDITORIA_ID',"=",request()->cookie('Auditoria_ID')],
                                   ["CODIGO_SAP","like","%".$r->input('Filtro')."%"]
                                 ])
                                 ->orderBy('Clave')
                                 ->get();
      $Datos = array();
      $Items = array();
      $x = 0;

      foreach ($ObtenerInventario as $Info) {
        $Items[0] = $Info->CODIGO_SAP;
        $Items[1] = $Info->CLAVE;
        $Items[2] = $Info->PRODUCTO;
        $Items[3] = number_format($Info->PCOMPRA,2);
        $Items[4] = number_format($Info->PVENTA,2);
        $Items[5] = number_format($Info->SISTEMA_TARA,2);
        $Items[6] = number_format($Info->SISTEMA_SIN_TARA,2);
        $Items[7] = number_format($Info->FISICO_TARA,2);
        $Datos[$x] = $Items;
        $x++;
      }

      $Info = array();

      if(sizeof($Datos) == 0){
        $Datos[0] = array('','','','','','','','');
      }
      $Info = $Datos;
      return response()->json(["TMensaje"=>"success","Info"=>$Info]);
    }

    /*=======================================================================*/

    public function FiltrarProductos_Almacen(Request $r){
      $Inventario = json_decode($r->input('Inventario'));
      $x = 1;

      $QueryFinal = '';

      foreach($Inventario as $I){

        for($A=3;$A<=6;$A++){

            $Valor = str_replace(',','',$I[$A]);

            if(!is_numeric($Valor)){
              switch($A){
                case 3: $Columna = 'PRECIO COMPRA'; break;
                case 4: $Columna = 'PRECIO VENTA';  break;
                case 5: $Columna = 'EXISTENCIA';    break;
                case 6: $Columna = 'EXIST. FISICO';        break;
              }
              return response()->json(["Titulo"=>"Algún dato proporcionado es erroneo","TMensaje"=>"warning","Mensaje"=>"Se esperaba un dato numerico para el dato ".$Columna." de la fila ".$x]);
            }else{
              switch($A){
                case 3: $PrecioC = $Valor;  break;
                case 4: $PrecioV = $Valor;  break;
                case 5: $Sellado = $Valor;  break;
                case 6: $Fisico = $Valor;   break;
              }
            }

        }

        $QueryFinal .= "UPDATE VW_AUDITORIA_PRODUCTO_ALMACEN SET FISICO=".$Fisico." WHERE AUDITORIA_ID = ".request()->cookie('Auditoria_ID')." AND CODIGO_SAP = '".$I[0]."';";
        $x++;

      }

      $Guardar = \DB::statement($QueryFinal);

      $ObtenerInventario = \DB::table('VW_AUDITORIA_PRODUCTO_ALMACEN')
                                 ->where([

                                   ['AUDITORIA_ID',"=",request()->cookie('Auditoria_ID')],
                                   ["CLAVE","like","%".$r->input('Filtro')."%"]
                                 ])
                                 ->orWhere([

                                   ['AUDITORIA_ID',"=",request()->cookie('Auditoria_ID')],
                                   ["CODIGO_SAP","like","%".$r->input('Filtro')."%"]
                                 ])
                                 ->orderBy('Clave')
                                 ->get();
      $Datos = array();
      $Items = array();
      $x = 0;

      foreach ($ObtenerInventario as $Info) {
        $Items[0] = $Info->CODIGO_SAP;
        $Items[1] = $Info->CLAVE;
        $Items[2] = $Info->PRODUCTO;
        $Items[3] = number_format($Info->PCOMPRA,2);
        $Items[4] = number_format($Info->PVENTA,2);
        $Items[5] = number_format($Info->SISTEMA,2);
        $Items[6] = number_format($Info->FISICO,2);
        $Datos[$x] = $Items;
        $x++;
      }

      $Info = array();

      if(sizeof($Datos) == 0){
        $Datos[0] = array('','','','','','','');
      }
      $Info = $Datos;
      return response()->json(["TMensaje"=>"success","Info"=>$Info]);
    }

    /*========================================================================*/

     public function TerminarAuditoria_Lab(Request $r){
       $Inventario = json_decode($r->input('Inventario'));
       $x = 1;

       $QueryFinal = '';

       foreach($Inventario as $I){

         for($A=3;$A<=7;$A++){

             $Valor = str_replace(',','',$I[$A]);

             if(!is_numeric($Valor)){
               switch($A){
                 case 3: $Columna = 'PRECIO COMPRA'; break;
                 case 4: $Columna = 'PRECIO VENTA';  break;
                 case 5: $Columna = 'EXISTENCIA';    break;
                 case 6: $Columna = 'EXIST. FISICO'; break;
                 case 7: $Columna = 'GR. FISICO CON TARA'; break;
               }
               return response()->json(["Titulo"=>"Algún dato proporcionado es erroneo","TMensaje"=>"warning","Mensaje"=>"Se esperaba un dato numerico para el dato ".$Columna." de la fila ".$x]);
             }else{
               switch($A){
                 case 3: $PrecioC = $Valor;  break;
                 case 4: $PrecioV = $Valor;  break;
                 case 5: $Sellado = $Valor;  break;
                 case 6: $Fisico = $Valor;   break;
                 case 7: $Fisico = $Valor;   break;

               }
             }

         }

         $QueryFinal .= "UPDATE VW_AUDITORIA_PRODUCTO_ALMACEN SET FISICO=".$Fisico." WHERE AUDITORIA_ID = ".request()->cookie('Auditoria_ID')." AND CODIGO_SAP = '".$I[0]."';";
         $x++;

       }



       $Guardar = \DB::statement($QueryFinal);
       $Auditoria = request()->cookie('Auditoria_ID');
       $UpdateAuditoria= "UPDATE AUDITORIAS SET ESTATUS_ID=1 WHERE AUDITORIA_ID = ".$Auditoria;
       $Guardar = \DB::statement($UpdateAuditoria);
       \Cookie::queue(\Cookie::forget('Auditoria_ID'));

       return response()->json(["TMensaje"=>"success","Auditoria"=>$Auditoria]);
     }

     /*========================================================================*/

     public function RealizarAfectacion(Request $r){
      $SQL = "EXEC P_AUDITORIA_AFECTAR_INVENTARIO ".$r->input('Auditoria');
      $Afectar = \DB::statement($SQL);
      return response()->json(["Titulo"=>"Proceso satisfactorio","Mensaje"=>"Se ha realizado la afectación del inventario de acuerdo a la auditoria","TMensaje"=>"success"]);
     }

    /*========================================================================*/

    public function TerminarAuditoria_Almacen(Request $r){
      $Inventario = json_decode($r->input('Inventario'));
      $x = 1;

      $QueryFinal = '';

      foreach($Inventario as $I){

        for($A=3;$A<=6;$A++){

            $Valor = str_replace(',','',$I[$A]);

            if(!is_numeric($Valor)){
              switch($A){
                case 3: $Columna = 'PRECIO COMPRA'; break;
                case 4: $Columna = 'PRECIO VENTA';  break;
                case 5: $Columna = 'EXISTENCIA';    break;
                case 6: $Columna = 'EXIST. FISICO';        break;
              }
              return response()->json(["Titulo"=>"Algún dato proporcionado es erroneo","TMensaje"=>"warning","Mensaje"=>"Se esperaba un dato numerico para el dato ".$Columna." de la fila ".$x]);
            }else{
              switch($A){
                case 3: $PrecioC = $Valor;  break;
                case 4: $PrecioV = $Valor;  break;
                case 5: $Sellado = $Valor;  break;
                case 6: $Fisico = $Valor;   break;
              }
            }

        }

        $QueryFinal .= "UPDATE VW_AUDITORIA_PRODUCTO_ALMACEN SET FISICO=".$Fisico." WHERE AUDITORIA_ID = ".request()->cookie('Auditoria_ID')." AND CODIGO_SAP = '".$I[0]."';";
        $x++;

      }

      $QueryFinal .= "UPDATE AUDITORIAS SET ESTATUS_ID=1 WHERE AUDITORIA_ID = ".request()->cookie('Auditoria_ID').";";

      $Guardar = \DB::statement($QueryFinal);
      $Auditoria = request()->cookie('Auditoria_ID');

      \Cookie::queue(\Cookie::forget('Auditoria_ID'));

      return response()->json(["TMensaje"=>"success","Auditoria"=>$Auditoria]);

    }

    /*==========================================================================*/

    public function Editar_Auditoria(Request $r){
      \Cookie::queue('Auditoria_ID', $r->input('Audit'));
      return "success";
    }

}
