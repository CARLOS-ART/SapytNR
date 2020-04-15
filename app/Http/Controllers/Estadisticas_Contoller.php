<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Estadisticas_Contoller extends Controller
{
  public function MenuMaker($M,$Mk,$Mks){
        $MenuMaker = new Menu_Maker_Controller;
        $MenuPrincipal = $MenuMaker->JsonToMenu($M,$Mk,$Mks);
        return $MenuPrincipal;
      }
    /*==========================================================================*/
    public function Inventario(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      return view('Estadisticas.InventarioTaller',compact('MenuPrincipal'));
    }
    /*==========================================================================*/
    public function EspConsumoBitacoras(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      return view('Estadisticas.EspConsumoBitacoras',compact('MenuPrincipal'));
    }
    /*==========================================================================*/
    public function EspConsumoTaller(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      return view('Estadisticas.EspConsumoTaller',compact('MenuPrincipal'));
    }
    /*==========================================================================*/
    public function Traspasos(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      return view('Estadisticas.Traspasos',compact('MenuPrincipal'));
    }
    /*==========================================================================*/


    public function PiezaImporte(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      return view('Estadisticas.PiezaImporte',compact('MenuPrincipal'));
    }
    /*==========================================================================*/


    public function TallerConsumoMensual(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      return view('Estadisticas.TallerConsumoMensual',compact('MenuPrincipal'));
    }

    /*==========================================================================*/
    public function TallerInforme(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      return view('Estadisticas.InformeTalleresImporte',compact('MenuPrincipal'));
    }

    /*==========================================================================*/
    public function CambioPrecios() {
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      return view('Estadisticas.EstadisticaCambioPrecio',compact('MenuPrincipal'));
    }
    /*==========================================================================*/

    public function Operario(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      $Operarios = \DB::table('VW_OPERARIOS')
                   ->where(["Taller_ID"=>request()->cookie('Taller_ID'),
                            "ACTIVO"=>1])
                  ->orderBy('NOMBRE')
                  ->get();
      return view('Estadisticas.EstadisticasOperarios',compact('Operarios','MenuPrincipal'));
    }

    /*==========================================================================*/

    public function ProductividadView(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      return view('Estadisticas.Productividad',compact('MenuPrincipal'));
    }

    /*==========================================================================*/

    public function ConsumoProductos(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      return view('Estadisticas.EstadisticasConsumo',compact('MenuPrincipal'));
    }

    /*==========================================================================*/
        public function Transferencia_producto(){
          $MenuPrincipal = self::MenuMaker(0,-1,0);
          $Report = \DB::select("SELECT T.TRANSFERENCIA_ID, P.PERSONA_ID, P.NOMBRE, T.FECHA
                                 FROM TRANSFERENCIAS T, PERSONAS P
                                 WHERE T.PERSONA_ID = P.PERSONA_ID");

          return view('Estadisticas.Transferencia_producto', compact("Report",'MenuPrincipal'));
        }
    /*==========================================================================*/

    public function Graficas(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);

    /*  $SQL = "EXEC RPT_CONSUMO_OPERARIOS ".request()->cookie('Taller_ID').",'2018-08-01T00:00:00','2018-10-09T23:59:00'";

       $Datos = \DB::select($SQL);

       $Filas = '';

      foreach ($Datos as $D) {
          $Filas .= '<tr>';
          $Filas .= '<td>'.$D->OPERARIO.'</td>';
          $Filas .= '<td>'.$D->PIEZAS.'</td>';
          $Filas .= '<td> $ '.number_format($D->COSTO_PINTURA + $D->COSTO_TRANSPARENTE + $D->COSTO_PRIMARIO + $D->COSTO_OTRO + $D->COSTO_ALIADOS,2).'</td>';
          $Filas .= '<td> $ '.number_format(($D->COSTO_PINTURA + $D->COSTO_TRANSPARENTE + $D->COSTO_PRIMARIO + $D->COSTO_OTRO + $D->COSTO_ALIADOS)/$D->PIEZAS,2).'</td>';
          $Filas .= '</tr>';
      }*/
      return view('Estadisticas.Graficas', compact('MenuPrincipal'));
    }

    /*==========================================================================*/

    public function GraficaConsumoOperarios(Request $r){
      require_once('C-Funciones.php');
      $Fecha1 = TransformaFecha($r->input('Fe1'));
      $Fecha2 = TransformaFecha($r->input('Fe2'));


      $SQL = "EXEC RPT_CONSUMO_OPERARIOS ".request()->cookie('Taller_ID').",'".$Fecha1."T00:00:00','".$Fecha2."T23:59:00'";

       $Datos = \DB::select($SQL);

       $Operarios = array();
       $Reparaciones = array();
       $Costo = array();
       $Filas = '';
       $F = 0;

      foreach ($Datos as $D) {
         $Operarios[$F] = $D->OPERARIO;
         $Reparaciones[$F] = $D->PIEZAS;
         $Costo[$F] = number_format($D->COSTO_PINTURA + $D->COSTO_TRANSPARENTE + $D->COSTO_PRIMARIO + $D->COSTO_OTRO + $D->COSTO_ALIADOS,2);

         $Filas .= '<tr>';
         $Filas .= '<td>'.$D->OPERARIO.'</td>';
         $Filas .= '<td>'.$D->PIEZAS.'</td>';
         $Filas .= '<td> $ '.number_format($D->COSTO_PINTURA + $D->COSTO_TRANSPARENTE + $D->COSTO_PRIMARIO + $D->COSTO_OTRO + $D->COSTO_ALIADOS,2).'</td>';
         $Filas .= '<td> $ '.number_format(($D->COSTO_PINTURA + $D->COSTO_TRANSPARENTE + $D->COSTO_PRIMARIO + $D->COSTO_OTRO + $D->COSTO_ALIADOS)/$D->PIEZAS,2).'</td>';
         $Filas .= '</tr>';
         $F++;
      }

      $SQL = "EXEC RPT_REPARACIONES_TAMANIO_VEHICULO_GLOBAL ".request()->cookie('Taller_ID').",'".$Fecha1."T00:00:00','".$Fecha2."T23:59:00'";
      $Datos = \DB::select($SQL);

      $Medida = array();
      $Valores = array();
      $Items = array();
      $F = 0;

      foreach ($Datos as $D) {

         $Medida[$F] = $D->MEDIDA;
         $Items['value'] = $D->REPARACIONES;
         $Items['name'] = $D->MEDIDA;

         $Valores[$F] = $Items;
         $F++;
      }

      $SQL = "EXEC RPT_PIEZAS_CONDICION ".request()->cookie('Taller_ID').",'".$Fecha1."T00:00:00','".$Fecha2."T23:59:00'";
      $Datos = \DB::select($SQL);
      $Items2 = array();
      $Condicion = array();
      $CondicionItems = array();

      $F = 0;

      foreach ($Datos as $D) {

         $Condicion[$F] = $D->CONDICION;
         $Items2['value'] = $D->NUMERO_REPARACIONES;
         $Items2['name'] = $D->CONDICION;

         $CondicionItems[$F] = $Items2;
         $F++;
      }

      /*$SQL = "EXEC RPT_PRODUCCION_TIPO_COLOR ".request()->cookie('Taller_ID').",'2018-08-01T00:00:00','2018-10-09T23:59:00'";
      $Datos = \DB::select($SQL);
      $F = 0;

      $TColor = array();
      $Personal = array();

      foreach ($Datos as $D) {

         $TColor[$F] = $D->TIPO_PINTURA;
         $Personal[$F] = $D->OPERARIO;
         $Items2['value'] = $D->NUMERO_REPARACIONES;
         $Items2['name'] = $D->CONDICION;

         $CondicionItems[$F] = $Items2;
         $F++;
      }*/



      return response()->json([
        "Operarios"=>$Operarios,
        "Reparaciones"=>$Reparaciones,
        "Costo"=>$Costo,
        "Medida"=>$Medida,
        "ItemsMedida"=>$Valores,
        "CondicionItems"=>$CondicionItems,
        "Condiciones"=>$Condicion,
        "Filas"=>$Filas
      ]);
    }
    /*==============================================================================*/

  public function EficienciaTaller(){
    $MenuPrincipal = self::MenuMaker(0,-1,0);

    $Taller = \DB::table('TALLERES')
                ->orderBy('Nombre')
                ->get();

    return view('Estadisticas.Eficiencia_Taller',compact('MenuPrincipal','Taller'));
  }
}
