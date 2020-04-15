function EditarFormato(Formato){
  var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/Productos/Aliados/Editar/Formato',
    type:'post',
    data:{_token:_token,Formato:Formato},
    success:function(){
     FormatoAliados();
    }
  })
}

/*================================================*/

function FormatoAliados(){
  var form =
  $('<form action="/Productos/FormatoAliados/Captura" method="get"></form>');

  $('body').append(form);
  form.submit();
}

/*================================================*/

function CancelarFormatoAliados(Formato){
  swal({
      title: "¿Esta seguro que desea Cancelar la solicitud y sus Items?",
      text: 'Si se encuentra seguro, haga click en "Si, Continuar" , de lo contrario presione "No, Cancelar!"',
      type: "question",
      showCancelButton: true,
      confirmButtonText: "Si, Continuar!",
      cancelButtonText: "No, cancelar!",
  }).then(function(isConfirm){
      if (isConfirm) {
        var _token = $('input[name="_token"]').val();
        $.ajax({
          url:'/Productos/FormatoAliados/Cancelar',
          type:'post',
          data:{_token:_token,Formato:Formato},
          success:function(data){
           swal(data.Titulo,data.Mensaje,data.TMensaje);
           $("#divEstatus"+Formato).removeClass("yellow").addClass('red');
           $("#divEstatus"+Formato).data('title',"Cancelado");
          }
        })
      }
  });
}

/*================================================*/

function ReportAliados(Cu,Solic){
  $("#tableWithSearch").data("solicitud",Solic);
  ReportViewer(Cu);
}
