<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Cuadrillas_Trabajo_Controller extends Controller
{
    public function CrearCuadrilla(){
      $Operarios = \DB::table('VW_OPERARIOS')->where([["TALLER_ID","=",request()->cookie('Taller_ID')],["ACTIVO","=",1]])->get();

      return view('Cuadrillas.Cuadrillas',compact('Operarios'));
    }

    /*==========================================================================*/

    public function RegistrarCuadrilla(Request $r){
      $Validar = \DB::table('CUADRILLAS')
                  ->where('GRUPO',"=",$r->input('NomCuadrilla'))
                  ->get();
      if(sizeof($Validar)>=1){
        return response()->json(["Titulo"=>"No es posible crear!","Mensaje"=>"El nombre de cuadrilla ya fue asignado anteriormente","TMensaje"=>"warning"]);
      }

      $Personal = $r->input('Items');

      if(sizeof($Personal)<=0){
        return response()->json(["Titulo"=>"No es posible crear!","Mensaje"=>"Por favor seleccione a los integrantes de la cuadrilla","TMensaje"=>"warning"]);
      }

      $StringPersonal = '';
      foreach ($Personal as $P) {
        $StringPersonal .= $P.'|';
      }

      $Crear = \DB::statement("EXEC P_CREAR_CUADRILLA_TRABAJO '".$r->input('NomCuadrilla')."','".$StringPersonal."',".request()->cookie('Taller_ID')."");
      return response()->json(["Titulo"=>"Proceso satisfactorio!","Mensaje"=>"Cuadrilla de trabajo creada correctamente","TMensaje"=>"success"]);

    }
}
