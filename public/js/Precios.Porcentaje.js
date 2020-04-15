function ActualizarPreciosPorcent(Linea,Porcentaje){
  swal({
      title: "¿Esta seguro que desea Actualizar sus precios?",
      text: 'Si esta seguro haga click en "Si, Actualizar" , de lo contrario presione "No, Cancelar!"',
      type: "question",
      showCancelButton: true,
      confirmButtonText: "Si, Actualizar!",
      cancelButtonText: "No, cancelar!",
  }).then(function(isConfirm){
      if (isConfirm) {
        var _token = $('input[name="_token"]').val();

        $.ajax({
          url:'/Productos/CambioPrecios/Porcentaje/Actualizar',
          type:'post',
          data:{_token:_token,Linea:Linea,Porcentaje:Porcentaje},
          beforeSend:function(){
             H5_loading.show();
          },
          success:function(data){
            swal(data.Titulo,data.Mensaje,data.TMensaje);
            H5_loading.hide();
          },
          error:function(){
            H5_loading.hide();
            swal("Error!","Ha ocurrido un error, no se han realizado cambios en los precios","error");
          }
        });
      }
  });
}
