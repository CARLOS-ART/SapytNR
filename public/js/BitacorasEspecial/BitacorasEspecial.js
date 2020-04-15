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
    },
    error:function(){
      console.log('ocurrio un error, no fue posible cargar la lista de los vehiculos');
    }
  });
}

/*=================================================*/

function IntegrantesCuadrilla(Cuadrilla){
  var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/Factory/Bitacoras/Crear/Info/IntegrantesCuadrilla',
    type:'post',
    data:{_token:_token,Cuadrilla:Cuadrilla},
    success:function(data){
       document.getElementById('dIntegrantes').innerHTML = data.Info;
    },
    error:function(){
      console.log('ocurrio un error, no fue posible cargar la lista de los Integrantes');
    }
  });
}

/*=================================================*/

function DatosBitacora(){
    var Campos = Array('txtNumOrden','txtFecha','txtCliente');
    var TituloCampos = Array('Numero de orden','Fecha', 'Nombre del Cliente');

    for(x = 0;x <= Campos.length-1;x++){
        if($("#"+Campos[x]).val().length == 0){
            swal("Faltan datos","Por favor proporcione la información para el campo "+TituloCampos[x],"warning");
            return false;
        }
    }

    var OT = $("#txtNumOrden").val();
    var _token = $('input[name="_token"]').val();
    var l = Ladda.create(document.querySelector('#btnGuardar'));

    $.ajax({
        url:'/Bitacoras/ValidarOT',
        type:'post',
        async:false,
        data:{_token:_token,OT:OT},
        beforeSend:function(){
            l.start();
        },
        success:function (data) {
            if(data.TMensaje == "warning"){
                setRespuesta(false);
                swal(data.Titulo,data.Mensaje,data.TMensaje);
                l.stop();
            }else{
                setRespuesta(true);
            }

          },
        error:function(){
            swal("Error!","No hemos podido validar el Numero de orden, ocurrio un error en el servidor, por favor intentelo nuevamente!","error");
            setRespuesta(false);
            l.stop();
        }
    });

    return $Respuesta;

}

/*==============================================================================*/

function ActividadGuardar(){
  var ActividadID = $("#btnAgregar01").data('actividad');
  var InfoActividad = $("#txtActividad").val();
  var _token = $('input[name="_token"]').val();

  $.ajax({
      url:'/Factory/Actividades/ActividadGuardar',
      type:'post',
      async:false,
      data:{_token:_token,ActividadID:ActividadID,InfoActividad:InfoActividad},
      beforeSend:function(){

      },
      success:function (data) {
        $("#btnAgregar01").data('actividad',0);
        swal(data.Titulo,data.Mensaje,data.TMensaje);

        },
      error:function(){
          swal("Error!","No hemos podido guardar la información, por favor intentelo nuevamente!","error");

      }
  });
  $(".close").click();
  location.reload();
}

/*==============================================================================*/

function ZonasGuardar(){
  var ZonaID = $("#btnAgregar01").data('zona');
  var InfoZona = $("#txtZona").val();
  var _token = $('input[name="_token"]').val();

  $.ajax({
      url:'/Factory/Actividades/Zonas/Guardar',
      type:'post',
      async:false,
      data:{_token:_token,ZonaID:ZonaID,InfoZona:InfoZona},
      beforeSend:function(){

      },
      success:function (data) {
        $("#btnAgregar01").data('zona',0);
        swal(data.Titulo,data.Mensaje,data.TMensaje);

        },
      error:function(){
          swal("Error!","No hemos podido guardar la información, por favor intentelo nuevamente!","error");

      }
  });
  $(".close").click();
  location.reload();
}

/*==============================================================================*/

function ActividadBitacora(){
  var ZonaID = $("#cmbZona").val();
  var Actividad = $("#cmbActividad").val();
  var _token = $('input[name="_token"]').val();

  $.ajax({
      url:'/Factory/Bitacoras/ActividadBitacora',
      type:'post',
      async:false,
      data:{_token:_token,ZonaID:ZonaID,Actividad:Actividad},
      beforeSend:function(){

      },
      success:function (data) {

        swal(data.Titulo,data.Mensaje,data.TMensaje);
        $('#tbActividades > tbody:last-child').append(data.Filas);
        },
      error:function(){
          swal("Error!","No hemos podido guardar la información, por favor intentelo nuevamente!","error");

      }
  });
  $(".close").click();
}
/*==============================================================================*/

function VehiculoGuardar(){

  var Vehiculo = $("#txtunidad").val();
  var _token = $('input[name="_token"]').val();

  $.ajax({
      url:'/Factory/Actividad/CatalogoVehiculos/VehiculoGuardar',
      type:'post',
      async:false,
      data:{_token:_token,Vehiculo:Vehiculo},
      beforeSend:function(){

      },
      success:function (data) {

        swal(data.Titulo,data.Mensaje,data.TMensaje);

        },
      error:function(){
          swal("Error!","No hemos podido guardar la información, por favor intentelo nuevamente!","error");

      }
  });

}
