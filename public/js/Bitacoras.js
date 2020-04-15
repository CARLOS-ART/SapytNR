var $container1 = $("#primarios");
var $parent = $container1.parent();
  var data = [
    [ "", "", "", "", "", "",  ""]
  ];

  function myAutocompleteRenderer(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.AutocompleteCell.renderer.apply(this, arguments);
    td.style.fontStyle = 'bold';
    td.title = 'Unidades de medida';
  }

  function negativeValueRenderer(instance, td, row, col, prop, value, cellProperties) {
  Handsontable.TextCell.renderer.apply(this, arguments);
    if (value === 'COMPRADO AL PROVEEDOR') {
      td.style.fontStyle = 'italic';
      td.style.background = '#98e1e6fe';
    }else if (value==='EN PROCESO'){
      td.style.background = '#F8BC34';
    }else if (value==='VACANTE') {
      td.style.background = '#71C21A';
      td.style.color = "#FFFFFF";

    }else if (value==="CANCELADO") {
      td.style.background = "#C21A1A";
      td.style.color = "#FFFFFF";
    }else if (value ==="AUTORIZADO") {
      td.style.background = "#407887fe";
      td.style.color = "#FFFFFF";
    }
    //td.properties.readOnly = true;#71C21A SURTIDO-ENTREGADO
}
Handsontable.cellLookup.renderer.negativeValueRenderer = negativeValueRenderer;

  var config = {
    data: data,
    minRows: 1,
    rowHeaders: true,
    colWidths: [100, 80,  225, 60, 140, 80,115],
    minCols: 9,
    minSpareRows: 1,
    autoWrapRow: true,
    colHeaders: ['CODIGO SAP', 'CLAVE', 'DESCRIPCIÓN', ' ', 'CANT. A AGREGAR','UNIDAD','TOTAL CONSUMO'],
    columns:[{},{},{},{},{},{},{}],
    contextMenu: false,
  cells: function (row, col, prop) {
    var cellProperties = {};


      cellProperties.renderer = "negativeValueRenderer"; //uses lookup map

    return cellProperties;
  },
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


  $container1.handsontable(config);



  function log_events(event, data) {
    if ( event == 'afterChange') {
        var info = data[0];



      }else if( event == 'afterSelection'){
        valorCell(data[0]);
      }else if( event == 'afterRemoveRow') {
        EliminarItem();
      }
  }

  var handsontable = $container1.data('handsontable');

  /*================================================================ */

  function valorCell(Fila){
    //funcion para obtener el ID
      $("#btnComentarios").data("item",$container1.handsontable('getDataAtCell',Fila,0));
    }

   /*================================================================ */

    function CargaProductoBitacoraPrimarios(){
      var Clasif = Array();
      Clasif[0]=1;
      var _token = $('input[name="_token"]').val();
      $.ajax({
        url:'/Bitacoras/CargaProductoBitacora',
        type:'post',
        data: {_token:_token,Clasif:Clasif},
        beforeSend:function(){
          H5_loading.show();

        },
        success:function(data){
          H5_loading.hide();

             $container1.handsontable('updateSettings',{data:data.Json,
               contextMenu: {callback: function (key, options) {

                  if (key === 'candidato') {
                    candidatoPartida();
                  }
                },items:
                 {
                   "detalle":{name:"..."}

                 }
               }});

               $container1.handsontable('updateSettings',{
                 cells: function (row, col ,prop) {
                 var cellProperties = {};
                 switch (prop) {
                   case 0: cellProperties.readOnly = true;    break;
                   case 1: cellProperties.readOnly = true;    break;
                   case 2: cellProperties.readOnly = true;    break;
                   case 3: cellProperties.readOnly = true;    break;
                 }
                 return cellProperties;
               }
             });
        },
        error:function(data){
          H5_loading.hide();

        //  swal('Error 500','Ha ocurrido un error y no se pudo procesar su solicitud, por favor intentelo nuevamente','error');
        }
      })
    }
    /*================================================================ */

    function CargaProductoBitacora1(){
      var _token = $('input[name="_token"]').val();
      var Item = $("#btnComentarios").data("item");

      $.ajax({
        url:'/Bitacoras/CargaProductoBitacora',
        type:'post',
        data:{_token:_token,Item:Item},
        beforeSend:function(){
          H5_loading.show();
        },
        success:function(data){
          H5_loading.hide();

        },
        error:function(data){
          H5_loading.hide();
          console.log('Service error');
        }
      });
    }

    /*================================================================ */

    function FinalizarCaptura(){

      var _token = $('input[name="_token"]').val();

      var JsonPrimarios = JSON.stringify($container1.handsontable('getData'));
      var JsonTransparentes = JSON.stringify($container2.handsontable('getData'));
      var JsonAdicionales = JSON.stringify($container3.handsontable('getData'));
      var JsonComplementos = JSON.stringify($container9.handsontable('getData'));

      var Elementos = Array(JsonPrimarios,JsonTransparentes,JsonAdicionales,JsonComplementos);

      var Operario = $("#cmbOperarios").val();

      $.ajax({
        url:'/Bitacoras/Productos/Consumo/FinalizarCaptura',
        type:'post',
        data:{_token:_token,Elementos:Elementos,Operario:Operario},
        beforeSend:function(){
          H5_loading.show();
        },
        success:function(data){
          H5_loading.hide();
          //CircleNotification(data.Titulo,'',data.TMensaje,'top-left');
          BarNotification(data.Titulo,data.Titulo+'. '+data.Mensaje,data.TMensaje,'top');
        },
        error:function(data){
          H5_loading.hide();
          console.log('Service error');
        }
      });
    }

    /*================================================================ */
