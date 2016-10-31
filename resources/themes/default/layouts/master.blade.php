<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8"/>
    <link rel="dns-prefetch" href="//assets.anyshare.coop">
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge" /><![endif]-->

    <title>
      @section('title')
        {{ trans('general.seo_title')}}
      @show
    </title>
    <!-- Mobile Specific Metas-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Template info -->
    <meta name="author" content="A. Gianotto">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha256-916EbMg70RQy9LHiGkXzG8hSg9EdNy97GazNG/aiY1w=" crossorigin="anonymous" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.0.0/bootstrap-social.min.css" integrity="sha256-aNI8KR/Gy4Hb87gooy9+CAjWOeVdSA0S5sd9XMmj4Xo=" crossorigin="anonymous" type="text/css" />
    <link rel="stylesheet" href="{{ Helper::cdn('css/compiled/app.css?v='.date('U')) }}" type="text/css">
    <link rel="stylesheet" href="{{ Theme::asset('css/styles.css', null, true) }}" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha256-uKEg9s9/RiqVVOIWQ8vq0IIqdJTdnxDMok9XhiqnApU=" crossorigin="anonymous" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" /> 
    <!-- PAGE LEVEL SCRIPTS -->
    <link href="{{ Helper::cdn('css/header-1.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ Helper::cdn('css/color_scheme/darkorange.css') }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Table style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.css" integrity="sha256-lHY6r+cFHp2F/XXDvi4iczsIj7nl0r+CBVFD8KdtFqc=" crossorigin="anonymous" type="text/css" media="screen" />

    <script type="text/javascript">var plugin_path = '/assets/plugins/';</script>

    <!-- jQuery 2.2.4-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha256-tQ3x4V2JW+L0ew/P3v2xzL46XDjEWUExFkCDY0Rflqc=" crossorigin="anonymous"></script>
    
    <!-- Bootstrap debug, very handy when working on a responsive layouts -->
    @if( getenv('APP_DEBUG'))
			<!-- <script src="{{ asset('assets/js/extensions/debug/bootstrap_debugger.js')}}"></script> -->
    @endif
  <link rel="shortcut icon" href="/favicon.ico">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" integrity="sha256-t2/7smZfgrST4FS1DT0bs/KotCM74XlcqZN5Vu7xlrw=" crossorigin="anonymous" />
  <link rel="stylesheet" type="text/css" href="{{ Helper::cdn('css/hp/webflow.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ Helper::cdn('css/hp/anyshare-corp.webflow.css') }}">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/webfont/1.6.26/webfontloader.js" integrity="sha256-+6jNhQy77vjBVW8D4TAIG0HBtnzN9YreZOvtii8vrAM=" crossorigin="anonymous" async></script>
  <script>
    WebFont.load({
      google: {
        families: ["Open Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic"]
      }
    });
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" integrity="sha256-0rguYS0qgS6L4qVzANq4kjxPLtvnp5nn2nB5G1lWRv4=" crossorigin="anonymous"></script>
  </head>

<body class="smoothscroll enable-animation">
  <!-- wrapper -->
		<div id="wrapper">

      @if (Route::is('home'))

        {{--*/ $bannerClasses = 'max_autoplay_movies' /*--}}
        {{--*/ $bannerHeight = '750px' /*--}}
        <div>@include('partials.header')</div>
      @else
        {{--*/ $bannerClasses = '' /*--}}
        {{--*/ $bannerHeight = '350px' /*--}}

        <div>@include('partials.header')</div>
        <!-- Notifications -->

        <div class="col-md-12 margin-top-0">
          @include('notifications')
        </div>
      @endif

      <div>@yield('content')</div>

      <div>@include('partials.footer')</div>

    </div>
    <!-- /wrapper -->


<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-73360507-1', 'auto');
  ga('send', 'pageview');

</script>

<script type="text/javascript" src="{{ Helper::cdn('js/webflow.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){ 
    //$('.max_autoplay_movies').css('height',  window.innerHeight); 
      
     var scroll_start = 30;
     var startchange = $('#header');
     var offset = startchange.offset();
     $(document).scroll(function() { 
        scroll_start = $(this).scrollTop();

        if(scroll_start > offset.top) {
            $('#header').css('background-color', 'white');
            $('#header').removeClass('header_noDropShadow');
            $('#header').addClass('header_dropShadow');
         } else {
            $('#header').css('background-color', 'transparent');
            $('#header').removeClass('header_dropShadow');
            $('#header').addClass('header_noDropShadow');
         }
     });
  });
</script>

</body>
</html>
