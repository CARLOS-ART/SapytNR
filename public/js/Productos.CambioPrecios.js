var $container = $("#example1");
var $console = $("#example1console");
var $parent = $container.parent();
var autosaveNotification;
$container.handsontable({
  rowHeaders: true,
  height: 600,
  colWidths: [70,70,500, 90, 90],
  colHeaders: ['SAP','CLAVE','DESCRIPCION','P. COMPRA','P. VENTA'],
  minSpareRows: 0,//Numero de filas vacias para escribir nueva info
  contextMenu: false,

});

var handsontable = $container.data('handsontable');



$parent.find('button[name=save]').click(function () {
  var _token = $('input[name="_token"]').val();

  //console.log(handsontable.getData());

  $.ajax({
    url:'/Productos/GuardarAliados',
    type:'post',
    data:{_token:_token,Aliados:handsontable.getData()},
    beforeSend:function(){
      console.log('Datos Enviados');
    },
    success:function(data){
      swal(data.Titulo,data.Mensaje,data.TMensaje);
    },
    error:function(){
      swal('Operación no realizada','No se pudo realizar la operacion solicitada, por favor intentelo nuevamente','error');
    }
  });

});

$parent.find('button[name=termina_y_carga]').click(function () {
    var _token = $('input[name="_token"]').val();

    //console.log(handsontable.getData());

    $.ajax({
      url:'/Productos/TerminarYCargar',
      type:'post',
      data:{_token:_token,Aliados:handsontable.getData()},
      beforeSend:function(){
        console.log('Datos Enviados');
      },
      success:function(data){
        swal(data.Titulo,data.Mensaje,data.TMensaje);
      },
      error:function(){
        swal('Operación no realizada','No se pudo realizar la operacion solicitada, por favor intentelo nuevamente','error');
      }
    });

  });

/**=================================================================== */

function GuardarCambios(){
    $("#btnSave").click();
}

/**=================================================================== */

function TerminaYCarga(){
  $("#btnFinish").click();
}

/**=================================================================== */

function CargarInventario(){
  var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/Productos/CambioPrecios/CargarInventario',
    type:'post',
    data:{_token:_token},
    beforeSend:function(){
      H5_loading.show();
    },
    success:function(data){
      $container.handsontable('updateSettings',{data:data.Info});
      $container.handsontable('updateSettings',{
        cells: function (row, col ,prop) {
        var cellProperties = {};
        switch (prop) {
          case 0: cellProperties.readOnly = true;    break;
          case 1: cellProperties.readOnly = true;    break;
          case 2: cellProperties.readOnly = true;    break;
          //case 7: cellProperties.readOnly = true;    break;
        }
        return cellProperties;
      }
    });
    H5_loading.hide();
    },
    error:function(){
      H5_loading.hide();
      swal('Error!','No fue posible consultar el catalogo de productos, ocurrio un error en el servidor, por favor intentelo nuevamente','error');
    }
  });
}

/*==============================================================================*/

function Busqueda_Productos(e,Filtro){
  if(esEnter(e)){
    var _token = $('input[name="_token"]').val();
    var Json = JSON.stringify($container.handsontable('getData'));
    $.ajax({
      url:'/Productos/CambioPrecios/FiltrarProductos',
      type:'post',
      data:{_token:_token,Filtro:Filtro,Inventario:Json},
      beforeSend:function(){
         H5_loading.show();
      },
      success:function(data){
        H5_loading.hide();
        if(data.TMensaje!="success"){
          swal(data.Titulo,data.Mensaje,data.TMensaje);
          return false;
        }
        $container.handsontable('updateSettings',{data:data.Info});
        $container.handsontable('updateSettings',{
          cells: function (row, col ,prop) {
          var cellProperties = {};
          switch (prop) {
            case 0: cellProperties.readOnly = true;    break;
            case 1: cellProperties.readOnly = true;    break;
            case 2: cellProperties.readOnly = true;    break;
            //case 7: cellProperties.readOnly = true;    break;
          }
          return cellProperties;
        }
      });
      },
      error:function(){
        H5_loading.hide();
        swal('Error!','No fue posible consultar el catalogo de productos, ocurrio un error en el servidor, por favor intentelo nuevamente','error');
      }
    });

  }
}

/*==============================================================================*/

$("#btnGuardar").click(function(){

  swal({
      title: "¿Esta seguro que desea Actualizar sus precios?",
      text: 'Si los datos proporcionados son correctos, haga click en "Si,Crear" , de lo contrario presione "No, Cancelar!"',
      type: "question",
      showCancelButton: true,
      confirmButtonText: "Si, Crear!",
      cancelButtonText: "No, cancelar!",
  }).then(function(isConfirm){
      if (isConfirm) {
        var _token = $('input[name="_token"]').val();
        var Json = JSON.stringify($container.handsontable('getData'));
        $.ajax({
          url:'/Productos/CambioPrecios/Actualizar',
          type:'post',
          data:{_token:_token,Inventario:Json},
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

});
