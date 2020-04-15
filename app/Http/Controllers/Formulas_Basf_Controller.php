<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Formulas_Basf_Controller extends Controller
{
  public function MenuMaker($M,$Mk,$Mks){
        $MenuMaker = new Menu_Maker_Controller;
        $MenuPrincipal = $MenuMaker->JsonToMenu($M,$Mk,$Mks);
        return $MenuPrincipal;
      }

  /*=======================================================================*/
    public function CrearFormula(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      return view('FormulasBasf.CrearFormula',compact('MenuPrincipal'));
    }
}
