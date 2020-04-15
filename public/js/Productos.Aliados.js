var $container = $("#example1");
var $console = $("#example1console");
var $parent = $container.parent();
var autosaveNotification;
$container.handsontable({
  rowHeaders: true,
  height: 450,
  colWidths: [70,450, 90, 90, 150],
  colHeaders: ['CLAVE','DESCRIPCION','P. COMPRA','P. VENTA','EXISTENCIA INICIAL '],
  minSpareRows: 1,//Numero de filas vacias para escribir nueva info
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
      CircleNotification(data.Titulo,data.Mensaje,data.TMensaje,"top-left");

      //swal(data.Titulo,data.Mensaje,data.TMensaje);
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
        CircleNotification(data.Titulo,data.Mensaje,data.TMensaje,"top-left");
        //swal(data.Titulo,data.Mensaje,data.TMensaje);
        if(data.TMensaje == "success"){
          var form =
          $('<form action="/Productos/Aliados" method="get" >' +

          '</form>');
          $('body').append(form);
          form.submit();
        }
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

/*================================================*/

function CargarDatos(){
  var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/Productos/FormatoAliados/CargarDatos',
    type:'post',
    data:{_token:_token},
    beforeSend:function(){

    },
    success:function(data){
      $container.handsontable('updateSettings',{data:data.Info});
    },
    error:function(){
      swal('Error!','No fue posible consultar el catalogo de productos, ocurrio un error en el servidor, por favor intentelo nuevamente','error');
    }
  });
}
