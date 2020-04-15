<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Auth_Controller extends Controller
{

  public function MenuMaker($M,$Mk,$Mks){
      $MenuMaker = new Menu_Maker_Controller;
      $MenuPrincipal = $MenuMaker->JsonToMenu($M,$Mk,$Mks);
      return $MenuPrincipal;
    }

    public function iniciardemo(){
      $MenuPrincipal = self::MenuMaker (0,0,0);
      return view ("main_template",compact('MenuPrincipal'));
    }

    public function Autentificacion(){
      if(request()->cookie('Persona_ID')){
        \Cookie::queue('LockScreen','Yes');
        return view('lock_screen');
      }else{
        return view('login');
      }
    }

/*==========================================================================*/

public function IniciarSesion(Request $r){
  $NUsuario = $r->input('txtNUsuario');
  $Arroba = 0;
  $CodigoTaller = '';
  $Arroba = strpos($NUsuario, '@');
  if( $Arroba >=1 ){
    $Datos = explode('@',$NUsuario);
    $NUsuario = $Datos[0];
    $CodigoTaller = $Datos[1];

  }

  $SQL = "SELECT * FROM F_AUTH_LOGIN('z32L_A4R5_8990','$NUsuario', '".$r->input('txtPassword')."')";
  $Loguear = \DB::select($SQL);

  if($Loguear[0]->CODIGO_AUTH == 200){
    $CodigoSys = $Loguear[0]->CODIGO;
    if($CodigoTaller !='' && $CodigoTaller != $CodigoSys){
      $TallerInfo = \DB::table('TALLERES')
                      ->where('CODIGO',"=",$CodigoTaller)
                      ->get();
      if(sizeof($TallerInfo)>=1){
        $TallerID = $TallerInfo[0]->TALLER_ID;
        $NomTaller = $TallerInfo[0]->NOMBRE;
      }else{
        //No existe taller
        return redirect('/')->with("E022","El parametro utilizado para el taller es invalido");
      }
    }else{
      $TallerID = $Loguear[0]->TALLER_ID;
      $NomTaller = $Loguear[0]->TALLER;
    }

    return redirect('/Iniciar')->with('Datos',"Inicio de sesión correcto")
                               ->cookie('Taller_ID',$TallerID)
                               ->cookie('Taller',$NomTaller)
                               ->cookie('Persona_ID',$Loguear[0]->PERSONA_ID)
                               ->cookie('Perfil_ID',$Loguear[0]->PERFIL_ID)
                               ->cookie('Perfil',$Loguear[0]->PERFIL)
                               ->cookie('Distribuidor',$Loguear[0]->DISTRIBUIDOR)
                               ->cookie('Distribuidor_ID',$Loguear[0]->EMPRESA_ID)
                               ->cookie('LockScreen','No')
                               ->cookie('NomUsuario',ucwords(strtolower($Loguear[0]->NOMBRE)));

  }else{
    //Usuario y/o contraseña incorrecto
    return redirect('/')->with("E022","Nombre de usuario o Password incorrecto");
  }

}

/*===========================================================================*/

public function Maqueta(){
 return view('maqueta');
}

/*===========================================================================*/

public function IniciarNuevamente(Request $r){
//Esta funcion permite quitar el "LockScreen" de una sesión activa
  if(strlen($r->input('txtPassword')) == 0){
    return redirect('/')->with("E023","Proporcione su contraseña");

  }

  $SQL = "SELECT * FROM F_LOCK_SCREEN_OFF('z32L_A4R5_8990',".request()->cookie('Persona_ID').", '".$r->input('txtPassword')."')";
  $IniciarNuevamente = \DB::select($SQL);

  $Mensaje = $IniciarNuevamente[0]->MENSAJE;

  if($Mensaje == 'DESBLOQUEO AUTORIZADO'){
    \Cookie::queue('LockScreen','No');
    return redirect('/Iniciar');
  }else{
    return redirect('/')->with("E022","Desbloqueo NO autorizado el Password proporcionado es incorrecto");

  }

}

/*===========================================================================*/

public function Logout(){
  \Cookie::queue(\Cookie::forget('Taller_ID'));
  \Cookie::queue(\Cookie::forget('Taller'));
  \Cookie::queue(\Cookie::forget('Persona_ID'));
  \Cookie::queue(\Cookie::forget('Perfil_ID'));
  \Cookie::queue(\Cookie::forget('Perfil'));
  \Cookie::queue(\Cookie::forget('Distribuidor'));
  \Cookie::queue(\Cookie::forget('Distribuidor_ID'));
  \Cookie::queue(\Cookie::forget('LockScreen'));
  \Cookie::queue(\Cookie::forget('NomUsuario'));
  \Cookie::queue(\Cookie::forget('Bitacora_ID'));


  return redirect('/');
}

}
