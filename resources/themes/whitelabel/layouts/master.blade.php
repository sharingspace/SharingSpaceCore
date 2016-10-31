<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8"/>
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge" /><![endif]-->

    <title>
      @section('title')
        {{ $whitelabel_group->name }}
      @show
    </title>
    <!-- Mobile Specific Metas-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Template info -->
    <meta name="author" content="A. Gianotto">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- token used in ajax calls where no form is present on the page -->
    <meta name="ajax-csrf-token" content="{{ csrf_token() }}" />

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha256-916EbMg70RQy9LHiGkXzG8hSg9EdNy97GazNG/aiY1w=" crossorigin="anonymous" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha256-rByPlHULObEjJ6XQxW/flG2r+22R5dKiAoef+aXWfik=" crossorigin="anonymous" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.0.0/bootstrap-social.min.css" integrity="sha256-aNI8KR/Gy4Hb87gooy9+CAjWOeVdSA0S5sd9XMmj4Xo=" crossorigin="anonymous" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/compiled/app.css?v='.date('U') ) }}" type="text/css">
    <link rel="stylesheet" href="{{ Theme::asset('css/styles.css', null, true) }}" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha256-uKEg9s9/RiqVVOIWQ8vq0IIqdJTdnxDMok9XhiqnApU=" crossorigin="anonymous" type="text/css" />

    <!-- PAGE LEVEL SCRIPTS -->
    <link href="{{ asset('assets/css/header-1.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/color_scheme/darkorange.css') }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Table style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.css" integrity="sha256-lHY6r+cFHp2F/XXDvi4iczsIj7nl0r+CBVFD8KdtFqc=" crossorigin="anonymous" type="text/css" media="screen" />

    <script type="text/javascript">var plugin_path = '/assets/plugins/';</script>

    <!-- jQuery 2.1.3-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js" integrity="sha256-IFHWFEbU2/+wNycDECKgjIRSirRNIDp2acEB5fvdVRU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha256-KM512VNnjElC30ehFwehXjx1YCHPiQkOPmqnrWtpccM=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="undefined" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/extensions/rotate/jQueryRotate.js')}}"></script>
    <script type="text/javascript">
    $( document ).ready(function() {
        if ($('.wl_usercover').length) {
          setBannerHeight();
        
          $(window).resize(function() {
              setBannerHeight();
          });

          $('.wl_usercover').show();
        }

        function setBannerHeight()
        {
            var height = $( window ).width()/4;
            // adaptive height is 25% of width
            $('.wl_usercover').css('height',height);
        }
    });
    </script>

    <!-- Bootstrap 3 Javascript is pulled in through the scripts.js file - no need to include it here -->
    <link rel="shortcut icon" href="/favicon.ico">
  </head>

<body class="smoothscroll enable-animation">
  <!-- wrapper -->
		<div id="wrapper">

      <div>@include('partials.header')</div>


      @if (!Route::is('home'))
        <!-- Notifications -->
        <div  id="notifications" class="container">
          <div class="row">
            @include('notifications')
          </div>
        </div>
      @endif

      <div>@yield('content')</div>

      <div>@include('partials.footer')</div>

    </div>
    <!-- /wrapper -->

@include('partials.geo-lookup')


<script>

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-73360507-1', 'auto');

  @if ($whitelabel_group->ga!='')
  ga('create', '{{ $whitelabel_group->ga }}', 'auto', 'clientTracker');
  @endif
  ga('send', 'pageview');

</script>

</body>
</html>
