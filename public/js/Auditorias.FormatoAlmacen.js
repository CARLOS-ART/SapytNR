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
    height:510,
    colHeaders: ['SAP','CLAVE', 'PRODUCTO', 'P. COMPRA', 'P. VENTA', 'EXIST. SISTEMA','EXIST. FISICO'],
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
    url:'/Auditorias/Formato/Almacen/Terminar',
    type:'post',
    data:{_token:_token,Inventario:Json},
    beforeSend:function(){
      H5_loading.show();
    },
    success:function(data){
      H5_loading.hide();

      if(data.TMensaje == "success"){
        document.getElementById('divBnt').innerHTML = '<div class="alert alert-success" role="alert">Auditoria cargado correctamente! </div>';
        //swal(data.Titulo,data.Mensaje,data.TMensaje);
      AfectarInventario(data.Auditoria);
      }
    },
    error:function(){
      H5_loading.hide();
      swal('Operación no realizada','No se pudo realizar la carga del inventario inicial, por favor intentelo nuevamente','error');
    }
  });

});


/*===========================================*/

function TerminarAuditoria(){
  swal({
      title: "¿Esta seguro que desea Terminar y Guardar la auditoria?",
      text: 'Si los datos proporcionados son correctos, haga click en "Si, Terminar" , de lo contrario presione "No, Cancelar!"',
      type: "question",
      showCancelButton: true,
      confirmButtonText: "Si, Terminar!",
      cancelButtonText: "No, cancelar!",
  }).then(function(isConfirm){
      if (isConfirm) {
        $("#btnSave").click();
      }
  });

}

/*===========================================*/

function AfectarInventario(Auditoria){
  swal({
      title: "¿Afectar Inventario Actual?",
      text: 'La afectacion de inventario modifica las exitencias del sistema, y en su lugar coloca la información capturada de acuerdo al conteo fisico. Haga Clic en "Si, Afectar" si desea realizar esta operacion',
      type: "question",
      showCancelButton: true,
      confirmButtonText: "Si, Afectar!",
      cancelButtonText: "No, cancelar!",
  }).then(function(isConfirm){
      if (isConfirm) {
        var _token = $('input[name="_token"]').val();
        
        $.ajax({
          url:'/Auditorias/Formato/Almacen/RealizarAfectacion',
          type:'post',
          data:{_token:_token,Auditoria:Auditoria},
          beforeSend:function(){
            H5_loading.show();
          },
          success:function(data){
            H5_loading.hide();

            if(data.TMensaje == "success"){

              swal(data.Titulo,data.Mensaje,data.TMensaje);

            }
          },
          error:function(){
            H5_loading.hide();
            swal('Operación no realizada','No se pudo realizar la afectacion de inventario , por favor intentelo nuevamente','error');
          }
        });
      }else{
        var form =
        $('<form action="/Auditorias/Tablero" method="get" >' +

        '</form>');
        $('body').append(form);
        form.submit();
      }
  });

}

/*===========================================*/

function Busqueda_Productos(e,Filtro){
  if(esEnter(e)){
    var _token = $('input[name="_token"]').val();
    var Json = JSON.stringify($container.handsontable('getData'));
    $.ajax({
      url:'/Auditorias/Formato/Almacen/FiltrarProductos',
      type:'post',
      data:{_token:_token,Filtro:Filtro,Inventario:Json},
      beforeSend:function(){
        H5_loading.show();
      },
      success:function(data){
        H5_loading.hide();
        if(data.TMensaje=="success"){
          $container.handsontable('updateSettings',{data:data.Info});
          $container.handsontable('updateSettings',{
            cells: function (row, col ,prop) {
            var cellProperties = {};
            switch (prop) {
              case 0: cellProperties.readOnly = true;    break;
              case 1: cellProperties.readOnly = true;    break;
              case 2: cellProperties.readOnly = true;    break;
              case 3: cellProperties.readOnly = true;    break;
              case 4: cellProperties.readOnly = true;    break;
              case 5: cellProperties.readOnly = true;    break;


              //case 7: cellProperties.readOnly = true;    break;
            }
            return cellProperties;
          }
        });
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

/*===========================================*/

function CargarDatos_Almacen(){
  var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/Auditorias/Formato/Almacen/CargarDatos',
    type:'post',
    data:{_token:_token},
    beforeSend:function(){
     H5_loading.show();
    },
    success:function(data){
      H5_loading.hide();
      console.log('Fue Divertido!');
      $container.handsontable('updateSettings',{data:data.Info});
      $container.handsontable('updateSettings',{
        cells: function (row, col ,prop) {
        var cellProperties = {};
        switch (prop) {
          case 0: cellProperties.readOnly = true;    break;
          case 1: cellProperties.readOnly = true;    break;
          case 2: cellProperties.readOnly = true;    break;
          case 3: cellProperties.readOnly = true;    break;
          case 4: cellProperties.readOnly = true;    break;
          case 5: cellProperties.readOnly = true;    break;

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
