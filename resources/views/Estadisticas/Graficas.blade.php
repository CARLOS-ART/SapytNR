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
<br><br>
<!-- START JUMBOTRON -->
<div class="jumbotron" data-pages="parallax">
    <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
      {{csrf_field()}}
        <div class="inner">
            <!-- START BREADCRUMB -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                <li class="breadcrumb-item active">Graficasl</li>
            </ol>
            <!-- END BREADCRUMB -->
            <div class="row">
                <div class="col-xl-7 col-lg-6 ">
                    <!-- START card -->
                    <div class="full-height">
                        <div class="card-body text-center">
                            <img class="image-responsive-height demo-mw-600" src="{{asset('assets/img/estadisticas/inventario.png')}}" alt="">
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
                            <h3>Graficas de productividad</h3>
                            <p></p>
                            <p class="small hint-text m-t-5">Elija un rango de fecha a consultar</p>
                        </div>
                        <!-- END card -->

                        <div class="row">
                          <div class="input-group date col-md-6 p-l-0">
                            <label>FECHA INICIAL</label>
                          </div>
                          <div class="input-group date col-md-6 p-l-0">
                            <label>FECHA FINAL</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="input-group date col-md-5 p-l-0">
                            <input type="text" class="form-control" value="{{date('d/m/Y')}}" type="text" name="txtFecha" id="txtFecha">
                            <div class="input-group-append ">
                              <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                          </div>
                          <div class="input-group date col-md-5 p-l-0">
                            <input type="text" class="form-control" value="{{date('d/m/Y')}}" type="text" name="txtFecha2" id="txtFecha2">
                            <div class="input-group-append ">
                              <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                          </div>
                        </div>

                      <br>
                      <div class="col-md-4">
                          <button class="btn btn-primary btnGraficas" type="button" onclick="MostrarGraficas();">Ver Graficas</button>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
    <!-- END JUMBOTRON -->


    <div class="">
      <script src="{{asset('js/Funciones_Basicas.js')}}"></script>
      <script src="{{asset('js/Estadisticas.js?version=2')}}"></script>
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
    <script src="{{asset('assets/js/form_elements.js')}}" type="text/javascript"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        $("#txtFecha").datepicker();
        $("#txtFecha2").datepicker();
      })
    </script>


      <!-- ECharts -->
      <script src="{{asset('/js/echarts/dist/echarts.min.js')}}"></script>
      <script src="{{asset('/js/echarts/map/js/world.js')}}"></script>

      <!-- Custom Theme Scripts -->
      <script type="text/javascript">

      function init_echarts(Operarios,Reparaciones,CostoRep,Medidas,DataMedida,Condiciones,CondicionItems) {
          if ("undefined" != typeof echarts) {
              console.log("init_echarts");
              var a = {
                  color: ["#26B99A", "#34495E", "#BDC3C7", "#3498DB", "#9B59B6", "#8abb6f", "#759c6a", "#bfd3b7"],
                  title: {
                      itemGap: 8,
                      textStyle: {
                          fontWeight: "normal",
                          color: "#408829"
                      }
                  },
                  dataRange: {
                      color: ["#1f610a", "#97b58d"]
                  },
                  toolbox: {
                      color: ["#408829", "#408829", "#408829", "#408829"]
                  },
                  tooltip: {
                      backgroundColor: "rgba(0,0,0,0.5)",
                      axisPointer: {
                          type: "line",
                          lineStyle: {
                              color: "#408829",
                              type: "dashed"
                          },
                          crossStyle: {
                              color: "#408829"
                          },
                          shadowStyle: {
                              color: "rgba(200,200,200,0.3)"
                          }
                      }
                  },
                  dataZoom: {
                      dataBackgroundColor: "#eee",
                      fillerColor: "rgba(64,136,41,0.2)",
                      handleColor: "#408829"
                  },
                  grid: {
                      borderWidth: 0
                  },
                  categoryAxis: {
                      axisLine: {
                          lineStyle: {
                              color: "#408829"
                          }
                      },
                      splitLine: {
                          lineStyle: {
                              color: ["#eee"]
                          }
                      }
                  },
                  valueAxis: {
                      axisLine: {
                          lineStyle: {
                              color: "#408829"
                          }
                      },
                      splitArea: {
                          show: !0,
                          areaStyle: {
                              color: ["rgba(250,250,250,0.1)", "rgba(200,200,200,0.1)"]
                          }
                      },
                      splitLine: {
                          lineStyle: {
                              color: ["#eee"]
                          }
                      }
                  },
                  timeline: {
                      lineStyle: {
                          color: "#408829"
                      },
                      controlStyle: {
                          normal: {
                              color: "#408829"
                          },
                          emphasis: {
                              color: "#408829"
                          }
                      }
                  },
                  k: {
                      itemStyle: {
                          normal: {
                              color: "#68a54a",
                              color0: "#a9cba2",
                              lineStyle: {
                                  width: 1,
                                  color: "#408829",
                                  color0: "#86b379"
                              }
                          }
                      }
                  },
                  map: {
                      itemStyle: {
                          normal: {
                              areaStyle: {
                                  color: "#ddd"
                              },
                              label: {
                                  textStyle: {
                                      color: "#c12e34"
                                  }
                              }
                          },
                          emphasis: {
                              areaStyle: {
                                  color: "#99d2dd"
                              },
                              label: {
                                  textStyle: {
                                      color: "#c12e34"
                                  }
                              }
                          }
                      }
                  },
                  force: {
                      itemStyle: {
                          normal: {
                              linkStyle: {
                                  strokeColor: "#408829"
                              }
                          }
                      }
                  },
                  chord: {
                      padding: 4,
                      itemStyle: {
                          normal: {
                              lineStyle: {
                                  width: 1,
                                  color: "rgba(128, 128, 128, 0.5)"
                              },
                              chordStyle: {
                                  lineStyle: {
                                      width: 1,
                                      color: "rgba(128, 128, 128, 0.5)"
                                  }
                              }
                          },
                          emphasis: {
                              lineStyle: {
                                  width: 1,
                                  color: "rgba(128, 128, 128, 0.5)"
                              },
                              chordStyle: {
                                  lineStyle: {
                                      width: 1,
                                      color: "rgba(128, 128, 128, 0.5)"
                                  }
                              }
                          }
                      }
                  },
                  gauge: {
                      startAngle: 225,
                      endAngle: -45,
                      axisLine: {
                          show: !0,
                          lineStyle: {
                              color: [
                                  [.2, "#86b379"],
                                  [.8, "#68a54a"],
                                  [1, "#408829"]
                              ],
                              width: 8
                          }
                      },
                      axisTick: {
                          splitNumber: 10,
                          length: 12,
                          lineStyle: {
                              color: "auto"
                          }
                      },
                      axisLabel: {
                          textStyle: {
                              color: "auto"
                          }
                      },
                      splitLine: {
                          length: 18,
                          lineStyle: {
                              color: "auto"
                          }
                      },
                      pointer: {
                          length: "90%",
                          color: "auto"
                      },
                      title: {
                          textStyle: {
                              color: "#333"
                          }
                      },
                      detail: {
                          textStyle: {
                              color: "auto"
                          }
                      }
                  },
                  textStyle: {
                      fontFamily: "Arial, Verdana, sans-serif"
                  }
              };
              if ($("#mainb").length) {
                  var b = echarts.init(document.getElementById("mainb"), a);
                  b.setOption({
                      title: {
                          text: "Consumo Operarios",
                          subtext: "Piezas reparadas y costos"
                      },
                      tooltip: {
                          trigger: "axis"
                      },
                      legend: {
                          data: ["Reparaciones", "Costo reparacion"]
                      },
                      toolbox: {
                          show: !1
                      },
                      calculable: !1,
                      xAxis: [{
                          type: "category",
                          data: Operarios
                      }],
                      yAxis: [{
                          type: "value"
                      }],
                      series: [{
                          name: "Reparaciones",
                          type: "bar",
                          data: Reparaciones,
                          markPoint: {
                              data: [{
                                  type: "max",
                                  name: "???"
                              }, {
                                  type: "min",
                                  name: "???"
                              }]
                          },
                          markLine: {
                              data: [{
                                  type: "average",
                                  name: "???"
                              }]
                          }
                      }, {
                          name: "Costo reparacion",
                          type: "bar",
                          data: CostoRep,
                          markPoint: {
                              data: [{
                                  type: "max",
                                  name: "???"
                              }, {
                                  type: "min",
                                  name: "???"
                              } ]
                          },
                          markLine: {
                              data: [{
                                  type: "average",
                                  name: "???"
                              }]
                          }
                      }]
                  })
              }
              if ($("#echart_sonar").length) {
                  var c = echarts.init(document.getElementById("echart_sonar"), a);
                  c.setOption({
                      title: {
                          text: "Budget vs spending",
                          subtext: "Subtitle"
                      },
                      tooltip: {
                          trigger: "item"
                      },
                      legend: {
                          orient: "vertical",
                          x: "right",
                          y: "bottom",
                          data: ["Allocated Budget", "Actual Spending"]
                      },
                      toolbox: {
                          show: !0,
                          feature: {
                              restore: {
                                  show: !0,
                                  title: "Restore"
                              },
                              saveAsImage: {
                                  show: !0,
                                  title: "Save Image"
                              }
                          }
                      },
                      polar: [{
                          indicator: [{
                              text: "Sales",
                              max: 6e3
                          }, {
                              text: "Administration",
                              max: 16e3
                          }, {
                              text: "Information Techology",
                              max: 3e4
                          }, {
                              text: "Customer Support",
                              max: 38e3
                          }, {
                              text: "Development",
                              max: 52e3
                          }, {
                              text: "Marketing",
                              max: 25e3
                          }]
                      }],
                      calculable: !0,
                      series: [{
                          name: "Budget vs spending",
                          type: "radar",
                          data: [{
                              value: [4300, 1e4, 28e3, 35e3, 5e4, 19e3],
                              name: "Allocated Budget"
                          }, {
                              value: [5e3, 14e3, 28e3, 31e3, 42e3, 21e3],
                              name: "Actual Spending"
                          }]
                      }]
                  })
              }


              if ($("#echart_line").length) {
                  var f = echarts.init(document.getElementById("echart_line"), a);
                  f.setOption({
                      title: {
                          text: "Ordenes",
                          subtext: "Subtitle"
                      },
                      tooltip: {
                          trigger: "axis"
                      },
                      legend: {
                          x: 220,
                          y: 40,
                          data: ["En espera", "Surtiendo", "Entregados"]
                      },
                      toolbox: {
                          show: !0,
                          feature: {
                              magicType: {
                                  show: !0,
                                  title: {
                                      line: "Line",
                                      bar: "Bar",
                                      stack: "Stack",
                                      tiled: "Tiled"
                                  },
                                  type: ["line", "bar", "stack", "tiled"]
                              },
                              restore: {
                                  show: !0,
                                  title: "Restore"
                              },
                              saveAsImage: {
                                  show: !0,
                                  title: "Save Image"
                              }
                          }
                      },
                      calculable: !0,
                      xAxis: [{
                          type: "category",
                          boundaryGap: !1,
                          data: ["Lun", "Mar", "Mier", "Jue", "Vie", "Sab", "Dom"]
                      }],
                      yAxis: [{
                          type: "value"
                      }],
                      series: [{
                          name: "Entregados",
                          type: "line",
                          smooth: !0,
                          itemStyle: {
                              normal: {
                                  areaStyle: {
                                      type: "default"
                                  }
                              }
                          },
                          data: [10, 12, 21, 54, 260, 830, 710]
                      }, {
                          name: "Surtiendo",
                          type: "line",
                          smooth: !0,
                          itemStyle: {
                              normal: {
                                  areaStyle: {
                                      type: "default"
                                  }
                              }
                          },
                          data: [30, 182, 434, 791, 390, 30, 10]
                      }, {
                          name: "En espera",
                          type: "line",
                          smooth: !0,
                          itemStyle: {
                              normal: {
                                  areaStyle: {
                                      type: "default"
                                  }
                              }
                          },
                          data: [1320, 1132, 601, 234, 120, 90, 20]
                      }]
                  })
              }
              if ($("#echart_scatter").length) {
                  var g = echarts.init(document.getElementById("echart_scatter"), a);
                  g.setOption({
                      title: {
                          text: "Scatter Graph",
                          subtext: "Heinz  2003"
                      },
                      tooltip: {
                          trigger: "axis",
                          showDelay: 0,
                          axisPointer: {
                              type: "cross",
                              lineStyle: {
                                  type: "dashed",
                                  width: 1
                              }
                          }
                      },
                      legend: {
                          data: ["Data2", "Data1"]
                      },
                      toolbox: {
                          show: !0,
                          feature: {
                              saveAsImage: {
                                  show: !0,
                                  title: "Save Image"
                              }
                          }
                      },
                      xAxis: [{
                          type: "value",
                          scale: !0,
                          axisLabel: {
                              formatter: "{value} cm"
                          }
                      }],
                      yAxis: [{
                          type: "value",
                          scale: !0,
                          axisLabel: {
                              formatter: "{value} kg"
                          }
                      }],
                      series: [{
                          name: "Data1",
                          type: "scatter",
                          tooltip: {
                              trigger: "item",
                              formatter: function(a) {
                                  return a.value.length > 1 ? a.seriesName + " :<br/>" + a.value[0] + "cm " + a.value[1] + "kg " : a.seriesName + " :<br/>" + a.name + " : " + a.value + "kg "
                              }
                          },
                          data: [
                              [161.2, 51.6],
                              [167.5, 59],
                              [159.5, 49.2],
                              [157, 63],
                              [155.8, 53.6],
                              [170, 59],
                              [159.1, 47.6],
                              [166, 69.8],
                              [176.2, 66.8],
                              [160.2, 75.2],
                              [172.5, 55.2],
                              [170.9, 54.2],
                              [172.9, 62.5],


                              [161.2, 54.8],
                              [155, 45.9],
                              [170, 70.6],

                              [169.4, 63.4],
                              [167.8, 59],
                              [159.5, 47.6],
                              [167.6, 63],
                              [161.2, 55.2],
                              [160, 45],
                              [163.2, 54],
                              [162.2, 50.2],
                              [161.3, 60.2],
                              [149.5, 44.8],
                              [157.5, 58.8],
                              [163.2, 56.4],
                              [172.7, 62],
                              [155, 49.2],
                              [156.5, 67.2],
                              [164, 53.8],
                              [160.9, 54.4],
                              [162.8, 58],
                              [167, 59.8],
                              [160, 54.8],
                              [160, 43.2],
                              [168.9, 60.5],
                              [158.2, 46.4],
                              [156, 64.4],
                              [160, 48.8],
                              [167.1, 62.2],
                              [158, 55.5],
                              [167.6, 57.8],

                              [175.3, 63.6],
                              [159.4, 53.2],
                              [160, 53.4],
                              [170.2, 55],
                              [162.6, 70.5],
                              [167.6, 54.5],
                              [162.6, 54.5],
                              [160.7, 55.9],
                              [160, 59],
                              [157.5, 63.6],
                              [162.6, 54.5],
                              [152.4, 47.3],
                              [170.2, 67.7],
                              [165.1, 80.9],
                              [172.7, 70.5],
                              [165.1, 60.9],
                              [170.2, 63.6],

                              [163.8, 67.3]
                          ],
                          markPoint: {
                              data: [{
                                  type: "max",
                                  name: "Max"
                              }, {
                                  type: "min",
                                  name: "Min"
                              }]
                          },
                          markLine: {
                              data: [{
                                  type: "average",
                                  name: "Mean"
                              }]
                          }
                      }, {
                          name: "Data2",
                          type: "scatter",
                          tooltip: {
                              trigger: "item",
                              formatter: function(a) {
                                  return a.value.length > 1 ? a.seriesName + " :<br/>" + a.value[0] + "cm " + a.value[1] + "kg " : a.seriesName + " :<br/>" + a.name + " : " + a.value + "kg "
                              }
                          },
                          data: [
                              [174, 65.6],
                              [175.3, 71.8],
                              [193.5, 80.7],
                              [186.5, 72.6],
                              [187.2, 78.8],
                              [181.5, 74.8],
                              [184, 86.4],
                              [184.5, 78.4],
                              [175, 62],
                              [184, 81.6],
                              [180, 76.6],
                              [177.8, 83.6],
                              [192, 90],
                              [176, 74.6],
                              [174, 71],
                              [184, 79.6],
                              [192.7, 93.8],
                              [171.5, 70],
                              [173, 72.4],
                              [176, 85.9],
                              [176, 78.8],
                              [180.5, 77.8],
                              [172.7, 66.2],
                              [176, 86.4],
                              [173.5, 81.8],
                              [178, 89.6],
                              [180.3, 82.8],
                              [180.3, 76.4],
                              [164.5, 63.2],
                              [173, 60.9],
                              [183.5, 74.8],
                              [175.5, 70],
                              [188, 72.4],
                              [189.2, 84.1],
                              [172.8, 69.1],
                              [170, 59.5],
                              [182, 67.2],
                              [170, 61.3],
                              [177.8, 68.6],
                              [184.2, 80.1],
                              [186.7, 87.8],
                              [171.4, 84.7],
                              [172.7, 73.4],
                              [175.3, 72.1],
                              [180.3, 82.6],
                              [182.9, 88.7],
                              [188, 84.1],
                              [177.2, 94.1],
                              [172.1, 74.9],
                              [167, 59.1],
                              [169.5, 75.6],
                              [174, 86.2],
                              [172.7, 75.3],
                              [182.2, 87.1],
                              [164.1, 55.2],
                              [163, 57],
                              [171.5, 61.4],
                              [184.2, 76.8],
                              [174, 86.8],
                              [174, 72.2],
                              [177, 71.6],
                              [186, 84.8],
                              [167, 68.2],
                              [171.8, 66.1],
                              [182, 72],
                              [167, 64.6],
                              [177.8, 74.8],
                              [164.5, 70],
                              [192, 101.6],
                              [175.5, 63.2],
                              [171.2, 79.1],
                              [181.6, 78.9],
                              [167.4, 67.7],
                              [181.1, 66],
                              [177, 68.2],
                              [174.5, 63.9],
                              [177.5, 72],
                              [170.5, 56.8],
                              [182.4, 74.5],
                              [197.1, 90.9],
                              [180.1, 93],
                              [175.5, 80.9],
                              [180.6, 72.7],

                              [188, 80.5],
                              [188, 82.7],
                              [175.3, 86.4],
                              [170.5, 67.7],
                              [179.1, 92.7],
                              [177.8, 93.6],
                              [175.3, 70.9],
                              [182.9, 75],
                              [170.8, 93.2],
                              [188, 93.2],
                              [180.3, 77.7],
                              [177.8, 61.4],
                              [185.4, 94.1],
                              [168.9, 75],
                              [185.4, 83.6],
                              [180.3, 85.5],
                              [174, 73.9],
                              [167.6, 66.8],
                              [182.9, 87.3],
                              [160, 72.3],
                              [180.3, 88.6],
                              [167.6, 75.5],
                              [186.7, 101.4],
                              [175.3, 91.1],
                              [175.3, 67.3],
                              [175.9, 77.7],
                              [175.3, 81.8],
                              [179.1, 75.5],
                              [181.6, 84.5],
                              [177.8, 76.6],
                              [182.9, 85],
                              [177.8, 102.5],
                              [184.2, 77.3],
                              [179.1, 71.8],
                              [176.5, 87.9],
                              [188, 94.3],
                              [174, 70.9],
                              [167.6, 64.5],
                              [170.2, 77.3],
                              [167.6, 72.3],
                              [188, 87.3],
                              [174, 80],
                              [176.5, 82.3],
                              [180.3, 73.6],
                              [167.6, 74.1],
                              [188, 85.9],
                              [180.3, 73.2],
                              [167.6, 76.3],
                              [183, 65.9],
                              [183, 90.9],
                              [179.1, 89.1],
                              [170.2, 62.3],
                              [177.8, 82.7],
                              [179.1, 79.1],
                              [190.5, 98.2],
                              [177.8, 84.1],
                              [180.3, 83.2],
                              [180.3, 83.2]
                          ],
                          markPoint: {
                              data: [{
                                  type: "max",
                                  name: "Max"
                              }, {
                                  type: "min",
                                  name: "Min"
                              }]
                          },
                          markLine: {
                              data: [{
                                  type: "average",
                                  name: "Mean"
                              }]
                          }
                      }]
                  })
              }
              if ($("#echart_bar_horizontal").length) {
                  var b = echarts.init(document.getElementById("echart_bar_horizontal"), a);
                  b.setOption({
                      title: {
                          text: "Producción por color",
                          subtext: "Numero de reparaciones por tipo de color"
                      },
                      tooltip: {
                          trigger: "axis"
                      },
                      legend: {
                          x: 100,
                          data: ["2015", "2016"] //TipoColor
                      },
                      toolbox: {
                          show: !0,
                          feature: {
                              saveAsImage: {
                                  show: !0,
                                  title: "Guardar"
                              }
                          }
                      },
                      calculable: !0,
                      xAxis: [{
                          type: "value",
                          boundaryGap: [0, .01]
                      }],
                      yAxis: [{
                          type: "category",
                          data: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"] // Personal
                      }],
                      series: [{
                          name: "2015",
                          type: "bar",
                          data: [18203, 23489, 29034, 104970, 131744, 630230]
                      }, {
                          name: "2016",
                          type: "bar",
                          data: [19325, 23438, 31e3, 121594, 134141, 681807]
                      }]
                  })
              }
              if ($("#echart_pie2").length) {
                  var h = echarts.init(document.getElementById("echart_pie2"), a);
                  h.setOption({
                      tooltip: {
                          trigger: "item",
                          formatter: "{a} <br/>{b} : {c} ({d}%)"
                      },
                      legend: {
                          x: "center",
                          y: "bottom",
                          data: Condiciones
                      },
                      toolbox: {
                          show: !0,
                          feature: {
                              magicType: {
                                  show: !0,
                                  type: ["pie", "funnel"]
                              },
                              restore: {
                                  show: !0,
                                  title: "Restore"
                              },
                              saveAsImage: {
                                  show: !0,
                                  title: "Save Image"
                              }
                          }
                      },
                      calculable: !0,
                      series: [{
                          name: "Area Mode",
                          type: "pie",
                          radius: [25, 90],
                          center: ["50%", 170],
                          roseType: "area",
                          x: "50%",
                          max: 40,
                          sort: "ascending",
                          data: CondicionItems
                      }]
                  })
              }

              if ($("#echart_pie").length) {
                  var j = echarts.init(document.getElementById("echart_pie"), a);
    console.log(Medidas);
                  j.setOption({
                      tooltip: {
                          trigger: "item",
                          formatter: "{a} <br/>{b} : {c} ({d}%)"
                      },
                      legend: {
                          x: "center",
                          y: "bottom",
                          data: Medidas
                      },
                      toolbox: {
                          show: !0,
                          feature: {
                              magicType: {
                                  show: !0,
                                  type: ["pie", "funnel"],
                                  option: {
                                      funnel: {
                                          x: "25%",
                                          width: "50%",
                                          funnelAlign: "left",
                                          max: 1548
                                      }
                                  }
                              },
                              restore: {
                                  show: !0,
                                  title: "Reset"
                              },
                              saveAsImage: {
                                  show: !0,
                                  title: "Guardar grafica"
                              }
                          }
                      },
                      calculable: !0,
                      series: [{
                          name: "?",
                          type: "pie",
                          radius: "55%",
                          center: ["50%", "48%"],
                          data: DataMedida
                      }]
                  });
                  var k = {
                          normal: {
                              label: {
                                  show: !1
                              },
                              labelLine: {
                                  show: !1
                              }
                          }
                      },
                      l = {
                          normal: {
                              color: "rgba(0,0,0,0)",
                              label: {
                                  show: !1
                              },
                              labelLine: {
                                  show: !1
                              }
                          },
                          emphasis: {
                              color: "rgba(0,0,0,0)"
                          }
                      }
              }


          }
      }

      $(".btnGraficas").click(function(){
        var _token = $('input[name="_token"]').val();
        var Fe1 = $("#txtFecha").val();
        var Fe2 = $("#txtFecha2").val();

        $.ajax({
          url:'/Estadisticas/Graficas/GraficaConsumoOperarios',
          type:'post',
          data:{_token:_token,Fe1:Fe1,Fe2:Fe2},
          success:function(data){
            init_echarts(data.Operarios,data.Reparaciones,data.Costo,JSON.stringify(data.Medida),data.ItemsMedida,data.Condiciones,data.CondicionItems);
            $('#TabConsumoOperarios > tbody:last-child').append(data.Filas);
          }
        });

      })

      </script>
