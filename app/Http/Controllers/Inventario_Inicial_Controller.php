<?php

namespace App\Http\Controllers;
use Cookie;
use Illuminate\Http\Request;

class Inventario_Inicial_Controller extends Controller
{

  public function MenuMaker($M,$Mk,$Mks){
        $MenuMaker = new Menu_Maker_Controller;
        $MenuPrincipal = $MenuMaker->JsonToMenu($M,$Mk,$Mks);
        return $MenuPrincipal;
      }

  /*=======================================================================*/
    public function Iniciar_Inventario_Inicial(){
      $CrearInventario = \DB::table('INVENTARIO_INICIAL')
                           ->insertGetId([
                             "TALLER_ID"=>request()->cookie('Taller_ID'),
                             "ESTATUS_ID"=>2,
                             "PERSONA_ID"=>request()->cookie('Persona_ID'),
                             "FECHA"=>date('Y-m-d')."T".date('H:i:s')
                           ]);

      return redirect('InventarioInicial/Formato')->with("Inventario")->cookie('Inventario_ID',$CrearInventario);

    }

    /*===========================================================================*/

    public function Iniciar_Inventario_Inicial_Aliados(){
      $CrearInventario = \DB::table('INVENTARIO_INICIAL')
                           ->insertGetId([
                             "TALLER_ID"=>request()->cookie('Taller_ID'),
                             "ESTATUS_ID"=>2,
                             "PERSONA_ID"=>request()->cookie('Persona_ID'),
                             "FECHA"=>date('Y-m-d')."T".date('H:i:s')
                           ]);

      return redirect('InventarioInicial/Formato/Aliados')->with("Inventario")->cookie('Inventario_ID',$CrearInventario);
    }

    /*===========================================================================*/

    public function Editar_Inventario_Inicial(Request $r){
      \Cookie::queue('Inventario_ID', $r->input('Formato'));
      return "success";
    }

    /*===========================================================================*/

     public function FiltrarProductos(Request $r){
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
                 case 6: $Columna = 'GRAMOS';        break;
               }
               return response()->json(["Titulo"=>"Algún dato proporcionado es erroneo","TMensaje"=>"warning","Mensaje"=>"Se esperaba un dato numerico para el dato ".$Columna." de la fila ".$x]);
             }else{
               switch($A){
                 case 3: $PrecioC = $Valor;  break;
                 case 4: $PrecioV = $Valor;  break;
                 case 5: $Sellado = $Valor;  break;
                 case 6: $Gramos = $Valor;   break;
               }
             }

         }

         $QueryFinal .= "UPDATE VW_INVENTARIO_INICIAL SET PRECIOC=".$PrecioC.", PRECIOV=".$PrecioV.",SELLADO=".$Sellado.",ABIERTO=".$Gramos." WHERE INVENTARIO_ID = ".request()->cookie('Inventario_ID')." AND CODIGO_SAP = '".$I[0]."';";
         $x++;

       }

       $Guardar = \DB::statement($QueryFinal);

       $ObtenerInventario = \DB::table('VW_INVENTARIO_INICIAL')
                                  ->where([
                                    ['MOSTRAR',"=",1],
                                    ['INVENTARIO_ID',"=",request()->cookie('Inventario_ID')],
                                    ["CLAVE","like","%".$r->input('Filtro')."%"]
                                  ])
                                  ->orWhere([
                                    ['MOSTRAR',"=",1],
                                    ['INVENTARIO_ID',"=",request()->cookie('Inventario_ID')],
                                    ["CODIGO_SAP","like","%".$r->input('Filtro')."%"]
                                  ])
                                  ->orderBy('Clave')
                                  ->get();

      if (sizeof($ObtenerInventario) == 0) {
        return response()->json(["TMensaje"=>"warning","Titulo"=>"Sin coincidencias","Mensaje"=>"No hemos encontrado coincidencias con la busqueda que proporcionó"]);

      }
       $Datos = array();
       $Items = array();
       $x = 0;

       foreach ($ObtenerInventario as $Info) {
         $Items[0] = $Info->CODIGO_SAP;
         $Items[1] = $Info->CLAVE;
         $Items[2] = $Info->PRODUCTO;
         $Items[3] = number_format($Info->PRECIOC,2);
         $Items[4] = number_format($Info->PRECIOV,2);
         $Items[5] = $Info->SELLADO;
         $Items[6] = number_format($Info->ABIERTO,2);
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

    /*===========================================================================*/

    public function CargarDatos(){
      $ObtenerInventario = \DB::table('VW_INVENTARIO_INICIAL')
                                 ->where(['MOSTRAR'=>1,'INVENTARIO_ID'=>request()->cookie('Inventario_ID')])
                                 ->orderBy('Clave')
                                 ->get();
      $Datos = array();
      $Items = array();
      $x = 0;

      foreach ($ObtenerInventario as $Info) {
        $Items[0] = $Info->CODIGO_SAP;
        $Items[1] = $Info->CLAVE;
        $Items[2] = $Info->PRODUCTO;
        $Items[3] = number_format($Info->PRECIOC,2);
        $Items[4] = number_format($Info->PRECIOV,2);
        $Items[5] = $Info->SELLADO;
        $Items[6] = number_format($Info->ABIERTO,2);
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

    /*===========================================================================*/

    public function FormatoInventario(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      return view('InventarioInicial',compact('MenuPrincipal'));
    }
    /*===========================================================================*/

    public function FormatoInventarioAliados(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);

      return view('InventarioInicial.InventarioInicialAliados',compact('MenuPrincipal'));

      $Info='';
      return view('InventarioInicial.InventarioInicialAliados',compact('MenuPrincipal','Info'));

    }
    /*===========================================================================*/

    public function CancelarFormato(Request $r){
      $Formato = \DB::table('INVENTARIO_INICIAL')
                  ->where('INVENTARIO_ID',"=",$r->input('Formato'))
                  ->update(["ESTATUS_ID"=>3]);
      return response()->json(["Titulo"=>"Cancelación exitosa","Mensaje"=>"Se ha realizado la cancelación del formato de carga de inventario inicial","TMensaje"=>"success"]);
    }

    /*========================================================================== */

    public function VTableroInventario(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      $Info = \DB::table('VW_TABLERO_INVENTARIO_INICIAL')
                   ->where('TALLER_ID',"=",request()->cookie('Taller_ID'))
                   ->get();

      return view('InventarioInicial.TableroInvInicial',compact('Info','MenuPrincipal'));
    }
    /*========================================================================== */

    public function VTableroInventarioAliados(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      $Info = \DB::table('VW_TABLERO_INVENTARIO_INICIAL')
                   ->where('TALLER_ID',"=",request()->cookie('Taller_ID'))
                   ->get();

      return view('InventarioInicial.TableroInicialAliados',compact('Info','MenuPrincipal'));
    }
    /*==========================================================================*/

    public function CargarLinea(Request $r){
      $SQL = "EXEC P_MOSTRAR_OCULTAR_INVENTARIO_INICIAL ".request()->cookie('Inventario_ID').",".$r->input('Seleccionar').",".$r->input('Linea').",".$r->input('BASF');
      $Actualizar = \DB::statement($SQL);

      $ObtenerInventario = \DB::table('VW_INVENTARIO_INICIAL')
                                 ->where(['MOSTRAR'=>1,'INVENTARIO_ID'=>request()->cookie('Inventario_ID')])
                                 ->orderBy('Linea_ID')
                                 ->get();
      $Datos = array();
      $Items = array();
      $x = 0;

      foreach ($ObtenerInventario as $Info) {
        $Items[0] = $Info->CODIGO_SAP;
        $Items[1] = $Info->CLAVE;
        $Items[2] = $Info->PRODUCTO;
        $Items[3] = number_format($Info->PRECIOC,2);
        $Items[4] = number_format($Info->PRECIOV,2);
        $Items[5] = $Info->SELLADO;
        $Items[6] = number_format($Info->ABIERTO,2);
        $Datos[$x] = $Items;
        $x++;
      }

      $Info = array();

      if(sizeof($Datos) == 0){
        $Datos[0] = array('','','','','','','');
      }
      $Info = $Datos;
      return response()->json(["TMensaje"=>$SQL,"Info"=>$Info]);
    }


    /*==========================================================================*/

    public function GuardarInvetario(Request $r){
      $JsonFile = $r->input('MyData');
      $F = fopen('NHola.json','w');
      fwrite($F,$JsonFile);
      fclose($F);
      return response()->json(["TMensaje"=>"success"]);
    }

    /*===========================================================================*/

    public function SubirInventario(Request $r){
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
                case 6: $Columna = 'GRAMOS';        break;
              }
              return response()->json(["Titulo"=>"Algún dato proporcionado es erroneo","TMensaje"=>"warning","Mensaje"=>"Se esperaba un dato numerico para el dato ".$Columna." de la fila ".$x]);
            }else{
              switch($A){
                case 3: $PrecioC = $Valor;  break;
                case 4: $PrecioV = $Valor;  break;
                case 5: $Sellado = $Valor;  break;
                case 6: $Gramos = $Valor;   break;
              }
            }

        }

        $QueryFinal .= "UPDATE VW_INVENTARIO_INICIAL SET PRECIOC=".$PrecioC.", PRECIOV=".$PrecioV.",SELLADO=".$Sellado.",ABIERTO=".$Gramos." WHERE INVENTARIO_ID = ".request()->cookie('Inventario_ID')." AND CODIGO_SAP = '".$I[0]."';";
        $x++;

      }

      $Guardar = \DB::statement($QueryFinal);

      $Cargar = \DB::statement('EXEC P_CARGAR_INVENTARIO_INICIAL '.request()->cookie('Taller_ID').','.request()->cookie('Inventario_ID').",".$r->input('BASF'));
      Cookie::queue(Cookie::forget('Inventario_ID'));

      return response()->json(["Titulo"=>"Proceso satisfactorio","TMensaje"=>"success","Mensaje"=>"Se ha realizado la carga existosa del Inventario Inicial"]);
    }
}
