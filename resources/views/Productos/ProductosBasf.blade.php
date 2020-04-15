@extends('main_template')

@section('WorkArea')
<div class="content">
  <!-- START JUMBOTRON -->
  <div class="jumbotron" data-pages="parallax">
      <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
          <div class="inner">
              <!-- START BREADCRUMB -->
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                  <li class="breadcrumb-item active">Productos BASF</li>
              </ol>
              <!-- END BREADCRUMB -->
              <div class="row">
                  <div class="col-xl-7 col-lg-6 ">
                      <!-- START card -->
                      <div class="full-height">
                          <div class="card-body text-center">
                              <img class="image-responsive-height demo-mw-600" src="{{asset('assets/img/productos/productosbasf.png')}}" alt="">
                          </div>
                      </div>
                      <!-- END card -->
                  </div>
                  <div class="col-xl-5 col-md-6 ">
                      <!-- START card -->
                      <div class="card card-transparent">
                          <div class="card-header ">
                              <div class="card-title">Iniciar
                              </div>
                          </div>
                          <div class="card-body">
                              <h3>Productos BASF</h3>
                              <p>En este modulo podrá activar los productos BASF que no estan disponibles en el inventario</p>
                              <p class="small hint-text m-t-5">Ingrese la clave o el código SAP para realizar la busqueda del producto, Active el producto en el botón "Activar"</p>
                          </div>
                      </div>
                      <!-- END card -->
                      <div class="input-group transparent col-lg-8 ">
                          <input class="form-control form-control-sm rounded bright" placeholder="Ingrese Clave o Codigo SAP" type="text" name="txtBuscar" id="txtBuscar" onkeyup="Busqueda_Productos(event,this.value)">
                          <div class="input-group-append ">
                              <span class="input-group-text transparent"> <i class="pg-search"></i></span>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- END JUMBOTRON -->
  <br>
  <div class=" container-fluid   container-fixed-lg bg-white">
    <div class="card card-transparent">
      <div class="element-box">

            <div class="card-body">
              <table class="table table-hover demo-table-search table-responsive-block" id="tableWithSearch">
                <thead>
                  <tr>
                    <th>SAP:</th>
                    <th>CLAVE</th>
                    <th>PRODUTO</th>
                    <th>MARCA</th>
                    <th>CLASIFICACION</th>
                    <th>ESTATUS</th>
                    <th>ACTIVAR</th>
                  </tr>
                </thead>
                <tbody>
  @foreach($Productos as $H)
                  <tr>
                    <td class="v-align-middle">{{$H->SAP}}</td>
                    <td class="v-align-middle">{{$H->CLAVE}}</td>
                    <td class="v-align-middle">{{$H->PRODUCTO}}</td>
                    <td class="v-align-middle">{{$H->LINEA}}</td>
                    <td class="v-align-middle">{{$H->CLASIFICACION}}</td>
                    <td class="v-align-middle"></td>
                    <td class="v-align-middle"></td>
                  </tr>
  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        {{csrf_field()}}
      </div>

</div>



@stop
@section('js')
<script type="text/javascript">
  function ActivarBasf(SAP,ActivarDesactivar){
    swal({
        title: "¿Esta seguro que desea Activar esta producto?",
        text: 'Si desea activar el producto, haga click en "Si, Activar" , de lo contrario presione "No, Cancelar!"',
        type: "question",
        showCancelButton: true,
        confirmButtonText: "Si, Activar!",
        cancelButtonText: "No, cancelar!",
    }).then(function(isConfirm){
        if (isConfirm) {
          var _token = $('input[name="_token"]').val();

          $.ajax({
            url:'/Productos/ProductosBASF/Activar',
            type:'post',
            data:{_token:_token,SAP:SAP,ActivarDesactivar:ActivarDesactivar},
            beforeSend:function(){

            },
            success:function(data){
              swal(data.Titulo,data.Mensaje,data.TMensaje);
              if (data.TMensaje == 'success'){
                $("#divEstatus"+SAP).removeClass("yellow").addClass('green');
                $("#divEstatus"+SAP).data('title',"Terminado");
                document.getElementById('Activar'+SAP).innerHTML = '';
              }
            },
            error:function(){
              swal("Error!","Ha ocurrido un error, no se han realizado la activación del producto","error");
            }
          });
        }
    });
  }
</script>
@stop
