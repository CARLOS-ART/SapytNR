@extends('main_template')
@section('handsontable')
<link href="{{asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css')}}" rel="stylesheet" type="text/css" media="screen">
<link href="{{asset('assets/plugins/summernote/css/summernote.css')}}" rel="stylesheet" type="text/css" media="screen">
<link href="{{asset('assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css')}}" rel="stylesheet" type="text/css" media="screen">
<link href="{{asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" media="screen">
<link href="{{asset('pages/css/pages-icons.css')}}" rel="stylesheet" type="text/css">
<link class="main-stylesheet" href="{{asset('pages/css/themes/light.css')}}" rel="stylesheet" type="text/css" />
@stop
@section('WorkArea')
<div class="content">

    <!-- START JUMBOTRON -->
    <div class="jumbotron" data-pages="parallax">
        <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
            <div class="inner">
                <!-- START BREADCRUMB -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Compras</li>
                </ol>
                <!-- END BREADCRUMB -->
                <div class="row">
                    <div class="col-xl-7 col-lg-6 ">
                        <!-- START card -->
                        <div class="full-height">
                            <div class="card-body text-center">
                                <img class="image-responsive-height demo-mw-600" src="{{asset('assets/img/productos/compras.png')}}" alt="">
                            </div>
                        </div>
                        <!-- END card -->
                    </div>
                    <div class="col-xl-5 col-lg-6 ">
                        <!-- START card -->
                        <div class="card card-transparent">
                            <div class="card-header ">
                                <div class="card-title">Iniciar
                                </div>
                            </div>
                            <div class="card-body">
                                <h3>Compras</h3>
                                <p>En este modulo podrá realizar compras para añadir productos al inventario</p>
                                <p class="small hint-text m-t-5">Ingrese la clave o el código SAP para realizar la busqueda del producto, una vez encontrado el producto ingrese los valores requeridos</p>
                                <br>
                                <div class="row">
                                    <div class="input-group date col-md-6 p-l-0">
                                        <label>FOLIO FACTURA</label>
                                    </div>
                                    <div class="input-group date col-md-6 p-l-0">
                                        <label>FECHA</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-group date col-md-6 p-l-0">
                                        <input class="form-control" required id="txtFolio">
                                    </div>
                                    <div class="input-group date col-md-6 p-l-0">
                                        <input type="text" class="form-control" name="Fecha" id="Fecha" type="text" value="{{date('d/m/Y')}}">
                                        <div class="input-group-append ">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="col-sm-12">
                                    @if(request()->cookie('Perfil_ID') == 8)
                                    <a class="btn btn-primary" href="#" onclick="GuardarCompraFactory();"><span>Guardar compra </span><i class="os-icon os-icon-arrow-right2"></i></a>
                                    @else
                                    <a class="btn btn-primary" href="#" onclick="GuardarCompra();"><span>Guardar compra </span><i class="os-icon os-icon-arrow-right2"></i></a>
                                    @endif
                                </div>
                            </div>
                            <!-- END card -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END JUMBOTRON -->
    {{csrf_field()}}
    <div class=" container-fluid   container-fixed-lg bg-white">
        <div class="card card-transparent">
            <br>
            <br>
            <div class="row">
                <div class="col-sm-2">
                    <input class="form-control form-control-sm rounded bright text-black bold" placeholder="Buscar" type="text" name="txtBuscar" id="txtBuscar" onkeyup="Busqueda_Productos(event,this.value)">
                </div>
            </div>
            <hr>
            <div class="element-box">
                <div class="card-header ">
                    <div class="card-title">Historial de compras
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    <table class="table table-hover demo-table-search table-responsive-block" id="tableWithSearch">
                        <thead>
                            <tr>
                                <th>SAP:</th>
                                <th>CLAVE:</th>
                                <th>PRODUCTO:</th>
                                <th>CANTIDAD:</th>
                                <th>PRECIO COMPRA:</th>
                                <th>IMPORTE:</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Producto as $P)
                            <tr id="row{{$P->ITEM}}">
                                <td class="v-align-middle semi-bold sorting_1">
                                    <p>{{$P->CODIGO_SAP}}</p>
                                </td>
                                <td class="v-align-middle">{{$P->CLAVE}}</td>
                                <td class="v-align-middle">
                                    <p>{{$P->PRODUCTO}}</p>
                                </td>
                                <td class="v-align-middle">
                                    <p>{{number_format($P->CANTIDAD,2)}} PZA</p>
                                </td>
                                <td class="v-align-middle">
                                    <p>$ {{number_format($P->PRECIOC,2)}}</p>
                                </td>
                                <td class="v-align-middle">
                                    <p>$ {{number_format($P->IMPORTE,2)}}</p>
                                </td>
                                <td class="text-danger"><a href="#" class="text-danger" onclick="EliminarItem({{$P->ITEM}})">Eliminar</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <button class="mr-2 mb-2 btn btn-primary" style="display:none" data-target="#onboardingSlideModal" data-toggle="modal" type="button" id="btnCatalogoProd">Catalogo productos</button>
    <!-- Modal -->
    <div class="modal fade fill-in" id="onboardingSlideModal" tabindex="-1" role="dialog" aria-hidden="true">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <i class="pg-close"></i>
        </button>
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Su busqueda tiene los siguientes resultados, <span class="semi-bold">por favor seleccione una opción:</span></h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-12" id="tableResult" style="min-height:387px; max-height:600px; overflow-x:hidden;overflow-y:scroll;">
                            </div>
                        </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
<!--

          <div class="modal fade stick-up" id="onboardingSlideModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content-wrapper">
                <div class="modal-content">
                  <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                    <h5>Su busqueda tiene los siguientes resultados, <span class="semi-bold">por favor seleccione una opción:</span></h5>
                  </div>
                  <div class="modal-body">
                    <form>
                       <div class="row">
                          <div class="col-sm-12" id="tableResult" style="min-height:387px; max-height:600px; overflow-x:hidden;overflow-y:scroll;">
                          </div>
                       </div>
                 </div>
                 </form>
                  </div>
                  <div class="modal-footer">
                  </div>
                </div>
              </div>

            </div>

          </div>
-->

<div>
    <script src="{{asset('js/Funciones_Basicas.js')}}"></script>
    <script src="{{asset('js/Compras.js?v=2.2')}}"></script>
    <script src="{{asset('js/Global.js?v=3')}}"></script>
</div>

@stop
@section('js')
<script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/summernote/js/summernote.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-typehead/typeahead.bundle.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-typehead/typeahead.jquery.min.js')}}"></script>
<script src="{{asset('assets/plugins/handlebars/handlebars-v4.0.5.js')}}"></script>
<!-- END VENDOR JS -->
<!-- BEGIN CORE TEMPLATE JS -->
<!-- BEGIN CORE TEMPLATE JS -->
<script src="{{asset('pages/js/pages.js')}}"></script>
<!-- END CORE TEMPLATE JS -->
<!-- BEGIN PAGE LEVEL JS -->
<script src="{{asset('assets/js/scripts.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL JS -->
<!-- END CORE TEMPLATE JS -->
<!-- BEGIN PAGE LEVEL JS -->
<script src="{{asset('assets/js/notifications.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/form_elements.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#Fecha").datepicker();
        $("#txtFecha2").datepicker();
    })
</script>
@stop
