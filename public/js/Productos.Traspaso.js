function Busqueda_Productos(e,Filtro){
  if(esEnter(e)){
    var _token = $('input[name="_token"]').val();

    $.ajax({
      url:'/Productos/Traspaso/Busqueda_Productos',
      type:'post',
      data:{_token:_token,Filtro:Filtro},
      beforeSend:function(){
        H5_loading.show();
      },
      success:function(data){
        H5_loading.hide();
      if(data.TMensaje=="success"){
        document.getElementById('Tablero').innerHTML = data.Info;
      }else{
        swal(data.Titulo,data.Mensaje,data.TMensaje);
      }

      },
      error:function(){
        H5_loading.hide();
        swal('Error!','No fue posible consultar el catalogo de productos, ocurrio un error en el servidor, por favor intentelo nuevamente','error');
      }
    });

  }
}

/*================================================================================*/

function useItem(Pro,Pre){
   var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/Productos/Traspaso/UseItem',
    data:{_token:_token,Pro:Pro,Pre:Pre},
    type:'post',
    beforeSend:function(){

    },
    success:function(data){

      document.getElementById('Tablero').innerHTML = data.InfoProducto;
    },
    error:function(){
      swal('Error!','No fue posible ejecutar su peticion, por favor intentelo mas tarde','error');
    }
  })
}

/*================================================================================*/

function TraspasoProducto(){
  var _token = $('input[name="_token"]').val();
  var Pro = $("#btnRM").data('producto');
  var Pre = $("#btnRM").data('presentacion');
  var Cant = $("#txtCant").val();
 $.ajax({
   url:'/Productos/Traspaso/TraspasoProducto',
   data:{_token:_token,Pro:Pro,Pre:Pre,Cant:Cant},
   type:'post',
   beforeSend:function(){
    H5_loading.show();
   },
   success:function(data){
       H5_loading.hide();
       swal(data.Titulo,data.Mensaje,data.TMensaje);
       document.getElementById('Tablero').innerHTML = '';
   },
   error:function(){
     H5_loading.hide();
     swal('Error!','No fue posible ejecutar su peticion, por favor intentelo mas tarde','error');
   }
 })
}
