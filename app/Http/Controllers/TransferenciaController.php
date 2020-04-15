<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransferenciaController extends Controller
{

  public function MenuMaker($M,$Mk,$Mks){
        $MenuMaker = new Menu_Maker_Controller;
        $MenuPrincipal = $MenuMaker->JsonToMenu($M,$Mk,$Mks);
        return $MenuPrincipal;
      }

  /*=======================================================================*/
    public function formTransfer(){
$MenuPrincipal = self::MenuMaker(0,-1,0);
      $Taller = \DB::table('TALLERES')
                   ->orderBy('NOMBRE')
                   ->get();

      return view('Transferencias.Transferencias',compact('Taller','MenuPrincipal'));
    }

/*================================================================================*/

  public function TablaProductos(Request $r)
  {

    $Tabla='<div class="table-responsive">
          <table class="table table-lightborder">
            <thead>
              <tr>
                <th>
                  SAP
                </th>
                <th>CLAVE</th>
                <th>PRODUCTO</th>
                <th>PRECIO COMPRA</th>
                <th>IMPORTE</th>
              </tr>
            </thead>
            <tbody>';
              //foreach($Top10 as $T10){
     $Tabla.='<tr>';
     $Tabla.='<td></td>';
     $Tabla.='<td></td>';
     $Tabla.='<td></td>';
     $Tabla.='</tr>';
            //}
     $Tabla.='</tbody>
          </table>
        </div>';

        return response()->json(["Tabla"=>$Tabla]);

  }
/*================================================================================*/
  public function BuscarProductos(Request $r)
  {
    $BuscarPro = \DB::table('VW_TALLER_PRODUCTO')
                ->where([
                  ["TALLER_ID","=",$r->input('TallerID')],
                  ["CLAVE","like","%".$r->input('Filtro')."%"]
                ])->get();

                $Tabla='<table class="table table-lightborder table-striped">
                      <thead>
                        <tr>
                          <td>CLAVE</td>
                          <td>PRODUCTO</td>
                          <td>EXISTENCIA</td>
                          <td>GRAMOS</td>
                          <td>PRECIO</td>
                          <td>LINEA</td>
                        </tr>
                      </thead>
                      <tbody>';
                      if (sizeof($BuscarPro) >= 1) {
                      foreach($BuscarPro as $BP) {
                $Tabla .= '<tr onclick="PoductosAgregar('.$BP->TALLER_ID.','.$BP->PRODUCTO_ID.','.$BP->PRESENTACION_ID.')" style="cursor:pointer">';
                $Tabla .= '<td>'.$BP->CLAVE.'</td>';
                $Tabla .= '<td>'.$BP->PRODUCTO.'</td>';
                $Tabla .= '<td>'.$BP->SELLADO.'</td>';
                $Tabla .= '<td>'.$BP->GRAMOS.'</td>';
                $Tabla .= '<td>$ '.number_format ($BP->PVENTA,2).'</td>';
                $Tabla .= '<td>'.$BP->LINEA.'</td>';
                $Tabla .= '</tr>';
                      }
                    }else {
                $Tabla .= '<tr><td colspan="6">No se encontraron coincidencias</td></tr>';
                }
                $Tabla.='</tbody>
                      </table>';

    return response()->json(["TMensaje"=>"success","Tabla"=>$Tabla]);
  }

/*================================================================================*/
  public function Producto(Request $r)
  {

  $Obtener = \DB::table('VW_TALLER_PRODUCTO')
              ->where([
                ["TALLER_ID","=",$r->input('TallerID')],
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
                    <button class="btn badge badge-light LineaProducto" id="btnProducto" data-presentacion="'.$O->PRESENTACION_ID.'" data-producto="'.$O->PRODUCTO_ID.'" data-seleccion="1" value="'.$O->PRODUCTO_ID.'">
                    Has seleccionado:
                    </button>
                       '.$O->CLAVE.'
                       <h5 class="post-title" style="font-size:26px; font-weight:bold">
                          '.$O->UM.'
                       </h5>
                       <div class="post-foot text-center">
                          <div class="post-tags text-center">
                             <button class="btn badge badge-success LineaProducto" id="btnRM" data-presentacion="'.$O->PRESENTACION_ID.'" data-producto="'.$O->PRODUCTO_ID.'" data-seleccion="1" value="'.$O->PRESENTACION_ID.'">
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
                    <button class="btn btn-primary" type="button" name="btnAddItem" id="btnAddItem" class="close" data-dismiss="modal" onclick="Agregar(btnProducto.value, btnRM.value, txtCant.value, txtPrecio.value);">Agregar</button>
                  </div>
                </div>

              </div>
              </div>';

            return response()->json(["InfoProducto"=>$Card]);

  }

/*================================================================================*/

  public function GuardarProducto(Request $r)
  {
    /*$Cantidad = \DB::table("TALLER_PRODUCTO")
                    ->where([["TALLER_ID","=",$r->input('TallerID')],["PRODUCTO_ID","=",$r->input('ProID')],["PRESENTACION_ID","=",$r->input('PreID')]])
                    //->where("TALLER_ID","=",$r->input('TallerID'))
                  //  ->where("PRODUCTO_ID","=",$r->input('ProID'))
                  //  ->where("PRESENTACION_ID","=",$r->input('PreID'))
                    ->get();

    $TransP = \DB::table("TRANSFERENCIA_PRODUCTO_TEMP")
                    ->where([["PRODUCTO_ID","=",$r->input('ProID')],["PRESENTACION_ID","=",$r->input('PreID')]])
                    //->where("PRODUCTO_ID","=",$r->input('ProID'))
                    //->where("PRESENTACION_ID","=",$r->input('PreID'))
                    ->get();*/

    /*$Cantidad[0]->SELLADO;
    $TransP[0]->CANTIDAD;*/

    /*  if ($TransP > $Cantidad) {
        return response()->json(["Titulo"=>"No se puede agregar","Mensaje"=>"La cantidad de producto a transferir es mayor a la cantidad existente, verifiquelo e intente nuevamnete","TMensaje"=>"warning"]);
      }else{*/
        $SQL = "INSERT INTO TRANSFERENCIA_PRODUCTO_TEMP (PRODUCTO_ID, PRESENTACION_ID,CANTIDAD,  PRECIO, PERSONA_ID )";
        $SQL.= " VALUES (".$r->input('ProID').",".$r->input('PreID').",".$r->input('Cant').",".$r->input('Precio').",".request()->cookie('Persona_ID').")";
        $Agregar = \DB:: statement($SQL);
    //  }


    $Mostrar = \DB::table("VW_TRANSFERENCIA_PRODUCTO")
                  ->where('PERSONA_ID',"=",request()->cookie('Persona_ID'))
                  ->get();

    $Tabla='<table class="table table-lightborder table-striped">
          <thead>
            <tr>
              <td>CLAVE<td>
              <td>PRODUCTO</td>
              <td>PRESENTACION</td>
              <td>CANTIDAD</td>
              <td>PRECIO COMPRA</td>
            </tr>
          </thead>
          <tbody>';
          foreach($Mostrar as $m) {
    $Tabla .='<tr id="row'.$m->ITEM.'">';
    $Tabla .='<td>'.$m->CLAVE.'<td>';
    $Tabla .= '<td>'.$m->PRODUCTO.'</td>';
    $Tabla .= '<td>'.$m->NOMBRE.'</td>';
    $Tabla .= '<td>'.$m->CANTIDAD.'</td>';
    $Tabla .= '<td>$ '.number_format ($m->PRECIO,2).'</td>';
    $Tabla .= '<td><button class="btn btn-primary btn-sm" type="button" name="btnElimItem" id="btnElimItem"  onclick="EliminarProd('.$m->ITEM.');">Eliminar</button></td>';
    $Tabla .= '</tr>';
        }
    $Tabla.='</tbody>
          </table>';

          return response()->json(["TMensaje"=>"success","Tabla"=>$Tabla]);
  }

/*================================================================================*/
public function EliminarProducto(Request $r){
  $Item = \DB::table('TRANSFERENCIA_PRODUCTO_TEMP')
               ->where("TRANS_PROD_ID","=",$r->input('Item'))
               ->delete();

  return response()->json(["TMensaje"=>"success","Mensaje"=>"Elemento eliminado","TMensaje"=>"success"]);
}

/*================================================================================*/

  public function GuardarTraspasoProducto(Request $r)
  {
    require_once('C-Funciones.php');
    $FechaCompra = TransformaFecha($r->input('Fecha')).'T00:00:00';

    $SQL = "EXEC P_REGISTRAR_TRANSFERENCIA '".request()->cookie('Persona_ID')."','".$FechaCompra."','".$r->input('TallerID_OR')."','".$r->input('TallerID_DES')."',
            '".$r->input('ProID')."','".$r->input('PreID')."','".$r->input('Cant')."','".$r->input('Precio')."'";
    $Guardar = \DB::select($SQL);


      $SQL2 = "EXEC P_RESTA_TRANSFERENCIA_PRODUCTO ".$Guardar[0]->TRANSFERENCIA_ID;
      $Realizar = \DB::statement($SQL2);


    return response()->json(["Titulo"=>"Guardado",
                             "Mensaje"=>"Se ha guardado la transferencia de los productos satisfactoriamente",
                             "TMensaje"=>"success"]);

  }
}
