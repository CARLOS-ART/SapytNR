<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Actividades_Factory_Controller extends Controller
{
    public function TableroActividades(){
      $Actividades = \DB::table('VW_ACTIVIDADES')->where('TALLER_ID',"=",request()->cookie('Taller_ID'))->orderBy('ACTIVIDAD')->get();
      return view('BitacorasFactory.ActividadesFactory',compact('Actividades'));
    }

    /*==========================================================================*/

    public function ActividadGuardar(Request $r){
      $SQL = \DB::statement("EXEC P_ACTIVIDADES_INFO ".$r->input('ActividadID').",'".$r->input('InfoActividad')."',".request()->cookie('Taller_ID'));
      return response()->json(['Titulo'=>'Datos guarados correctamente',"Mensaje"=>"La información proporcionada fue guardada correctamente","TMensaje"=>"success"]);
    }

    /*==========================================================================*/

    public function ZonasGuardar(Request $r){
      $SQL = \DB::statement("EXEC P_ZONAS_ACTIVIDADES_INFO ".$r->input('ZonaID').",'".$r->input('InfoZona')."',".request()->cookie('Taller_ID'));
      return response()->json(['Titulo'=>'Datos guarados correctamente',"Mensaje"=>"La información proporcionada fue guardada correctamente","TMensaje"=>"success"]);
    }

    /*=========================================================================*/

    public function TableroZonas(){
      $Actividades = \DB::table('ZONAS_ACTIVIDADES')->where('TALLER_ID',"=",request()->cookie('Taller_ID'))->orderBy('ZONA_ACTIVIDAD')->get();
      return view('BitacorasFactory.ZonasFactory',compact('Actividades'));
    }
    /*=========================================================================*/
    public function TableroVehiculos(){
      $Vehiculos = \DB::table('VEHICULOS')->where('MARCA_ID',"=",64)->orderBy('VEHICULO_ID')->get();
      return view('BitacorasFactory.CatalogoVehiculos',compact('Vehiculos'));
    }
    /*=========================================================================*/
    public function VehiculoGuardar(Request $r){

      if(request()->cookie('Taller_ID') == 2051){
      $SQL = \DB::statement("INSERT INTO VEHICULOS VALUES (64,'".$r->input('Vehiculo')."')");
      return response()->json(['Titulo'=>'Datos guarados correctamente',"Mensaje"=>"La información proporcionada fue guardada correctamente","TMensaje"=>"success"]);
    }else {
      return response()->json(['Titulo'=>'Acceso no permitido',"Mensaje"=>"No cuenta con los accesos necesarios para realizar esta acción","TMensaje"=>"warning"]);
    }

}
}
