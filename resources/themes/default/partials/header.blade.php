<div class="w-section">
    <div class="w-background-video background-video {{$bannerClasses}}" style="height:{{$bannerHeight}}">
    <video autoplay="autoplay" loop="loop" poster='https://daks2k3a4ib2z.cloudfront.net/5732933114b267cf667f7706/5732950814b267cf667f7c6c_homepage-Wi-Fi%20High%20v4-poster-00001.png'><source src="https://daks2k3a4ib2z.cloudfront.net/5732933114b267cf667f7706/5732950814b267cf667f7c6c_homepage-Wi-Fi High v4-transcode.webm" data-wf-ignore=""><source src="https://daks2k3a4ib2z.cloudfront.net/5732933114b267cf667f7706/5732950814b267cf667f7c6c_homepage-Wi-Fi High v4-transcode.mp4" data-wf-ignore="">
    </video>
        <div class="w-nav nav-bar">
            <div id="header" class="header_dropShadow sticky clearfix header-sm" style="background-color:transparent!important;">

                <!-- TOP NAV -->
                <div id="topNav" >
                    <div class="container">
                        <!-- Mobile Menu Button -->
                        <button class="btn btn-mobile" data-toggle="collapse" data-target=".nav-main-collapse">
                            <i class="fa fa-bars"></i>
                        </button>

                        <!-- Logo -->
                        <a href="/" class="w-nav-brand">
                                <img width="200" src="/assets/img/hp/anyshare-logo-web-retina.png" class="logo">
                            </a>

                        <!-- Top Nav -->
                        <div class="navbar-collapse pull-right nav-main-collapse collapse">
                            <nav class="nav-main">
                                <ul id="topMain" class="nav nav-pills nav-main nav-onepage">
                                    <li><a href="{{ URL::to('features') }}">{{ trans('general.nav.features') }}</a></li>
                                    <li><a href="{{ URL::to('pricing') }}">{{ trans('pricing.headline') }} <span class="sr-only">(current)</span></a></li>
                                    @if (Auth::check())
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="{{ Auth::user()->gravatar() }}" class="avatar-smm" style="height:25px;width:25px;margin-right:5px;">{{ Auth::user()->getDisplayName() }} <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ route('user.history') }}">{{ trans('general.nav.order_history') }} </a></li>
                                            <li><a href="{{ route('logout') }}">{{ trans('general.nav.logout') }} </a></li>
                                        </ul>
                                    </li>
                                    @else
                                    <li><a href="{{ route('login') }}">{{ trans('general.nav.login') }} </a> </li>
                                    <li><a href="{{ route('register') }}">{{ trans('general.nav.register') }} </a></li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (Route::is('home'))
            <h1 class="hp_heading">{{ trans('home.home_headline') }}<br>
            <span class="subheading">{{ trans('home.subhome_headline') }}</span><br>
            <a href="{{ route('community.create.form') }}" class="w-button cta-button contained-button size-20"">START NOW</a></h1>
            <div class="scroll-button-div"></div>
        @elseif (Route::is('login'))
            <h1 class="heading">{{trans('general.nav.login') }}</h1>
        @elseif (Route::is('register'))
            <h1 class="heading">{{trans('general.nav.register') }}</h1>
        @elseif (Route::is('community.create.form'))
            <h1 class="heading">{{trans('general.community.create') }}</h1>
        @elseif (Route::is('assistance'))
            <h1 class="heading">{{trans('pricing.financial_assist.apply') }}</h1>
        @elseif (Route::is('coop'))
            <h1 class="heading">{{ trans('coop.headline') }}</h1>
        @else  
            <!-- using route name as the h1 -->
            <h1 class="heading">{{ucfirst(Route::getCurrentRoute()->getPath())}}</h1>
        @endif
    </div>
</div>