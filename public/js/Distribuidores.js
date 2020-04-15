function GuardarDistribuidor(){

    if($("#txtNombre").val().length == 0){
        CircleNotification('Proporcione el nombre comercial','Por favor proporcione el nombre comercial del distribuidor','warning',"top-left");
        return false;
    }

    if($("#txtRSocial").val().length == 0){
        CircleNotification('Falta Razon Social','Por favor proporcione razon social del distribuidor','warning',"top-left");
        return false;
    }

    var Nombre = document.getElementById('txtNombre').value;
    var RSocial = document.getElementById('txtRSocial').value;
    var Fecha = document.getElementById('txtFecha').value;
    var _token = $('input[name="_token"]').val();

    $.ajax({
        url:'/Distribuidores/GenerarAlta',
        type:'post',
        data:{_token:_token,Nombre:Nombre,RSocial:RSocial,Fecha:Fecha},
        beforeSend:function(){

        },
        success:function(data){
          CircleNotification(data.Titulo,data.Mensaje,data.TMensaje,"top-left");
          if(data.TMensaje == "success"){
            document.getElementById('txtNombre').value= '';
            document.getElementById('txtRSocial').value= '';
          }
        },
        error:function(){
            CircleNotification('Ocurrio un error!','Error interno, el servidor ha respondido con el codigo 500','error',"top-left");
        }
    });

}
