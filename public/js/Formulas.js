function BuscarP(e,ClaveP){
  if (esEnter(e)) {
    var _token = $('input[name="_token"]').val();

    $.ajax({
      url:'/Factory/Formulas/BuscarProductos',
      type:'post',
      data:{_token:_token,ClaveP:ClaveP},
      success:function(data){
        document.getElementById('txtCvProd').value=ClaveP;
        document.getElementById('TablaResultados').innerHTML=data.Tabla;

     },
     error:function(){
       swal('Error!','No fue posible encontar el producto','error');
     }
   });
  }

}

/*===============================================================================*/

function consultar(Pro){
  var _token = $('input[name="_token"]').val();

  $.ajax({
    url:'/Factory/Formulas/ItemFormula',
    type:'post',
    data:{_token:_token,Pro:Pro},
    success:function(data){
      document.getElementById('TablaResultados').innerHTML=data.InfoProducto;

    },
    error:function(){
      swal('Error','No fue posible agregar cantidad','error');
    }
  });
}

/*===============================================================================*/
function agregarPro(){
  var _token = $('input[name="_token"]').val();
  var Producto = $(".LineaProducto").data("producto");
  var Cantidad = $("#txtCant").val();

  $.ajax({
    url:'/Factory/Formulas/AgregarProductoFormula',
    type:'post',
    data:{_token:_token, Producto:Producto, Cantidad:Cantidad},
    success:function(data) {
      swal(data.Titulo,data.Mensaje,data.TMensaje);

      document.getElementById('txtCant').value;
      document.getElementById('TableroFormulas').innerHTML=data.insertarDatos;
      $("#btnCerrar").click();

    },
    error:function() {
      swal('Error','No fue posible agregar el producto','Error');
    }
  });
}

/*===============================================================================*/
function Eliminar(Item) {
  var _token = $('input[name="_token"]').val();

  $.ajax({
    url:'/Factory/Formulas/EliminarItem',
    type:'post',
    data:{_token:_token,Item:Item},
    success:function(data) {
      //swal(data.Titulo,data.Mensaje,data.TMensaje);

      $("#Fila"+Item).fadeOut(500);

    },
    error:function() {
      swal('Error','No fue posible eliminar los datos del producto','error');
    }
  });
}

/*==============================================================================*/

function CrearFormula(){
  var _token = $('input[name="_token"]').val();

  if($("#txtClave").val().length == 0){
    swal("Falta campo Clave","El campo CLAVE está vacío, la información es muy importante, por favor proporcione el dato",'warning');
    return false;
  }

  if($("#txtNombre").val().length == 0){
    swal("Falta campo Nombre o descripción de la formula","El campo NOMBRE está vacío, la información es muy importante, por favor proporcione el dato",'warning');
    return false;
  }

  if($("#txtPrecioBase").val().length == 0){
    swal("Falta campo Precio base por litro de la formula","El campo PRECIO BASE está vacío, la información es muy importante, por favor proporcione el dato",'warning');
    return false;
  }

  $.ajax({
    url:'/Factory/Formulas/CrearFormula',
    type:'post',
    data:{_token:_token,
        
          Clave:$("#txtClave").val(),
          Nombre:$("#txtNombre").val(),
          PrecioBase: $("#txtPrecioBase").val()
        },
    success:function(data) {
      swal(data.Titulo,data.Mensaje,data.TMensaje);
    },
    error:function() {
      swal('Error','No fue posible eliminar los datos del producto','error');
    }
  });
}
