<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Usuarios_Controller extends Controller
{
  public function MenuMaker($M,$Mk,$Mks){
        $MenuMaker = new Menu_Maker_Controller;
        $MenuPrincipal = $MenuMaker->JsonToMenu($M,$Mk,$Mks);
        return $MenuPrincipal;
      }

  /*=======================================================================*/
    public function FormCrear(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      $Perfiles = \DB::table('PERFILES')->orderBy('PERFIL')->get();
      $Talleres = \DB::table('TALLERES')->where('EMPRESA_ID','=',request()->cookie('Distribuidor_ID'))->get();
      return view('Usuarios.UsuariosCrear',compact('Perfiles','Talleres','MenuPrincipal'));
    }

    /*==========================================================================*/

    public function GuardarUsuario(Request $r){
      $Items = '';
      $Talleres = $r->input('Talleres');
      foreach ($Talleres as $C) {
  	$Items .= $C."|";
  }
  //$Talleres .="-99";

      $SQL = \DB::statement("EXEC P_CREAR_USUARIO ".$r->input('Perfil').",'".$r->input('Nombre')."','".$r->input('Cuenta')."','".$r->input('Pwd')."','z32L_A4R5_8990','".$Items."'");
      return response()->json(["TMensaje"=>"success","Mensaje"=>"Se ha registrado el usuario correctamente","Titulo"=>"Usuario creado!","Talleres"=>$Items]);
    }
}
