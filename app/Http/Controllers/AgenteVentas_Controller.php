<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgenteVentas_Controller extends Controller
{
    //


public function AgenteVentas(){
  $TalleresAsignados = \DB::select('EXEC P_TALLER_USUARIO '.request()->cookie('Persona_ID'));
  return view('AgenteVentas.AgenteVentas',compact('TalleresAsignados'));
}
}
