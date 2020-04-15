function EditarFormato(Formato){
  var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/InventarioInicial/Formato/Editar',
    type:'post',
    data:{_token:_token,Formato:Formato},
    success:function(){
     FormatoInventario();
    }
  })
}

/*================================================*/

function FormatoInventario(){
  var form =
  $('<form action="/InventarioInicial/Formato" method="get">' +
  '</form>');

  $('body').append(form);
  form.submit();
}

/*================================================*/

function CancelarInventario(Formato){
  CircleNotification({
      title: "¿Esta seguro que desea Cancelar Inventario?",
      text: 'Si se encuentra seguro, haga click en "Si, Continuar" , de lo contrario presione "No, Cancelar!"',
      type: "question",
      showCancelButton: true,
      confirmButtonText: "Si, Continuar!",
      cancelButtonText: "No, cancelar!",
  }).then(function(isConfirm){
      if (isConfirm) {
        var _token = $('input[name="_token"]').val();
        $.ajax({
          url:'/InventarioInicial/Formato/Cancelar',
          type:'post',
          data:{_token:_token,Formato:Formato},
          success:function(data){
           CircleNotification(data.Titulo,data.Mensaje,data.TMensaje);
           $("#divEstatus"+Formato).removeClass("yellow").addClass('red');
           $("#divEstatus"+Formato).data('title',"Cancelado");
          }
        })
      }
  });


}
