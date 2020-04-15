var Flag = 0;
var $container = $("#example1");
var $parent = $container.parent();
  var data = [
    ["", "", "", "", "", "",""]
  ];

  var config = {
    data: data,
    minRows: 1,
    colWidths: [100, 350, 70, 50, 90, 90],
    minCols: 6,
    minSpareRows: 1,
    autoWrapRow: true,
    colHeaders: ['CLAVE', 'DESCRIPCION', 'CANTIDAD', 'UM', 'PRECIO','IMPORTE',""],
    contextMenu: {items:{"remove_row":{name:"Eliminar"}}},
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

  function log_events(event, data) {

    if ( event == 'afterChange'){
        var info = data[0];
        if(info[0][1] == 0){
            $container.handsontable('updateSettings', { disableVisualSelection: true});
            if(Flag == 0){
            ObtenerProducto(info[0][3]);
          }else {
            Flag = 0;
          }

        }else{
          //  console.log("Cambiaste el valor de la columna "+info[0][1]);
        }
    }else if( event == 'afterSelection'){
      valorCell(data[0]);
    }else if ( event == 'afterRemoveRow') {
      EliminarItem();
    }
  }

  var handsontable = $container.data('handsontable');

  /*===============================================================================*/

  function valorCell(Fila){
    $("#btnLPA").data("item",$container.handsontable('getDataAtCell',Fila,6));
  }

  /*===============================================================================*/

  function EliminarItem(){
      var Item = $("#btnLPA").data("item");
      var _token = $('input[name="_token"]').val();

      $.ajax({
          url:'/Factory/Bitacoras/Items/EliminarItem',
          type:'post',
          async:false,
          data:{_token:_token,Item:Item},
          beforeSend:function(){
            H5_loading.show();
          },
          success:function(data){
            Preview();
          /*  $container.handsontable('updateSettings',{data:data.Info});
            Flag = 1;
            $container.handsontable('updateSettings',{
              cells: function (row, col ,prop) {
              var cellProperties = {};
              switch (prop) {
                case 1: cellProperties.readOnly = true;    break;
                case 4: cellProperties.readOnly = true;    break;
                case 5: cellProperties.readOnly = true;    break;
                case 6: cellProperties.readOnly = true;    break;
              }
              return cellProperties;
            }
          });*/

          H5_loading.hide();
          },
          error:function(){
            H5_loading.hide();
            swal("Error!","No hemos podido eliminar la pieza seleccionada, intentelo nuevamente","error");
          }
      });

  }


  /*================================================================ */

  function ObtenerProducto(Cve){
     if(Cve.length > 0){
       //console.log("Numero de empleado es "+NumEmpleado);
       var _token = $('input[name="_token"]').val();
       $.ajax({
         url:'/Bitacoras/Crear/AddItems/ObtenerProducto',
         type:'post',
         data: {_token:_token,Cve:Cve},
         beforeSend:function(){
           H5_loading.show();
         },
         success:function(data){
          H5_loading.hide();

            if(data.TMensaje == "success"){

              $container.handsontable('updateSettings',{data:data.Info});
              $container.handsontable('updateSettings',{
               cells: function (row, col ,prop) {
               var cellProperties = {};
               switch (prop) {
                 case 1: cellProperties.readOnly = true;    break;
                 case 4: cellProperties.readOnly = true;    break;
                 case 5: cellProperties.readOnly = true;    break;
                 case 6: cellProperties.readOnly = true;    break;
               }
               return cellProperties;
             }
           });

            }else{
              swal(data.Titulo,data.Mensaje,data.TMensaje);
            }
         },
         error:function(data){
           swal('Error 500','Ha ocurrido un error y no se pudo procesar su solicitud, por favor intentelo nuevamente','error');
           H5_loading.hide();

         }
       })
     }
  }

  /*================================================================ */

  function Preview(){
    var _token = $('input[name="_token"]').val();
    var Activity1 = $("#btnLPA").data('actividad');
    var Zona = $("#btnLPA").data('zona');

    $.ajax({
      url:'/Factory/Bitacoras/Items/Preview',
      type:'post',
      data:{_token:_token,Activity1:Activity1,Zona:Zona},
      beforeSend:function(){
      H5_loading.show();
      },
      success:function(data){
        if(data.TMensaje != "success"){
          swal(data.Titulo,data.Mensaje,data.TMensaje);
        }else{
          $container.handsontable('updateSettings',{data:data.Info});
          $container.handsontable('updateSettings',{
           cells: function (row, col ,prop) {
           var cellProperties = {};
           switch (prop) {
             case 1: cellProperties.readOnly = true;    break;
             case 4: cellProperties.readOnly = true;    break;
             case 5: cellProperties.readOnly = true;    break;
             case 6: cellProperties.readOnly = true;    break;
           }
           return cellProperties;
         }
       });
        }

        H5_loading.hide();
      },
      error:function(){
        swal('Error 500','Error inesperado, por favor intentelo nuevamente','error');
        H5_loading.hide();
      }
    })
  }



   /*================================================================ */

   function Busqueda_Productos(e,Filtro){
     if(esEnter(e)){
       var _token = $('input[name="_token"]').val();
       $.ajax({
         url:'/Factory/Bitacoras/Items/ConsultarCatalogo',
         type:'post',
         data:{_token:_token,Filtro:Filtro},
         beforeSend:function(){

         },
         success:function(data){
           document.getElementById('tableResult').innerHTML = data.Table;
           $("#btnCatalogoProd").click();
         },
         error:function(){
           swal('Error!','No fue posible consultar el catalogo de productos, ocurrio un error en el servidor, por favor intentelo nuevamente','error');
         }
       });

     }
   }

   /*====================================================================*/

   function useItem(Pro,Pre){
      var _token = $('input[name="_token"]').val();
     $.ajax({
       url:'/Factory/Bitacoras/Items/UseItem',
       data:{_token:_token,Pro:Pro,Pre:Pre},
       type:'post',
       beforeSend:function(){

       },
       success:function(data){
         document.getElementById('tableResult').innerHTML = data.InfoProducto;
       },
       error:function(){
         swal('Error!','No fue posible ejecutar su peticion, por favor intentelo mas tarde','error');
       }
     })
   }

   /*====================================================================*/

   function AgregarProducto(){
     var _token = $('input[name="_token"]').val();
     var Pro = $("#btnProducto").data('producto');
     var Pre = $("#btnProducto").data('presentacion');
     var Um = document.getElementById('cmbUnidad').value;
     var Can = document.getElementById('txtCant').value;

     var Activity1 = $("#btnLPA").data('actividad');
     var Zona = $("#btnLPA").data('zona');

    $.ajax({
      url:'/Factory/Bitacoras/Items/AgregarProducto',
      data:{_token:_token,Pro:Pro,Pre:Pre,Can:Can,Um:Um,Activity1:Activity1,Zona:Zona},
      type:'post',
      beforeSend:function(){

      },
      success:function(data){
      Preview();
      $(".close").click();
      $("#txtBuscar").val('');
      $("#txtBuscar").focus();
      },
      error:function(){
        swal('Error!','No fue posible ejecutar su peticion, por favor intentelo mas tarde','error');
      }
    });
   }

/*==============================================================================*/

 function BuscarLPA(e,Filtro){
   if(esEnter(e)){
   var _token = $('input[name="_token"]').val();
   $.ajax({
     url:'/Factory/Bitacoras/Items/BuscarLPA',
     data:{_token:_token,Filtro:Filtro},
     type:'post',
     beforeSend:function(){

     },
     success:function(data){
     document.getElementById('Resultados').innerHTML = data.Tabla;

     $("#txtClaveLPA").val('');

     },
     error:function(){
       swal('Error!','No fue posible ejecutar su peticion, por favor intentelo mas tarde','error');
     }
   });
 }
 }

 /*=============================================================================*/

 function PrepararMezcla(Formula,PrecioBase){
   var Cantidad = $("#txtCantidadLPA").val();

   var _token = $('input[name="_token"]').val();
   $.ajax({
     url:'/Factory/Bitacoras/Items/PrepararMezcla',
     data:{_token:_token,Formula:Formula,PrecioBase:PrecioBase,Cantidad:Cantidad},
     type:'post',
     beforeSend:function(){

     },
     success:function(data){
     document.getElementById('Resultados').innerHTML = data.Tabla;

     $("#txtClaveLPA").val('');


     },
     error:function(){
       swal('Error!','No fue posible ejecutar su peticion, por favor intentelo mas tarde','error');
     }
   });

 }

 /*=============================================================================*/

 function MezclarLPA(Formula,PrecioBase){
   $("#divClaveLPA").attr("hidden",true);
   document.getElementById('Resultados').innerHTML = '<div class="form-group" id="divCantidad"><label for=""> Cantidad a preparar (Mililitros)</label><input class="form-control" placeholder="Escriba cantidad" type="text" name="txtCantidadLPA" id="txtCantidadLPA"></div><button class="btn btn-primary btn-sm" id="btnPrepararLPA" onclick="PrepararMezcla('+Formula+','+PrecioBase+')"><i class="icon-chemistry"></i><span>Preparar LPA</span></button><hr><button class="btn btn-outline-danger btn-sm" id="btnCancelar" onclick="CancelarMezcla()" ><i class="os-icon os-icon-close"></i><span>Cancelar</span></button>';

 }

 /*=============================================================================*/

 function CancelarMezcla(){
   $("#divClaveLPA").attr("hidden",false);
   document.getElementById('Resultados').innerHTML = '';
 }

 /*=============================================================================*/

 function LpaToBitacora(Formula,PrecioBase,Cantidad){
   var Activity1 = $("#btnLPA").data('actividad');
   var Zona = $("#btnLPA").data('zona');
   var _token = $('input[name="_token"]').val();
   $.ajax({
     url:'/Factory/Bitacoras/Items/LpaToBitacora',
     data:{_token:_token,Activity1:Activity1,Zona:Zona,Formula:Formula,Cantidad:Cantidad,PrecioBase:PrecioBase},
     type:'post',
     beforeSend:function(){

     },
     success:function(data){

     $("#txtClaveLPA").val('');
     CancelarMezcla();
     Preview();


     },
     error:function(){
       swal('Error!','No fue posible ejecutar su peticion, por favor intentelo mas tarde','error');
     }
   });
 }

 /*==========================*/

 function GuardarArticulos(){
   var _token = $('input[name="_token"]').val();
   $.ajax({
     url:'/Factory/Bitacoras/Items/GuardarArticulos',
     data:{_token:_token},
     type:'post',
     beforeSend:function(){
//Antes de enviar al controlador por medio de la ruta
     },
     success:function(data){
//cuando se ejecuta correctamente
     },
     error:function(){
       //En caso de existir un error
       swal('Error!','No fue posible ejecutar su peticion, por favor intentelo mas tarde','error');
     }
   });
 }
