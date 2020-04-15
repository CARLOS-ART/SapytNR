<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Bitacoras_Tablero_Controller extends Controller
{
  public function MenuMaker($M,$Mk,$Mks){
        $MenuMaker = new Menu_Maker_Controller;
        $MenuPrincipal = $MenuMaker->JsonToMenu($M,$Mk,$Mks);
        return $MenuPrincipal;
      }

  /*=======================================================================*/
    public function Tablero(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      return view('Bitacoras.BitacorasTablero',compact('MenuPrincipal'));
    }

    /*================================================================*/

    public function MostrarBitacoras(Request $r){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
       require_once('C-Funciones.php');
       $Fe1 = TransformaFecha($r->input('txtFecha')).'T00:00:00';
       $Fe2 = TransformaFecha($r->input('txtFecha2')).'T23:59:00';

       $Buscar = \DB::table('VW_BITACORAS_TABLERO')
                    ->where('TALLER_ID',"=",request()->cookie('Taller_ID'))
                    ->whereBetween('FECHA',[$Fe1,$Fe2])
                    ->orderBy('FECHA')
                    ->get();

      $Fe1 = $r->input('txtFecha');
      $Fe2 = $r->input('txtFecha2');
    return view('Bitacoras.Historial',compact('Buscar','Fe1','Fe2','MenuPrincipal'));
    }

    /*================================================================*/

    public function CerrarOT(Request $r){
      $EstatusBit = \DB::table('Bitacoras')
                 ->where("Bitacora_id","=",$r->input('Bit'))
                 ->get();
      if (sizeof($EstatusBit)>0) {
        $Estatus = $EstatusBit[0]->ESTATUS_ID;
        if ($Estatus == 2) {
          $Cerrar = \DB::table('BITACORAS')
          ->where("Bitacora_id","=",$r->input('Bit'))
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

    /*====================================================================*/

    public function IrBitacora($Bit){
	  \Cookie::queue(\Cookie::forget('Bitacora_ID'));
      \Cookie::queue('Bitacora_ID',$Bit);
      return redirect('Bitacoras/Bitacoras');
    }

/*===============================================================================*/

    public function MostrarBit(Request $r) {

      $Mostrar = \DB::table('BITACORAS')
                     ->where('BITACORA_ID','=',$r->input('Bit'))
                     ->get();

      $Bita = $Mostrar[0]->BITACORA_ID;

      return response()->json(["Bitacora"=>$Bita]);

    }
/*==============================================================================*/

    public function CancelarOT(Request $r){

      $Cancelar = "UPDATE BITACORAS SET ESTATUS_ID = 3 WHERE BITACORA_ID = '".$r->input('Bita')."'";
      $SQL = \DB::statement($Cancelar);

      return response()->json(["Titulo"=>"Bitacora Cancelada","Mensaje"=>"la bitacora ha sido cancelada","TMensaje"=>"success"]);
    }
/*===============================================================================*/

    public function MostrarBitCancelar(Request $r) {

      $Mostrar = \DB::table('BITACORAS')
                     ->where('BITACORA_ID','=',$r->input('Bit'))
                     ->get();

      $Bita = $Mostrar[0]->BITACORA_ID;

      return response()->json(["Bitacora"=>$Bita]);

    }
}
