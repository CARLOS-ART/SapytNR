var $container = $("#example1");
var $parent = $container.parent();
  var data = [
    ["", "", "", ""]
  ];

  var config = {
    data: data,
    minRows: 1,
    colWidths: [1, 135, 77, 68],
    maxCols: 4,
    minSpareRows: 0,
    autoWrapRow: true,
    colHeaders: ['COD. PZA', 'PIEZA', 'CONDICION', 'VAL. REP.'],
    contextMenu: false,
    //contextMenu: {items:{"remove_row":{name:"Eliminar"}}},
    outsideClickDeselects :  true
  };


  var hooks = Handsontable.PluginHooks.hooks.persistent;
  for (var hook in hooks) {
    if (hooks.hasOwnProperty(hook)) {
      config[hook] = (function (hook) {

        return function () {
          log_events(hook, arguments);
        }
      })(hook);
    }
  }


  $container.handsontable(config);

  function valorCell(Fila){
    $("#btnGuardar").data("pieza",$container.handsontable('getDataAtCell',Fila,0));
    $("#btnGuardar").data("pos",Fila);
  }

  function EliminarPieza(){
      var Pieza = $("#btnGuardar").data("pieza");
      var Pos = $("#btnGuardar").data("pos");
      var _token = $('input[name="_token"]').val();

      $.ajax({
          url:'/Bitacoras/Piezas/Eliminar',
          type:'post',
          data:{_token:_token,Pieza:Pieza,Pos:Pos},
          beforeSend:function(){

          },
          success:function(data){
            $container.handsontable('updateSettings',{data:data.Piezas});
            $container.handsontable('updateSettings',{
              cells: function (row, col ,prop) {
              var cellProperties = {};
              switch (prop) {
                case 0: cellProperties.readOnly = true;    break;
                case 1: cellProperties.readOnly = true;    break;
                case 2: cellProperties.readOnly = true;    break;
              }
              return cellProperties;
            }
          });
          },
          error:function(){
            swal("Error!","No hemos podido eliminar la pieza seleccionada, intentelo nuevamente","error");
          }
      });

  }

  function log_events(event, data) {

    if( event == 'afterSelection'){
        valorCell(data[0]);
    }

   /*if ( event == 'afterRemoveRow') {
    EliminarPieza();
  }*/
  }

  var handsontable = $container.data('handsontable');

  /*===========================================================*/

  function NuevaPieza(){
    var _token = $('input[name="_token"]').val();
    var Condicion = $("#cmbCondicion2").val();
    var Medida = $("#btnGuardar").data("medida");
    var Pieza = $("#txtCantPza").val();
    var NamePza = $("#txtNombrePza").val();

    $.ajax({
        url:'/Bitacoras/Piezas/NuevaPza',
        type:'post',
        data:{_token:_token,Pieza:Pieza,Medida:Medida,Condicion:Condicion,NamePza:NamePza},
        beforeSend:function(){

        },
        success:function(data){

          if(data.TMensaje == "success"){
              $container.handsontable('updateSettings',{data:data.Piezas});
          }
          swal(data.Titulo,data.Mensaje,data.TMensaje);
        },
        error:function(){
            swal("Error!","No se pudo establecer conexion con el servidor, por favor intentelo nuevamente","error");
        }
    })
  }


/*======================================================*/
$(".imgVehiculo").click(function(){
    var Medida = $(this).data("medida");

    $(".imgVehiculo").removeClass('badge-success').addClass('badge-light');
    $(this).removeClass('badge-light').addClass('badge-success');

    $("#btnGuardar").data("medida",Medida);

    document.getElementById('imgVehiculo').innerHTML = '<img class="img-fluid" src="/img/Despiece/'+Medida+'.png"/>';
});

/*=====================================================*/

function AgregarPieza(Pieza){
    var _token = $('input[name="_token"]').val();

    var Condicion = 1;
    var Medida = $("#cmbVehiculo").val();
    //var Pieza = $("#txtNumPza").val();

    $.ajax({
        url:'/Bitacoras/Piezas/Cargar',
        type:'post',
        data:{_token:_token,Pieza:Pieza,Medida:Medida,Condicion:Condicion},
        beforeSend:function(){

        },
        success:function(data){

          if(data.TMensaje == "success"){
              $container.handsontable('updateSettings',{data:data.Piezas});
              $container.handsontable('updateSettings',{
                cells: function (row, col ,prop) {
                var cellProperties = {};
                switch (prop) {
                  case 0: cellProperties.readOnly = true;    break;
                  case 1: cellProperties.readOnly = true;    break;
                  case 2: cellProperties.readOnly = true;    break;
                }
                return cellProperties;
              }
            });
          }else{
          CircleNotification(data.Titulo,data.Mensaje,data.TMensaje,'top-left');
          }

        },
        error:function(){
            swal("Error!","No se pudo establecer conexion con el servidor, por favor intentelo nuevamente","error");
        }
    })
};

/*======================================================*/

$(".LadoPieza").click(function(){
  var PartNum = $(this).data('partnum');
  console.log(PartNum);
  AgregarPieza(PartNum);
}
);
/*=====================================================*/

$("#btnGuardar").click(function(){
  var Medida = $("#cmbVehiculo").val();
  var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/Bitacoras/Piezas/GuardaCambios',
    type:'post',
    data:{_token:_token,Medida:Medida,Info:$container.handsontable('getData')},
    beforeSend:function(){

    },
    success:function(data){
      var form =
    $('<form action="' + data.Url + '" method="get" ' +
        '<input type="hidden" name="CU" value="'+ Medida +'" />' +
    '</form>');

    $('body').append(form);
    form.submit();
    },
    error:function(){
        swal("Error!","No se pudo establecer conexion con el servidor, por favor intentelo nuevamente","error");
    }
})
});

/*=====================================================*/

function LeerPiezasBitacora(){
  //$("#btnGuardar").data('medida',Medida);
  //$("#btnMedida"+Medida).click();
  var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/Bitacoras/Piezas/LeerPiezasBitacora',
    type:'post',
    data:{_token:_token},
    beforeSend:function(){

    },
    success:function(data){
      $container.handsontable('updateSettings',{data:data.Piezas,
               contextMenu: {callback: function (key, options) {
                  if (key === 'nuevo') {
                    setCondicion(1);
                  }else if(key === "reparado"){
                    setCondicion(2);
                  }else if(key === "esfume"){
                    setCondicion(3);
                  }else if(key === "eliminar"){
                    EliminarPieza();
                  }
                },items:
                 {
                   "nuevo":{name:"NUEVO"},
                   "reparado": {name: 'REPARADO'},
                   "esfume": {name: 'ESFUME'},
                   "eliminar":{name:"ELIMINAR PIEZA"}
                 }
               }});
      $container.handsontable('updateSettings',{
        cells: function (row, col ,prop) {
        var cellProperties = {};
        switch (prop) {
          case 0: cellProperties.readOnly = true;    break;
          case 1: cellProperties.readOnly = true;    break;
          case 2: cellProperties.readOnly = true;    break;
        }
        return cellProperties;
      }
      });
    },
    error:function(){
        swal("Error!","No se pudo establecer conexion con el servidor, por favor intentelo nuevamente","error");
    }
})
}

/*==============================================================================*/

function setCondicion(Condicion){
  var _token = $('input[name="_token"]').val();
  var Pieza = $("#btnGuardar").data("pieza");
  $.ajax({
    url:'/Bitacoras/Piezas/setCondicion',
    type:'post',
    data:{_token:_token,Condicion:Condicion,Pieza:Pieza},
    beforeSend:function(){

    },
    success:function(data){
      LeerPiezasBitacora();
    },
    error:function(){
        swal("Error!","No se pudo establecer conexion con el servidor, por favor intentelo nuevamente","error");
    }
  });
}

/*===============================================================================*/

function PiezaInfo(Titulo,PartNum){
  $("#PartName").text("Seleccione lado para "+Titulo);
  $("#btnIzq").data('partnum',PartNum+'I');
  $("#btnDer").data('partnum',PartNum);
}

/*===============================================================================*/

function ShowMap(){
  $(".MapCars").hide();
  var Map ="#Map"+ $("#cmbVehiculo").val();
  $(Map).fadeIn();
  $('.map').maphilight();

}
