<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Talleres_Controller extends Controller
{

  public function MenuMaker($M,$Mk,$Mks){
        $MenuMaker = new Menu_Maker_Controller;
        $MenuPrincipal = $MenuMaker->JsonToMenu($M,$Mk,$Mks);
        return $MenuPrincipal;
      }

  /*=======================================================================*/
    public function VCrear(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
        $Empresas = \DB::table('EMPRESAS')
                     ->orderBy('EMPRESA')
                     ->get();

        return view('Talleres.Talleres',compact('Empresas','MenuPrincipal'));
    }

    /*===============================================*/

    public function VInfo(){
      $MenuPrincipal = self::MenuMaker(0,-1,0);
      $Operarios = \DB::table('VW_OPERARIOS')->where("TALLER_ID","=",request()->cookie('Taller_ID'))->get();
      $Piezas = \DB::select("EXEC RPT_PIEZAS_TALLER ".request()->cookie('Taller_ID'));

      $Total = 0;

      foreach ($Piezas as $P) {
        $Total = $Total + $P->NUMERO_REPARACIONES;
      }

     $CountBitacoras = \DB::select("SELECT 'TOTALES' AS BITACORAS,COUNT(*) AS CUENTA FROM BITACORAS WHERE TALLER_ID = ".request()->cookie('Taller_ID')." UNION SELECT 'MENSUALES' AS BITACORAS,COUNT(*) AS CUENTA FROM BITACORAS WHERE TALLER_ID = ".request()->cookie('Taller_ID')." AND DATEPART(MONTH,FECHA) = DATEPART(MONTH,GETDATE()) AND DATEPART(YEAR,FECHA) = DATEPART(YEAR,GETDATE())");
     $Top10 = \DB::select('EXEC P_TOP10_CONSUMO '.request()->cookie('Taller_ID'));

      $Lineas = \DB::select('SELECT * FROM LINEAS WHERE LINEA_ID IN(SELECT DISTINCT LINEA_ID FROM PRODUCTOS WHERE PRODUCTO_ID IN(SELECT DISTINCT PRODUCTO_ID FROM TALLER_PRODUCTO WHERE TALLER_ID = '.request()->cookie('Taller_ID').')) AND LINEA_ID <>12');

        return view('Talleres.InfoTaller',compact('Lineas','Total','Piezas','Operarios','CountBitacoras','Top10','MenuPrincipal'));
    }

    /*===============================================*/

    public function FichaTallerSet($TallerID){
      $Info = \DB::select('SELECT T.*,E.EMPRESA AS DISTRIBUIDOR FROM   TALLERES T, EMPRESAS E WHERE  T.EMPRESA_ID = E.EMPRESA_ID AND T.TALLER_ID = '.$TallerID);
      \Cookie::queue('Taller_ID',$TallerID);
      \Cookie::queue('Taller',$Info[0]->NOMBRE);
      \Cookie::queue('Distribuidor',$Info[0]->DISTRIBUIDOR);
      \Cookie::queue('Ubicacion',$Info[0]->CIUDAD.' - '.$Info[0]->ESTADO);

      return redirect('/Talleres/FichaTaller');
    }

    /*===============================================*/

    public function nuevoTaller(Request $r){

        $Datos = $r->input('Info');

        $Verificar = \DB::table('TALLERES')
                       ->where("NOMBRE","=",$Datos[0])
                       ->get();

        if(sizeof($Verificar) >=1 ){
            return response()->json([
                "Titulo"=>"Taller existente",
                "Mensaje"=>"Ya existe otro taller con el mismo nombre, no es posible repetir esta información",
                "TMensaje"=>"warning"
            ]);
        }


        $Operarios = $r->input('Operarios');
        $OperariosList = '';

        for($x=0;$x<=(sizeof($Operarios)-1);$x++){
             $Info = $Operarios[$x];

             if($Info[0]!=null){
                $OperariosList .= $Info[0].'|';
             }

        }

        $Query = "EXEC P_CREAR_TALLER ".$Datos[5].",'".strtoupper($Datos[0])."','".($Datos[6])."','".strtoupper($Datos[1])."','".($Datos[3])."','".($Datos[4])."','z32L_A4R5_8990','".strtoupper($OperariosList)."'";

        $Guardar = \DB::statement($Query);

        return response()->json([
                                "Titulo"=>"Proceso satisfactorio",
                                "Mensaje"=>"Se ha generado el taller correctamente. En breve el administrador del taller recibirá un correo de confirmación a la dirección de correo electrónico proporcionado",
                                "TMensaje"=>"success"
                                ]);
    }

    /*===============================================*/

    public function CrearOperario(Request $r){
      $Nombre = trim($r->input('Dato'));
      $Validar = \DB::table('VW_OPERARIOS')
      ->where(["TALLER_ID"=>request()->cookie('Taller_ID'),"NOMBRE"=>$Nombre])
      ->get();

      if(sizeof($Validar)>=1){
        return response()->json([
          "Titulo"=>"Operario existente!",
          "Mensaje"=>"Ya existe un operario en este taller con el nombre que proporcionó ",
          "TMensaje"=>"warning"
        ]);
      }

      $Registrar = \DB::statement("EXEC P_CREAR_OPERARIO '".strtoupper($Nombre)."',".request()->cookie('Taller_ID'));
      return response()->json([
        "Titulo"=>"Operario creado correctamente!",
        "Mensaje"=>"Se ha registrado un nuevo operario con el dato proporcionado",
        "TMensaje"=>"success",
        "NOperario"=>'<tr><td>'.strtoupper($Nombre).'</td><td>OPERARIO</td><td>ACTIVO</td><td></td>'
      ]);

    }

    /*===============================================*/

    public function CambiarEstatus(Request $r){
      if($r->input('Est') == 1){
        $NEstatus = 'INACTIVO';
        $Est = 0;
      }else{
        $NEstatus = 'ACTIVO';
        $Est = 1;
      }

     $SQL = "UPDATE OPERARIOS SET ACTIVO = ".$Est." WHERE PERSONA_ID = ".$r->input('Ope');
     $Ejecutar = \DB::statement($SQL);

     return response()->json([
       "Titulo"=>"Proceso satisfactorio",
       "Mensaje"=>"Se ha realizado el cambio de estatus del operario de manera exitosa",
       "TMensaje"=>"success",
       "NEstatus"=>$NEstatus
     ]);

    }

    /*================================================================================*/
    public function UploadFotoLogo(Request $r)
 {

   $path = public_path().'/images/Logos/';

   //Primero validaremos el tamaño y las extensiones de los archivos
   foreach ($r->file('txtFile') as $Arch) {
     $fileName = $Arch->getClientOriginalName();
     if(filesize($Arch)>10485760){
       return response()->json(["Titulo"=>"No se puede cargar!","Mensaje"=>"No es posible cargar el archivo ".$fileName.", ya que supera el tamaño maximo permitido","TMensaje"=>"warning"]);
     }else{
       $File = explode('.',$fileName);
       $Ext = end($File);
       $Extensiones = array( 'png' ,'jpg' ,'jpeg');
       if(in_array(strtolower($Ext),$Extensiones) == false){
        return response()->json(["Titulo"=>"Archivo no valido","Mensaje"=>"El archivo ".$fileName. ' es invalido, ya que la extensión "'.$Ext.'" no es permitida por el sistema',"TMensaje"=>"warning"]);
      }
     }
   }

   // si las validaciones fueron superadas, se guardan los archivos fisicamente en el servidor
   foreach ($r->file('txtFile') as $Arch) {
        $fileName = $Arch->getClientOriginalName();
        $File = explode('.',$fileName);
        $Ext = end($File);


        require_once('C-Funciones.php');
        //$Identificador = randomPassword(3);

        $NuevoNombre = request()->cookie('Taller_ID').".".$Ext;

        $Arch->move($path,$NuevoNombre);
      }

      return response()->json(["Titulo"=>"Proceso satisfactorio","Mensaje"=>"Se ha guardado el logo del taller correctamente","TMensaje"=>"success"]);
 }
}
