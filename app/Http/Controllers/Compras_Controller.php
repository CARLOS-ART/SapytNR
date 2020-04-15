<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Compras_Controller extends Controller
{

  public function MenuMaker($M,$Mk,$Mks){
        $MenuMaker = new Menu_Maker_Controller;
        $MenuPrincipal = $MenuMaker->JsonToMenu($M,$Mk,$Mks);
        return $MenuPrincipal;
      }

  /*=======================================================================*/
    public function CapturaCompra(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      $Producto = \DB::table('VW_COMPRA_TEMPORAL')
                    ->where('PERSONA_ID',"=",request()->cookie('Persona_ID'))
                    ->orderBy("ITEM")
                    ->get();

      return view('Compras.PantallaCaptura',compact('Producto','MenuPrincipal'));
    }

    /*==========================================================================*/

    public function ConsultarCatalogo(Request $r){
      $Obtener = \DB::table('VW_TALLER_PRODUCTO')
                  ->where([
                    ["TALLER_ID","=",request()->cookie('Taller_ID')],
                    ["CLAVE","like","%".$r->input('Filtro')."%"]
                  ])->orWhere([

                    ["TALLER_ID","=",request()->cookie('Taller_ID')],
                    ["PRODUCTO","like","%".$r->input('Filtro')."%"]
                    ])->get();

      $Rows = '<thead><tr><td>CLAVE</td><td>PRODUCTO</td><td>EXISTENCIA</td><td>GRAMOS</td><td>PRECIO</td><td>LINEA</td></tr></thead>';
      if (sizeof($Obtener) >= 1) {
        foreach ($Obtener as $O) {
          $Rows .= '<tr onclick="useItem('.$O->PRODUCTO_ID.','.$O->PRESENTACION_ID.')" style="cursor:pointer">';
          $Rows .= '<td>'.$O->CLAVE.'</td>';
          $Rows .= '<td>'.$O->PRODUCTO.'</td>';
          $Rows .= '<td>'.$O->SELLADO.'</td>';
          $Rows .= '<td>'.$O->GRAMOS.'</td>';
          $Rows .= '<td>$ '.number_format ($O->PVENTA,2).'</td>';
          $Rows .= '<td>'.$O->LINEA.'</td>';
          $Rows .= '</tr>';
        }
      }else {
        $Rows .= '<tr><td colspan="6">No se encontraron coincidencias</td></tr>';
      }

      $Table = '<table class="table table-lightborder table-striped">'.$Rows.'</table>';
      return response()->json(["TMensaje"=>"success","Table"=>$Table]);

    }

    /*==========================================================================*/

    public function UseItem(Request $r){
      $Obtener = \DB::table('VW_TALLER_PRODUCTO')
                  ->where([
                    ["TALLER_ID","=",request()->cookie('Taller_ID')],
                    ["PRODUCTO_ID","=",$r->input('Pro')]
                  ])->get();

      $Card = '';

      foreach ($Obtener as $O) {
          if(in_array( $O->LINEA_ID , array(1,2,3) )){
            $Logo = '/img/GlasuritLogo.png';
          }elseif (in_array($O->LINEA_ID,array(4,7,8,10))) {
            $Logo = '/img/RMLogo.png';
          }elseif (in_array($O->LINEA_ID,array(5,6))) {
            $Logo = '/img/LimcoLogo.png';
          }elseif (in_array($O->LINEA_ID,array(11))) {
            $Logo = '/img/NorbinLogo.png';
          }else{
            $Logo = '/img/cta-pattern-light.png';
          }

          if ($O->PRESENTACION_ID == $r->input('Pre')) {
            $CardPrincipal = '
                      <div class="col-sm-12">
                       <div class="post-box">
                        <div class="post-media" style="background-image: url('.$Logo.'); background-size:90px 90px; background-repeat:no-repeat;"></div>
                        <div class="post-content text-center">
                        <button class="btn badge badge-light LineaProducto" id="btnProducto" data-presentacion="'.$O->PRESENTACION_ID.'" data-producto="'.$O->PRODUCTO_ID.'" data-seleccion="1">
                        Has seleccionado:
                        </button>
                           '.$O->CLAVE.'
                           <h5 class="post-title" style="font-size:26px; font-weight:bold">
                              '.$O->UM.'
                           </h5>
                           <div class="post-foot text-center">
                              <div class="post-tags text-center">
                                 <button class="btn badge badge-success LineaProducto" id="btnRM" data-presentacion="'.$O->PRESENTACION_ID.'" data-producto="'.$O->PRODUCTO_ID.'" data-seleccion="1">
                                 Seleccionado
                                 </button>
                              </div>
                           </div>
                        </div>
                     </div>
                     <hr>
                     <small>Otras presentaciones disponibles:</small>
                   </div>

                 ';
          }else{
            $Card .= '<div class="col-sm-12">
                       <div class="post-box">
                        <div class="post-media" style="background-image: url('.$Logo.'); background-size:30px 30px; background-repeat:no-repeat;"></div>
                        <div class="post-content text-center">
                           <h5 class="post-title" style="font-size:14px;">
                            '.$O->CLAVE.'  '.$O->UM.'
                           </h5>
                        </div>
                     </div>
                   </div>';
          }

      }

      $Card = '<div class="row">
                <div class="col-sm-4">
                '.$CardPrincipal.$Card.'
                </div>
                <div class="col-sm-8 form-producto">
                  <div class="row">
                    <div class="col-sm-7">
                          <div class="form-group">
                            <label for=""> Cantidad</label><input class="form-control" placeholder="Cantidad" autocomplete="off" onkeypress="return justDecimals(event,'."'txtCant'".',9);" type="text" name="txtCant" id="txtCant">
                          </div>
                    </div>
                    <div class="col-sm-7">
                          <div class="form-group">
                            <label for=""> Precio compra</label><input class="form-control" placeholder="Precio compra" autocomplete="off" onkeypress="return justDecimals(event,'."'txtPrecio'".',9);" type="text" name="txtPrecio" id="txtPrecio">
                          </div>
                    </div>
                    <div class="col-sm-4">
                          <div class="form-group">
                             <label for="">Unidad</label>
                             <select class="form-control" name="cmbUnidad" id="cmbUnidad">

                               <option value="3">PZA </option>

                             </select>
                           </div>
                    </div>
                    <div class="col-sm-2">
                       <label for=""> </label>
                      <button class="btn btn-primary" type="button" name="btnAddItem" id="btnAddItem" onclick="AgregarProducto();">Agregar</button>
                    </div>
                  </div>

                </div>
                </div>';

      return response()->json(["InfoProducto"=>$Card]);

    }

    /*==========================================================================*/

    public function AgregarProducto(Request $r){
      $Item = \DB::table('COMPRA_TEMPORAL')
           ->insertGetId([
              "PRODUCTO_ID"=>$r->input('Pro'),
              "PRESENTACION_ID"=>$r->input('Pre'),
              "PERSONA_ID"=>request()->cookie('Persona_ID'),
              "CANTIDAD"=>$r->input('Can'),
              "PRECIOC"=>$r->input('PCompra'),
              "PRECIOV"=>$r->input('PCompra')
           ]);

      $Producto = \DB::table('VW_COMPRA_TEMPORAL')
                    ->where('Item',"=",$Item)
                    ->get();

      $rows='';
      foreach ($Producto as $P) {
        $rows .= '<tr id="row'.$P->ITEM.'">';
          $rows .='<td class="text-bright">'.$P->CODIGO_SAP.'</td>';
          $rows .='<td class="text-bright">'.$P->CLAVE.'</td>';
          $rows .='<td class="text-bright">'.$P->PRODUCTO.'</td>';
          $rows .='<td class="text-bright">'.number_format($P->CANTIDAD,2).' PZA</td>';
          $rows .='<td class="text-bright">$ '.number_format($P->PRECIOC,2).'</td>';
          $rows .='<td class="text-bright">$ '.number_format($P->IMPORTE,2).'</td>';
          $rows .='<td class="text-danger"><a href="#" class="text-danger" onclick="EliminarItem('.$P->ITEM.')">Eliminar</a></td>';
        $rows .= '</tr>';
      }

           return response()->json(["TMensaje"=>"success","InfoProducto"=>$rows]);
    }

    /*==========================================================================*/

    public function EliminarItem(Request $r){
      $Item = \DB::table('COMPRA_TEMPORAL')
                   ->where("ITEM","=",$r->input('Item'))
                   ->delete();

      return response()->json(["TMensaje"=>"success","Mensaje"=>"Elemento eliminado"]);
    }

    /*==========================================================================*/

    public function GuardarCompra(Request $r){
      require_once('C-Funciones.php');
      $FechaCompra = TransformaFecha($r->input('Fecha')).'T00:00:00';
      $Guardar = \DB::statement('EXEC P_REALIZAR_COMPRA '.request()->cookie('Persona_ID').','.request()->cookie('Taller_ID').",'".$FechaCompra."','".$r->input('Folio')."'");
      return response()->json(["Titulo"=>"Compra guardada correctamente!","Se ha registrado la compra con exito y ls productos han sido añadidos al inventario del Almacen","TMensaje"=>"success"]);
    }

    /*==========================================================================*/

    public function GuardarCompraFactory(Request $r){
      require_once('C-Funciones.php');
      $FechaCompra = TransformaFecha($r->input('Fecha')).'T00:00:00';
      $Guardar = \DB::statement('EXEC P_REALIZAR_COMPRA_FACTORY '.request()->cookie('Persona_ID').','.request()->cookie('Taller_ID').",'".$FechaCompra."','".$r->input('Folio')."'");
      return response()->json(["Titulo"=>"Compra guardada correctamente!","Mensaje"=>"Se ha registrado la compra con exito ","TMensaje"=>"success"]);
    }

    /*==========================================================================*/

    public function AceptarCompraFactory(Request $r){
      \DB::statement('EXEC P_ACEPTAR_COMPRA '.$r->input('CompraID'));
      return response()->json(["Titulo"=>"Compra aceptada correctamente!","Mensaje"=>"Se ha aceptado la compra con exito y los productos han sido añadidos al inventario del Almacen","TMensaje"=>"success"]);
    }

    /*==========================================================================*/

    public function Historial(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      return view('Compras.TableroCompras',compact('MenuPrincipal'));
    }

    /*==========================================================================*/

    public function HistorialTablero(Request $r){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      require_once('C-Funciones.php');
      $Fe1 = TransformaFecha($r->input('txtFecha')).'T00:00:00';
      $Fe2 = TransformaFecha($r->input('txtFecha2')).'T23:59:00';

      $Buscar = \DB::table('VW_COMPRAS')
                   ->where('TALLER_ID',"=",request()->cookie('Taller_ID'))
                   ->whereBetween('FECHA',[$Fe1,$Fe2])
                   ->get();

     $Fe1 = $r->input('txtFecha');
     $Fe2 = $r->input('txtFecha2');
   return view('Compras.HistorialTablero',compact('MenuPrincipal','Buscar','Fe1','Fe2'));
    }

}
