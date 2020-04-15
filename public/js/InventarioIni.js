var $container = $("#example1");
var $parent = $container.parent();
  var data = [
    ["", "", "", "", "", "", ""]
  ];

  var config = {
    data: data,
    minRows: 1,
    rowHeaders: true,
    colWidths: [70,100, 320, 90, 90, 100, 100],
    minCols: 6,
    minSpareRows: 0,
    autoWrapRow: true,
    colHeaders: ['SAP','CLAVE', 'PRODUCTO', 'P. COMPRA', 'P. VENTA', 'EXISTENCIA','GRAMOS'],
    contextMenu: false,
    outsideClickDeselects :  true
  };

  $container.handsontable(config);
  //$('#example1 table').addClass('table').addClass('table-striped');

   var handsontable = $container.data('handsontable');

  $parent.find('button[name=save]').click(function () {
  var _token = $('input[name="_token"]').val();
  var Json = JSON.stringify($container.handsontable('getData'));

  $.ajax({
    url:'/InventarioInicial/SubirInventario',
    type:'post',
    data:{_token:_token,Inventario:Json,BASF:1},
    beforeSend:function(){

    },
    success:function(data){
      CircleNotification(data.Titulo,data.Mensaje,data.TMensaje);
      if(data.TMensaje == "success"){
        document.getElementById('divBnt').innerHTML = '<div class="alert alert-success" role="alert">Inventario cargado correctamente! </div>';
      }
    },
    error:function(){
      CircleNotification('Operación no realizada','No se pudo realizar la carga del inventario inicial, por favor intentelo nuevamente','error');
    }
  });

});

/**================================================================ */

$(".LineaProducto").click(function(){
  var Brand = $(this).data("brand");
  var Linea = $("#"+Brand).data("linea");
  var Seleccionar = $("#"+Brand).data("seleccion");

  if(Seleccionar == 0){
    Seleccionar = 1;
    $("#"+Brand).data("seleccion",1);
    $("#"+Brand).removeClass('badge-light').addClass('badge-success');
  }else{
    Seleccionar = 0;
    $("#"+Brand).data("seleccion",0);
    $("#"+Brand).removeClass('badge-success').addClass('badge-light');
  }

  var _token = $('input[name="_token"]').val();

  $.ajax({
    url:'/InventarioInicial/CargarLinea',
    type:'post',
    data:{_token:_token,Linea:Linea,Seleccionar:Seleccionar,BASF:1},
    beforeSend:function(data){
     console.log('Peticion enviada');
     H5_loading.show();
    },
    success:function(data){
      //$("#btnLoad").click();
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
      console.log('No se pudo realizar la carga de la informacion solicitada');
    }
  })
})

/*===========================================*/

function SubirInventario(){
  CircleNotification({
      title: "¿Esta seguro que desea Terminar y Subir el Inventario?",
      text: 'Si los datos proporcionados son correctos, haga click en "Si,Crear" , de lo contrario presione "No, Cancelar!"',
      type: "question",
      showCancelButton: true,
      confirmButtonText: "Si, Crear!",
      cancelButtonText: "No, cancelar!",
  }).then(function(isConfirm){
      if (isConfirm) {
        $("#btnSave").click();
      }
  });

}

/*===========================================*/

function Busqueda_Productos(e,Filtro){
  if(esEnter(e)){
    var _token = $('input[name="_token"]').val();
    var Json = JSON.stringify($container.handsontable('getData'));
    $.ajax({
      url:'/InventarioInicial/Formato/FiltrarProductos',
      type:'post',
      data:{_token:_token,Filtro:Filtro,Inventario:Json},
      beforeSend:function(){
       H5_loading.show();
      },
      success:function(data){
        if(data.TMensaje == "success"){
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
      }else{
        CircleNotification(data.Titulo,data.Mensaje,data.TMensaje);
      }

      H5_loading.hide();
      },
      error:function(){
        H5_loading.hide();
        CircleNotification('Error!','No fue posible consultar el catalogo de productos, ocurrio un error en el servidor, por favor intentelo nuevamente','error');
      }
    });

  }
}

/*===========================================*/

function CargarDatos(){
  var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/InventarioInicial/Formato/CargarDatos',
    type:'post',
    data:{_token:_token},
    beforeSend:function(){
     H5_loading.show();
    },
    success:function(data){
      H5_loading.hide();
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
      CircleNotification('Error!','No fue posible consultar el catalogo de productos, ocurrio un error en el servidor, por favor intentelo nuevamente','error');
    }
  });
}
