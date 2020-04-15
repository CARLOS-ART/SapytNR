function BusquedaProd(e,Filtro,TallerID){
  if(esEnter(e)){
    var _token = $('input[name="_token"]').val();
    console.log('Filtro')
    $.ajax({
      url:'/Transfer/BuscarProductos',
      type:'post',
      data:{_token:_token,Filtro:Filtro,TallerID:TallerID},
      beforeSend:function(){

      },
      success:function(data){
        document.getElementById('ModTablero').innerHTML = data.Tabla;
        $("#btnCatalogoProd").click();
      },
      error:function(){
        swal('Error!','No fue posible consultar el catalogo de productos, ocurrio un error en el servidor, por favor intentelo nuevamente','error');
      }
    });

  }
}
/*================================================================================*/

function PoductosAgregar(TallerID, Pro, Pre) {
  var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/Transfer/Producto',
    type:'post',
    data:{_token:_token,TallerID:TallerID, Pro:Pro, Pre:Pre},

    success:function(data) {
      document.getElementById("ModTablero").innerHTML=data.InfoProducto;
    },
    error:function() {
      swal('Error!','No fue posble ir a la siguiente seccion, por favor intentelo nuevamente', 'error');
    }
  });
}
/*================================================================================*/

  function Agregar(ProID,PreID,Cant,Precio) {
    var _token = $('input[name="_token"]').val();
    $.ajax({
      url:'/Transfer/GuardarProducto',
      type:'post',
      data:{_token:_token, ProID:ProID, PreID:PreID, Cant:Cant, Precio:Precio},

      success:function(data) {
        swal(data.Titulo,data.Mensaje,data.TMensaje);

        document.getElementById("btnProducto").val='';
        document.getElementById("btnRM").val='';
        document.getElementById("txtCant").val='';
        document.getElementById("txtPrecio").val='';
        document.getElementById('Tablero').innerHTML=data.Tabla;

        $("#BuscarProd").val('');

      },
      error:function() {
        swal('Error!','No fue posible agregar el producto, por favor intentelo nuevamente', 'error');
      }
    });
  }
/*================================================================================*/

function EliminarProd(Item){
  var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/Transfer/EliminarProducto',
    data:{_token:_token,Item:Item},
    type:'post',
    beforeSend:function(){

    },
    success:function(data){

     $('#row'+Item).fadeOut();
    },
    error:function(){
      swal('Error!','No fue posible ejecutar su peticion, por favor intentelo mas tarde','error');
    }
  });
}

/*================================================================================*/

function GuardarTraspaso(Fecha,TallerID_OR,TallerID_DES, ProID, PreID, Cant, Precio) {
  var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/Transfer/GuardarTraspasoProducto',
    type:'post',
    data:{_token:_token,Fecha:Fecha,TallerID_OR:TallerID_OR,TallerID_DES:TallerID_DES,ProID:ProID, PreID:PreID, Cant:Cant, Precio:Precio},

    success:function(data) {
      swal(data.Titulo,data.Mensaje,data.TMensaje);

      document.getElementById("txtFecha").val='';
      document.getElementById("cmbTallerOrigen").val='';
      document.getElementById("cmbTallerDestino").val='';
      document.getElementById("btnProducto").val='';
      document.getElementById("btnRM").val='';
      document.getElementById("txtCant").val='';
      document.getElementById("txtPrecio").val='';

      $('#Tablero td').fadeOut();

    },
    error:function() {
      swal('Error!','No fue posible guardar la transferencia de los productos, por favor intentelo nuevamente', 'error');
    }
  });
}
