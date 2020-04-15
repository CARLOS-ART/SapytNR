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
    $("#btnPreview").data("item",$container.handsontable('getDataAtCell',Fila,6));
  }

  /*===============================================================================*/

  function EliminarItem(){
      var Item = $("#btnPreview").data("item");
      var _token = $('input[name="_token"]').val();

      $.ajax({
          url:'/Bitacoras/Crear/AddItems/EliminarItem',
          type:'post',
          async:false,
          data:{_token:_token,Item:Item},
          beforeSend:function(){
            H5_loading.show();
          },
          success:function(data){
            $container.handsontable('updateSettings',{data:data.Info});
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
          });

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

    $.ajax({
      url:'/Bitacoras/Crear/AddItems/Preview',
      type:'post',
      data:{_token:_token,Info:$container.handsontable('getData')},
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

    function GuardarProductos(){
      var _token = $('input[name="_token"]').val();
      var Operario = $("#cmbOperario").val();

      $.ajax({
        url:'/Bitacoras/Crear/AddItems/GuardarProductos',
        type:'post',
        data:{_token:_token,Operario:Operario,Info:$container.handsontable('getData')},
        beforeSend:function(){
          H5_loading.show();
        },
        success:function(data1){
          H5_loading.hide();
          swal(data1.Titulo,data1.Mensaje,data1.TMensaje);
          if(data1.TMensaje == "success"){
            $container.handsontable('updateSettings',{data:data});
            var form =
            $('<form action="/Bitacoras/Crear" method="get" >' +

            '</form>');
            $('body').append(form);
            form.submit();
          }
        },
        error:function(){
          H5_loading.hide();
          swal('Error!','No fue posible cargar los productos a la bitacora',"error");
        }
      });
    }

   /*================================================================ */

   function Busqueda_Productos(e,Filtro){
     if(esEnter(e)){
       var _token = $('input[name="_token"]').val();
       $.ajax({
         url:'/Bitacoras/Crear/AddItems/ConsultarCatalogo',
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
       url:'/Bitacoras/Crear/AddItems/UseItem',
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
     var Proc = document.getElementById('cmbProceso').value;

    $.ajax({
      url:'/Bitacoras/Crear/AddItems/AgregarProducto',
      data:{_token:_token,Pro:Pro,Pre:Pre,Can:Can,Um:Um,Proc:Proc},
      type:'post',
      beforeSend:function(){

      },
      success:function(data){
        //document.getElementById('tableResult').innerHTML = data.InfoProducto;
      //  $("#tableResult").val(data.InfoProducto);
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
