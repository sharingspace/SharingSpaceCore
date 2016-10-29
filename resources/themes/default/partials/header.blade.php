<div class="w-section">
    <div class="w-background-video background-video {{$bannerClasses}}" style="color:red;height:{{$bannerHeight}}">
        <video autoplay="autoplay" loop="loop" poster='/assets/img/hp/poster.png'>
            @if (Route::is('about') || Route::is('coop') || Route::is('coop_success'))
                <source src="/assets/movies/clothing-transcode.webm" data-wf-ignore="">
                <source src="/assets/movies/clothing-transcode.mp4" data-wf-ignore="">
            @else
                <source src="/assets/movies/anyshare_homepage_vid-transcode.webm" data-wf-ignore="">
                <source src="/assets/movies/anyshare_homepage_vid-transcode.mp4" data-wf-ignore="">
            @endif
        </video>
        <div class="w-nav nav-bar">
            <div id="header" class="header_dropShadow sticky clearfix header-sm" style="background-color:transparent!important;">

                <!-- TOP NAV -->
                <div id="topNav" >
                    <div class="container">
                        <!-- Mobile Menu Button -->
                        <button class="btn btn-mobile text-white" data-toggle="collapse" data-target=".nav-main-collapse">
                            <i class="fa fa-bars"></i>
                        </button>

                        <!-- Logo -->
                        <a href="/" class="w-nav-brand">
                            <img width="200" src="/assets/img/hp/anyshare-logo-web-retina.png" class="logo">
                            <!-- <img width="230" src="/assets/img/hp/anyshare-logo-beta.png" class="logo"> -->
                        </a>

                        <!-- Top Nav -->
                        <div class="navbar-collapse pull-right nav-main-collapse collapse">
                            <nav class="nav-main">
                                <ul id="topMain" class="nav nav-pills nav-main nav-onepage">
                                    <li><a href="{{ URL::to('features') }}">{{ trans('general.nav.features') }}</a></li>
                                    <li><a href="{{ URL::to('pricing') }}">{{ trans('pricing.headline') }} <span class="sr-only">(current)</span></a></li>
                                    @if (Auth::check())
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="{{ Auth::user()->gravatar_img() }}" class="avatar-smm" style="height:25px;width:25px;margin-right:5px;">{{ Auth::user()->getDisplayName() }} <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ route('user.history') }}">{{ trans('general.nav.order_history') }} </a></li>
                                            <li><a href="{{ route('logout') }}">{{ trans('general.nav.logout') }} </a></li>
                                        </ul>
                                    </li>
                                    @else
                                    <li><a href="{{ route('register') }}">Try</a></li>

                                    <li><a href="{{ route('login') }}">{{ trans('general.nav.login') }} </a> </li>
                                    @endif
                                    @can('admin')
                                        <li><a href="{{ route('admin.index') }}">Admin</a></li>
                                    @endcan
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (Route::is('home'))
           <h1 class="heading">{{ trans('home.home_headline') }}</h1>
            <h2 class="hp_subheading">
                {{ trans('home.subhome_headline') }}<br>
                <div class="header_cta_button">
                    <a href="{{ route('community.create.form') }}" class="btn-warning btn btn-sm contained-button size-18 weight-800 font-smoothing">1 Minute Start</a>
                </div>
            </h2>
            <div class="scroll-button-div"></div>
        @elseif (Route::is('login'))
            <h1 class="heading">{{trans('general.nav.login') }}</h1>
        @elseif (Route::is('register'))
            <h1 class="heading">
                {{trans('general.nav.register') }}
            @if (!empty($subdomain))
                <h2 class="subheading size-30 margin-top-20">To join <em>{{ucfirst($subdomain)}}'s</em> share,<br>create an account with AnyShare</h2>
            @endif
            </h1>
        @elseif (Route::is('community.create.form'))
            <h1 class="heading">{{trans('general.community.create') }}</h1>
        @elseif (Route::is('assistance'))
            <h1 class="heading">{{trans('pricing.financial_assist.apply') }}</h1>
        @elseif (Route::is('coop'))
            <h1 class="heading">{{ trans('coop.headline') }}</h1>
            <h2 class="subheading">{{ trans('coop.mission_subheadline') }}</h2>
        @elseif (Route::is('coop_success'))
            <h1 class="heading">{{ trans('coop.congrats') }}</h1>
            <h2 class="subheading">{{ trans('coop.you_are_member') }}</h2>
        @elseif (Route::is('about'))
            <h1 class="heading">{{trans('general.nav.about_mission') }}</h1>
            <h2 class="subheading">{{ trans('about.end_scarcity') }}</h2>
        @elseif (Route::is('features'))
            <h1 class="heading">Features.</h1>
            <h2 class="subheading">"Shares" help a group or community exchange.</h2>
        @else  
            <!-- using route name as the h1 -->
            <h1 class="heading">{{ucfirst(Route::getCurrentRoute()->getPath())}}</h1>
        @endif
    </div>
</div>
