@php
 switch ($CU) {
   case 1:
     $params = '&Inv='.$Inventario;
    break;
    case 2:
      $params = '&Solic='.$Solic;
     break;
    case 3:
      $params = '&Bit='.$Bitacora;
    break;
    case 4:
       $params = '&Auditoria='.$Auditoria;
       $CU =22;
    break;
    case 5:
        $params = '&Auditoria='.$Auditoria;
        $CU= 23;
    break;
    case 6:
        $params = '&Compra='.$Compra;
    break;
    case 7:
        $params = '&Taller='.$Taller;
    break;
    case 8:
        $params = '&Taller='.$Taller;
    break;
    case 9:
        $params = '&Taller='.$Taller.'&Fecha_i='.$Fecha_i.'&Fecha_f='.$Fecha_f;
    break;
    case 10:
        $params = '&Taller='.$Taller.'&Fecha_i='.$Fecha_i.'&Fecha_f='.$Fecha_f;
    break;
    case 11:
        $params = '&Taller='.$Taller.'&Fecha_i='.$Fecha_i.'&Fecha_f='.$Fecha_f;
    break;
    case 12:
        $params = '&Taller='.$Taller.'&Fecha_i='.$Fecha_i.'&Fecha_f='.$Fecha_f;
    break;
    case 13:
        $params = '&Taller='.$Taller.'&Fecha_i='.$Fecha_i.'&Fecha_f='.$Fecha_f;
    break;
    case 14:
        $params = '&Taller='.$Taller.'&Fecha_i='.$Fecha_i.'&Fecha_f='.$Fecha_f;
    break;
    case 15:
        $params = '&Taller='.$Taller.'&Fecha_i='.$Fecha_i.'&Fecha_f='.$Fecha_f;
    break;
    case 16:
        $params = '&Taller='.$Taller.'&Fecha_i='.$Fecha_i.'&Fecha_f='.$Fecha_f;
    break;
    case 17:
        $params = '&Taller='.$Taller.'&Fecha_i='.$Fecha_i.'&Fecha_f='.$Fecha_f.'&Operario='.$Operario;
    break;
    case 18:
      $params = '&Bit='.$Bitacora;
    break;
    case 20:
        $params = '&Taller='.$Taller.'&Fecha1='.$Fecha_i.'&Fecha2='.$Fecha_f;
    break;
    case 21:
        $params = '&TALLER='.$Taller.'&FECHA_I='.$Fecha_i.'&FECHA_F='.$Fecha_f;
    break;
    case 24:
        $params = '&TALLERES='.$Talleres;
    break;
    case 25:
        $params = '&TALLER='.$Taller.'&FECHA1='.$Fecha_i.'&FECHA2='.$Fecha_f;
    break;
    case 26:
        $params = '&Taller='.$Taller.'&REGISTRO='.$Registro;
    case 27:
        $params = '&TRANSFERENCIAID='.$Transfer;
    case 28:
        $params = '&TALLER='.$Taller.'&FECHA1='.$Fecha_i.'&FECHA2='.$Fecha_f;
        break;
    case 29:
          $params = '&TALLER='.$Taller.'&FECHA1='.$Fecha_i.'&FECHA2='.$Fecha_f;
        break;
    case 30:
          $params = '&TALLER='.$Taller.'&FECHA1='.$Fecha_i.'&FECHA2='.$Fecha_f;
        break;
    case 31:
      $params = '&TALLER='.$Taller.'&MES='.$Mes.'&ANIO='.$Anio;
    break;

 }
@endphp
<iframe src="http://74.208.178.230:94/ReportViewer.aspx?RPT=<?php echo $CU.$params ?>" height="100%" width="100%" frameborder="0"></iframe>
