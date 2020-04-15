$(".TeamWork").click(function(){
  var Personal = $(this).data("brand");
  //var Linea = $("#"+Personal).data("linea");
  var Seleccionar = $("#"+Personal).data("seleccion");

  if(Seleccionar == 0){
    Seleccionar = 1;
    $("#"+Personal).data("seleccion",1);
    $("#"+Personal).removeClass('btn-light').addClass('btn-success');
    $("#box"+Personal).prop("checked",true);

  }else{
    Seleccionar = 0;
    $("#"+Personal).data("seleccion",0);
    $("#"+Personal).removeClass('btn-success').addClass('btn-light');
    $("#box"+Personal).prop("checked",false);

  }


})

/*==============================================================================*/

function CrearCuadrilla(){
  var Campos = Array('txtNomCuadrilla');
  var TituloCampos = Array('Nombre de cuadrilla');

  for(x = 0;x <= Campos.length-1;x++){
      if($("#"+Campos[x]).val().length == 0){
          swal("Faltan datos","Por favor proporcione la información para el campo "+TituloCampos[x],"warning");
          return false;
      }
  }

     var _token = $('input[name="_token"]').val();

      var Items = Array();
      var Flag = 0;
      $("input:checkbox:checked").each(function() {
        if($(this).val() != 'on'){
          Items[Flag]=$(this).val();
          Flag++;
        }
      });

    var NomCuadrilla = $("#txtNomCuadrilla").val();

  $.ajax({
    url:'/Factory/Cuadrillas/CrearCuadrilla',
    type:'post',
    data:{_token:_token,Items:Items,NomCuadrilla:NomCuadrilla},
    beforeSend:function(data){
     H5_loading.show();
    },
    success:function(data){
      H5_loading.hide();
      swal(data.Titulo,data.Mensaje,data.TMensaje);
      if(data.TMensaje=="success"){
        $("#txtNomCuadrilla").val()
      }
    },
    error:function(){
      H5_loading.hide();
      console.log('No se pudo realizar la carga de la informacion solicitada');
    }
  });
}
