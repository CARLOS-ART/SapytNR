<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Api_Controller extends Controller
{
    public function DatosBitacora(Request $r){
      
      $SQL = "EXEC RPT_BITACORA_API '".$r->Orden."','".$r->token."'";
      $Datos = \DB::select($SQL);
      $Resp = $Datos[0]->BITACORA_ID;
      $InfoGeneral = array();

      $x=0;
      $P=0;
      $Proceso = "";

      $Procesos = array();
      $Productos = array();
      $Item = array();
      $ProcesoInterno="";

      if ($Resp != 0) {
         $InfoGeneral['CODIGO']  = "200";
         $InfoGeneral['MENSAJE']  = "PROCESO SATISFACTORIO";
         $InfoGeneral['TALLER']  = $Datos[0]->TALLER;
         $InfoGeneral['VEHICULO']  = $Datos[0]->VEHICULO;
         $InfoGeneral['COLOR']  = $Datos[0]->COLOR;
         $InfoGeneral['VIN']  = $Datos[0]->VIN;
         $InfoGeneral['ASEGURADORA']  = $Datos[0]->SEGURO;
         $InfoGeneral['PLACAS']  = $Datos[0]->PLACAS;
         $InfoGeneral['ORDEN_TRABAJO']  = $Datos[0]->OT;
         $InfoGeneral['ESTATUS']  = $Datos[0]->ESTATUS;
         $InfoGeneral['DESCRIPCION_PIEZAS']  = $Datos[0]->PIEZAS;
         $InfoGeneral['CANT_PIEZAS']  = $Datos[0]->NUM_PIEZAS;
         $InfoGeneral['FECHA']  = $Datos[0]->FECHA;

         foreach ($Datos as $Bitacorasinfo) {
           $Proceso =  $Bitacorasinfo->PROCESO;

             if ($x!=0) {
             if($Proceso != $ProcesoInterno ){
                  $Procesos[$ProcesoInterno] = $Productos;
                  $Productos = array();
                  $x=0;
                  $P++;
              }
            }

             $Productos[$x]['CLAVE'] = $Bitacorasinfo->CLAVE;
             $Productos[$x]['DESCRIPCION'] = $Bitacorasinfo->PRODUCTO;
             $Productos[$x]['CANTIDAD'] = $Bitacorasinfo->CANTIDAD."";
             $Productos[$x]['UNIDAD_MEDIDA'] = $Bitacorasinfo->UM;
             $Productos[$x]['PRECIOC'] = number_format($Bitacorasinfo->PRECIOC,5)."";
             $Productos[$x]['PRECIOV'] = number_format($Bitacorasinfo->PRECIOV,5)."";
             $Productos[$x]['OPERARIO'] = $Bitacorasinfo->OPERARIO;
             $ProcesoInterno =  $Bitacorasinfo->PROCESO;
             $x++;
         }

         $Procesos[$ProcesoInterno] = $Productos;
         $InfoGeneral['PROCESOS'] = $Procesos;

         return json_encode($InfoGeneral);

      }else {
        $Inaccesible = array();
        $Inaccesible['CODIGO'] = "404";
        $Inaccesible['MENSAJE'] = "El token utilizado no es valido, o el taller no tiene autorización para utilizar esta función.";
        $Inaccesible['TALLER'] = "NO IDENTIFICADO";
        return( json_encode($Inaccesible));
      }



    }
}
