<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Formulas_Controller extends Controller
{

  public function MenuMaker($M,$Mk,$Mks){
        $MenuMaker = new Menu_Maker_Controller;
        $MenuPrincipal = $MenuMaker->JsonToMenu($M,$Mk,$Mks);
        return $MenuPrincipal;
      }

  /*=======================================================================*/
    public function CrearFormulas(){
$MenuPrincipal = self::MenuMaker(0,-1,0);
      return view('Formulas.CrearFormulas',compact('MenuPrincipal'));

    }

/*===============================================================================*/
    public function BuscarProductos(Request $B){

      $Buscar = \DB::table('PRODUCTOS')
                ->where("CLAVE","like","%".$B->input('ClaveP')."%")
                ->get();

                $TablaD='<div class="table-responsive">
                  <table id="TablaFormulas" width="100%" class="table table-striped table-lightfont">
                    <thead>
                      <tr>
                        <th>Clave</th>
                        <th>Nombre del producto</th>
                    </thead>
                    <tbody>.';
                    foreach ($Buscar as $B) {
                $TablaD.='<tr>';
                $TablaD.='<td>'.$B->CLAVE.'</td>';
                $TablaD.='<td type="label label-button" class="mr-2 mb-2 btn btn-link" onclick="consultar('.$B->PRODUCTO_ID.');">'.$B->PRODUCTO.'</td>';
                $TablaD.='</tr>';
              }
                $TablaD.='</tbody></table>';




       return response()->json(["BuscarP"=>$Buscar,"Tabla"=>$TablaD]);

    }
/*===============================================================================*/
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
                <div class="col-sm-10">
                      <div class="form-group">
                        <label for=""> Cantidad</label><input class="form-control" placeholder="Cantidad" autocomplete="off" onkeypress="return justDecimals(event,'."'txtCant'".',9);" type="text" name="txtCant" id="txtCant">
                      </div>
                </div>
                <div class="col-sm-4">
                      <div class="form-group">
                         <label for="">Unidad</label>
                         <select class="form-control" name="cmbUnidad" id="cmbUnidad">
                           <option value="1"> ML </option>
                           <option value="2"> GR </option>
                           <option value="3">PZA </option>
                           <option value="4"> OZ </option>
                         </select>
                       </div>

                </div>

                <div class="col-sm-6">
                   <label for=""> </label>
                  <button class="btn btn-primary" type="button" name="btnAddItem" id="btnAddItem" onclick="AgregarProducto();">Agregar</button>
                </div>
              </div>

            </div>
            </div>';

  return response()->json(["InfoProducto"=>$Card]);

}
/*===============================================================================*/
public function ItemFormula(Request $r){
  $Obtener = \DB::table('PRODUCTOS')
              ->where([
                ["PRODUCTO_ID","=",$r->input('Pro')]
              ])->get();

  $Card = '';
$CardPrincipal = '';
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

      if ($O->PRODUCTO_ID == $r->input('Pro')) {
        $CardPrincipal = '
                  <div class="col-sm-12">
                   <div class="post-box">
                    <div class="post-media" style="background-image: url('.$Logo.'); background-size:90px 90px; background-repeat:no-repeat;"></div>
                    <div class="post-content text-center">
                    <button class="btn badge badge-light LineaProducto" id="btnProducto"  data-producto="'.$O->PRODUCTO_ID.'" data-seleccion="1">
                    Has seleccionado:
                    </button>
                       '.$O->CLAVE.'
                       <h5 class="post-title" style="font-size:26px; font-weight:bold">
                          '.$O->CLAVE.'
                       </h5>
                       <div class="post-foot text-center">
                          <div class="post-tags text-center">
                             <button class="btn badge badge-success LineaProducto" id="btnRM"  data-producto="'.$O->PRODUCTO_ID.'" data-seleccion="1">
                             Seleccionado
                             </button>
                          </div>
                       </div>
                    </div>
                 </div>
                 <div class="col-sm-8 form-producto">
                   <div class="row">
                     <div class="col-sm-10">
                           <div class="form-group">
                             <label for=""> Ingrese Cantidad</label><input class="form-control" placeholder="Cantidad" autocomplete="off" onkeypress="return justDecimals(event,'."'txtCant'".',9);" type="text" name="txtCant" id="txtCant">
                           </div>
                     </div>
                     </div>
                     </div>
                     <div class="col-sm-6">
                        <label for=""> </label>
                       <button class="btn btn-primary" type="button" name="btnAddItem" id="btnAddItem" onclick="agregarPro();">Agregar</button>
                     </div>
               </div>';
      }else{
        $Card .= '<div class="col-sm-12">
                   <div class="post-box">
                    <div class="post-media" style="background-image: url('.$Logo.'); background-size:30px 30px; background-repeat:no-repeat;"></div>
                    <div class="post-content text-center">
                       <h5 class="post-title" style="font-size:14px;">
                        '.$O->CLAVE.'
                       </h5>
                    </div>
                 </div>
               </div>';
      }


}

return response()->json(["InfoProducto"=>$CardPrincipal.$Card]);

}

/*===============================================================================*/

public function AgregarProductoFormula(Request $r){
  //$SQL='';
//$SQL2='';

    $SQL = "INSERT INTO TEMP_FORMULA (PERSONA_ID, PRODUCTO_ID, CANTIDAD)";
    $SQL.= " VALUES (".request()->cookie('Persona_ID').",".$r->input('Producto').",".$r->input('Cantidad').")";

    $agregar = \DB:: statement($SQL);

    $SQL2= \DB::select("SELECT P.CLAVE, P.PRODUCTO, TF.CANTIDAD, TF.ITEM FROM PRODUCTOS AS P, TEMP_FORMULA AS TF WHERE P.PRODUCTO_ID=TF.PRODUCTO_ID AND PERSONA_ID =".request()->cookie('Persona_ID'));

    $TablaR ='<div class="table-responsive">
      <table id="TablaFormulasRes" width="100%" class="table table-striped table-lightfont">
        <thead>
          <tr>
            <th>Clave</th>
            <th>Nombre del producto</th>
            <th>cantidad</th>
            <th></th>
        </thead>
        <tbody>.';
        foreach ($SQL2 as $r) {
    $TablaR.='<tr id="Fila'.$r->ITEM.'">';
    $TablaR.='<td>'.$r->CLAVE.'</td>';
    $TablaR.='<td>'.$r->PRODUCTO.'</td>';
    $TablaR.='<td>'.number_format($r->CANTIDAD,4).'</td>';
    $TablaR.='<td><button type="button" id="btnEliminar'.$r->ITEM.'" class="btn btn-secondary btn-sm" onclick="Eliminar('.$r->ITEM.')">Eliminar</button></td>';
    $TablaR.='</tr>';
  }
    $TablaR.='</tbody></table>';

    return response()->json(["Titulo"=>"Mensaje","Mensaje"=>"Se agrego correctamente","TMensaje"=>"success","Agregar"=>$agregar, "insertarDatos"=>$TablaR]);
}
/*===============================================================================*/

public function EliminarItem(Request $r){

      $SQL="DELETE FROM TEMP_FORMULA WHERE ITEM=".$r->input('Item');

      $eliminar = \DB:: statement($SQL);

/*  $eliminarI = \DB::table('TEMP_FORMULA')
              ->where("ITEM","=",$r->input('Item'))
              ->delete();*/

      return response()->json(["Datos"=>$eliminar]);
}
/*===============================================================================*/

 public function CrearFormula(Request $r){
   $Validar = \DB::table('TEMP_FORMULA')->where('PERSONA_ID',"=",request()->cookie('Persona_ID'))->get();
   if(sizeof($Validar) == 0){
     return response()->json(["Titulo"=>"No es posible guardar",
                              "Mensaje"=>"Para crear una formula es necesario que ingrese primero los elementos que la componen",
                              "TMensaje"=>"warning"
                            ]);
   }

   $Guardar = \DB::statement("EXEC P_CREAR_FORMULA '".$r->input('Clave')."','".$r->input('Nombre')."',".$r->input('PrecioBase').",".request()->cookie('Persona_ID').",".request()->cookie('Taller_ID'));
    return response()->json([
      "Titulo"=>"Proceso satisfactorio",
      "Mensaje"=>"Se ha creado la formula correctamente, ahora ya está disponible en el catálogo",
      "TMensaje"=>"success"
    ]);
 }
}
