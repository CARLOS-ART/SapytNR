function VerCompra(Co){
  $("#tableWithSearch").data('compra',Co);
  ReportViewer(6);
}

/*=================================================*/

function AceptarCompra(CompraID){
  var _token = $('input[name="_token"]').val();

  swal({
      title: "¿Esta seguro que desea Aceptar la compra?",
      text: 'Si desea aceptar, haga click en "Si, Aceptar" , de lo contrario presione "No, Cancelar!"',
      type: "question",
      showCancelButton: true,
      confirmButtonText: "Si, Aceptar!",
      cancelButtonText: "No, cancelar!",
  }).then(function(isConfirm){
      if (isConfirm) {
        $.ajax({
          url:'/Compras/AceptarCompraFactory',
          data:{_token:_token,CompraID:CompraID},
          type:'post',
          success:function(data){
           swal(data.Titulo,data.Mensaje,data.TMensaje);
          },
          error:function(){
            swal('Error!','No fue posible ejecutar su peticion, por favor intentelo mas tarde','error');
          }
        });
      }
  });
}
