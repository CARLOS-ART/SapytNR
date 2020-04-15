@extends('main_template') @section('WorkArea') {{csrf_field()}}
<div class="content">
    <!--start Modal operarios-->
    <div class="modal fade fill-in" id="modalFillIn" tabindex="-1" role="dialog" aria-hidden="true">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <i class="pg-close"></i>
        </button>
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="text-left p-b-5"><span class="semi-bold">Agregar</span> Operario</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-9 ">
                            <input type="text" placeholder="Ingrese nombre del operario" class="form-control input-lg" id="icon-filter" name="txtNombreOperario" id="txtNombreOperario">
                        </div>
                        <div class="col-lg-3 no-padding sm-m-t-10 sm-text-center">
                            <button type="button" class="btn btn-info btn-lg btn-large fs-15" onclick="GuardarOperario(txtNombreOperario.value)">Agregar</button>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--end Modal operarios -->
    <div class="social-wrapper">
        <div class="social " data-pages="social">
            <!-- START JUMBOTRON -->
            <div class="jumbotron" data-social="cover" data-pages="parallax">
                <div class="cover-photo">
                    <img alt="Cover photo" src="{{asset('assets/img/taller/tinfo.fw.png')}}" />
                </div>
                <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
                    <div class="inner">
                        <div class="pull-bottom bottom-left m-b-40 sm-p-l-15">

                            <h1 class="text-white no-margin"><span class="semi-bold">  {{request()->cookie('Taller')}}</span></h1>
                            <h5 class="text-white no-margin">{{request()->cookie('Distribuidor')}} | {{request()->cookie('Ubicacion')}}</h5>
                        </div>

                    </div>
                </div>
            </div>
            <!-- END JUMBOTRON -->
            <div class="container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
                <div class="feed">
                    <div class="day" data-social="day">
                        <!-- START lineas de producto -->
                        <div class="card no-border bg-transparent full-width" data-social="item">
                            <!-- START CONTAINER FLUID -->
                            <div class="container-fluid p-t-30 p-b-30 ">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="container-xs-height">
                                            <div class="row-xs-height">

                                                <div class="col-xs-height p-l-20">
                                                    <h3 class="no-margin p-b-5"> <span class="semi-bold">{{$CountBitacoras[1]->CUENTA}}</span> </h3>
                                                    <p class="no-margin fs-16">Bitacoras al mes
                                                    </p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <h3 class="no-margin p-b-5"> <span class="semi-bold">{{$CountBitacoras[0]->CUENTA}}  </span></h3>
                                        <p class="no-margin fs-16"> Bitacoras totales</p>
                                    </div>
                                    <div class="col-lg-3">
                                        <p class="m-b-5 small">Lineas de producto</p>
                                        <ul class="list-unstyled ">
                                            @foreach($Lineas as $L)
                                            <li class="m-r-10">
                                                <div class="thumbnail-wrapper d32 circular b-white m-r-5 b-a b-white">
                                                    <img width="35" height="35" alt="Profile Image"
                                                    @if(in_array($L->
                                                    LINEA_ID,array(1,2,3))) src="/img/GlasuritLogo.png"
                                                    @elseif (in_array($L->LINEA_ID,array(4,7,8,9,10))) src="/img/RMLogo.png"
                                                    @elseif (in_array($L->LINEA_ID,array(5,6))) src="/img/LimcoLogo.png"
                                                    @elseif (in_array($L->LINEA_ID,array(11))) src="/img/NorbinLogo.png"
                                                    @elseif (in_array($L->LINEA_ID,array(14))) src="/img/3MLogo.jpg"
                                                    @endif height="35" >
                                                </div>
                                                <!--  <span class="hint-text m-t-9 small">{{$L->LINEA}}</span> -->
                                            </li>
                                            @endforeach
                                        </ul>
                                        <br>
                                    </div>
                                    <div class="col-lg-5">
                                        <p class="m-b-5 small">Logotipo del taller</p>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <form role="form" method="post" enctype="multipart/form-data" action="/Talleres/Imagen/Upload" id="Form">
                                                    {{csrf_field()}}
                                                    <div class="box">
                                                        <input type="file" name="txtFile[]" id="file-5" class="inputfile inputfile-4" data-multiple-caption="{count} archivos seleccionados" />
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="submit" class="btn btn-success ladda-button" data-style="expand-left" id="btnSubir" name="btnSubir" style="width:120px; height:30px">
                                                    <span class="ladda-label"><i class="fa fa-cloud-upload"></i> Subir foto</span>
                                                </button>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END CONTAINER FLUID -->
                        </div>
                        <!-- END lineas de producto -->
                        <hr>
                        <!-- START numero de piezas -->
                        <div class="card no-border bg-transparent full-width" data-social="item">
                            <!-- START CONTAINER FLUID -->
                            <div class="container-fluid p-t-30 p-b-30 ">
                                <div class="row">
                                    @foreach($Piezas as $P)
                                    <div class="col-lg-4">
                                        <!-- START WIDGET widget_weekly_sales_card-->
                                        <div class="card no-border widget-loader-bar m-b-10">

                                            <div class="container-xs-height full-height">
                                                <div class="row-xs-height">
                                                    <div class="col-xs-height col-top">
                                                        <div class="card-header  top-left top-right">
                                                            <div class="card-title">
                                                                <span class="font-montserrat fs-11 all-caps">{{$P->CONDICION}} <i class="fa fa-chevron-right"></i>
				                        </span>
                                                            </div>
                                                            <div class="card-controls">
                                                                <ul>
                                                                    <li><a href="#" class="portlet-refresh text-black" data-toggle="refresh"><i class="portlet-icon portlet-icon-refresh"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-xs-height">
                                                    <div class="col-xs-height col-top">
                                                        <div class="p-l-20 p-t-50 p-b-40 p-r-20">
                                                            <h3 class="no-margin p-b-5">{{$P->NUMERO_REPARACIONES}}</h3>
                                                            <span class="small hint-text pull-left ">Piezas de {{$Total}}</span>
                                                            <span class="pull-right small text-primary">{{$P->NUMERO_REPARACIONES}}/{{$Total}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-xs-height">
                                                    <div class="col-xs-height col-bottom">
                                                        <div class="progress progress-small m-b-0">
                                                            <!-- START BOOTSTRAP PROGRESS (http://getbootstrap.com/components/#progress) -->
                                                            @php $Parte = round($P->NUMERO_REPARACIONES*100/$Total,0,PHP_ROUND_HALF_UP) @endphp
                                                            <div class="progress-bar progress-bar-primary" style="width:{{$Parte}}%"></div>
                                                            <!-- END BOOTSTRAP PROGRESS -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- END WIDGET -->
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- END CONTAINER FLUID -->
                        </div>
                        <!-- END numero de piezas -->
                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-sm-12 ">
                                    <!-- START Top 10 de productos mas usados-->
                                    <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                                        <div class="card-header top-right">
                                            <div class="card-controls">
                                                <ul>
                                                    <li><a data-toggle="refresh" class="portlet-refresh text-black" href="#"><i class="portlet-icon portlet-icon-refresh"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="padding-25">
                                            <div class="pull-left">
                                                <h2 class="text-success no-margin">Top 10 de productos mas usados</h2>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="auto-overflow widget-11-2-table">
                                            <table class="table table-condensed table-hover">
                                                <tbody>
                                                    @foreach($Top10 as $T10)
                                                    <tr>
                                                        <td class="font-montserrat all-caps fs-12 w-50">{{$T10->PRODUCTO}}</td>
                                                        <td class="text-right hidden-lg">
                                                            <span class="hint-text small">dewdrops</span>
                                                        </td>
                                                        <td class="text-right b-r b-dashed b-grey w-25">
                                                            <span class="hint-text small">{{$T10->CLAVE}}</span>
                                                        </td>
                                                        <td class="w-25">
                                                            <span class="font-montserrat fs-18">$ {{number_format($T10->IMPORTE_CONSUMO,2)}}</span>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- END Top 10 de productos mas usados -->
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="col-sm-12">
                                    <!-- START WIDGET Operarios-->
                                    <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                                        <div class="card-header top-right">
                                            <div class="card-controls">
                                                <ul>
                                                    <li><a data-toggle="refresh" class="portlet-refresh text-black" href="#"><i
                        class="portlet-icon portlet-icon-refresh"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="padding-25">
                                            <div class="pull-left">
                                                <h2 class="text-success no-margin">Operarios</h2>
                                            </div>
                                            <div class="padding-10">
                                                <div class="pull-right">
                                                    <button class="btn btn-info btn-cons" <i class="fa fa-paste" data-target="#modalFillIn" data-toggle="modal" id="btnFillSizeToggler" style="width:140px; height:30px">
                                                        </i> Agregar operario</button>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="auto-overflow widget-11-2-table">
                                            <table class="table table-condensed table-hover">
                                                <tbody>
                                                    @foreach($Operarios as $O)
                                                    <tr>
                                                        <td class="font-montserrat all-caps fs-12 w-50">{{$O->NOMBRE}}</td>
                                                        <td class="text-right hidden-lg">
                                                            <span class="hint-text small">dewdrops</span>
                                                        </td>
                                                        <td class="text-right b-r b-dashed b-grey w-25" id="tdEstatus{{$O->PERSONA_ID}}">
                                                            <span class="hint-text small">OPERARIO {{$O->ESTATUS}}</span>
                                                        </td>
                                                        <td class="w-25">
                                                            @if($O->ESTATUS == 'ACTIVO')
                                                            <button class="btn btn-danger btn-sm btnCambioEstatus" data-ope="{{$O->PERSONA_ID}}" data-est="{{$O->ACTIVO}}" id="btn{{$O->PERSONA_ID}}" style="width:92px; height:30px">Desactivar</button>
                                                            @else
                                                            <button class="btn btn-complete btn-sm btnCambioEstatus" data-ope="{{$O->PERSONA_ID}}" data-est="{{$O->ACTIVO}}" id="btn{{$O->PERSONA_ID}}" style="width:92px; height:30px">Activar</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="padding-25 mt-auto">
                                            <p class="small no-margin">
                                                <a href="#">

                                            </p>
                                        </div>
                                    </div>
                                    <!-- END operarios -->
                                </div>
                            </div>
                        </div>

                        <hr>
                    </div>
                </div>
            </div>

        </div>
        <!-- /container -->
    </div>
</div>
@stop
@section('js')
<script type="text/javascript" src="{{asset('js/Talleres.Info.js?v=2')}}"></script>
@stop
