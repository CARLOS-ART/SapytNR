@extends('main_template')

@section('handsontable')
<script src="{{asset('handsontable/jquery.min.js')}}"></script>
<script src="{{asset('handsontable/jquery.handsontable.full2.js')}}"></script>
<link rel="stylesheet" media="screen" href="{{asset('handsontable/jquery.handsontable.full.css')}}">
@stop

@section('WorkArea')
{{csrf_field()}}
<div class="content">
  <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-3" id="dVehiculos">
      <div class="card card-default">
        <div class="card-header  separator">
          <div class="card-title">Piezas a reparar
          </div>
        </div>
        <div class="card-body">
          <h3>
        <span class="semi-bold">Parts</span> Tool</h3>
        <div class="form-group form-group-default form-group-default-select2 required">
          <label class="">TAMAÑO DEL Vehículo</label>
          <select class="full-width" data-placeholder="Selecione Tamaño de Vehiculo" onchange="ShowMap();" data-init-plugin="select2" name="cmbVehiculo" id="cmbVehiculo">
            @foreach($Tam as $T)
            <option value="{{$T->MEDIDA_ID}}" @if($T->MEDIDA_ID == $Medida) selected @endif>{{$T->MEDIDA}} </option>
            @endforeach

          </select>
        </div>

        <div id="example1" style="width:100%"></div>

        <hr>
        <button type="button" class="btn btn-primary" name="btnGuardar" id="btnGuardar" data-pos="0" data-pieza="0">Guardar</button>

          <p>*Pase el mouse sobre la pieza desea, despues haga click sobre está misma para que sea agregada a la lista de piezas a reparar<br>*Para eliminar una pieza, haga click derecho sobre la pieza deseada y seleccione la opción "Eliminar"</p>
        </div>
      </div>


    </div>


  <div class="col-md-12 col-sm-12 col-lg-9 MapCars" id="Map1" style="display:none;">
    <img src="/assets/img/MapCars/10.png" usemap="#image-map" class="map">
    <map name="image-map">
        <area target="" data-target="#modalSlideUpSmall" data-toggle="modal" onclick="PiezaInfo('Costado',4);" alt="Costado" title="Costado" href="#" coords="421,268,442,285,445,275,446,261,451,250,458,241,467,236,476,230,485,230,493,230,502,231,510,235,517,230,524,222,527,217,521,213,515,210,510,206,519,205,506,200,507,193,513,187,513,178,502,169,492,160,485,156,476,151,467,149,462,151,466,156,471,163,471,169,470,175,461,179,467,186,469,193,469,200,469,207,465,215,452,225,433,252,427,258,424,261" shape="poly">
        <area target="" data-target="#modalSlideUpSmall" data-toggle="modal" alt="Puerta trasera" onclick="PiezaInfo('Puerta trasera',2);" alt="Puerta trasera" title="Puerta trasera" href="#" coords="353,274,365,274,377,274,386,274,398,273,407,274,414,271,419,266,441,242,451,224,465,213,469,197,465,186,460,178,450,180,455,150,438,146,417,144,397,143,365,143,355,186,349,215,350,254" shape="poly">
        <area target="" data-target="#modalSlideUpSmall" data-toggle="modal" alt="Puerta delantera" onclick="PiezaInfo('Puerta delantera',1);" title="Puerta delantera" href="#" coords="232,280,351,276,349,254,348,215,353,192,364,141,328,143,296,150,259,164,228,180,223,197,220,227,222,247" shape="poly">
        <area target="" data-target="#modalSlideUpSmall" data-toggle="modal" alt="Salpicadera" onclick="PiezaInfo('Salpicadera',3);" alt="Salpicadera" title="Salpicadera" href="#" coords="217,278,231,278,223,252,220,229,223,196,207,196,201,195,212,187,202,185,180,191,157,201,162,205,137,216,136,223,149,237,167,230,184,232,202,241,213,255" shape="poly">
        <area target="" onclick="AgregarPieza(6)" alt="Facia delantera" title="Facia delantera" href="#" coords="646,223,643,237,645,266,648,279,653,288,675,289,743,289,840,288,847,267,847,253,847,227,838,227,828,232,806,233,803,235,803,248,783,273,706,272,689,253,685,233,664,233,655,229" shape="poly">
        <area target="" onclick="AgregarPieza(7)" alt="Parilla" title="Parilla" href="#" coords="687,230,688,244,703,273,786,274,800,252,802,235" shape="poly">
        <area target="" onclick="AgregarPieza(5)" alt="Cofre" title="Cofre" href="#" coords="116,574,150,591,167,595,195,591,184,565,179,534,177,475,186,439,193,415,164,413,139,420,116,432,102,448,94,482,95,519,99,551" shape="poly">
        <area target="" onclick="AgregarPieza(10)" alt="Toldo" title="Toldo" href="#" coords="299,572,374,567,478,567,476,535,477,474,481,442,372,439,298,436,290,474,285,481,285,527,291,535" shape="poly">
        <area target="" onclick="AgregarPieza(11)" alt="Espejo" title="Espejo" href="#" coords="246,602,252,615,262,625,271,624,265,602,254,591" shape="poly">
        <area target="" onclick="AgregarPieza(8)" alt="Tapa cajuela" title="Tapa cajuela" href="#" coords="666,497,706,509,788,508,821,498,815,482,821,469,836,461,829,452,817,421,770,416,717,416,672,421,660,448,649,460,668,469,677,482" shape="poly">
        <area target="" onclick="AgregarPieza(9)" alt="Facia trasera" title="Facia trasera" href="#" coords="639,487,635,515,636,545,639,563,662,565,717,569,776,568,830,566,850,560,855,536,857,511,848,488,790,509,706,510" shape="poly">
        <area target=""  alt="Rin delantero" title="Rin delantero" href="#" coords="173,273,28" shape="circle">
        <area target=""  alt="Rin trasera" title="Rin trasera" href="#" coords="485,272,30" shape="circle">
        <area target="" onclick="AgregarPieza(5)" alt="Cofre F" title="Cofre F" href="#" coords="653,201,687,229,800,230,833,203,829,184,779,185,714,184,659,184" shape="poly">
    </map>
  </div>

  <div class="col-md-12 col-sm-12 col-lg-9 MapCars" id="Map2" style="display:none;">
    <img src="/assets/img/MapCars/20.png" usemap="#image-map2" class="map">
    <map name="image-map2">
        <area target="" data-target="#modalSlideUpSmall" data-toggle="modal" alt="Salpicadera" onclick="PiezaInfo('Salpicadera',3);" alt="Salipicadera" title="Salipicadera" href="#" coords="52,145,46,157,71,157,83,145,95,139,111,137,125,141,136,149,143,158,149,170,149,185,161,185,155,165,150,137,151,117,155,111,163,107,157,99,151,105,139,107,129,117,104,121,71,127,59,136" shape="poly">
        <area target="" data-target="#modalSlideUpSmall" data-toggle="modal" alt="Puerta delantera" onclick="PiezaInfo('Puerta delantera',1);" alt="Puerta delantera" title="Puerta delantera" href="#" coords="161,186,272,184,269,152,272,121,274,111,276,108,293,66,269,68,240,70,201,84,176,96,162,104,155,111,151,116,151,140" shape="poly">
        <area target="" data-target="#modalSlideUpSmall" data-toggle="modal" alt="Puerta trasera" onclick="PiezaInfo('Puerta trasera',2);" alt="Puerta trasera" title="Puerta trasera" href="#" coords="273,183,344,182,353,177,376,139,392,109,388,102,393,87,389,80,371,74,338,69,294,66,278,105,272,133" shape="poly">
        <area target="" data-target="#modalSlideUpSmall" data-toggle="modal" onclick="PiezaInfo('Costado',4);" alt="Costado" title="Costado" href="#" coords="345,182,364,191,369,163,384,145,400,139,412,138,427,143,435,149,457,117,461,112,453,100,446,97,391,75,387,81,391,85,388,99,391,107,382,126,368,151,355,174" shape="poly">
        <area target="" onclick="AgregarPieza(6)" alt="Facia delantera" title="Facia delantera" href="#" coords="582,143,577,151,583,194,599,190,749,191,763,193,770,153,761,144,729,153,731,146,721,145,715,161,708,169,643,169,633,164,625,142,618,143,621,151" shape="poly">
        <area target="" onclick="AgregarPieza(7)" alt="Parrilla" title="Parrilla" href="#" coords="623,140,631,164,644,168,704,168,713,164,725,142,696,139,688,143,662,142,653,140" shape="poly">
        <area target="" onclick="AgregarPieza(5)" alt="Cofre" title="Cofre" href="#" coords="29,461,57,478,80,489,127,493,143,489,143,481,127,448,122,417,123,387,129,359,143,335,143,327,128,323,79,325,62,333,29,353,21,388,20,424" shape="poly">
        <area target="" onclick="AgregarPieza(10)" alt="Toldo" title="Toldo" href="#" coords="229,467,291,464,386,466,389,431,389,381,385,350,293,353,229,347,223,390,223,432" shape="poly">
        <area target="" onclick="AgregarPieza(11)" alt="Espejo D" title="Espejo D" href="#" coords="182,321,195,322,207,300,197,301,187,309" shape="poly">
        <area target="" onclick="AgregarPieza('11I')"alt="Espejo I" title="Espejo I" href="#" coords="199,494,205,514,192,510,185,501,180,493" shape="poly">
        <area target="" onclick="AgregarPieza(8)" alt="Tapa Cajuela" title="Tapa Cajuela" href="#" coords="593,365,615,377,629,402,716,403,728,377,751,365,736,351,669,351,606,354" shape="poly">
        <area target="" onclick="AgregarPieza(9)" alt="Facia trasera" title="Facia trasera" href="#" coords="586,378,579,402,581,428,590,455,758,452,765,427,765,401,759,376,757,388,719,392,715,402,628,400,623,392,590,387" shape="poly">
        <area target="" alt="Rin delantero" title="Rin delantero" href="#" coords="107,181,27" shape="circle">
        <area target="" alt="Rin Trasero" title="Rin Trasero" href="#" coords="409,181,27" shape="circle">
        <area target="" onclick="AgregarPieza(8)" alt="Tapa cajuela A" title="Tapa cajuela A" href="#" coords="447,470,452,474,459,483,485,479,493,472,501,457,507,451,507,364,502,360,493,342,487,334,459,330,454,340,446,344,453,383,453,430,447,470" shape="poly">
    	  <area target="" onclick="AgregarPieza(5)"alt="Cofre F" title="Cofre F" href="#" coords="590,123,614,143,623,143,632,140,719,140,721,144,727,142,757,125,760,116,754,106,599,105,589,111,587,119" shape="poly">
    </map>
  </div>

  <div class="col-md-12 col-sm-12 col-lg-9 MapCars" id="Map3" style="display:none;">
    <img src="/assets/img/MapCars/30.png" usemap="#image-map3" class="map">
    <map name="image-map3">
       <area target="" data-target="#modalSlideUpSmall" data-toggle="modal" alt="Puerta delantera" onclick="PiezaInfo('Puerta delantera',1);" alt="Puerta deltantera" title="Puerta deltantera" href="#" coords="176,144,176,153,175,165,174,176,175,186,178,199,181,209,185,219,200,220,251,219,294,219,294,210,294,198,294,182,293,168,295,153,299,141,303,116,307,98,297,97,275,96,257,98,234,105,213,114,192,124,185,129" shape="poly">
       <area target="" data-target="#modalSlideUpSmall" data-toggle="modal" alt="Puerta trasera" onclick="PiezaInfo('Puerta trasera',2);" alt="Puerta trasera" title="Puerta trasera" href="#" coords="295,219,306,219,344,219,355,213,366,203,381,184,396,164,400,150,397,138,390,133,391,110,392,96,352,96,321,95,308,95,303,112,298,139,293,154,294,201" shape="poly">
       <area target="" data-target="#modalSlideUpSmall" data-toggle="modal" alt="Salpicadera" onclick="PiezaInfo('Salpicadera',3);" alt="Salpicadera" title="Salpicadera" href="#" coords="170,136,163,133,147,138,135,144,107,150,83,166,101,182,114,172,127,171,144,172,158,177,168,189,171,218,180,216,173,183,174,154,176,144,164,144" shape="poly">
       <area target="" alt="Estribo" title="Estribo" href="#" coords="171,215,181,214,185,221,347,219,361,211,375,210,373,227,173,230" shape="poly">
       <area target="" data-target="#modalSlideUpSmall" data-toggle="modal" onclick="PiezaInfo('Costado',4);" alt="Costado" title="Costado" href="#" coords="395,134,412,126,413,115,406,100,429,96,456,126,450,131,441,136,452,139,465,139,471,146,462,151,450,163,439,178,432,174,415,173,402,175,391,180,383,190,375,211,358,211,368,201,374,191,383,180,391,169,399,156,397,142" shape="poly">
       <area target="" onclick="AgregarPieza(5)" alt="Cofre" title="Cofre" href="#" coords="176,351,164,349,105,349,94,353,77,367,63,386,55,426,58,464,65,488,79,508,104,519,148,519,166,519,175,514,162,508,153,494,147,475,143,449,143,421,146,395,152,373,159,359" shape="poly">
       <area target="" onclick="AgregarPieza(10)" alt="Toldo" title="Toldo" href="#" coords="245,370,241,410,240,456,247,499,439,492,440,438,438,373" shape="poly">
       <area target="" onclick="AgregarPieza(8)" alt="Tapa Cajuela" title="Tapa Cajuela" href="#" coords="593,423,593,460,597,472,754,471,759,461,758,422,738,421,733,416,749,400,763,397,758,378,744,356,724,349,628,346,610,351,592,378,586,394,599,399,612,410,615,421,603,422" shape="poly">
       <area target="" onclick="AgregarPieza(6)" alt="Fascia Delantera" title="Fascia Delantera" href="#" coords="577,135,568,145,570,175,572,192,576,211,600,212,611,221,612,210,752,211,753,219,784,213,791,194,795,172,796,148,787,137,773,141,762,145,747,147,753,134,741,135,735,150,720,159,643,161,633,150,625,134,612,135,619,150,605,146,595,142,584,139" shape="poly">
       <area target="" onclick="AgregarPieza(7)" alt="Parrilla" title="Parrilla" href="#" coords="627,133,656,131,705,131,719,131,738,133,738,141,727,156,681,157,642,158,631,147,625,140" shape="poly">
       <area target="" onclick="AgregarPieza(5)" alt="Cofre" title="Cofre" href="#" coords="579,118,610,134,625,134,647,131,675,130,726,131,740,134,753,134,784,119,780,104,774,98,685,98,627,100,593,100,583,104" shape="poly">
       <area target="" onclick="AgregarPieza(9)" alt="Fascia Trasera" title="Fascia Trasera" href="#" coords="571,422,566,439,566,458,567,482,575,497,592,507,606,516,758,515,782,489,786,463,785,439,780,422,759,421,759,442,759,464,753,472,597,471,593,459,593,422" shape="poly">
       <area target="" alt="Rin" title="Rin" href="#" coords="131,218,37" shape="circle">
       <area target="" alt="Rin" title="Rin" href="#" coords="418,221,36" shape="circle">
       <area target="" onclick="AgregarPieza(11)" alt="Espejo Izquierdo" title="Espejo Izquierdo" href="#" coords="195,521,219,547" shape="rect">
       <area target="" onclick="AgregarPieza('11I')" alt="Espejo Derecho" title="Espejo Derecho" href="#" coords="193,345,221,320" shape="rect">
    </map>
  </div>

  <div class="col-md-12 col-sm-12 col-lg-9 MapCars" id="Map4" style="display:none;">
    <img src="/assets/img/MapCars/40.png" usemap="#image-map4" class="map">
    <map name="image-map4">
      <area target="" alt="Rin" title="Rin" href="#" coords="116,217,31" shape="circle">
          <area target="" alt="Rin" title="Rin" href="#" coords="420,222,32" shape="circle">
          <area target="" onclick="AgregarPieza(10)" alt="Toldo" title="Toldo" href="#" coords="187,370,183,374,178,439,183,504,496,509,497,371" shape="poly">
          <area target="" onclick="AgregarPieza(5)" alt="Cofre" title="Cofre" href="#" coords="133,356,87,360,54,381,44,421,44,458,52,497,82,516,138,522,126,513,116,474,116,438,118,403,122,381" shape="poly">
          <area target="" onclick="AgregarPieza(11)" alt="Espejo Derecho" title="Espejo Derecho" href="#" coords="152,353,167,338" shape="rect">
          <area target="" onclick="AgregarPieza('11I')" alt="Espejo Izquierdo" title="Espejo Izquierdo" href="#" coords="154,526,166,543" shape="rect">
          <area target="" alt="Puerta A" title="Puerta A" href="#" coords="685,317,685,503,618,505,608,496,606,482,606,429,605,409,612,357,616,334,622,319" shape="poly">
          <area target="" alt="Puerta B" title="Puerta B" href="#" coords="686,316,685,504,748,504,759,501,764,489,764,478,764,430,766,417,761,378,756,342,747,318" shape="poly">
          <area target="" onclick="AgregarPieza(9)" alt="Fascia Trasera" title="Fascia Trasera" href="#" coords="596,482,595,496,600,511,613,518,621,517,623,524,749,523,750,515,763,516,770,510,776,488,773,480,763,479,763,488,762,496,757,502,713,504,631,504,616,502,609,498,606,482" shape="poly">
          <area target="" data-target="#modalSlideUpSmall" data-toggle="modal" alt="Puerta delantera" onclick="PiezaInfo('Puerta delantera',1);" alt="Puerta Delantera" title="Puerta Delantera" href="#" coords="137,135,137,169,150,181,158,199,162,216,218,216,219,200,222,181,222,161,226,153,230,67,211,68,185,70,165,83,152,96,142,108,138,121" shape="poly">
          <area target="" data-target="#modalSlideUpSmall" data-toggle="modal" alt="Puerta trasera" onclick="PiezaInfo('Puerta trasera',2);" alt="Puerta Trasera" title="Puerta Trasera" href="#" coords="235,40,234,214,361,215,360,197,360,181,359,132,358,38" shape="poly">
          <area target="" data-target="#modalSlideUpSmall" data-toggle="modal" onclick="PiezaInfo('Costado',4);" alt="Costado" title="Costado" href="#" coords="360,131,362,211,379,215,387,201,397,186,409,179,429,178,446,186,456,203,460,218,492,213,494,198,500,182,500,150,500,128" shape="poly">
          <area target="" onclick="AgregarPieza(5)" alt="Cofre" title="Cofre" href="#" coords="613,129,608,142,608,157,633,168,638,165,660,164,712,164,740,166,754,163,768,159,766,137,761,130" shape="poly">
          <area target="" onclick="AgregarPieza(7)" alt="Parrilla" title="Parrilla" href="#" coords="631,169,640,195,689,205,739,197,746,167,689,164" shape="poly">
          <area target="" onclick="AgregarPieza(6)" alt="Fascia Delantera" title="Fascia Delantera" href="#" coords="605,186,638,190,688,203,739,190,764,188,773,181,774,216,760,235,690,237,612,235,602,218,600,196" shape="poly">
      	<area target="" data-target="#modalSlideUpSmall" data-toggle="modal" alt="Salpicadera" onclick="PiezaInfo('Salpicadera',3);" alt="Salpicadera" title="Salpicadera" href="#" coords="128,128,117,127,74,149,80,153,63,173,67,180,81,180,91,182,102,178,114,175,127,177,140,183,149,193,150,202,154,217,162,219,161,207,155,191,146,175,137,170,137,136,120,139" shape="poly">
          <area target="" alt="Estribo" title="Estribo" href="#" coords="162,215,384,220" shape="rect">
    </map>
  </div>

  <div class="col-md-12 col-sm-12 col-lg-9 MapCars" id="Map5" style="display:none;">
    <img src="/assets/img/MapCars/50bb.png" usemap="#image-map5" class="map">
    <map name="image-map5">
          <area target="" data-target="#modalSlideUpSmall" data-toggle="modal" alt="Salpicadera" onclick="PiezaInfo('Salpicadera',3);" alt="Salpicadera" title="Salpicadera" href="#" coords="35,177,51,178,53,168,59,164,53,168,88,162,120,162,128,168,138,203,143,204,150,205,148,197,143,164,143,144,146,128,123,127,74,131,38,134,27,139,36,143" shape="poly">
          <area target="" data-target="#modalSlideUpSmall" data-toggle="modal" alt="Puerta delantera" onclick="PiezaInfo('Puerta delantera',1);" alt="Puerta delantera" title="Puerta delantera" href="#" coords="150,203,254,202,251,192,251,161,253,129,252,126,253,129,254,82,231,81,218,83,205,85,192,92,153,118,146,128,143,147,143,165" shape="poly">
          <area target="" data-target="#modalSlideUpSmall" data-toggle="modal" alt="Puerta trasera" onclick="PiezaInfo('Puerta trasera',2);" alt="Puerta trasera" title="Puerta trasera" href="#" coords="254,201,330,201,341,199,344,196,347,186,347,158,347,128,344,104,341,89,338,84,334,80,255,82,254,127,252,155,251,180" shape="poly">
          <area target="" onclick="AgregarPieza(14)" alt="Batea exterior" title="Batea exterior" href="#" coords="352,206,388,206,393,169,396,163,403,160,433,157,461,158,469,159,472,165,475,176,477,206,488,204,514,201,516,186,519,179,529,179,532,167,515,164,516,135,530,130,529,120,353,125,354,166" shape="poly">
          <area target="" alt="Estribo" title="Estribo" href="#" coords="150,204,349,201,348,207,152,211" shape="poly">
          <area target="" alt="Rin delantero" title="Rin delantero" href="#" coords="92,215,21" shape="circle">
          <area target="" alt="Rin trasero" title="Rin trasero" href="#" coords="436,214,21" shape="circle">
          <area target="" onclick="AgregarPieza(7)" alt="Parrilla" title="Parrilla" href="#" coords="676,181,680,186,685,189,772,190,850,189,861,187,866,181,869,137,866,134,676,136,673,137,674,156,676,171,676,175" shape="poly">
          <area target="" onclick="AgregarPieza(6)" alt="Fascia delantera" title="Fascia delantera" href="#" coords="636,184,637,213,640,234,644,246,652,256,663,259,706,263,760,264,805,264,850,263,867,257,885,254,898,246,903,235,904,220,906,197,906,184,901,176,870,182,857,188,685,191,673,182,640,176" shape="poly">
          <area target="" onclick="AgregarPieza(11)" alt="Espejo FD" title="Espejo FD" href="#" coords="635,95,667,117" shape="rect">
          <area target="" onclick="AgregarPieza('11I')" alt="Espejo FI" title="Espejo FI" href="#" coords="908,95,876,116" shape="rect">
          <area target="" onclick="AgregarPieza(5)" alt="Cofre" title="Cofre" href="#" coords="22,505,32,524,49,543,138,549,138,545,124,539,111,503,107,463,111,429,124,392,141,383,141,379,50,386,32,405,24,419,18,461" shape="poly">
          <area target="" onclick="AgregarPieza(10)" alt="Toldo" title="Toldo" href="#" coords="194,537,368,535,369,394,194,393,182,426,177,431,178,497,183,502" shape="poly">
          <area target="" onclick="AgregarPieza(13)" alt="Cama / Batea interior" title="Cama / Batea interior" href="#" coords="376,391,376,539,534,539,534,391,446,390" shape="poly">
          <area target="" onclick="AgregarPieza('11I')" alt="Espejo I" title="Espejo I" href="#" coords="188,580,158,550" shape="rect">
          <area target="" onclick="AgregarPieza(11)" alt="Espejo D" title="Espejo D" href="#" coords="187,348,159,381" shape="rect">
          <area target="" onclick="AgregarPieza(8)" alt="Tapa batea" title="Tapa batea" href="#" coords="663,395,664,476,877,475,877,395" shape="poly">
          <area target="" onclick="AgregarPieza(9)" alt="Fascia Trasera" title="Fascia Trasera" href="#" coords="637,478,646,510,701,515,838,516,895,510,902,478" shape="poly">
    </map>
  </div>

</div>
  </div>
</div>

<div class="modal fade slide-up disable-scroll" id="modalSlideUpSmall" tabindex="-1" role="dialog" aria-hidden="false">
  <div class="modal-dialog modal-sm">
    <div class="modal-content-wrapper">
      <div class="modal-content">
        <div class="modal-body text-center m-t-20">
          <h4 class="no-margin p-b-10" id="PartName">Seleccione un lado para puerta</h4>
          <button aria-label="" type="button" class="btn btn-primary btn-xs LadoPieza" data-partnum="0" id="btnIzq" onclick="AgregarLadoPieza()" data-dismiss="modal">IZQUIERDA</button>
          <button aria-label="" type="button" class="btn btn-primary btn-xs LadoPieza" data-partnum="0" id="btnDer" onclick="AgregarLadoPieza()" data-dismiss="modal">DERECHA</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="{{asset('js/SelectorPieza.js?v=3')}}"></script>
@stop

@section('js')

	<script type="text/javascript" src="{{asset('js/jquery.maphilight.min.js')}}"></script>

  <script type="text/javascript">
  $(document).ready(function(){
    LeerPiezasBitacora();
    ShowMap();
  });
</script>
@stop
