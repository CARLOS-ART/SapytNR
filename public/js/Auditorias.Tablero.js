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

/*=============================================================================*/

function EditarFormato(Tipo,Audit){
  var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/Auditorias/Formato/Editar',
    type:'post',
    data:{_token:_token,Audit:Audit},
    success:function(){
     FormatoAuditoria(Tipo);
    }
  })
}

/*=============================================================================*/

function FormatoAuditoria(Tipo){
  var url = "/Auditorias/Formato/Almacen";

  if(Tipo == 0){
    var url = "/Auditorias/Formato/Laboratorio";
  }
  var form =
  $('<form action="'+url+'" method="get">' +
  '</form>');

  $('body').append(form);
  form.submit();
}

/*=============================================================================*/
