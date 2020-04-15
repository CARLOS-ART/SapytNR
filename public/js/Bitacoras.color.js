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
    $("#btnGuardarColor").data("item",$container.handsontable('getDataAtCell',Fila,6));
  }

  /*===============================================================================*/

  function EliminarItem(){
      var Item = $("#btnGuardarColor").data("item");
      var _token = $('input[name="_token"]').val();

      $.ajax({
          url:'/Bitacoras/Color/EliminarItemColor',
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
                case 0: cellProperties.readOnly = true;    break;
                case 1: cellProperties.readOnly = true;    break;
                case 3: cellProperties.readOnly = true;    break;
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

  function Busqueda_Productos(e,Filtro){
    //url:'/Bitacoras/Crear/AddItems/ConsultarCatalogo',
    if(esEnter(e)){
      var _token = $('input[name="_token"]').val();
      $.ajax({
        url:'/Bitacoras/Crear/AddItems/Color/Productos',
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

  function useItemColor(Pro,Pre){
     var _token = $('input[name="_token"]').val();
    $.ajax({
      url:'/Bitacoras/Crear/AddItems/Color/UseItemColor',
      data:{_token:_token,Pro:Pro,Pre:Pre},
      type:'post',
      beforeSend:function(){
       H5_loading.show();
      },
      success:function(data){
        H5_loading.hide();
        document.getElementById('tableResult').innerHTML = data.InfoProducto;
      },
      error:function(){
        H5_loading.hide();
        swal('Error!','No fue posible ejecutar su peticion, por favor intentelo mas tarde','error');
      }
    })
  }

  /*====================================================================*/

  function AddItemColorEnter(event){
    if(esEnter(event) == true){
      AddItemColor();
    }
  }

  /*====================================================================*/
  function MostrarItemsColor(){
    var _token = $('input[name="_token"]').val();
    $.ajax({
      url:'/Bitacoras/Color/AddItems/Color/MostrarItemsColor',
      data:{_token:_token},
      type:'post',
      beforeSend:function(){

      },
      success:function(data){
      $(".close").click();
      $("#txtBuscar").val('');
      $("#txtBuscar").focus();
      if(data.TMensaje == "success"){
        $container.handsontable('updateSettings',{data:data.Info});
        $container.handsontable('updateSettings',{
         cells: function (row, col ,prop) {
         var cellProperties = {};
         switch (prop) {
           case 0: cellProperties.readOnly = true;    break;
           case 1: cellProperties.readOnly = true;    break;
           case 3: cellProperties.readOnly = true;    break;
           case 4: cellProperties.readOnly = true;    break;
           case 5: cellProperties.readOnly = true;    break;
           case 6: cellProperties.readOnly = true;    break;
         }
         return cellProperties;
       }
     });
      }
      },
      error:function(){
        swal('Error!','No fue posible ejecutar su peticion, por favor intentelo mas tarde','error');
      }
    });
  }
  /*====================================================================*/


  function AddItemColor(){
    var _token = $('input[name="_token"]').val();
    var Pro = $("#btnProducto").data('producto');
    var Pre = $("#btnProducto").data('presentacion');
    var Um = document.getElementById('cmbUnidad').value;
    var Can = document.getElementById('txtCant').value;

   $.ajax({
     url:'/Bitacoras/Crear/AddItems/Color/AddItemColor',
     data:{_token:_token,Pro:Pro,Pre:Pre,Can:Can,Um:Um},
     type:'post',
     beforeSend:function(){

     },
     success:function(data){
     $(".close").click();
     $("#txtBuscar").val('');
     $("#txtBuscar").focus();
     if(data.TMensaje == "success"){
       $container.handsontable('updateSettings',{data:data.Info});
       $container.handsontable('updateSettings',{
        cells: function (row, col ,prop) {
        var cellProperties = {};
        switch (prop) {
          case 0: cellProperties.readOnly = true;    break;
          case 1: cellProperties.readOnly = true;    break;
          case 3: cellProperties.readOnly = true;    break;
          case 4: cellProperties.readOnly = true;    break;
          case 5: cellProperties.readOnly = true;    break;
          case 6: cellProperties.readOnly = true;    break;
        }
        return cellProperties;
      }
    });
     }
     },
     error:function(){
       swal('Error!','No fue posible ejecutar su peticion, por favor intentelo mas tarde','error');
     }
   });
  }

  /*=======================================================================*/

  function GuardarColor(){
    TipoColor = $("#btnGuardarColor").data('tipocolor');
    TipoIgualado = $("#btnGuardarColor").data('tipoigualado');
    LineaColor = $("#btnGuardarColor").data('lineapintura');
    CodColor = $("#txtCodigo").val();
    NomColor = $("#txtColor").val();

    var Campos = Array('txtCodigo','txtColor');
    var TituloCampos = Array('Codigo color','Nombre color');

    for(x = 0;x <= Campos.length-1;x++){
        if($("#"+Campos[x]).val().length == 0){
            swal("Faltan datos","Por favor proporcione la información para el campo "+TituloCampos[x],"warning");
            return false;
        }
    }

    Operario = document.getElementById("cmbOperario").value;
    var _token = $('input[name="_token"]').val();
    $.ajax({
      url:'/Bitacoras/Color/GuardarColor',
      type:'post',
      data:{_token:_token,TipoColor:TipoColor,TipoIgualado:TipoIgualado,LineaColor:LineaColor,CodColor:CodColor,NomColor:NomColor,Operario:Operario,Info:$container.handsontable('getData')},
      beforeSend:function(){
       H5_loading.show();
      },
      success:function(data){
        H5_loading.hide();
        swal(data.Titulo,data.Mensaje,data.TMensaje);
        if(data.TMensaje == "success"){
          var form =
          $('<form action="/Bitacoras/Crear" method="get" >' +

          '</form>');
          $('body').append(form);
          form.submit();
        }

      },
      error:function(){
        H5_loading.hide();
        swal('Error interno','No se puede guardar el color','error');
      }
    });
  }
