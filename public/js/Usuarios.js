/*$(".Talleres").click(function(){
  var Brand = $(this).data("brand");
  var Taller = $("#"+Brand).data("taller");
  var Seleccionar = $("#"+Brand).data("seleccion");

  if(Seleccionar == 0){
    Seleccionar = 1;
    $("#"+Brand).data("seleccion",1);
    $("#"+Brand).removeClass('badge-light').addClass('badge-success');
  }else{
    Seleccionar = 0;
    $("#"+Brand).data("seleccion",0);
    $("#"+Brand).removeClass('badge-success').addClass('badge-light');
  }


})

/*===================================================*/
/*
$(".CrearUsuario").click(function(){

  var Talleres = Array();
  var i = 0;
 $( ".trending" ).each(function(){
   if($(this).data('seleccion') == 1){
    Talleres[i] = $(this).data('taller');
    i++;
   }
 });

 //validaciones
 var Campos = Array('txtNombrePersona','txtUsuario','txtContra','txtContra2');
 var Titulos = Array('Nombre','Cuenta o usuario','Contraseña','Confirmar contraseña');

 //

 for(x=0;x<=3;x++){
  if($("#"+Campos[x]).val().length == 0){
    CircleNotification("Faltan datos","El campo "+Titulos[0]+" esta vacio, por favor proporcione este dato","warning","top-left");
    return false;
  }
 }

 if($("#txtContra").val() != $("#txtContra2").val()){
   CircleNotification('La contraseña y su confirmacion no coindice','Las contraseñas no coinciden, por favor verifiquela e intentelo nuevamente','warning',"top-left");
   return false;
 }

   var _token = $('input[name="_token"]').val();

 var Nombre = $("#txtNombrePersona").val();
 var Cuenta = $("#txtUsuario").val();
 var Pwd = $("#txtContra").val();
 var Perfil = $("#CmbPerfil").val();

 $.ajax({
  url: '/Usuarios/GuardarUsuario',
  type:'post',
  data:{_token:_token,Talleres:Talleres,Nombre:Nombre,Cuenta:Cuenta,Pwd:Pwd,Perfil:Perfil},
  success:function(data){
   CircleNotification(data.Titulo,data.Mensaje,data.TMensaje);
   if(data.TMensaje == "success"){
     for(x=0;x<=3;x++){
      $("#"+Campos[x]).val('')

     }
   }
  },
  error:function(){
    CircleNotification('Error!','No es posible guardar el usuario','error',"top-left");
  }
 });
})
*/
/*====================================================================*/

function GuardarUsuario(){
  var _token = $('input[name="_token"]').val();
  var Talleres = Array();
    var Flag = 0;

    $("input:checkbox:checked").each(function() {
      if($(this).val() != 'on'){
        Talleres[Flag]=$(this).val();
        Flag++;
      }
    });


  //validaciones
  var Campos = Array('txtNombrePersona','txtUsuario','txtContra','txtContra2');
  var Titulos = Array('Nombre','Cuenta o usuario','Contraseña','Confirmar contraseña');

  //

  for(x=0;x<=3;x++){
   if($("#"+Campos[x]).val().length == 0){
     CircleNotification("Faltan datos","El campo "+Titulos[0]+" esta vacio, por favor proporcione este dato","warning","top-left");
     return false;
   }
  }

  if($("#txtContra").val() != $("#txtContra2").val()){
    CircleNotification('La contraseña y su confirmacion no coindice','Las contraseñas no coinciden, por favor verifiquela e intentelo nuevamente','warning',"top-left");
    return false;
  }

    var _token = $('input[name="_token"]').val();

  var Nombre = $("#txtNombrePersona").val();
  var Cuenta = $("#txtUsuario").val();
  var Pwd = $("#txtContra").val();
  var Perfil = $("#CmbPerfil").val();


        $.ajax({
          url:'/Usuarios/GuardarUsuario',
          data:{_token:_token,Talleres:Talleres,Nombre:Nombre,Cuenta:Cuenta,Pwd:Pwd,Perfil:Perfil},
          type:'post',
          beforeSend:function(){

          },
          success:function(data){

           CircleNotification(data.Titulo,data.Mensaje,data.TMensaje,"top-left");
           $("#txtNombrePersona").val('');
           $("#txtUsuario").val('');
           $("#txtContra").val('');
           $("#txtContra2").val('');           
           $("#CmbPerfil").val('');
          },
          error:function(){
            CircleNotification('Error!','No fue posible ejecutar su peticion, por favor intentelo mas tarde','error',"top-left");
          }
        });
}
