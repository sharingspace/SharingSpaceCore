<!DOCTYPE html>
<html lang="en">
<head>
    <style>.async-hide { opacity: 0 !important} </style> <script>(function(a,s,y,n,c,h,i,d,e){s.className+=' '+y;h.start=1*new Date; h.end=i=function(){s.className=s.className.replace(RegExp(' ?'+y),'')}; (a[n]=a[n]||[]).hide=h;setTimeout(function(){i();h.end=null},c);h.timeout=c; })(window,document.documentElement,'async-hide','dataLayer',4000, {'GTM-MWRV7QL':true});
    </script> 
    <script type="text/javascript">
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-81177317-1', 'auto');
        ga('require', 'GTM-MWRV7QL');
        @if ($whitelabel_group->ga!='')
        ga('create', '{{ $whitelabel_group->ga }}', 'auto', 'clientTracker');
        ga('clientTracker.send', 'pageview');
        @endif
        ga('send', 'pageview');
    </script>
    <meta charset="UTF-8"/>
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="//assets.anyshare.coop">
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/><![endif]-->

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
    <meta name="ajax-csrf-token" content="{{ csrf_token() }}"/>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha256-916EbMg70RQy9LHiGkXzG8hSg9EdNy97GazNG/aiY1w=" crossorigin="anonymous" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha256-rByPlHULObEjJ6XQxW/flG2r+22R5dKiAoef+aXWfik=" crossorigin="anonymous" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.0.0/bootstrap-social.min.css" integrity="sha256-aNI8KR/Gy4Hb87gooy9+CAjWOeVdSA0S5sd9XMmj4Xo=" crossorigin="anonymous" type="text/css"/>
    <link rel="stylesheet" href="{{ Theme::asset('css/styles.css', null, true) }}" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha256-uKEg9s9/RiqVVOIWQ8vq0IIqdJTdnxDMok9XhiqnApU=" crossorigin="anonymous" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous"/>

    <!-- Bootstrap Table style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.css" integrity="sha256-lHY6r+cFHp2F/XXDvi4iczsIj7nl0r+CBVFD8KdtFqc=" crossorigin="anonymous" type="text/css" media="screen"/>

    <!--our css last -->
    <link href="/assets/css/header-1.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="/assets/css/compiled/app.css?v={{ date('U') }}" type="text/css">
    <link href="/assets/css/color_scheme/{{$whitelabel_group->color}}.css" rel="stylesheet" type="text/css"/>

@yield('custom_css')

<!-- Leaflet and WRLD Maps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" integrity="sha512-M2wvCLH6DSRazYeZRIm1JnYyh22purTM+FDB5CsyxtQJYeKq83arPe5wgbNmcFXGqiSH2XR8dT/fJISVA1r/zQ==" crossorigin=""/>
    @if ($whitelabel_group->wrld3d && $whitelabel_group->wrld3d->get('api_key'))
        <link href="https://cdn-webgl.wrld3d.com/wrldjs/addons/resources/latest/css/wrld.css" rel="stylesheet"/>
    @endif

<!-- Plugins -->
    <script type="text/javascript">var plugin_path = '/assets/plugins/';</script>

    <!-- jQuery 2.2.4-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha256-KM512VNnjElC30ehFwehXjx1YCHPiQkOPmqnrWtpccM=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha256-tQ3x4V2JW+L0ew/P3v2xzL46XDjEWUExFkCDY0Rflqc=" crossorigin="anonymous"></script>

    <script src="/assets/js/extensions/rotate/jQueryRotate.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            if ($('.wl_usercover').length) {
                setBannerHeight();

                $(window).resize(function () {
                    setBannerHeight();
                });

                $('.wl_usercover').show();
            }

            function setBannerHeight () {
                var height = $(window).width() / 4;
                // adaptive height is 25% of width
                $('.wl_usercover').css('height', height);
            }
        });
    </script>
    <script type="text/javascript">
        if (window.location.hash && (window.location.hash == '#=')) {
            window.location.hash = '';
        }
    </script>
    <!-- Bootstrap 3 Javascript is pulled in through the scripts.js file - no need to include it here -->
    <link rel="shortcut icon" href="/favicon.ico">
    
    <!-- start Mixpanel --><script type="text/javascript">(function(e,a){if(!a.__SV){var b=window;try{var c,l,i,j=b.location,g=j.hash;c=function(a,b){return(l=a.match(RegExp(b+"=([^&]*)")))?l[1]:null};g&&c(g,"state")&&(i=JSON.parse(decodeURIComponent(c(g,"state"))),"mpeditor"===i.action&&(b.sessionStorage.setItem("_mpcehash",g),history.replaceState(i.desiredHash||"",e.title,j.pathname+j.search)))}catch(m){}var k,h;window.mixpanel=a;a._i=[];a.init=function(b,c,f){function e(b,a){var c=a.split(".");2==c.length&&(b=b[c[0]],a=c[1]);b[a]=function(){b.push([a].concat(Array.prototype.slice.call(arguments,
0)))}}var d=a;"undefined"!==typeof f?d=a[f]=[]:f="mixpanel";d.people=d.people||[];d.toString=function(b){var a="mixpanel";"mixpanel"!==f&&(a+="."+f);b||(a+=" (stub)");return a};d.people.toString=function(){return d.toString(1)+".people (stub)"};k="disable time_event track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config reset people.set people.set_once people.unset people.increment people.append people.union people.track_charge people.clear_charges people.delete_user".split(" ");
for(h=0;h<k.length;h++)e(d,k[h]);a._i.push([b,c,f])};a.__SV=1.2;b=e.createElement("script");b.type="text/javascript";b.async=!0;b.src="undefined"!==typeof MIXPANEL_CUSTOM_LIB_URL?MIXPANEL_CUSTOM_LIB_URL:"file:"===e.location.protocol&&"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js".match(/^\/\//)?"https://cdn.mxpnl.com/libs/mixpanel-2-latest.min.js":"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";c=e.getElementsByTagName("script")[0];c.parentNode.insertBefore(b,c)}})(document,window.mixpanel||[]);
mixpanel.init("0c8964feac7aebf9f40b95e1cfe55030");</script><!-- end Mixpanel -->
</head>

<body class="smoothscrolll enable-animationn">
<!-- wrapper -->
<div id="wrapper" class="share_wrapper">

    <div>@include('partials.header')</div>

    <!-- Notifications -->
    <div id="notifications" class="container">
        <div class="row">
            @include('notifications')
        </div>
    </div>

    <div id="share_content">@yield('content')</div>
    <div>@include('partials.footer')</div>
</div> <!-- /wrapper -->

@if (isset($whitelabel_group))
    <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js" integrity="sha512-lInM/apFSqyy1o6s89K4iQUKg6ppXEgsVxT35HbzUupEVRh2Eu9Wdl4tHj7dZO0s1uvplcYGmt3498TtHq+log==" crossorigin=""></script>

    @if ($whitelabel_group->wrld3d && $whitelabel_group->wrld3d->get('api_key'))
        <script src="https://cdn-webgl.wrld3d.com/wrldjs/dist/latest/wrld.js"></script>
        <script src="https://cdn-webgl.wrld3d.com/wrldjs/addons/indoor_control/latest/indoor_control.js"></script>
        <script src="https://cdn-webgl.wrld3d.com/wrldjs/addons/marker_controller/latest/marker_controller.js"></script>
    @endif

    @javascript('WRLD_3D_API_KEY', $whitelabel_group->wrld3d ? $whitelabel_group->wrld3d->get('api_key') : '')
    @javascript('MAPBOX_KEY',config('services.mapbox.access_token'))
    @javascript('mapLat', $whitelabel_group->latitude ?: '')
    @javascript('mapLng', $whitelabel_group->longitude ?: '')
@endif

@yield('custom_js')

@include('partials.geo-lookup')
</body>
</html>
