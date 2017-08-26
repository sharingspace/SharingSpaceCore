<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="AnyShare makes it easy to share skills, things, and ideas within any group or community.">
    <meta name="keywords" content="anyshare, share, sharing, community, group, communities, groups, skills, things, ideas">

    <title>
      @section('title')
        {{ trans('general.seo_title')}}
      @show
    </title>

    <!-- Styles -->
    <link href="{{ asset('assets/css/reset.css?v='.date('U')) }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/corporate/css/core.min.css?v='.date('U')) }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/corporate/css/thesaas.min.css?v='.date('U')) }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/corporate/css/style.css?v='.date('U')) }}" rel="stylesheet" type="text/css">
    <style>
      .hidden {
        display: none;
        visibility: hidden;
      }
      ul.list-inline {
        list-style: none;
        margin: 0;
        padding-left: 3px;
        float: left;
        margin-right: 15px;
        margin-top: 3px;
      }
      ul.list-inline .avatar-sm {
        height: 25px;
        width: 25px;
        margin-right: 5px;
      }
      ul.list-inline li {
        float: left;
      }
      .topbar-right {
        float: right;
      }
      ul.list-inline .dropdown-toggle::after {
        content: "\f0d7";
        margin-right: 10px;
      }
      ul.list-inline .caret-down {

      }
    </style>
    <!-- Favicons -->
    <link rel="apple-touch-icon" href="{{ Helper::cdn('img/apple-touch-icon.png') }}">
    <link rel="icon" href="assets/img/favicon.png">

    <!--  Open Graph Tags -->
    <meta property="og:title" content="AnyShare | The New Way to Share">
    <meta property="og:description" content="AnyShare makes it easy to share skills, things, and ideas within any group or community.">
    <!--
    <meta property="og:image" content="http://thetheme.io/thesaas/assets/img/og-img.jpg">
    -->
    <meta property="og:url" content="https://anyshare.coop">
    <meta name="twitter:card" content="summary_large_image">
  </head>

  <body>
    <!-- Topbar -->
    <nav class="topbar topbar-inverse topbar-expand-md topbar-sticky">
      <div class="container">

        <div class="topbar-left">
          <button class="topbar-toggler">&#9776;</button>
          <a class="topbar-brand" href="{{ route('home') }}">
            <img class="logo-default" src="{{ asset('assets/corporate/img/anyshare-logo-grey.png')}}" alt="AnyShare - Home">
            <img class="logo-inverse" src="{{ asset('assets/corporate/img/anyshare-logo-white.png')}}" alt="AnyShare - Home">
          </a>
        </div>

        <div class="topbar-right">
        @if (Auth::check())
        <ul class="list-inline">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="{{ Auth::user()->gravatar_img() }}" class="avatar-sm">{{ Auth::user()->getDisplayName() }} <span class="caret-down"></span></a>
            <ul class="dropdown-menu">
              <li><a href="{{ route('_memberships') }}"><i class="fa fa-users"></i> {{ trans('general.memberships') }}</a></li>
              <li><a href="{{ route('_orders') }}"><i class="fa fa-credit-card"></i> {{ trans('general.nav.my_orders') }}</a></li>
              <li><a href="{{ route('logout') }}"><i class="fa fa-power-off"></i> {{ trans('general.nav.logout') }} </a></li>
            </ul>
          </li>
        </ul>
        
        <button class="drawer-toggler">&#9776;</button>
        @else
          <a class="btn btn-xs btn-malibu-outline mr-4" href="{{ route('login') }}">Sign In</a>
          <a class="btn btn-xs btn-malibu mr-4" href="{{ route('register') }}">Start</a>
          <button class="drawer-toggler ml-12">&#9776;</button>
        @endif
        <!-- /QUICK SHOP CART -->

          
        </div>

      </div>
    </nav>
    <!-- END Topbar -->

   <!-- Header -->
  @if (Route::is('home'))
      @include('partials.hp_header')
  @else
      @include('partials.header')

      <div class="col-md-12 margin-top-0">
        @include('notifications')
      </div>
  @endif
  <!-- End Header -->

  <!-- Main container -->
  <main class="main-content">
    @yield('content')
  </main>
  <!-- END Main container -->
  
  @include('partials.footer')

 

    <!-- Freshdesk js -->
    <script type="text/javascript" src="https://s3.amazonaws.com/assets.freshdesk.com/widget/freshwidget.js"></script>
    <script type="text/javascript">
FreshWidget.init("", {"queryString": "&widgetType=popup&formTitle=Help+%26+Support&submitThanks=Thank+you+for+your+feedback.+We'll+be+in+touch+soon.", "utf8": "✓", "widgetType": "popup", "buttonType": "text", "buttonText": "Help", "buttonColor": "white", "buttonBg": "#686868", "alignment": "2", "offset": "90%", "submitThanks": "Thank you for your feedback. We'll be in touch soon.", "formHeight": "500px", "url": "https://anyshare.freshdesk.com"} );
    </script>

    <script type="text/javascript">
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-81177317-1', 'auto');
        ga('send', 'pageview');
    </script>

    <script type="text/javascript">
    if (window.location.hash && (window.location.hash == '#=')) {
        window.location.hash = '';
    }
    </script>
  </body>
</html>
