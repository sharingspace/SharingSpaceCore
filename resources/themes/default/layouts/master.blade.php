<!DOCTYPE html>
<html lang="en-us">
  <head>
    <!-- *** General page information *** -->
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge" /><![endif]-->
    <meta charset="UTF-8"/>
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
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/compiled/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/compiled/app.css') }}">
    <link rel="stylesheet" href="{{ Theme::asset('css/styles.css', null, true) }}">

    <!-- PAGE LEVEL SCRIPTS -->
		<link href="{{ asset('assets/css/header-1.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/color_scheme/orange.css') }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Table style -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.8.1/bootstrap-table.min.css" type="text/css" media="screen" />

    <script type="text/javascript">var plugin_path = '/assets/plugins/';</script>

    <!-- jQuery 2.1.4-->
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>

    <!-- Bootstrap debug, very handy when working on a responsive layouts -->
    @if( getenv('APP_DEBUG'))
			<!-- <script src="assets/js/extensions/debug/bootstrap-debugger.js"></script> -->
    @endif
  <link rel="shortcut icon" href="/favicon.ico">

  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/hp/normalize.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/hp/webflow.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/hp/anyshare-corp.webflow.css') }}">
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js"></script>
  <script>
    WebFont.load({
      google: {
        families: ["Open Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic"]
      }
    });
  </script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

  <link rel="shortcut icon" type="image/x-icon" href="https://daks2k3a4ib2z.cloudfront.net/img/favicon.ico">
  <link rel="apple-touch-icon" href="https://daks2k3a4ib2z.cloudfront.net/img/webclip.png">
  </head>

<body class="smoothscroll enable-animation">
  <!-- wrapper -->
		<div id="wrapper">

      @if (Route::is('home'))
        {{--*/ $bannerHeight = '500px' /*--}}
        <div>@include('partials.header')</div>
      @else
      {{--*/ $bannerHeight = '300px' /*--}}

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

<script type="text/javascript" src="{{ asset('assets/js/webflow.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){       
     var scroll_start = 30;
     var startchange = $('#header');
     var offset = startchange.offset();
     $(document).scroll(function() { 
        scroll_start = $(this).scrollTop();
        console.log("scroll scroll_start = "+scroll_start +", offset.top = "+offset.top);

        if(scroll_start > offset.top) {
            $('#header').css('background-color', 'white');
         } else {
            $('#header').css('background-color', 'transparent');
         }
     });
  });
</script>

</body>
</html>
