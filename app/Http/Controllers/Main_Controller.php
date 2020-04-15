<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Main_Controller extends Controller
{
  public function MostrarBitacoras(Request $r){
     require_once('C-Funciones.php');
     $Fe1 = TransformaFecha($r->input('txtFecha')).'T00:00:00';
     $Fe2 = TransformaFecha($r->input('txtFecha2')).'T23:59:00';

     $Buscar = \DB::table('VW_BITACORAS_TABLERO')
                  ->where('TALLER_ID',"=",request()->cookie('Taller_ID'))
                  ->whereBetween('FECHA',[$Fe1,$Fe2])
                  ->orderBy('FECHA')
                  ->get();

    return response()->json(["Bitacoras"=>$Buscar]);

  }
}
