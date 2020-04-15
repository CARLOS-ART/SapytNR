<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>Sapyt - Pantalla Bloqueada</title>
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
    <link href="{{asset('pages/css/pages-icons.css')}}" rel="stylesheet" type="text/css">
    <link class="main-stylesheet" href="{{asset('pages/css/themes/light.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
    window.onload = function()
    {
      // fix for windows 8
      if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
        document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="pages/css/windows.chrome.fix.css" />'
    }
    </script>
  </head>
  <body class="fixed-header ">
    <!-- START PAGE-CONTAINER -->
    <div class="lock-container full-height">
      <!-- START PAGE CONTENT WRAPPER -->
      <div class="full-height sm-p-t-50 align-items-center d-md-flex">
        <div class="row full-width">
          <div class="col-md-12">
            <!-- START Lock Screen User Info -->
            <div class="d-flex justify-content-start align-items-center">
              <div class="">
                <div class="thumbnail-wrapper circular d48 m-r-10 ">
                  <img width="43" height="43" data-src-retina="assets/img/profiles/avatar_small2x.jpg" data-src="assets/img/profiles/avatar.jpg" alt="" src="assets/img/profiles/avatar_small2x.jpg">
                </div>
              </div>
              <div class="">
                <h5 class="logged hint-text no-margin">
                              Conectado como
                          </h5>
                <h2 class="name no-margin">{{request()->cookie('NomUsuario')}}</h2>
              </div>
            </div>
            <!-- END Lock Screen User Info -->
          </div>

          <div class="col-md-12"><br>
            <!-- START Lock Screen Form -->
            <form action="/IniciarNuevamente" method="post">
{{csrf_field()}}
              <div class="row">
                <div class="col-md-12">
                  @if (Session::has('E022'))
        					<div class="alert alert-danger">
        						<strong>{{ Session::get('E022') }}</strong>
        					</div>
        				@endif

        				@if (Session::has('E023'))
        					<div class="alert alert-warning">
        						<strong>{{ Session::get('E023') }}</strong>
        					</div>
        				@endif
                  <div class="form-group form-group-default sm-m-t-30">
                    <label>Password</label>
                    <div class="controls">
                      <input type="password" placeholder="Contraseña para desbloquear" class="form-control" name="txtPassword" id="txtPassword" required>
                    </div>
                  </div>
                  <!-- END Form Control -->
                </div>
              </div>
              <!-- START Lock Screen Notification Icons-->
              <div class="row">
                <div class="col-md-12 sm-p-l-25">
                  <!--a href="#" class="inline text-black fs-14 hint-text"><i class="pg-mail"></i> <span class="hint-text">12</span></a>
                  <a href="#" class="inline text-black  fs-14 hint-text m-l-30"><i class="pg-comment"></i> <span class="hint-text">4</span></a-->
                  <div class="hint-text m-t-5 small"><a class="hint-text m-t-5 small" href="/Logout">Iniciar sesión con un usuario diferente</a></div></div>
                </div>

              </div>
              <!-- END Lock Screen Notification Icons-->
            </form>
            <!-- END Lock Screen Form -->
          </div>
        </div>
      </div>
      <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE-CONTAINER -->
    <!-- START Lock Screen Footer Content-->
    <div class="pull-bottom full-width">
      <div class="lock-container m-b-10 clearfix row">
        <div class="inline col-lg-2">
          <img src="{{asset('assets/img/demo/pages_icon.png')}}" alt="" class="m-t-5 " data-src="{{asset('assets/img/demo/pages_icon.png')}}" data-src-retina="{{asset('assets/img/demo/pages_icon_2x.png')}}" width="60" height="60">
        </div>
        <div class="col-lg-10 m-t-15">
          <p class="hinted-text small inline ">Ninguna parte de este sitio web o cualquiera de sus contenidos puede ser reproducida, copiada, modificada o adaptada, sin el consentimiento previo por escrito del autor</p>
        </div>
      </div>
    </div>
    <!-- END Lock Screen Footer Content-->
    <!-- START OVERLAY -->
    <div class="overlay hide" data-pages="search">
      <!-- BEGIN Overlay Content !-->
      <div class="overlay-content has-results m-t-20">
        <!-- BEGIN Overlay Header !-->
        <div class="container-fluid">
          <!-- BEGIN Overlay Logo !-->
          <img class="overlay-brand" src="assets/img/logo.png" alt="logo" data-src="assets/img/logo.png" data-src-retina="assets/img/logo_2x.png" width="78" height="22">
          <!-- END Overlay Logo !-->
          <!-- BEGIN Overlay Close !-->
          <a href="#" class="close-icon-light overlay-close text-black fs-16">
            <i class="pg-close"></i>
          </a>
          <!-- END Overlay Close !-->
        </div>
        <!-- END Overlay Header !-->


      </div>
      <!-- END Overlay Content !-->
    </div>
    <!-- END OVERLAY -->
    <!-- BEGIN VENDOR JS -->
    <script src="{{asset('assets/plugins/pace/pace.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/jquery/jquery-3.2.1.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/modernizr.custom.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/popper/umd/popper.min.j')}}s" type="text/javascript"></script>
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
      $('#form-lock').validate()
    })
    </script>
  </body>
</html>
