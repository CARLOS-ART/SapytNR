var $container = $("#example1");
var $console = $("#example1console");
var $parent = $container.parent();
var autosaveNotification;
$container.handsontable({
  rowHeaders: true,

  height: 450,
  colHeaders: ['NOMBRE DEL OPERARIO'],
  minSpareRows: 1,//Numero de filas vacias para escribir nueva info
  contextMenu: false,

});

var handsontable = $container.data('handsontable');



$parent.find('button[name=save]').click(function () {
  var _token = $('input[name="_token"]').val();

  var Info = [
    $("#txtNombre").val(),
    $("#txtNombreCompleto").val(),
    $("#txtCorreoElectronico").val(),
    $("#txtUsuario").val(),
    $("#txtPwd").val(),
    $("#cmbEmpresa").val(),
    $("#txtCodigo").val()
  ]

  //console.log(handsontable.getData());

  $.ajax({
    url:'/Talleres/nuevoTaller',
    type:'post',
    data:{_token:_token,Info:Info,Operarios:handsontable.getData()},
    beforeSend:function(){
      console.log('Datos Enviados');
    },
    success:function(data){
      CircleNotification(data.Titulo,data.Mensaje,data.TMensaje,"top-left");
      if(data,TMensaje == "success"){
        $("#txtNombre").val("");
        $("#txtNombreCompleto").val("");
        $("#txtCorreoElectronico").val("");
        $("#txtUsuario").val("");
        $("#txtPwd").val("");
        $("#cmbEmpresa").val("");
        $("#txtCodigo").val("");
      }
    },
    error:function(){
      CircleNotification('Operación no realizada','No se pudo realizar la operacion solicitada, por favor intentelo nuevamente','error',"top-left");
    }
  });

});

/**=================================================================== */

function GuardarTaller(){
    if($("#txtNombre").val().length <=0){
        CircleNotification('Falta el nombre del Taller','Por favor llene el campo nombre del Taller','warning',"top-left");
        return false;
    }

    if ($("#txtNombreCompleto").val().length <= 0) {
        CircleNotification("Falta el nombre completo",'Por favor llene el nombre del usuario',"top-left");
        return false;
    }

    if($ ("#txtCorreoElectronico").val().length<=0){
        CircleNotification('Falta el correo electronico','Por favor llene el campo de correo','warning',"top-left");
        return false;
    }

    if($("#txtUsuario").val().length<=0){
        CircleNotification('Falta el nombre del usuario','Por favor llene el nombre del usaurio','warning',"top-left");
        return false;
    }

    if($("#txtPwd").val().length<=0){
        CircleNotification('Falta la contraseña','Por favor llene el campo de la contraseña','warning',"top-left");
        return false;
    }

    $("#btnSave").click();

}

/**===================================================================== */

function RandomPwd(){
  var text = "";
  var possible = "?!V8XSCYZ01KW34UL6RDOPQ25HIJ9_*-7EFGMTABN";

  for (var i = 0; i < 6; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));

  $("#txtPwd").val(text);
}
