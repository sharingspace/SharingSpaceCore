<div class="w-section">
    <div class="w-background-video background-video {{$bannerClasses}}" style="height:{{$bannerHeight}}">
        <video autoplay="autoplay" loop="loop" poster='{{ Helper::cdn('img/hp/poster.png') }}'>
            @if (Route::is('about') || Route::is('coop') || Route::is('coop_success'))
                <source src="{{ Helper::cdn('movies/clothing-transcode.webm') }}" data-wf-ignore="">
                <source src="{{ Helper::cdn('movies/clothing-transcode.mp4') }}" data-wf-ignore="">
            @else
                <source src="{{ Helper::cdn('movies/homepage-720-high.webm') }}" data-wf-ignore="">
                <source src="{{ Helper::cdn('movies/homepage-720-high.mp4') }}" data-wf-ignore="">
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
                            <img width="230" src="{{ Helper::cdn('img/hp/anyshare-logo-web-retina.png') }}" class="logo">
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
                                            <li><a href="{{ route('user.history') }}">{{ trans('general.nav.my_orders') }} </a></li>
                                            <li><a href="{{ route('logout') }}">{{ trans('general.nav.logout') }} </a></li>
                                        </ul>
                                    </li>

                                    <li><button class="margin-top-15 btn-warning btn btn-xs contained-button size-18 weight-800 font-smoothing bg_share+ "><a class="text-white" href="{{ route('community.create.form') }}" >{{ trans('general.nav.share+') }}</a></button></li>
                                    @else
                                    <li><a href="{{ route('user.register') }}">{{ trans('general.nav.try') }}</a></li>

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
                    <a class="w-button cta-button contained-button size-20" href="{{ route('community.create.form') }}">
                        {{ trans('general.nav.try_now') }}
                    </a>
                </div>
            </h2>
        @elseif (Route::is('login'))
            <h1 class="heading">{{trans('general.nav.login') }}</h1>
        @elseif (Route::is('register'))
            <h2 class="heading">
                {{trans('general.nav.register') }}
            @if (!empty($subdomain))
                <h2 class="subheading size-30 margin-top-20">To join <em>{{ucfirst($subdomain)}}'s</em> share,<br>create an account with AnyShare</h2>
            @endif
            </h2>
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
            <h1 class="heading">{{trans('about.headline') }}</h1>
            <h2 class="subheading">{{ trans('about.sub_headline') }}</h2>
        @elseif (Route::is('features'))
            <h1 class="heading">Features.</h1>
            <h2 class="subheading">"Shares" help a group or community exchange.</h2>
        @elseif (Route::is('auth/register'))
            <h1 class="heading">{{ trans('general.nav.try_now') }}</h1>
            <h2 class="subheading">{!! trans('general.nav.join_public_shares_free')!!}</h2>
        @elseif (Route::is('user.history'))
            <h1 class="heading">{{ trans('general.nav.my_orders') }}</h1>
        @elseif (Route::is('user.register'))
            <h1 class="heading">{{ trans('auth.create_account') }}</h1>
            <h2 class="subheading">{{ trans('auth.join_public_shares') }}</h2>
        @elseif (Route::is('pricing_page'))
            <h1 class="heading">{{ trans('pricing.headline') }}</h1>
        @else  
            <!-- using route name as the h1 -->
            <h1 class="heading">{{ucfirst(Route::getCurrentRoute()->getPath())}}</h1>
        @endif
    </div>
</div>
