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
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}" />
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
    <link href="{{asset('pages/css/pages-icons.css" rel="stylesheet')}}" type="text/css">
    <link class="main-stylesheet" href="{{asset('pages/css/themes/light.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
    window.onload = function()
    {
      // fix for windows 8
      if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
        document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="pages/css/windows.chrome.fix.css" />'
    }
    </script>
	<style>
	.banner-brands{


	position:fixed;

	right:7%;
	max-height:450px;

	}
	</style>
  </head>
  <body class="fixed-header menu-pin">
    <div class="login-wrapper ">
      <div class="bg-pic">
        <img src="{{asset('assets/img/demo/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg')}}"
             data-src="{{asset('assets/img/demo/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg')}}"
		         data-src-retina="{{asset('assets/img/demo/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg')}}" style="width:100%;">
        <div class="bg-caption pull-bottom sm-pull-bottom text-white p-l-20 m-b-20">
          <h2 class="semi-bold text-white">SAPYT</h2>
          <p class="small">
            Todos los derechos reservados © 2020 BASF.
          </p>
        </div>
      </div>
      <div class="login-container">
	  <img src="{{asset('assets/img/banner.png')}}" height="430" class="banner-brands"/>
        <div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
          <img src="{{asset('assets/img/logo.png')}}" alt="logo" data-src="{{asset('assets/img/logo.png')}}" data-src-retina="{{asset('assets/img/logo_2x.png')}}" width="78" height="22">
          <p class="p-t-35" style="color:#FFF;">Introduzca los datos solicitados a continuación para iniciar sesión</p>
          <!-- START Login Form -->
          <form id="form-login" class="p-t-15" role="form" action="/Auth/IniciarSesion" method="post">
            {{csrf_field()}}
            <!-- START Form Control-->
            <div class="form-group form-group-default">
              <label>Usuario</label>
              <div class="controls">
                <input type="text" name="txtNUsuario" id="txtNUsuario" placeholder="Usuario" class="form-control" required>
              </div>
            </div>
            <!-- END Form Control-->
            <!-- START Form Control-->
            <div class="form-group form-group-default">
              <label>Contraseña</label>
              <div class="controls">
                <input type="password" class="form-control" name="txtPassword" id="txtPassword" placeholder="Contraseña" required>
              </div>
            </div>
            <!-- START Form Control-->
            <div class="row">

              <div class="col-md-6 d-flex align-items-center justify-content-end">
                <a href="#" class="text-info small">¿Ayuda? Póngase en contacto con el equipo de soporte</a>
              </div>
            </div>
            <!-- END Form Control-->
            <button class="btn btn-primary btn-cons m-t-10" type="submit">Iniciar Sesión</button>
          </form>
          <!--END Login Form-->
          <div class="pull-bottom sm-pull-bottom">

          </div>
        </div>
      </div>
      <!-- END Login Right Container-->
    </div>

    <!-- END OVERLAY -->
    <!-- BEGIN VENDOR JS -->
    <script src="{{asset('assets/plugins/pace/pace.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/jquery/jquery-3.2.1.min.js')}}" type="text/javascript"></script>
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
    <script src="{{asset('assets/plugins/jquery-validation/js/jquery.validate.js')}}" type="text/javascript"></script>
    <!-- END VENDOR JS -->
    <script src="{{asset('pages/js/pages.min.js')}}"></script>
    <script>
    $(function()
    {
      $('#form-login').validate()
    })
    </script>
  </body>
</html>
