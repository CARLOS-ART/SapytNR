<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportViewer_Controller extends Controller
{
    public function Visor(Request $r){
      $CU = $r->input('CU');
      switch ($CU) {
        case 1:
          $Inventario = $r->input('Inventario');
          return view('ReportViewer',compact('Inventario','CU'));
        break;
        case 2:
          $Solic = $r->input('Solicitud');
          return view('ReportViewer',compact('Solic','CU'));
        break;
        case 3:
        $Bitacora = $r->input('Bitacora');
        return view('ReportViewer',compact('Bitacora','CU'));
        break;
        case 4:
          $Auditoria = $r->input('Auditoria');
          return view('ReportViewer',compact('Auditoria','CU'));
        break;
        case 5:
          $Auditoria = $r->input('Auditoria');
          return view('ReportViewer',compact('Auditoria','CU'));
        break;
        case 6:
          $Compra = $r->input('Compra');
          return view('ReportViewer',compact('Compra','CU'));
        break;
        case 7:
          $Taller = request()->cookie('Taller_ID');
          return view('ReportViewer',compact('Taller','CU'));
        break;
        case 8:
          $Taller = request()->cookie('Taller_ID');
          return view('ReportViewer',compact('Taller','CU'));
        break;
        case 9:
          $Taller = request()->cookie('Taller_ID');
          require_once('C-Funciones.php');
          $Fecha_i = TransformaFecha($r->input('Fecha_i'))."T00:00:00";
          $Fecha_f = TransformaFecha($r->input('Fecha_f'))."T23:59:00";
          return view('ReportViewer',compact('Taller','CU','Fecha_i','Fecha_f'));
        break;
        case 10:
          $Taller = request()->cookie('Taller_ID');
          require_once('C-Funciones.php');
          $Fecha_i = TransformaFecha($r->input('Fecha_i'))."T00:00:00";
          $Fecha_f = TransformaFecha($r->input('Fecha_f'))."T23:59:00";
          return view('ReportViewer',compact('Taller','CU','Fecha_i','Fecha_f'));
        break;
        case 11:
          $Taller = request()->cookie('Taller_ID');
          require_once('C-Funciones.php');
          $Fecha_i = TransformaFecha($r->input('Fecha_i'))."T00:00:00";
          $Fecha_f = TransformaFecha($r->input('Fecha_f'))."T23:59:00";
          return view('ReportViewer',compact('Taller','CU','Fecha_i','Fecha_f'));
        break;
        case 12:
          $Taller = request()->cookie('Taller_ID');
          require_once('C-Funciones.php');
          $Fecha_i = TransformaFecha($r->input('Fecha_i'))."T00:00:00";
          $Fecha_f = TransformaFecha($r->input('Fecha_f'))."T23:59:00";
          return view('ReportViewer',compact('Taller','CU','Fecha_i','Fecha_f'));
        break;
        case 13:
          $Taller = request()->cookie('Taller_ID');
          require_once('C-Funciones.php');
          $Fecha_i = TransformaFecha($r->input('Fecha_i'))."T00:00:00";
          $Fecha_f = TransformaFecha($r->input('Fecha_f'))."T23:59:00";
          return view('ReportViewer',compact('Taller','CU','Fecha_i','Fecha_f'));
        break;
        case 14:
          $Taller = request()->cookie('Taller_ID');
          require_once('C-Funciones.php');
          $Fecha_i = TransformaFecha($r->input('Fecha_i'))."T00:00:00";
          $Fecha_f = TransformaFecha($r->input('Fecha_f'))."T23:59:00";
          return view('ReportViewer',compact('Taller','CU','Fecha_i','Fecha_f'));
        break;
        case 15:
          $Taller = request()->cookie('Taller_ID');
          require_once('C-Funciones.php');
          $Fecha_i = TransformaFecha($r->input('Fecha_i'))."T00:00:00";
          $Fecha_f = TransformaFecha($r->input('Fecha_f'))."T23:59:00";
          return view('ReportViewer',compact('Taller','CU','Fecha_i','Fecha_f'));
        break;
        case 16:
          $Taller = request()->cookie('Taller_ID');
          require_once('C-Funciones.php');
          $Fecha_i = TransformaFecha($r->input('Fecha_i'))."T00:00:00";
          $Fecha_f = TransformaFecha($r->input('Fecha_f'))."T23:59:00";
          return view('ReportViewer',compact('Taller','CU','Fecha_i','Fecha_f'));
        break;
        case 17:
          $Taller = request()->cookie('Taller_ID');
          require_once('C-Funciones.php');
          $Fecha_i = TransformaFecha($r->input('Fecha_i'))."T00:00:00";
          $Fecha_f = TransformaFecha($r->input('Fecha_f'))."T23:59:00";
          $Operario = $r->input('Operario');
          return view('ReportViewer',compact('Taller','CU','Fecha_i','Fecha_f','Operario'));
        break;
        case 18:
        $Bitacora = $r->input('Bitacora');
        return view('ReportViewer',compact('Bitacora','CU'));
        case 20:
          $Taller = request()->cookie('Taller_ID');
          require_once('C-Funciones.php');
          $Fecha_i = TransformaFecha($r->input('Fecha_i'))."T00:00:00";
          $Fecha_f = TransformaFecha($r->input('Fecha_f'))."T23:59:00";

          return view('ReportViewer',compact('Taller','CU','Fecha_i','Fecha_f'));
        break;
        case 21:
          $Taller = request()->cookie('Taller_ID');
          require_once('C-Funciones.php');
          $Fecha_i = TransformaFecha($r->input('Fecha_i'))."T00:00:00";
          $Fecha_f = TransformaFecha($r->input('Fecha_f'))."T23:59:00";

          return view('ReportViewer',compact('Taller','CU','Fecha_i','Fecha_f'));
        break;
        case 24:
          $Talleres = request()->cookie('Taller_ID');
          require_once('C-Funciones.php');

          return view('ReportViewer',compact('Talleres','CU'));
        break;
        case 25:
          $Taller = request()->cookie('Taller_ID');
          require_once('C-Funciones.php');
          $Fecha_i = TransformaFecha($r->input('Fecha_i'))."T00:00:00";
          $Fecha_f = TransformaFecha($r->input('Fecha_f'))."T23:59:00";
          return view('ReportViewer',compact('Taller','Fecha_i','Fecha_f','CU'));
        break;
        case 26:
          $Taller = $r->input('TallerID');
          $Registro = $r->input('RegistroID');
          return view('ReportViewer',compact('Taller','Registro','CU'));
        break;
        case 27:
          $Transfer= $r->input('TransfID');
          return view('ReportViewer',compact('Transfer','CU'));
        break;
        case 28:
          $Taller = request()->cookie('Taller_ID');
          require_once('C-Funciones.php');
          $Fecha_i = TransformaFecha($r->input('Fecha_i'))."T00:00:00";
          $Fecha_f = TransformaFecha($r->input('Fecha_f'))."T23:59:00";
          return view('ReportViewer',compact('Taller','Fecha_i','Fecha_f','CU'));
        break;
        case 29:
          $Taller = request()->cookie('Taller_ID');
          require_once('C-Funciones.php');
          $Fecha_i = TransformaFecha($r->input('Fecha_i'))."T00:00:00";
          $Fecha_f = TransformaFecha($r->input('Fecha_f'))."T23:59:00";
          return view('ReportViewer',compact('Taller','Fecha_i','Fecha_f','CU'));
        break;
        case 30:
          $Taller = request()->cookie('Taller_ID');
          require_once('C-Funciones.php');
          $Fecha_i = TransformaFecha($r->input('Fecha_i'))."T00:00:00";
          $Fecha_f = TransformaFecha($r->input('Fecha_f'))."T23:59:00";
          return view('ReportViewer',compact('Taller','Fecha_i','Fecha_f','CU'));
        break;
        case 31:
          $Taller = $r->input('TallerID');
          $Mes = $r->input('Mes');
          $Anio = $r->input('Anio');
          return view('ReportViewer',compact('Taller','Mes','Anio','CU'));
        break;
      }
    }
}
