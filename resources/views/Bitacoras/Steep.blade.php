@extends('main_template')
@section('WorkArea')
<div class="content">
<div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
            <!-- START CATEGORY -->{{csrf_field()}}
            <div class="gallery" style="position: relative; width: 1150px; height: 1250px;">
              <div class="gallery-filters p-t-20 p-b-10">
               @if(request()->cookie('Bitacora_ID') == true)
                <ul class="list-inline text-right">
                  <li class="hint-text">Número de orden: </li>
                  <li class="hint-text" style="color: #CD4945"><b>{{$BitacoraInfo[0]->OT}}</b> </li>
                  <li class="hint-text">Fecha Ingreso: </li>
                  <li class="hint-text" style="color: #000000">{{date('d/m/Y',strtotime($BitacoraInfo[0]->FECHA))}} </li>
                  <li class="hint-text">Vehículo: </li>
                  <li class="hint-text" style="color:#000000"><b>{{$BitacoraInfo[0]->VEHICULO}} {{$BitacoraInfo[0]->MODELO}}</b> </li>
                  <a class="btn btn-white btn-sm" href="/Bitacoras/TerminarCaptura"><i class="os-icon os-icon-check"></i><span>Terminar captura</span></a>
                  <li><a class="btn btn-white btn-sm" href="/Bitacoras/Administrar/Partidas"><i class="os-icon os-icon-check"></i><span>Administrar Partidas</span></a></li>
                  <li><a class="btn btn-white btn-sm"  data-target="#onboardingSlideModal" data-toggle="modal" onclick="MostrarC()"><i class="os-icon os-icon-check"></i><span>Agregar comentarios</span></a></li>
                </ul>
                @endif
              </div>

              <div class="gallery-item first" data-width="1" data-height="1" style="position: absolute; left: 0px; top: 0px;">
                <!-- START PREVIEW -->
                <img src="/assets/bitacoras/orden.png" alt="" class="image-responsive-height">

                <div class="overlayer bottom-left full-width">
                  <div class="overlayer-wrapper item-info ">
                    <div class="gradient-grey p-l-20 p-r-20 p-t-20 p-b-5">
                      <div class="">
                        <p class="pull-left bold text-white fs-14 p-t-10">Paso #1: Datos de la orden de Trabajo</p>
                         <h5 class="pull-right semi-bold text-white font-montserrat bold"> @if(request()->cookie('Bitacora_ID')==false) Pendiente @else Listo @endif</h5>
                        <div class="clearfix"></div>
                      </div>
                      <div class="m-t-10">
                        <div class="inline m-l-10">
                          <p class="no-margin text-white fs-12">Proporcione los datos generales de la orden de trabajo</p>

                        </div>

                        <div class="pull-right m-t-10">
                          <a href="/Bitacoras/Crear/Info" class="btn btn-white btn-xs btn-mini bold fs-14" type="button">Abrir</a>
                        </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END PRODUCT OVERLAY DESCRIPTION -->
              </div>

              <div class="gallery-item " data-width="2" data-height="2" style="position: absolute; left: 290px; top: 0px;">
                <!-- START PREVIEW -->
                <div class="live-tile slide carousel" data-speed="750" data-delay="4000" data-mode="carousel">
                  <div class="slide-front slide" style="transition-property: top; transition-duration: 750ms; transition-timing-function: ease; top: -100%; left: 0%;">
                    <img src="/assets/bitacoras/productos_basf.png" alt="" class="image-responsive-height">
                  </div>
                  <div class="slide-back slide active" style="left: 0%; top: 0%; transition-duration: 750ms; transition-property: top; transition-timing-function: ease;">
                    <img src="/assets/bitacoras/productos_basf.png" alt="" class="image-responsive-height">
                  </div>
                </div>

                <div class="overlayer bottom-left full-width">
                  <div class="overlayer-wrapper item-info more-content">
                    <div class="gradient-grey p-l-20 p-r-20 p-t-20 p-b-5">
                      <div class="">
                        <h3 class="pull-left bold text-white no-margin">Productos</h3>
                        <h3 class="pull-right semi-bold text-white font-montserrat bold no-margin">En Espera</h3>
                        <div class="clearfix"></div>
                        <span class="hint-text pull-left text-white">Agregue productos de repintado y complementos utilizados en el proceso de reparación</span>
                        <div class="clearfix"></div>
                      </div>

                      <div class="m-t-10">
                        <div class="pull-right m-t-10">
                          @if(request()->cookie('Bitacora_ID')==false)
                           <a href="/Bitacoras/Crear/Info" class="btn btn-white btn-xs btn-mini bold fs-14" type="button">IR PASO #1</a>
                          @else
                           <a href="/Bitacoras/Productos/Consumo" class="btn btn-white btn-xs btn-mini bold fs-14" type="button">Abrir</a>
                          @endif
                        </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <div class="gallery-item " data-width="1" data-height="1" style="position: absolute; left: 870px; top: 0px;">
                <img src="/assets/bitacoras/pintura.png" alt="" class="image-responsive-height">

                <div class="overlayer bottom-left full-width">
                  <div class="overlayer-wrapper item-info ">
                    <div class="gradient-grey p-l-20 p-r-20 p-t-20 p-b-5">
                      <div class="">
                        <p class="pull-left bold text-white fs-14 p-t-10">Color / Pintura</p>
                        <h5 class="pull-right semi-bold text-white font-montserrat bold">
                          @if(request()->cookie('Bitacora_ID')==false)
                           En Espera
                          @else
                            @if($Piezas == '')
                            En Espera
                            @else
                            Listo
                            @endif
                          @endif
                        </h5>
                        <div class="clearfix"></div>
                      </div>
                      <div class="m-t-10">
                        <div class="inline m-l-10">
                          <p class="no-margin text-white fs-12">Agregue los elementos utilizados para el color igualado</p>

                        </div>

                        <div class="pull-right m-t-10">
                          @if(request()->cookie('Bitacora_ID')==false)
                           <a href="/Bitacoras/Crear/Info" class="btn btn-white btn-xs btn-mini bold fs-14" type="button">IR PASO #1</a>
                          @else
                           <a href="/Bitacoras/Crear/Pintura" class="btn btn-white btn-xs btn-mini bold fs-14" type="button">Abrir</a>
                          @endif
                        </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END PRODUCT OVERLAY DESCRIPTION -->
              </div>

              <div class="gallery-item " data-width="1" data-height="1" style="position: absolute; left: 0px; top: 250px;">
                <!-- START PREVIEW -->
                <img src="/assets/bitacoras/piezas.png" alt="" class="image-responsive-height">
                <!-- END PREVIEW -->
                <!-- START ITEM OVERLAY DESCRIPTION -->
                <div class="overlayer bottom-left full-width">
                  <div class="overlayer-wrapper item-info ">
                    <div class="gradient-grey p-l-20 p-r-20 p-t-20 p-b-5">
                      <div class="">
                        <p class="pull-left bold text-white fs-14 p-t-10">Paso #2: Piezas a Reparar</p>
                        <h5 class="pull-right semi-bold text-white font-montserrat bold">
                        @if(request()->cookie('Bitacora_ID')==false)
                         En Espera
                        @else
                          @if($Piezas == '')
                          En Espera
                          @else
                          Listo
                          @endif
                        @endif
                        </h5>
                        <div class="clearfix"></div>
                      </div>
                      <div class="m-t-10">
                        <div class="inline m-l-10">
                          <p class="no-margin text-white fs-12">Seleccione las piezas a reparar en la orden de trabajo</p>

                        </div>

                        <div class="pull-right m-t-10">
                          @if(request()->cookie('Bitacora_ID')==false)
                           <a href="/Bitacoras/Crear/Info" class="btn btn-white btn-xs btn-mini bold fs-14" type="button">IR PASO #1</a>
                          @else
                           <a href="/Bitacoras/Crear/SelectorPiezas" class="btn btn-white btn-xs btn-mini bold fs-14" type="button">Abrir</a>
                          @endif

                        </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END PRODUCT OVERLAY DESCRIPTION -->
              </div>

              <div class="gallery-item " data-width="1" data-height="1" style="position: absolute; left: 870px; top: 250px;">
                <!-- START PREVIEW -->
                <img src="/assets/bitacoras/basf.png" alt="" class="image-responsive-height">
                <!-- END PREVIEW -->
                <!-- START ITEM OVERLAY DESCRIPTION -->
                <div class="overlayer bottom-left full-width">
                  <div class="overlayer-wrapper item-info ">
                    <div class="gradient-grey p-l-20 p-r-20 p-t-20 p-b-5">
                      <div class="">
                        <p class="pull-left bold text-white fs-14 p-t-10">Vista Previa</p>
                        <h5 class="pull-right semi-bold text-white font-montserrat bold">Listo</h5>
                        <div class="clearfix"></div>
                      </div>
                      <div class="m-t-10">
                        <div class="thumbnail-wrapper d32 circular m-t-5">
                          <img width="40" height="40" src="assets/img/profiles/avatar.jpg" data-src="assets/img/profiles/avatar.jpg" data-src-retina="assets/img/profiles/avatar2x.jpg" alt="">
                        </div>

                        <div class="pull-right m-t-10">
                          @if(request()->cookie('Bitacora_ID')==false)
                           <a href="/Bitacoras/Crear/Info" class="btn btn-white btn-xs btn-mini bold fs-14" type="button">IR PASO #1</a>
                          @else
                           <a href="#" id="tableWithSearch" onclick="ReportBitacora({{request()->cookie('Bitacora_ID')}});" class="btn btn-white btn-xs btn-mini bold fs-14" type="button">Abrir</a>
                          @endif
                        </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END PRODUCT OVERLAY DESCRIPTION -->
              </div>


            </div>

          </div></div>

          <!-- Modal -->
          <div class="modal fade fill-in" id="onboardingSlideModal" tabindex="-1" role="dialog" aria-hidden="true">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                  <i class="pg-close"></i>
              </button>
              <div class="modal-dialog ">
                  <div class="modal-content">
                      <div class="modal-header">

                          <h5>  <span class="semi-bold">Aquí podras escribir algun comentario o apunte acerca de la orden, esto se añadirá a la bitácora.</span></h5>
                      </div>
                      <div class="modal-body">
                        <div class="col-lg-12">
                           <div class="form-group form-group-default">
                              <textarea class="form-control" placeholder="..." type="text" style="min-width:100%; max-width:100%; min-height:50px;" rows="3" name="comentarios" id="comentarios"></textarea>
                           </div>
                        </div>
                        <div class="col-sm-10">
                          <button class="btn btn-complete" id="btnAgregar" name="btnAgregar" type="button" onclick="actualizarC();" data-dismiss="modal">Agregar</button>
                        </div>
                      </div>

                  </div>
                  <div class="modal-footer">
                  </div>
              </div>
              <!-- /.modal-content -->
          </div>

          <div>
            <link href="{{asset('js/loading.css')}}" rel="stylesheet">
            <script src="{{asset('js/loading.js')}}"></script>
            <script src="{{asset('js/Bitacoras.Tablero.js')}}"></script>
            <script src="{{asset('js/Funciones_Basicas.js')}}"></script>
          </div>

@stop
@section('js')

@stop
