 @extends('main_template')

@section('handsontable')
<script src="{{asset('jquery.min.js')}}"></script>
<script src="{{asset('handsontable/jquery.handsontable.full.js')}}"></script>
<link rel="stylesheet" media="screen" href="{{asset('handsontable/jquery.handsontable.full.css')}}">
@stop
@section('WorkArea')

<div class="content">
  <!-- START JUMBOTRON -->
  <div class="jumbotron" data-pages="parallax">
      <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
          <div class="inner">
              <!-- START BREADCRUMB -->
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/Productos/Aliados">Aliados y complementos</a></li>
                  <li class="breadcrumb-item active">Formato aliados</li>
              </ol>
              <!-- END BREADCRUMB -->
              <div class="row">
                  <div class="col-xl-7 col-lg-6 ">
                      <!-- START card -->
                      <div class="full-height">
                          <div class="card-body text-center">
                              <img class="image-responsive-height demo-mw-600" src="{{asset('assets/img/productos/inventarioini.png')}}" alt="">
                          </div>
                      </div>
                      <!-- END card -->
                  </div>
                  <div class="col-xl-5 col-lg-6 ">
                      <!-- START card -->
                      <div class="card card-transparent">

                        {{csrf_field()}}

                          <div class="card-body">
                              <h3 >Formato aliados</h3>
                              <p >En este modulo podrá añadir al inventario productos que no pertenecen a las marcas de Basf</p>
                              <p class="small hint-text m-t-5">Ingrese la informacion requerida de cada producto, al terminar haga click en el botón terminar y cargar productos</p>
                          </div>
                          <!-- END card -->

                          <div class="col-md-6 text-center">
                            <div class="card card-transparent">
                              <div class="card-header  separator">
                                <div class="card-title">Número de solicitud
                                </div>
                              </div>
                              <div class="card-body">
                                <h3><span class="bold">F{{request()->cookie('Solicitud_ID')}}</span> </h3>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-5">
                              <div class="btn btn-primary" onclick="GuardarCambios();" >
                                <i class="fa fa-save faa-spin animated-hover"></i> Guardar cambios
                              </div>
                            </div>

                            <div class="col-sm-5">
                              <div class="btn btn-primary" onclick="TerminaYCarga();">
                                <i class="fa fa-upload faa-spin animated-hover"></i> Terminar y Cargar Productos
                              </div>
                            </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
      <!-- END JUMBOTRON -->
  <div class="content-i">
    <div class="content-box">
       <div class="row">
          <div class="col-sm-12">
             <div class="element-wrapper">
                <div class="element-content">
                   <div class="row">
                      <div class="col-lg-12 col-sm-12">
                         <div id="example1" style="width:100%"></div>
                         <p style="display:none">
                            <button name="load" id="btnLoad">Load</button>
                            <button name="save" id="btnSave">Save</button>
                            <button name="termina_y_carga" id="btnFinish">Finish</button>
                         </p>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>

    {{csrf_field()}}
  <br>

    </div>

  <div>

    <script src="{{asset('js/Productos.Aliados.js?v=3')}}"></script>
    <script src="{{asset('js/Global.js?v=3')}}"></script>

  </div>
</div>

@stop
@section('js')
<script src="asset{{('assets/js/notifications.js')}}" type="text/javascript"></script>
 <script src="asset{{('assets/js/scripts.js')}}" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function(){
    CargarDatos();
  })
</script>
@stop
