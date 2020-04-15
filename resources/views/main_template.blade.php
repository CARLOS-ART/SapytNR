@if(request()->cookie('Persona_ID') == false || request()->cookie('LockScreen') == 'Yes')
  {{redirect()->to('/')->send()}}
@endif
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>Sapyt - BASF Coatings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
    <link rel="apple-touch-icon" href="{{asset('pages/ico/60.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('pages/ico/76.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('pages/ico/120.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('pages/ico/152.png')}}">
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="Sistema de administración pinturas y talleres" name="description" />
    <meta content="BASF Coatings México" name="author" />
    <link href="{{asset('assets/plugins/pace/pace-theme-flash.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/font-awesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/jquery-scrollbar/jquery.scrollbar.css')}}" rel="stylesheet" type="text/css" media="screen" />
    <link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" media="screen" />
    <link href="{{asset('assets/plugins/switchery/css/switchery.min.css')}}" rel="stylesheet" type="text/css" media="screen" />
    <link href="{{asset('pages/css/pages-icons.css')}}" rel="stylesheet" type="text/css">
    <link class="main-stylesheet" href="{{asset('pages/css/themes/light.css')}}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
	  <script src="{{asset('js/sweetalert2.min.js')}}"></script>

    <script type="text/javascript">
      if(history.forward(1)){
        location.replace( history.forward(1) );
      }
    </script>
    @yield('handsontable')
  </head>
  <body class="fixed-header menu-pin">
    <!-- BEGIN SIDEBPANEL-->
    <nav class="page-sidebar" data-pages="sidebar">
      <!-- BEGIN SIDEBAR MENU TOP TRAY CONTENT-->
      <!-- END SIDEBAR MENU TOP TRAY CONTENT-->
      <!-- BEGIN SIDEBAR MENU HEADER-->
      <div class="sidebar-header">
        <img src="{{asset('assets/img/logo.png')}}" alt="logo" class="brand" data-src="{{asset('assets/img/logo.png')}}" data-src-retina="{{asset('assets/img/logo_2x.png')}}" width="78" height="22">
      </div>
      <!-- END SIDEBAR MENU HEADER-->
      <!-- INICIA PANEL DE MENU -->
      <div class="sidebar-menu">
        <!-- BEGIN SIDEBAR MENU ITEMS-->
          <ul class="menu-items">
              @php
              echo $MenuPrincipal
              @endphp
          </ul>
        <div class="clearfix"></div>
      </div>
      <!-- TERMINA PANEL DE MENU -->
    </nav>
    <!-- END SIDEBAR -->
    <!-- END SIDEBPANEL-->
    <!-- START PAGE-CONTAINER -->
    <div class="page-container ">
      <!-- START HEADER -->
      <div class="header ">
        <!-- START MOBILE SIDEBAR TOGGLE -->
        <a href="#" class="btn-link toggle-sidebar d-lg-none pg pg-menu" data-toggle="sidebar">
        </a>
        <!-- END MOBILE SIDEBAR TOGGLE -->
        <div class="">
          <div class="brand inline">
            <img src="{{asset('assets/img/logo.png')}}" alt="logo" data-src="{{asset('assets/img/logo.png')}}" data-src-retina="{{asset('assets/img/logo_2x.png')}}" width="78" height="22">
          </div>
          <a href="#" class="btn btn-link text-primary m-l-20 d-none d-lg-inline-block d-xl-inline-block">{{request()->cookie('Taller')}}</a>
        </div>
        <div class="">
          @yield('Fijo')
        </div>
        <div class="d-flex align-items-center">
          <!-- START User Info-->
          <div class="pull-left p-r-10 fs-14 font-heading d-lg-inline-block d-none m-l-20">
            <span class="semi-bold">{{request()->cookie('NomUsuario')}}</span> <span class="text-master">-</span><span class="text-master">  {{request()->cookie('Perfil')}}</span>
          </div>
          <div class="dropdown pull-right d-lg-inline-block d-none">
            <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="thumbnail-wrapper d32 circular inline">
              <img src="{{asset('assets/img/profiles/avatar.jpg')}}" alt="" data-src="{{asset('assets/img/profiles/avatar.jpg')}}" data-src-retina="assets/img/profiles/avatar_small2x.jpg" width="32" height="32">
              </span>
            </button>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
              <a href="#" class="dropdown-item"><i class="pg-settings_small"></i> Settings</a>
              <a href="#" class="dropdown-item"><i class="pg-outdent"></i> Feedback</a>
              <a href="#" class="dropdown-item"><i class="pg-signals"></i> Help</a>
              <a href="#" class="clearfix bg-master-lighter dropdown-item">
                <span class="pull-left">Cerrar sesión</span>
                <span class="pull-right"><i class="pg-power"></i></span>
              </a>
            </div>
          </div>

        </div>

      </div>
      <!-- END HEADER -->
      <!-- START PAGE CONTENT WRAPPER -->
      <div class="page-content-wrapper ">


            @yield('WorkArea')

        <div class=" container-fluid  container-fixed footer" style="background-color:#BCBDC1; background-image:url('/assets/img/logo-basf-gris-pie.png'); background-repeat:no-repeat;" width="100%">
          <div class="copyright " >

            <p class="small no-margin pull-right sm-pull-reset">
              Copyright &copy; 2020  <span class="hint-text">&amp; <span class="hint-text font-montserrat">BASF Coatings</span>. Todos los derechos reservados</span>
            </p>
            <div class="clearfix"></div>
          </div>

        </div>
        <!-- END COPYRIGHT -->
      </div>
      <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTAINER -->
    <div>
      <link href="{{asset('css/loading.css')}}" rel="stylesheet">
      <script src="{{asset('js/loading.js')}}"></script>
    </div>


    <script src="{{asset('js/Global.js')}}"></script>
    <!-- BEGIN VENDOR JS -->

    <script src="{{asset('assets/plugins/jquery/jquery-3.3.1.min.js')}}" type="text/javascript"></script>



    <script src="{{asset('assets/plugins/feather-icons/feather.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/pace/pace.min.js')}}" type="text/javascript"></script>

    <script src="{{asset('assets/plugins/modernizr.custom.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/popper/umd/popper.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/jquery/jquery-easy.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/jquery-unveil/jquery.unveil.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/jquery-ios-list/jquery.ioslist.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/jquery-actual/jquery.actual.min.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/plugins/classie/classie.js')}}"></script>
    <script src="{{asset('assets/plugins/switchery/js/switchery.min.js')}}" type="text/javascript"></script>

    <script src="{{asset('pages/js/pages.js')}}"></script>

    <script src="{{asset('assets/js/scripts.js')}}" type="text/javascript"></script>

    <!--
   -->
    @yield('js')
  </body>
</html>
