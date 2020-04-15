function GuardarOperario(Dato){

  if($("#txtNombreOperario").val().length == 0){
    $('#cerrarmodal').click();
    swal('Falta nombre completo','Debe ingresar el nombre completo del operario a crear','warning');
    return false;
  }

  var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/Talleres/Operarios/Crear',
    type:'post',
    data:{_token:_token,Dato:Dato},
    success:function(data){
      $('#cerrarmodal').click();
      swal(data.Titulo,data.Mensaje,data.TMensaje);
      if(data.TMensaje == 'success'){
        $('#TabOperarios > tbody:last-child').append(data.NOperario);
      }
      $('#txtNombreOperario').val('');
    },
    error:function(){
      console.log('No fue posible guardar el operario');
      swal('Error!','No fue posible guardar un nuevo operario','error');
    }
  })
}

/*==============================================================================*/

$(".btnCambioEstatus").click(function(){
  var _token = $('input[name="_token"]').val();
  var Ope = $(this).data('ope');
  var Est = $(this).data('est');

  $.ajax({
    url:'/Talleres/Operarios/CambiarEstatus',
    type:'post',
    data:{_token:_token,Ope:Ope,Est:Est},
    success:function(data){

      swal(data.Titulo,data.Mensaje,data.TMensaje);
      if(data.TMensaje == 'success'){
        $('#tdEstatus'+Ope).text(data.NEstatus);
        if(data.NEstatus == 'INACTIVO'){
          $("#btn"+Ope).removeClass('btn-danger').addClass('btn-success');
            $("#btn"+Ope).text('Activar');
            $("#btn"+Ope).data('est',0);
        }else{


          $("#btn"+Ope).removeClass('btn-success').addClass('btn-danger');
          $("#btn"+Ope).text('Desactivar');
          $("#btn"+Ope).data('est',1);

        }
      }

    },
    error:function(){
      swal('Error!','No fue posible cambiar el estatus del operario','error');
    }
  })
})
/*=================================================================================*/

$("#Form").on("submit", function(e){
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var formData = new FormData(document.getElementById("Form"));
        //formData.append("dato", "valor");
        //formData.append(f.attr("name"), $(this)[0].files[0]);

        $.ajax({
            url: url,
            type: "post",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend:function(data){

            },
            success:function(data){

                swal(data.Titulo,data.Mensaje,data.TMensaje);

            },
            error:function(data){

                swal("Error","Ha ocurrido un error, intentelo nuevamente","error");
            }
        })
});
