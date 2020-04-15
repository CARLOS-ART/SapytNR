function Busqueda_Productos(e,Filtro){
  if(esEnter(e)){
    var _token = $('input[name="_token"]').val();
    $.ajax({
      url:'/Compras/ConsultarCatalogo',
      type:'post',
      data:{_token:_token,Filtro:Filtro},
      beforeSend:function(){

      },
      success:function(data){
        document.getElementById('tableResult').innerHTML = data.Table;
        $("#btnCatalogoProd").click();
      },
      error:function(){
        CircleNotification('Error!','No fue posible consultar el catalogo de productos, ocurrio un error en el servidor, por favor intentelo nuevamente','error',"top-left");
      }
    });

  }
}

/*==============================================================================*/

function useItem(Pro,Pre){
   var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/Compras/UseItem',
    data:{_token:_token,Pro:Pro,Pre:Pre},
    type:'post',
    beforeSend:function(){

    },
    success:function(data){
      document.getElementById('tableResult').innerHTML = data.InfoProducto;
    },
    error:function(){
      CircleNotification('Error!','No fue posible ejecutar su peticion, por favor intentelo mas tarde','error',"top-left");
    }
  })
}

/*====================================================================*/

function AgregarProducto(){
  var _token = $('input[name="_token"]').val();
  var Pro = $("#btnProducto").data('producto');
  var Pre = $("#btnProducto").data('presentacion');
  var PCompra = $("#txtPrecio").val();
  var Can = document.getElementById('txtCant').value;

 $.ajax({
   url:'/Compras/AgregarProducto',
   data:{_token:_token,Pro:Pro,Pre:Pre,Can:Can,PCompra:PCompra},
   type:'post',
   beforeSend:function(){

   },
   success:function(data){
   $('#tableWithSearch > tbody:last-child').append(data.InfoProducto);
   $(".close").click();
   $("#txtBuscar").val('');
   $("#txtBuscar").focus();
   },
   error:function(){
     CircleNotification('Error!','No fue posible ejecutar su peticion, por favor intentelo mas tarde','error',"top-left");
   }
 });
}

/*====================================================================*/

function EliminarItem(Item){
  var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/Compras/EliminarItem',
    data:{_token:_token,Item:Item},
    type:'post',
    beforeSend:function(){

    },
    success:function(data){
     $('#row'+Item).fadeOut();
    },
    error:function(){
      CircleNotification('Error!','No fue posible ejecutar su peticion, por favor intentelo mas tarde','error',"top-left");
    }
  });
}

/*====================================================================*/

function GuardarCompra(){
  var _token = $('input[name="_token"]').val();
  var Fecha = $("#Fecha").val();
  var Folio = $('#txtFolio').val();

  var Campos = Array('Fecha','txtFolio');
  var TituloCampos = Array('Fecha de compra','Folio de factura');

  for(x = 0;x <= Campos.length-1;x++){
      if($("#"+Campos[x]).val().length == 0){
          CircleNotification("Faltan datos","Por favor proporcione la información para el campo "+TituloCampos[x],"warning","top-left");
          return false;
      }
  }

  swal({
      title: "¿Esta seguro que desea Guardar la compra?",
      text: 'Si los datos proporcionados son correctos, haga click en "Si, Terminar" , de lo contrario presione "No, Cancelar!"',
      type: "question",
      showCancelButton: true,
      confirmButtonText: "Si, Terminar!",
      cancelButtonText: "No, cancelar!",
  }).then(function(isConfirm){
      if (isConfirm) {
        $.ajax({
          url:'/Compras/GuardarCompra',
          data:{_token:_token,Fecha:Fecha,Folio:Folio},
          type:'post',
          beforeSend:function(){

          },
          success:function(data){
           $('#tableWithSearch td').fadeOut();
           CircleNotification(data.Titulo,data.Mensaje,data.TMensaje,"top-left");

           //swal(data.Titulo,data.Mensaje,data.TMensaje);
          },
          error:function(){
            CircleNotification('Error!','No fue posible ejecutar su peticion, por favor intentelo mas tarde','error',"top-left");
          }
        });
      }
  });


}

function GuardarCompraFactory(){
  var _token = $('input[name="_token"]').val();
  var Fecha = $("#Fecha").val();
  var Folio = $('#txtFolio').val();

  var Campos = Array('Fecha','txtFolio');
  var TituloCampos = Array('Fecha de compra','Folio de factura');

  for(x = 0;x <= Campos.length-1;x++){
      if($("#"+Campos[x]).val().length == 0){
          CircleNotification("Faltan datos","Por favor proporcione la información para el campo "+TituloCampos[x],"warning","top-left");
          return false;
      }
  }

  swal({
      title: "¿Esta seguro que desea Guardar la compra?",
      text: 'Si los datos proporcionados son correctos, haga click en "Si, Terminar" , de lo contrario presione "No, Cancelar!"',
      type: "question",
      showCancelButton: true,
      confirmButtonText: "Si, Terminar!",
      cancelButtonText: "No, cancelar!",
  }).then(function(isConfirm){
      if (isConfirm) {
        $.ajax({
          url:'/Compras/GuardarCompraFactory',
          data:{_token:_token,Fecha:Fecha,Folio:Folio},
          type:'post',
          beforeSend:function(){

          },
          success:function(data){
           $('#tableWithSearch td').fadeOut();
           CircleNotification(data.Titulo,data.Mensaje,data.TMensaje,"top-left");

           //swal(data.Titulo,data.Mensaje,data.TMensaje);
          },
          error:function(){
            CircleNotification('Error!','No fue posible ejecutar su peticion, por favor intentelo mas tarde','error',"top-left");
          }
        });
      }
  });
}
