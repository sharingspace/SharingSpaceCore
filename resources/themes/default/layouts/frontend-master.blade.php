<!DOCTYPE html>
<html lang="en">

<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
        <link rel="shortcut icon" href="images/favicon.png"/>
        <title>Modern Agency &#8211; Moody HTML Template</title>

        <link rel="stylesheet" href="/frontend/css/bootstrap.min.css" type="text/css" media="all"/>
        <link rel="stylesheet" href="/frontend/css/font-awesome.min.css" type="text/css" media="all" />
        <link rel="stylesheet" href="/frontend/css/simple-line-icons.css" type="text/css" media="all" />
        <link rel="stylesheet" href="/frontend/css/settings.css" type="text/css" media="all"/>
        <link rel="stylesheet" href="/frontend/css/magnific-popup.css" type="text/css" media="all"/>
        <link rel="stylesheet" href="/frontend/css/owl.carousel.css" type="text/css" media="all"/>
        <link rel="stylesheet" href="/frontend/css/owl.theme.css" type="text/css" media="all"/>
        <link rel="stylesheet" href="/frontend/css/owl.transitions.css" type="text/css" media="all"/>
        <link rel="stylesheet" href="/frontend/css/style.css" type="text/css" media="all"/>
        <link rel="stylesheet" href="/frontend/css/custom.css" type="text/css" media="all"/>
        <link href="//fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900%7CLibre+Baskerville:400,400i,700" rel="stylesheet"/>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    @yield('styles')
</head>

<body>
    <div class="noo-spinner">
        <div class="spinner">
            <div class="cube1"></div>
            <div class="cube2"></div>
        </div>
    </div>
    <div id="search-hider"></div>
    <div class="search-form-top">
        <div class="search-form-top-inner">
            <form class="form-search">
                <input type="text" value="" name="s" id="search_top" class="highlighted" placeholder="Type And Hit ENTER...">
            </form>
            <div class="search-close">
                <div class="line line-1"></div>
                <div class="line line-2"></div>
            </div>
        </div>
    </div>
    <div class="site">
        @include('includes/header')        
        
        	@yield('content')
        
        @include('includes/footer')

    </div>
    
    <a id="backtotop" class="scrollup scrollup--fixed"><i class="fa fa-angle-up"></i></a>

    <!-- LOAD JQUERY LIBRARY -->
    <script src="/frontend/js/jquery.min.js"></script>
    <script src="/frontend/js/jquery-migrate.min.js"></script>
    <script src="/frontend/js/bootstrap.min.js"></script>
    <script src="/frontend/js/modernizr-2.7.1.min.js"></script>
    <script src="/frontend/js/imagesloaded.pkgd.min.js"></script>
    <script src="/frontend/js/isotope.pkgd.min.js"></script>
    <script src="/frontend/js/packery-mode.pkgd.min.js"></script>
    <script src="/frontend/js/jquery.justifiedGallery.min.js"></script>
    <script src="/frontend/js/jquery.isotope.init.js"></script>
    <script src="/frontend/js/jquery.magnific-popup.min.js"></script>
    <script src="/frontend/js/owl.carousel.min.js"></script>
    <script src="/frontend/js/headroom.min.js"></script>
    <script src="/frontend/js/jQuery.headroom.js"></script>
    <script src="/frontend/js/waypoints.min.js"></script>
    <script src="/frontend/js/circle-progress.min.js"></script>
    <script src="/frontend/js/pie-chart.js"></script>
    <script src="/frontend/js/jquery.counterup.min.js"></script>
    <script src="/frontend/js/script.js"></script>

    <script src="/frontend/js/jquery.themepunch.tools.min.js"></script>
    <script src="/frontend/js/jquery.themepunch.revolution.min.js"></script>
    <script src="/frontend/js/extensions/revolution.extension.video.min.js"></script>
    <script src="/frontend/js/extensions/revolution.extension.slideanims.min.js"></script>
    <script src="/frontend/js/extensions/revolution.extension.actions.min.js"></script>
    <script src="/frontend/js/extensions/revolution.extension.layeranimation.min.js"></script>
    <script src="/frontend/js/extensions/revolution.extension.kenburn.min.js"></script>
    <script src="/frontend/js/extensions/revolution.extension.navigation.min.js"></script>
    <script src="/frontend/js/extensions/revolution.extension.migration.min.js"></script>
    <script src="/frontend/js/extensions/revolution.extension.parallax.min.js"></script>
    @yield('scripts')

</body>

</html>