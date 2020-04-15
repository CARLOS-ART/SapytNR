<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Distribuidores_Controller extends Controller
{

  public function MenuMaker($M,$Mk,$Mks){
        $MenuMaker = new Menu_Maker_Controller;
        $MenuPrincipal = $MenuMaker->JsonToMenu($M,$Mk,$Mks);
        return $MenuPrincipal;
      }

  /*=======================================================================*/
    public function AltaDist(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
        return view('Distribuidores.AltaDistribuidores',compact('MenuPrincipal'));
    }

    /*=============================================================*/

    public function GenerarAlta(Request $r){
        $Validacion = \DB::table('EMPRESAS')
                       ->where(["EMPRESA"=>$r->input('Nombre')])
                       ->get();
        if(sizeof($Validacion)>=1){
          return response()->json([
              "Titulo"=>"Distribuidor existente!",
              "Mensaje"=>"Ya existe un distribuidor con el nombre comercial ".$r->input('Nombre').", no es posible guardar con el mismo nombre",
              "TMensaje"=>"warning"
              ]);
        }

        $Validacion2 = \DB::table('EMPRESAS')
                       ->where(["RAZON_SOCIAL"=>$r->input('RSocial')])
                       ->get();

        if(sizeof($Validacion2)>=1){
          return response()->json([
              "Titulo"=>"Distribuidor existente!",
              "Mensaje"=>"Ya existe un distribuidor con la razón social ".$r->input('RSocial').", no es posible guardar con esta información",
              "TMensaje"=>"warning"
              ]);
        }

        $Guardar = \DB::table('EMPRESAS')
                    ->insert([
                        "EMPRESA"=>strtoupper($r->input('Nombre')),
                        "RAZON_SOCIAL"=>strtoupper($r->input('RSocial')),
                        "FECHA_ALTA"=>date('Y-m-d')."T".date('H:i:s'),
                        "ACTIVO"=>1
                    ]);

         return response()->json([
                    "Titulo"=>"Distribuidor Creado!",
                    "Mensaje"=>"Se ha creado correctamete el distribuidor con los datos especificados",
                    "TMensaje"=>"success"
                    ]);
    }
}
