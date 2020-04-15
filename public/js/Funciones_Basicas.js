function Longitud(txt,Tam){

      txt="#"+txt;
			if ($(txt).val().length>=Tam){
				return false;
				}else{
					return true;
					}
  }

  /*===============================================================*/

function justDecimals(e,txt,Tam){
		var Respuesta;
		Respuesta =Longitud(txt,Tam);
		var keynum = window.event ? window.event.keyCode : e.which;
		if(Respuesta==true){
			if ((keynum == 8))return true;
			if((keynum==46)){
				var Cadena=document.getElementById(txt).value;
				var Punto=Cadena.indexOf(".");
				if(Punto==-1){
				 return true;}else{return false}
				 }

		}else{
			return false;
			}
		return /\d/.test(String.fromCharCode(keynum));
        }

/*===============================================================*/

function justNumbers(e,txt,Tam)
        {
        var Respuesta;
        Respuesta =Longitud(txt,Tam);

        var keynum = window.event ? window.event.keyCode : e.which;
        if(Respuesta==true){
          if ((keynum == 8)) return true;
        }else{
          return false;
        }

        return /\d/.test(String.fromCharCode(keynum));
        }

/*===============================================================*/

function esEnter(e){
  var keynum = window.event ? window.event.keyCode : e.which;
  if ((keynum == 13) ){
		return true;
	}else{
    return false;
	}

  return /\d/.test(String.fromCharCode(keynum));
}

 /*===============================================================*/

 function ReportViewer(Cu){
 var _token = $('input[name="_token"]').val();
 console.log(Cu);
 switch (Cu) {
   case 1:
       var Inventario = $("#tableWithSearch").data('inventario');
       var form =
       $('<form action="/ReportViewer" method="post" target="_blank">' +
           '<input type="hidden" name="CU" value="1" />' +
           '<input type="hidden" name="Inventario" value="' + Inventario + '" />' +
           '<input type="hidden" name="_token" value="' + _token + '" />' +
       '</form>');
   break;
   case 2:
       var Solic = $("#tableWithSearch").data("solicitud");
       var form =
       $('<form action="/ReportViewer" method="post" target="_blank">' +
           '<input type="hidden" name="CU" value="2" />' +
           '<input type="hidden" name="Solicitud" value="' + Solic + '" />' +
           '<input type="hidden" name="_token" value="' + _token + '" />' +
       '</form>');
   break;
   case 3:
     var Bitacora = $("#tableWithSearch").data("bitacora");
     var form =
     $('<form action="/ReportViewer" method="post" target="_blank">' +
         '<input type="hidden" name="CU" value="3" />' +
         '<input type="hidden" name="Bitacora" value="' + Bitacora + '" />' +
         '<input type="hidden" name="_token" value="' + _token + '" />' +
     '</form>');
   break;
   case 4:
   var Auditoria = $("#tableWithSearch").data("auditoria");
   var form =
   $('<form action="/ReportViewer" method="post" target="_blank">' +
       '<input type="hidden" name="CU" value="4" />' +
       '<input type="hidden" name="Auditoria" value="' + Auditoria + '" />' +
       '<input type="hidden" name="_token" value="' + _token + '" />' +
   '</form>');
   break;
   case 5:
     var Auditoria = $("#tableWithSearch").data("auditoria");
     var form =
     $('<form action="/ReportViewer" method="post" target="_blank">' +
         '<input type="hidden" name="CU" value="5" />' +
         '<input type="hidden" name="Auditoria" value="' + Auditoria + '" />' +
         '<input type="hidden" name="_token" value="' + _token + '" />' +
     '</form>');
   break;
   case 6:
     var Compra = $("#tableWithSearch").data("compra");
     var form =
     $('<form action="/ReportViewer" method="post" target="_blank">' +
         '<input type="hidden" name="CU" value="6" />' +
         '<input type="hidden" name="Compra" value="' + Compra + '" />' +
         '<input type="hidden" name="_token" value="' + _token + '" />' +
     '</form>');
   break;
   case 7:
     var form =
     $('<form action="/ReportViewer" method="post" target="_blank">' +
         '<input type="hidden" name="CU" value="7" />' +
         '<input type="hidden" name="_token" value="' + _token + '" />' +
     '</form>');
   break;
   case 8:
     var form =
     $('<form action="/ReportViewer" method="post" target="_blank">' +
         '<input type="hidden" name="CU" value="8" />' +
         '<input type="hidden" name="_token" value="' + _token + '" />' +
     '</form>');
   break;
   case '9':
     var Fecha_i = $("#txtFecha").val();
     var Fecha_f = $("#txtFecha2").val();
     var form =
     $('<form action="/ReportViewer" method="post" target="_blank">' +
         '<input type="hidden" name="CU" value="9" />' +
         '<input type="hidden" name="Fecha_i" value="'+Fecha_i+'" />' +
         '<input type="hidden" name="Fecha_f" value="'+Fecha_f+'" />' +
         '<input type="hidden" name="_token" value="' + _token + '" />' +
     '</form>');

   break;
   case '10':
     var Fecha_i = $("#txtFecha").val();
     var Fecha_f = $("#txtFecha2").val();
     var form =
     $('<form action="/ReportViewer" method="post" target="_blank">' +
         '<input type="hidden" name="CU" value="10" />' +
         '<input type="hidden" name="Fecha_i" value="'+Fecha_i+'" />' +
         '<input type="hidden" name="Fecha_f" value="'+Fecha_f+'" />' +
         '<input type="hidden" name="_token" value="' + _token + '" />' +
     '</form>');
   break;
   case '11':
     var Fecha_i = $("#txtFecha").val();
     var Fecha_f = $("#txtFecha2").val();
     var form =
     $('<form action="/ReportViewer" method="post" target="_blank">' +
         '<input type="hidden" name="CU" value="11" />' +
         '<input type="hidden" name="Fecha_i" value="'+Fecha_i+'" />' +
         '<input type="hidden" name="Fecha_f" value="'+Fecha_f+'" />' +
         '<input type="hidden" name="_token" value="' + _token + '" />' +
     '</form>');
   break;
   case '12':
     var Fecha_i = $("#txtFecha").val();
     var Fecha_f = $("#txtFecha2").val();
     var form =
     $('<form action="/ReportViewer" method="post" target="_blank">' +
         '<input type="hidden" name="CU" value="12" />' +
         '<input type="hidden" name="Fecha_i" value="'+Fecha_i+'" />' +
         '<input type="hidden" name="Fecha_f" value="'+Fecha_f+'" />' +
         '<input type="hidden" name="_token" value="' + _token + '" />' +
     '</form>');
   break;
   case '13':
     var Fecha_i = $("#txtFecha").val();
     var Fecha_f = $("#txtFecha2").val();
     var form =
     $('<form action="/ReportViewer" method="post" target="_blank">' +
         '<input type="hidden" name="CU" value="13" />' +
         '<input type="hidden" name="Fecha_i" value="'+Fecha_i+'" />' +
         '<input type="hidden" name="Fecha_f" value="'+Fecha_f+'" />' +
         '<input type="hidden" name="_token" value="' + _token + '" />' +
     '</form>');
   break;
   case '14':
     var Fecha_i = $("#txtFecha").val();
     var Fecha_f = $("#txtFecha2").val();
     var form =
     $('<form action="/ReportViewer" method="post" target="_blank">' +
         '<input type="hidden" name="CU" value="14" />' +
         '<input type="hidden" name="Fecha_i" value="'+Fecha_i+'" />' +
         '<input type="hidden" name="Fecha_f" value="'+Fecha_f+'" />' +
         '<input type="hidden" name="_token" value="' + _token + '" />' +
     '</form>');
   break;
   case '15':
     var Fecha_i = $("#txtFecha").val();
     var Fecha_f = $("#txtFecha2").val();
     var form =
     $('<form action="/ReportViewer" method="post" target="_blank">' +
         '<input type="hidden" name="CU" value="15" />' +
         '<input type="hidden" name="Fecha_i" value="'+Fecha_i+'" />' +
         '<input type="hidden" name="Fecha_f" value="'+Fecha_f+'" />' +
         '<input type="hidden" name="_token" value="' + _token + '" />' +
     '</form>');
   break;
   case '16':
     var Fecha_i = $("#txtFecha").val();
     var Fecha_f = $("#txtFecha2").val();
     var form =
     $('<form action="/ReportViewer" method="post" target="_blank">' +
         '<input type="hidden" name="CU" value="16" />' +
         '<input type="hidden" name="Fecha_i" value="'+Fecha_i+'" />' +
         '<input type="hidden" name="Fecha_f" value="'+Fecha_f+'" />' +
         '<input type="hidden" name="_token" value="' + _token + '" />' +
     '</form>');
   break;
   case '17':
     var Fecha_i = $("#txtFecha").val();
     var Fecha_f = $("#txtFecha2").val();
     var Operario = $("#cmbOperario").val();
     var form =
     $('<form action="/ReportViewer" method="post" target="_blank">' +
         '<input type="hidden" name="CU" value="17" />' +
         '<input type="hidden" name="Fecha_i" value="'+Fecha_i+'" />' +
         '<input type="hidden" name="Fecha_f" value="'+Fecha_f+'" />' +
         '<input type="hidden" name="Operario" value="'+Operario+'" />' +

         '<input type="hidden" name="_token" value="' + _token + '" />' +
     '</form>');
   break;
   case 18:
     var Bitacora = $("#TableroBitacoras").data("bitacora");
     var form =
     $('<form action="/ReportViewer" method="post" target="_blank">' +
         '<input type="hidden" name="CU" value="18" />' +
         '<input type="hidden" name="Bitacora" value="' + Bitacora + '" />' +
         '<input type="hidden" name="_token" value="' + _token + '" />' +
     '</form>');
   break;
   case '20':
     var Fecha_i = $("#txtFecha").val();
     var Fecha_f = $("#txtFecha2").val();

     var form =
     $('<form action="/ReportViewer" method="post" target="_blank">' +
         '<input type="hidden" name="CU" value="20" />' +
         '<input type="hidden" name="Fecha_i" value="'+Fecha_i+'" />' +
         '<input type="hidden" name="Fecha_f" value="'+Fecha_f+'" />' +

         '<input type="hidden" name="_token" value="' + _token + '" />' +
     '</form>');
   break;
   case '21':
     var Fecha_i = $("#txtFecha").val();
     var Fecha_f = $("#txtFecha2").val();

     var form =
     $('<form action="/ReportViewer" method="post" target="_blank">' +
         '<input type="hidden" name="CU" value="21" />' +
         '<input type="hidden" name="Fecha_i" value="'+Fecha_i+'" />' +
         '<input type="hidden" name="Fecha_f" value="'+Fecha_f+'" />' +

         '<input type="hidden" name="_token" value="' + _token + '" />' +
     '</form>');
   break;
   case '24':
     var Talleres = $("#btnTColor1").val();


     var form =
     $('<form action="/ReportViewer" method="post" target="_blank">' +
         '<input type="hidden" name="CU" value="24" />' +

         '<input type="hidden" name="_token" value="' + _token + '" />' +
     '</form>');
   break;
   case '25':
     var Fecha_i = $("#txtFecha").val();
     var Fecha_f = $("#txtFecha2").val();

     var form =
     $('<form action="/ReportViewer" method="post" target="_blank">' +
         '<input type="hidden" name="CU" value="25" />' +
         '<input type="hidden" name="Fecha_i" value="'+Fecha_i+'" />' +
         '<input type="hidden" name="Fecha_f" value="'+Fecha_f+'" />' +

         '<input type="hidden" name="_token" value="' + _token + '" />' +
     '</form>');
   break;
   case 26:
   var  TallerID = $("#cmbTaller").val();
   var RegistroID =$("#TablaCambioPrecios").data("cambio");
   var form =
   $('<form action="/ReportViewer" method="post" target="_blank">' +
       '<input type="hidden" name="CU" value="26" />' +
       '<input type="hidden" name="TallerID" value="'+TallerID+'" />' +
       '<input type="hidden" name="RegistroID" value="'+RegistroID+'" />' +
       '<input type="hidden" name="_token" value="' + _token + '" />' +
   '</form>');
   break;

   case 27:
   //var TransfID =$("#btnVerRpt1").val();
   var TransfID =$("#tableWithSearch").data("Transf");
   var form =
   $('<form action="/ReportViewer" method="post" target="_blank">' +
       '<input type="hidden" name="CU" value="27" />' +
       '<input type="hidden" name="TransfID" value="'+TransfID+'" />' +
       '<input type="hidden" name="_token" value="' + _token + '" />' +
   '</form>');
   break;
   case '28':
   var Fecha_i = $("#txtFecha").val();
   var Fecha_f = $("#txtFecha2").val();

   var form =
   $('<form action="/ReportViewer" method="post" target="_blank">' +
       '<input type="hidden" name="CU" value="28" />' +
       '<input type="hidden" name="Fecha_i" value="'+Fecha_i+'" />' +
       '<input type="hidden" name="Fecha_f" value="'+Fecha_f+'" />' +

       '<input type="hidden" name="_token" value="' + _token + '" />' +
   '</form>');
   break;
   case '29':
     var Fecha_i = $("#txtFecha").val();
     var Fecha_f = $("#txtFecha2").val();

     var form =
     $('<form action="/ReportViewer" method="post" target="_blank">' +
         '<input type="hidden" name="CU" value="29" />' +
         '<input type="hidden" name="Fecha_i" value="'+Fecha_i+'" />' +
         '<input type="hidden" name="Fecha_f" value="'+Fecha_f+'" />' +

         '<input type="hidden" name="_token" value="' + _token + '" />' +
     '</form>');
   break;

   case '30':
     var Fecha_i = $("#txtFecha").val();
     var Fecha_f = $("#txtFecha2").val();

     var form =
     $('<form action="/ReportViewer" method="post" target="_blank">' +
         '<input type="hidden" name="CU" value="30" />' +
         '<input type="hidden" name="Fecha_i" value="'+Fecha_i+'" />' +
         '<input type="hidden" name="Fecha_f" value="'+Fecha_f+'" />' +

         '<input type="hidden" name="_token" value="' + _token + '" />' +
     '</form>');
   break;
   case '31':
   var TallerID = $("#cmbTaller").val();
   var Mes = $("#cmbMes").val();
   var Anio = $("#cmbAnio").val();

   var form =
   $('<form action="/ReportViewer" method="post" target="_blank">' +
       '<input type="hidden" name="CU" value="31" />' +
       '<input type="hidden" name="TallerID" value="'+TallerID+'" />'+
       '<input type="hidden" name="Mes" value="'+Mes+'" />' +
       '<input type="hidden" name="Anio" value="'+Anio+'" />' +

       '<input type="hidden" name="_token" value="' + _token + '" />' +
   '</form>');
 break;
 }

$('body').append(form);
form.submit();

 }

 /*===============================================================*/

 function ReportInventario(Cu,Inventario){
   $("#tableWithSearch").data("inventario",Inventario);
   ReportViewer(Cu);
 }
