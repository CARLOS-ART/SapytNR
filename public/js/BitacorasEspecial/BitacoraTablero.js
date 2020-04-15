function CancelarBitacora(Bit){
  swal({
      title: "¿Esta seguro que desea Cancelar la bitacora?",
      text: 'Si se encuentra seguro, haga click en "Si, Continuar" , de lo contrario presione "No, Cancelar!"',
      type: "question",
      showCancelButton: true,
      confirmButtonText: "Si, Continuar!",
      cancelButtonText: "No, cancelar!",
  }).then(function(isConfirm){
      if (isConfirm) {
        var _token = $('input[name="_token"]').val();
        $.ajax({
          url:'/Factory/Bitacoras/Tablero/CancelarOT',
          type:'post',
          data:{_token:_token,Bit:Bit},
          success:function(data){
           swal(data.Titulo,data.Mensaje,data.TMensaje);
           if(data.TMensaje == "success"){
             $("#divEstatus"+Bit).removeClass("yellow").addClass('red');
             $("#divEstatus"+Bit).removeClass("green").addClass('red');

             $("#divEstatus"+Bit).data('title',"Cancelado");
           }

          }
        })
      }
  });
}

/*==============================================================================*/
function CerrarBitacora(Bit){
  swal({
      title: "¿Esta seguro que desea cerrar la bitacora?",
      text: 'Si se encuentra seguro, haga click en "Si, Continuar" , de lo contrario presione "No, Cancelar!"',
      type: "question",
      showCancelButton: true,
      confirmButtonText: "Si, Continuar!",
      cancelButtonText: "No, cancelar!",
  }).then(function(isConfirm){
      if (isConfirm) {
        var _token = $('input[name="_token"]').val();
        $.ajax({
          url:'/Factory/Bitacoras/Tablero/CerrarOT',
          type:'post',
          data:{_token:_token,Bit:Bit},
          success:function(data){
           swal(data.Titulo,data.Mensaje,data.TMensaje);
           if(data.TMensaje == "success"){
             $("#divEstatus"+Bit).removeClass("yellow").addClass('green');
             $("#divEstatus"+Bit).data('title',"Terminado");
           }

          }
        })
      }
  });
}

/*==============================================================================*/

function ReportBitacoraFa(Bit){
  $("#TableroBitacoras").data('bitacora',Bit);
  ReportViewer(18);
}

/*==============================================================================*/

function EliminarItem(Partida){
  swal({
      title: "¿Esta seguro que desea Eliminar la partida?",
      text: 'Si se encuentra seguro, haga click en "Si, Continuar" , de lo contrario presione "No, Cancelar!"',
      type: "question",
      showCancelButton: true,
      confirmButtonText: "Si, Continuar!",
      cancelButtonText: "No, cancelar!",
  }).then(function(isConfirm){
      if (isConfirm) {
        var _token = $('input[name="_token"]').val();
        $.ajax({
          url:'/Factory/Bitacoras/Administrar/Partidas/Eliminar',
          type:'post',
          data:{_token:_token,Partida:Partida},
          success:function(data){
           swal(data.Titulo,data.Mensaje,data.TMensaje);
           if(data.TMensaje == "success"){
             $('#row'+Partida).fadeOut();

           }

          }
        })
      }
  });
}
