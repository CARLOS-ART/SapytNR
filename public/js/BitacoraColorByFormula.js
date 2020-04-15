function BuscarIgualado(e,Filtro){
  if(esEnter(e) == false){
    return false;
  }

 if(Filtro.length == 0){
   swal('Introduzca formula','Por favor ingrese la clave o codigo de color','warning');
   return false;
 }

 var _token = $('input[name="_token"]').val();
 $.ajax({
   url:'/Bitacoras/AddItems/Color/Formula/Buscar',
   type:'post',
   data:{_token:_token,Filtro:Filtro},
   success:function(data){
    document.getElementById('Resultados').innerHTML = data.Resultados;
   },
   error:function(){
     swal('Formula no obtenida','No se pudo obtener resultados en la busqueda, es posible que su conexión a internet no este funcionando correctamente ','error');
   }
 });

}

/*==============================================================================*/

function usarLPA(Formula,Codigo,NomColor){
  $("#txtCodColor").data('formula',Formula);
  $("#txtCodigo").val(Codigo);
  $("#txtColor").val(NomColor);
  document.getElementById('Resultados').innerHTML = '<div class="form-group" id="divCantidad"><label for=""> Cantidad a preparar (Mililitros)</label><input class="form-control" placeholder="Escriba cantidad" type="text" name="txtCantidadLPA" id="txtCantidadLPA"><br><button class="btn btn-primary btn-sm" id="btnPrepararLPA" onclick="PrepararMezcla()"><i class="icon-chemistry"></i><span>Preparar LPA</span></button></div>';
}

/*==============================================================================*/

function PrepararMezcla(Formula,PrecioBase){
  var Formula = $("#txtCodColor").data('formula');
  var PrecioBase = "1000";

  var Cantidad = $("#txtCantidadLPA").val();
  var TipoMezcla = $("#txtCodColor").data('tipoigualado');

  var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/Bitacoras/AddItems/Color/Formula/PrepararMezcla',
    data:{_token:_token,Formula:Formula,PrecioBase:PrecioBase,Cantidad:Cantidad,TipoMezcla:TipoMezcla},
    type:'post',
    beforeSend:function(){

    },
    success:function(data){
    document.getElementById('Resultados').innerHTML = data.Tabla;
    $("#txtJson").val(data.DatosJson);

    $("#txtClaveLPA").val('');


    },
    error:function(){
      swal('Error!','No fue posible ejecutar su peticion, por favor intentelo mas tarde','error');
    }
  });

}

/*===============================================================================*/

function LpaBitacoraProducto(){
var Validaciones = document.getElementById('txtJson').value;
   if(Validaciones.length>=1){

     var json = JSON.parse(Validaciones);
     var ItemID = '';

     var NJson = Array();
     var x = 0;

     for (var clave in json){
var NArray = {};
          ItemID = 'cmbPresentacion'+json[clave].PRODUCTO_ID;

          if($("#"+ItemID).val().length == 0 ){
            swal("Faltan datos","Seleccione presentación para el producto "+json[clave].CLAVE+", por favor proporcione la información correspondiente","warning");
            return false;
          }

          NArray['PRODUCTO_ID'] = json[clave].PRODUCTO_ID;
          NArray['PRESENTACION_ID'] = $("#"+ItemID).val();
          NArray['CANTIDAD'] = json[clave].CANTIDAD;
          NArray['CLAVE'] = json[clave].CLAVE;

          NJson[x] = NArray;
          x++;
        }


        TipoColor = $("#txtCodColor").data('tipocolor');
        TipoIgualado = $("#txtCodColor").data('tipoigualado');
        LineaColor = $("#txtCodColor").data('lineapintura');
        CodColor = $("#txtCodigo").val();
        NomColor = $("#txtColor").val();
        Operario = document.getElementById("cmbOperario").value;

    var _token = $('input[name="_token"]').val();
    $.ajax({
      url:'/Bitacoras/AddItems/Color/Formula/InsertaLPA',
      data:{_token:_token,NJson:NJson,TipoColor:TipoColor,TipoIgualado:TipoIgualado,LineaColor:LineaColor,CodColor:CodColor,NomColor:NomColor,Operario:Operario},
      type:'post',
      beforeSend:function(){

      },
      success:function(data){
      swal(data.Titulo,data.Mensaje,data.TMensaje);
      if(data.TMensaje == "success"){
        document.getElementById('Resultados').innerHTML = '<center>Se agregó la formúla a la bitácora</center>';
		if(TipoIgualado == -1){
			Preview();
		}

      }
      },
      error:function(){
        swal('Error!','No fue posible ejecutar su peticion, por favor intentelo mas tarde','error');
      }
    });

        }
 }	


/*===============================================================================*/

 function LpaToBitacora(){
   var Validaciones = document.getElementById('txtJson').value;
   if(Validaciones.length>=1){

     var json = JSON.parse(Validaciones);
     var ItemID = '';

     var NJson = Array();
     var x = 0;

     for (var clave in json){
var NArray = {};
          ItemID = 'cmbPresentacion'+json[clave].PRODUCTO_ID;

          if($("#"+ItemID).val().length == 0 ){
            swal("Faltan datos","Seleccione presentación para el producto "+json[clave].CLAVE+", por favor proporcione la información correspondiente","warning");
            return false;
          }

          NArray['PRODUCTO_ID'] = json[clave].PRODUCTO_ID;
          NArray['PRESENTACION_ID'] = $("#"+ItemID).val();
          NArray['CANTIDAD'] = json[clave].CANTIDAD;
          NArray['CLAVE'] = json[clave].CLAVE;

          NJson[x] = NArray;
          x++;
        }


        TipoColor = $("#txtCodColor").data('tipocolor');
        TipoIgualado = $("#txtCodColor").data('tipoigualado');
        LineaColor = $("#txtCodColor").data('lineapintura');
        CodColor = $("#txtCodigo").val();
        NomColor = $("#txtColor").val();
        Operario = document.getElementById("cmbOperario").value;

    var _token = $('input[name="_token"]').val();
    $.ajax({
      url:'/Bitacoras/AddItems/Color/Formula/InsertaLPA',
      data:{_token:_token,NJson:NJson,TipoColor:TipoColor,TipoIgualado:TipoIgualado,LineaColor:LineaColor,CodColor:CodColor,NomColor:NomColor,Operario:Operario},
      type:'post',
      beforeSend:function(){

      },
      success:function(data){
      swal(data.Titulo,data.Mensaje,data.TMensaje);
      if(data.TMensaje == "success"){
        document.getElementById('Resultados').innerHTML = '<center>Se agregó la formúla a la bitácora</center>';

      }
      },
      error:function(){
        swal('Error!','No fue posible ejecutar su peticion, por favor intentelo mas tarde','error');
      }
    });

        }
 }
