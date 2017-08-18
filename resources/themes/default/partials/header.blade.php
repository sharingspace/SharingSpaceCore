<div class="w-section">
  <div class="background-video" style="height:{{ $bannerHeight or '' }}">
    <video autoplay="autoplay" loop="loop" poster='{{ Helper::cdn('img/hp/poster.png') }}'>
      @if (Route::is('about') || Route::is('coop') || Route::is('coop_success'))
      <source src="{{ Helper::cdn('movies/clothing-transcode.webm') }}" data-wf-ignore="">
      <source src="{{ Helper::cdn('movies/clothing-transcode.mp4') }}" data-wf-ignore="">
      @else
      <source src="{{ Helper::cdn('movies/homepage-720-high.webm') }}" data-wf-ignore="">
      <source src="{{ Helper::cdn('movies/homepage-720-high.mp4') }}" data-wf-ignore="">
      @endif
    </video>

    <!-- Top Bar -->
    <div id="topBar">
      <div class="container">
      <!-- right -->
      <ul class="top-links list-inline pull-right">
        @if (Auth::check())
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="{{ Auth::user()->gravatar_img() }}" class="avatar-sm" style="height:25px;width:25px;margin-right:5px;">{{ Auth::user()->getDisplayName() }} <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('user.history') }}">{{ trans('general.nav.my_orders') }} </a></li>
            <li><a href="{{ route('account.memberships.view') }}">{{ trans('general.memberships') }}</a></li>
            <li><a href="{{ route('logout') }}">{{ trans('general.nav.logout') }} </a></li>
          </ul>
        </li>
        <!-- NOTIFICATION BOX -->
        @if (0)
        <li class="notifications-popdown">
          <a href="#">
          @if (Auth::user()->getUnreadMessagesCount() > 0)
            <span class="badge badge-red btn-xs badge-corner-sm">{{ Auth::user()->getUnreadMessagesCount() }}</span>
          @endif
            <i class="fa fa-envelope-o"></i>
          </a>

          <div class="notifications-popdown-box" style="display: none;border-left: 1px rgba(91, 91, 91, 0.2) solid; padding-left: 10px;">
            <div class="notifications-popdown-wrapper">
              <div class="clearfix margin-bottom-20 text-center"><!-- notification item -->
                {{ Auth::user()->getUnreadMessagesCount() }} {{ trans('general.nav.new_messages') }}
              </div>

              @foreach (Auth::user()->getLimitedUnreadMessages() as $unread_messages)
              <div class="clearfix margin-bottom-10 member_thumb">
                <!-- notification item -->
                <img src="{{ $unread_messages->sender->gravatar_img() }}" class="pull-left" style="margin-left: 5px; margin-top: 5px;">
                <span class="text-muted">
                  {{ $unread_messages->sender->getDisplayName() }}
                </span>
                <span class="text-muted">
                  <span class="pull-right margin-right-5">
                    {{ date('M j, Y', strtotime($unread_messages->created_at)) }}
                  </span>
                  <br>
                  <a href="/account/message/thread/{{ $unread_messages->thread_id }}">
                    {{Str::limit($unread_messages->message, 50)}}
                  </a>
                </span>
              </div><!-- /notification item -->
              @endforeach

              <!-- quick cart footer -->
              <div class="notifications-popdown-footer clearfix">
                <a href="/account/messages" class="btn btn-primary btn-xs pull-right">{{ trans('general.nav.view_all') }}</a>
                <!-- <span class="pull-left"><strong>TOTAL:</strong> $54.39</span> -->
              </div>
              <!-- /quick cart footer -->
            </div>
          </li>
          <!-- NOTIFICATION BOX -->
          @endif
          @else
          <li><a href="{{ route('register') }}">{{ trans('general.nav.try') }}</a></li>
          <li><a href="{{ route('login') }}">{{ trans('general.nav.login') }} </a> </li>
          @endif
          @can('admin')
          <li><a href="{{ route('admin.index') }}">Admin</a></li>
          @endcan
        </ul>

        <!-- left -->
        <ul class="top-links"> 
          <li class="dropdown languages">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{App::getLocale()}}<span class="caret"></span></a>
            <ul class="dropdown-menu">
              @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
              <li class="language_select">
                <a rel="alternate" hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode)}}">{{$properties['native']}}</a>
              </li>
              @endforeach
              <li class="language_select">
                <a class="show5" href="https://anyshare.freshdesk.com/support/solutions/articles/17000035900-is-anyshare-available-in-my-language-">
                   <i class="fa fa-ellipsis-h"> more</i>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
    <!-- /Top Bar -->

    <div class="w-nav nav-bar">
      <div id="header" class="header_dropShadow sticky clearfix header-sm">
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
            </a>

            <!-- Top Nav -->
            <div class="navbar-collapse pull-right nav-main-collapse collapse">
              <nav class="nav-main">
                <ul id="topMain" class="nav nav-pills nav-main nav-onepage">
                  <li {!! (Route::is('product') ? ' class="active"' : '') !!}>
                    <a href="{{ route('product') }}">{{ trans('general.nav.features') }}</a>
                  </li>
                  <li {!! (Route::is('memberships') ? ' class="active"' : '') !!}>
                    <a href="{{ route('memberships') }}">{{ trans('general.memberships') }}</a>
                  </li>
                  <li {!! (Route::is('about') ? ' class="active"' : '') !!}>
                    <a href="{{ route('about') }}">{{ trans('about.headline') }} <span class="sr-only">(current)</span></a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="headerWrapper">
      <div class="container">
        @if (Route::is('home'))
        <div class="row">
          <div class="col-xs-12">
            <h1 class="hp_heading">{!! trans('general.make_share') !!}</h1>
            <h2 class="hp_subheading">{!! trans('home.subhome_headline') !!}</h2>
            <div class="pull-left margin-top-10">
              <a class="cta-button contained-button size-20 bg-black border-dkgray" href="{{ route('product') }}">
                {{ trans('general.learn_more') }}
              </a>
              <a class="cta-button contained-button size-20 margin-left-5 bg-red border-crimson" href="{{ route('memberships') }}">
                {{ trans('home.free_membership') }}
              </a>
            </div>
          </div>
        </div>
        @elseif (Route::is('login'))
        <h1 class="heading">{{trans('general.nav.login') }}</h1>
        @elseif (Route::is('register'))
        <h2 class="heading">
        {{trans('general.nav.register') }}
        @if (!empty($subdomain))
        <h2 class="subheading size-30 margin-top-20">
          To join <em>{{ucfirst($subdomain)}}'s</em> share,<br>create an account with AnyShare</h2>
        @endif
        </h2>
        @elseif (Route::is('community.create.form'))
        <h1 class="heading">{!!trans('general.start_share') !!}</h1>
        @elseif (Route::is('coop'))
        <h1 class="heading">{{ trans('coop.headline') }}</h1>
        <h2 class="subheading">{{ trans('coop.mission_subheadline') }}</h2>
        @elseif (Route::is('coop_success'))
        <h1 class="heading">{{ trans('coop.congrats') }}</h1>
        @elseif (Route::is('about'))
        <h1 class="heading">{{trans('about.headline') }}</h1>
        <h2 class="subheading">{{ trans('about.sub_headline') }}</h2>
        @elseif (Route::is('product'))
        <h1 class="heading">{{ trans('general.nav.features')}}</h1>
        <h2 class="subheading">{{ trans('general.page_about.product')}}</h2>
        @elseif (Route::is('register'))
        <h1 class="heading">{{ trans('general.nav.try_now') }}</h1>
        <h2 class="subheading">{!! trans('general.nav.join_public_shares_free')!!}</h2>
        @elseif (Route::is('user.history'))
        <h1 class="heading">{{ trans('general.nav.my_orders') }}</h1>
        @elseif (Route::is('register'))
        <h1 class="heading">{{ trans('auth.create_account') }}</h1>
        <h2 class="subheading">{{ trans('auth.join_public_shares') }}</h2>
        @elseif (Route::is('pricing_page'))
        <h1 class="heading">{{ trans('pricing.headline') }}</h1>
        <h2 class="subheading">{{ trans('pricing.sub_headline') }}</h2>
        <a class="cta-button contained-button size-20 margin-top-15 bg-blue" href="{{ route('register') }}">
          {{ trans('home.free_signup') }}
        </a>
        @else  
        <!-- using route name as the h1 -->
        <h1 class="heading">{{ucfirst(Route::getFacadeRoot()->current()->uri())}}</h1>
        @endif
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $( document ).ready(function() {
    $( document ).tooltip();
  });
</script>
