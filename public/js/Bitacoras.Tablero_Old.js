function CerrarBitacora(Bit){
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
          url:'/Bitacoras/Tablero/CerrarOT',
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

function ReportBitacora(Bit){
  $("#TableroBitacoras").data('bitacora',Bit);
  ReportViewer(3);
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
          url:'/Bitacoras/Administrar/Partidas/Eliminar',
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

/*==============================================================================*/

function EditarOperario(Partida,NOperario){
  var _token = $('input[name="_token"]').val();
  console.log('Works');
  $.ajax({
    url:'/Bitacoras/Administrar/Partidas/EditarOperario',
    type:'post',
    data:{_token:_token,Partida:Partida,NOperario:NOperario},
    success:function(data){
     swal(data.Titulo,data.Mensaje,data.TMensaje);
     if(data.TMensaje == "success"){
       console.log('Works1');


     }

    }
  })
}
/*================================================================================*/
function actualizarC(){
  var _token = $('input[name="_token"]').val();
  var coments = document.getElementById('comentarios').value;
  console.log('coments');
  $.ajax({
    url:'/Bitacoras/Actualizar',
    type:'post',
    data:{_token:_token,coments:coments},
    success:function(data){
     swal(data.Titulo,data.Mensaje,data.TMensaje);
     document.getElementById('comentarios').innerHTML=data.Comentario;

   },
    error:function(){
        swal("Error!","No hemos podido validar el Numero de orden, ocurrio un error en el servidor, por favor intentelo nuevamente!","error");

    }
  });
}

/*================================================================================*/

function MostrarC() {
  var _token = $('input[name="_token"]').val();
  //var coments = document.getElementById('comentarios').value;
  console.log('coments');
  $.ajax({
    url:'/Bitacoras/Mostrar',
    type:'post',
    data:{_token:_token},
    success:function(data){
     //swal(data.Titulo,data.Mensaje,data.TMensaje);
     document.getElementById('comentarios').innerHTML=data.Comentario;

   },
    error:function(){
        swal("Error!","No hemos podido validar el Numero de orden, ocurrio un error en el servidor, por favor intentelo nuevamente!","error");

    }
  });
}
