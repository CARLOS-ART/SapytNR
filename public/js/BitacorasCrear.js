var $Respuesta = false;

function setRespuesta(val){
    $Respuesta = val;
}

/*==================================================*/

function getRespuesta(){
    return $Respuesta;
}

function mostrarVehiculos(Marca){
  var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/Bitacoras/Crear/Info/ObtenerVehiculos',
    type:'post',
    data:{_token:_token,Marca:Marca},
    success:function(data){
       document.getElementById('dVehiculos').innerHTML = data.Combo;
       $("#cmbVehiculo").select2();
    },
    error:function(){
      console.log('ocurrio un error, no fue posible cargar la lista de los vehiculos');
    }
  });
}

/*=================================================*/

function DatosBitacora(){

    var Campos = Array('txtNumOrden','txtFecha','txtValuacionSeguro','txtValuacionTaller','txtPlacas','txtVin','txtColor','txtModelo');
    var Labels = Array('Numero de orden','Fecha', 'Valuación Seguro','Valuación Taller',  'Placas','Vin ó Serie','Color','Modelo (Año)');

    for(x = 0;x <= Campos.length-1;x++){
        if($("#"+Campos[x]).val().length == 0){
            CircleNotification('El campo "'+Labels[x]+'"','<b>está vacío. Agregue el dato</b>','warning',"top-left");
            return false;
        }
    }



    var OT = $("#txtNumOrden").val();
    var _token = $('input[name="_token"]').val();

    $.ajax({
        url:'/Bitacoras/ValidarOT',
        type:'post',
        async:false,
        data:{_token:_token,OT:OT},
        beforeSend:function(){

        },
        success:function (data) {
            if(data.TMensaje == "warning"){
                setRespuesta(false);
            }else{
                setRespuesta(true);
                GuardarBitacora();
            }
          },
        error:function(){
            setRespuesta(false);
        }
    });

    return $Respuesta;

}

 /*==============================================================================*/

function GuardarBitacora(){
  $("#txtVehiculo").val( $("#cmbVehiculo").val());

  var form = $("#Form");
  var url = form.attr('action');
  var formData = new FormData(document.getElementById("Form"));

  $.ajax({
      url: url,
      type: "post",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend:function(data){
      H5_loading.show();
      },
      success:function(data){
      H5_loading.hide();
      CircleNotification(data.Titulo,data.Mensaje,data.TMensaje,"top-left");
      },
      error:function(data){
      H5_loading.hide();
      }
  });
}
