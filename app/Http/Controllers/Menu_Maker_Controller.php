<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Menu_Maker_Controller extends Controller
{

  public function JsonToMenu($Mk,$Mk2,$Mks){
    $TMenu = "json/BASF_Manager.json";


    $string = file_get_contents($TMenu);
    $Array = json_decode($string, true);

    $MenuStr = "";
    $z = 0;


    foreach ($Array as $Menu){
      if($Menu['Tipo'] == "Menu"){
          $MenuStr .= '<li><a href="javascript:;"><span class="title">'.$Menu['Menu'].'</span><span class=" arrow"></span></a>';
          $MenuStr .= '<span class="icon-thumbnail"><i class="'.$Menu['Icono'].'"></i></span>';
          $Marker = $z;
          $MenuStr .= '<ul class="sub-menu">';

          $Pos = 0;
             $SubMenus = $Menu['Links'];
             foreach ($SubMenus as $Links) {

                 $MenuStr .= '<li class="';
                 if($Mk == $Marker ){$MenuStr .= ' active';}
                 $MenuStr .='"><a href="'.$Links['Link'].'" >'.$Links['Opcion'].'</a> <span class="icon-thumbnail">ea</span></li>';
                 $Pos++;
               }

               $MenuStr .='</ul>';
               $MenuStr .='</li>';

      }else{
        $MenuStr .= '<li class="">
            <a href="'.$Menu['Link'].'"><span class="title">'.$Menu['Menu'].'</span></a>
            <span class="icon-thumbnail"><i class="'.$Menu['Icono'].'" data-feather="'.$Menu['Icono'].'"></i></span>
          </li>';
      }
      $z++;
     }

    return $MenuStr;
  }



  /*============================================*/

  public function MenuPrincipal(){
    $MenuPrincipal = self::JsonToMenu(0,-1,0);
    return view('main_template',compact('MenuPrincipal'));
  }
}
