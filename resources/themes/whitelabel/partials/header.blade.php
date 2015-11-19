
<!-- Top Bar -->
  <div id="topBar">
    <div class="container">

      <!-- right -->
      <ul class="top-links list-inline pull-right">


        @if (Auth::check())
        <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="{{ Auth::user()->gravatar() }}" class="avatar-sm">{{ Auth::user()->getDisplayName() }} <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="{{ route('user.settings') }}"><i class="fa fa-gears"></i> {{ trans('general.nav.settings') }}</a></li>
                <li><a href="{{ route('logout') }}"><i class="fa fa-power-off"></i> {{ trans('general.nav.logout') }} </a></li>
              </ul>
        </li>

        <!-- QUICK SHOP CART -->
				<li class="quick-cart">
					<a href="#">
						<span class="badge badge-red btn-xs badge-corner-sm">2</span>
						<i class="fa fa-envelope-o"></i>
					</a>
					<div class="quick-cart-box" style="display: none;">
						<h4>Messages</h4>

						<div class="quick-cart-wrapper">
							<a class="text-center" href="#">
								<h6>0 MESSAGES</h6>
							</a>
						</div>

						<!-- quick cart footer -->
						<div class="quick-cart-footer clearfix">
							<a href="/user/messages" class="btn btn-primary btn-xs pull-right">VIEW MESSAGES</a>
							<!-- <span class="pull-left"><strong>TOTAL:</strong> $54.39</span> -->
						</div>
						<!-- /quick cart footer -->

					</div>
				</li>
				<!-- /QUICK SHOP CART -->




        @else
          <li><a href="{{ route('login') }}">{{ trans('general.nav.login') }} </a> </li>
          <li><a href="{{ route('register') }}">{{ trans('general.nav.register') }} </a></li>
        @endif
      </ul>

      <!-- left -->
      <ul class="top-links list-inline">

            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <li>
                    <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode) }} ">
                      <img src="/assets/img/flags/{{ $localeCode }}.png" width="16" height="11" alt="lang" />
                        {{{ $properties['native'] }}}
                    </a>
                </li>
            @endforeach

      </ul>


    </div>
  </div>
  <!-- /Top Bar -->


      <!--
				AVAILABLE HEADER CLASSES

				Default nav height: 96px
				.header-md 		= 70px nav height
				.header-sm 		= 60px nav height

				.noborder 		= remove bottom border (only with transparent use)
				.transparent	= transparent header
				.translucent	= translucent header
				.sticky			= sticky header
				.static			= static header
				.dark			= dark header
				.bottom			= header on bottom

				shadow-before-1 = shadow 1 header top
				shadow-after-1 	= shadow 1 header bottom
				shadow-before-2 = shadow 2 header top
				shadow-after-2 	= shadow 2 header bottom
				shadow-before-3 = shadow 3 header top
				shadow-after-3 	= shadow 3 header bottom

				.clearfix		= required for mobile menu, do not remove!

				Example Usage:  class="clearfix sticky header-sm transparent noborder"
			-->
			<div id="header" class="sticky clearfix header-sm">

				<!-- TOP NAV -->
				<header id="topNav">
					<div class="container">

						<!-- Mobile Menu Button -->
						<button class="btn btn-mobile" data-toggle="collapse" data-target=".nav-main-collapse">
							<i class="fa fa-bars"></i>
						</button>

						<!-- Logo -->
            <a class="logo pull-left navbar-brand" href="{{ route('home') }}">
              @if ($whitelabel_group->logo!='')
                <img src="{{ $whitelabel_group->getLogo() }}">
              @else
                {{ $whitelabel_group->name }}
              @endif
            </a>
            @if ($whitelabel_group->location!='')
              <div class="pull-left" style="padding-left: 10px; padding-top: 23px;">
                {{ $whitelabel_group->location}}
              </div>
            @endif

						<!--
							Top Nav

							AVAILABLE CLASSES:
							submenu-dark = dark sub menu
						-->
						<div class="navbar-collapse pull-right nav-main-collapse collapse">
							<nav class="nav-main">

								<!--
									.nav-onepage
									Required for onepage navigation links

									Add .external for an external link!
								-->
								<ul id="topMain" class="nav nav-pills nav-main nav-onepage">
                  <li{!! (Route::is('browse') ? ' class="active"' : '') !!}>
                    <a href="{{ route('browse') }}">
                      {{ trans('general.nav.browse') }}
                      {!! (Route::is('browse') ? '<span class="sr-only">(current)</span>' : '') !!}
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      {{ trans('general.nav.add') }}
                      {!! (Route::is('browse') ? '<span class="sr-only">(current)</span>' : '') !!}
                    </a>
                  </li>
                  <li{!! (Route::is('members') ? ' class="active"' : '') !!}>
                    <a href="{{ route('members') }}">
                      {{ trans('general.nav.members') }}
                      {!! (Route::is('members') ? '<span class="sr-only">(current)</span>' : '') !!}
                    </a>
                  </li>
								</ul>

							</nav>
						</div>

					</div>
				</header>
				<!-- /Top Nav -->

			</div>

  <div class="col-md-12 wl_usercover" style="background-image: url({{ $whitelabel_group->getCover() }});">

  </div>

<div class="col-md-12">
	<!-- Notifications -->
	@include('notifications')
</div>
