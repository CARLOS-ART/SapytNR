function Tablero(TallerID, Operacion, Fecha, Fecha2){

    var _token = $('input[name="_token"]').val();
    $.ajax({
      url:'/Soporte/MostrarTableroAuditoria',
      type:'post',
      data:{_token:_token,TallerID:TallerID, Operacion:Operacion, Fecha:Fecha,Fecha2:Fecha2},
      beforeSend:function(){

      },
      success:function(data){
        document.getElementById("Tablero").innerHTML= data.Tabla;
        CircleNotification(data.Titulo,data.Mensaje,data.TMensaje);
      },
      error:function(){
        CircleNotification('Error!','Es necesario seleccionar un taller','error');
      }
    })
  }
/*================================================================================*/
function CambiarEstAudi(AuditoriaID) {
  var _token = $('input[name="_token"]').val();

  $.ajax({
    url:'/Soporte/CambiarEstatusAuditoria',
    type:'post',
    data:{_token:_token, AuditoriaID:AuditoriaID},
    success:function(data) {

      CircleNotification(data.Titulo,data.Mensaje,data.TMensaje);
    }
  })
}
/*================================================================================*/
function MostrarDTaller(TallerID) {
  var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/Soporte/MostrarDatosTaller',
    type:'post',
    data:{_token:_token, TallerID:TallerID},
    success:function(data){
      document.getElementById("TableroInfoTaller").innerHTML=data.TablaTaller;
    }
  })
}
/*================================================================================*/
function CambiarEstBit(BitacoraID) {
  var _token = $('input[name="_token"]').val();

  $.ajax({
    url:'/Soporte/CambiarEstatusBitacora',
    type:'post',
    data:{_token:_token, BitacoraID:BitacoraID},
    success:function(data) {

      CircleNotification(data.Titulo,data.Mensaje,data.TMensaje);
    }
  })
}
/*================================================================================*/
function CambiarEstAliados(SolicitudID) {
  var _token = $('input[name="_token"]').val();

  $.ajax({
    url:'/Soporte/CambiarEstatusAliados',
    type:'post',
    data:{_token:_token, SolicitudID:SolicitudID},
    success:function(data) {

      CircleNotification(data.Titulo,data.Mensaje,data.TMensaje);
    }
  })
}
/*================================================================================*/
function CambiarEstInv(InventarioID) {
  var _token = $('input[name="_token"]').val();

  $.ajax({
    url:'/Soporte/CambiarEstInventario',
    type:'post',
    data:{_token:_token, InventarioID:InventarioID},
    success:function(data) {

      CircleNotification(data.Titulo,data.Mensaje,data.TMensaje);
    }
  })
}
/*================================================================================*/
function ReportAuditoria(Tipo,Audit){
  var Rpt = 0
 if(Tipo == 1){
   Rpt = 4;
 }else{
   Rpt = 5;
 }

$("#tableWithSearch").data('auditoria',Audit);

ReportViewer(Rpt);

}
/*================================================================================*/
function ReportBitacora(Bit){
  $("#tableWithSearch").data('bitacora',Bit);
  ReportViewer(3);
}
/*================================================================================*/
function VerCompra(Co){
  $("#tableWithSearch").data('compra',Co);
  ReportViewer(6);
}
/*================================================================================*/
function ReportAliados(Cu,Solic){
  $("#tableWithSearch").data("solicitud",Solic);
  ReportViewer(Cu);
}
/*================================================================================*/
function ReportInventario(Cu,Inventario){
  $("#tableWithSearch").data("inventario",Inventario);
  ReportViewer(Cu);
}

/*================================================================================*/
/*function ReportCompras(Cu,Compras){
  $("#dataTable1").data("compras",Compras);
  ReportViewer(Cu);
}*/
/*================================================================================*/

/*================================================================================*/
function MostrarReportOperarios(TallerID) {
  var _token = $('input[name="_token"]').val();
console.log(TallerID);
  $.ajax({
    url:'/Soporte/construirFormOperarios',
    type:'post',
    data:{_token:_token, TallerID:TallerID},
    success:function(data){
      //document.getElementById("cmbTaller").value='';
      document.getElementById("Tablero2").innerHTML=data.FormularioOperarios;
    }
  })
}
/*================================================================================*/
function MostrarFormProd() {
  var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/Soporte/CrearFormularioProductividad',
    type:'post',
    data:{_token:_token},
    success:function(data){
      document.getElementById("Tablero2").innerHTML=data.Productividad;
    }
  })
}
/*================================================================================*/

/*================================================================================*/
function EstadisticaCons() {
  var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/Soporte/MostrarFormEstConsumo',
    type:'post',
    data:{_token:_token},
    success:function(data){
      document.getElementById("Tablero2").innerHTML=data.EstConsumo;
    }
  })
}

/*================================================================================*/
