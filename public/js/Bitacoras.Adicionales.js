var $container3 = $("#adicionales");
var $parent = $container3.parent();
  var data = [
    ["", "", "", "", "", "", ""]
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


  $container3.handsontable(config);



  function log_events(event, data) {
    if ( event == 'afterChange') {
        var info = data[0];



      }else if( event == 'afterSelection'){
        valorCell(data[0]);
      }else if( event == 'afterRemoveRow') {
        EliminarItem();
      }
  }

  var handsontable = $container3.data('handsontable');

  /*================================================================ */

  function valorCell(Fila){
    //funcion para obtener el ID
      $("#btnComentarios").data("item",$container3.handsontable('getDataAtCell',Fila,0));
    }

    /*================================================================ */

    function CargaProductoBitacoraAdicionales(){
      var Clasif = Array();
      Clasif[0]=2;
      Clasif[1]=3;
      Clasif[2]=5;
      Clasif[3]=6;
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

             $container3.handsontable('updateSettings',{data:data.Json,
               contextMenu: {callback: function (key, options) {

                  if (key === 'detalle') {
                    candidatoPartida();
                  }
                },items:
                 {
                   "detalle":{name:"..."}

                 }
               }});
        },
        error:function(data){
          H5_loading.hide();

        //  swal('Error 500','Ha ocurrido un error y no se pudo procesar su solicitud, por favor intentelo nuevamente','error');
        }
      })
    }
