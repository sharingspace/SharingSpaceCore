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

    <script type="text/javascript">
    if (window.location.hash && (window.location.hash == '#=')) {
        window.location.hash = '';
    }

    // start Mixpanel
    (function(e,a){if(!a.__SV){var b=window;try{var c,l,i,j=b.location,g=j.hash;c=function(a,b){return(l=a.match(RegExp(b+"=([^&]*)")))?l[1]:null};g&&c(g,"state")&&(i=JSON.parse(decodeURIComponent(c(g,"state"))),"mpeditor"===i.action&&(b.sessionStorage.setItem("_mpcehash",g),history.replaceState(i.desiredHash||"",e.title,j.pathname+j.search)))}catch(m){}var k,h;window.mixpanel=a;a._i=[];a.init=function(b,c,f){function e(b,a){var c=a.split(".");2==c.length&&(b=b[c[0]],a=c[1]);b[a]=function(){b.push([a].concat(Array.prototype.slice.call(arguments,0)))}}var d=a;"undefined"!==typeof f?d=a[f]=[]:f="mixpanel";d.people=d.people||[];d.toString=function(b){var a="mixpanel";"mixpanel"!==f&&(a+="."+f);b||(a+=" (stub)");return a};d.people.toString=function(){return d.toString(1)+".people (stub)"};k="disable time_event track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config reset people.set people.set_once people.unset people.increment people.append people.union people.track_charge people.clear_charges people.delete_user".split(" ");
        for(h=0;h<k.length;h++)e(d,k[h]);a._i.push([b,c,f])};a.__SV=1.2;b=e.createElement("script");b.type="text/javascript";b.async=!0;b.src="undefined"!==typeof MIXPANEL_CUSTOM_LIB_URL?MIXPANEL_CUSTOM_LIB_URL:"file:"===e.location.protocol&&"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js".match(/^\/\//)?"https://cdn.mxpnl.com/libs/mixpanel-2-latest.min.js":"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";c=e.getElementsByTagName("script")[0];c.parentNode.insertBefore(b,c)}})(document,window.mixpanel||[]);
      mixpanel.init("0c8964feac7aebf9f40b95e1cfe55030");
      // end Mixpanel
    </script>
  </head>

  <body>
    <!-- Topbar -->
    <nav class="topbar topbar-inverse topbar-expand-md topbar-sticky">
      <div class="container">
        <div class="topbar-left">
          <button class="topbar-toggler">&#9776;</button>
          <a class="topbar-brand" href="{{ route('home') }}">
            <img class="logo-default hidden-xs-down" src="{{ asset('assets/corporate/img/sharing-space-logo-dark.png')}}" alt="AnyShare - Home">
            <img class="logo-inverse hidden-xs-down" src="{{ asset('assets/corporate/img/sharing-space-logo.png')}}" alt="AnyShare - Home">
            <img class="hidden-sm-up" src="{{ asset('assets/corporate/img/anyshare-logo.png')}}" alt="AnyShare - Home">
          </a>
        </div>

        <div class="topbar-right d-none">
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
            <li>
              <a class="btn btn-xs btn-malibu margin-left-15" href="{{ route('community.create.form') }}">Start</a>
            </li>
          </ul>
        
          <button class="drawer-toggler">&#9776;</button>
          @else
            <a class="btn btn-xs btn-malibu-outline mr-4" href="{{ route('login') }}">Sign In</a>
            <a class="btn btn-xs btn-malibu mr-4" href="{{ route('community.create.form') }}">Start</a>
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
  </body>
</html>
