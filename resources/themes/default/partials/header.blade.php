
<!-- Top Bar -->
  <div id="topBar">
    <div class="container">

      <!-- right -->
      <ul class="top-links list-inline pull-right">


        @if (Auth::check())
        <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="{{ Auth::user()->gravatar() }}" class="avatar-sm">{{ Auth::user()->getDisplayName() }} <span class="caret"></span></a>
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

      <!-- left -->
      <ul class="top-links list-inline">

            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <li>
                    <a rel="alternate" hreflang="{{$localeCode}}" href="{{ LaravelLocalization::getLocalizedURL($localeCode) }} ">
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
            <a class="logo pull-left navbar-brand" href="/"><img src="/assets/img/anyshare-logo-squares.png"></a>

						<!--
							Top Nav

							AVAILABLE CLASSES:
							submenu-dark = dark sub menu
						-->
						<div class="navbar-collapse pull-right nav-main-collapse collapse">
							<nav class="nav-main">
								<ul id="topMain" class="nav nav-pills nav-main nav-onepage">
                  <li><a href="/#about">{{ trans('general.nav.basics') }} <span class="sr-only">(current)</span></a></li>
                  <li><a href="/#features">{{ trans('general.nav.features') }}</a></li>
                  <!-- <li><a href="/#examples">{{ trans('general.nav.examples') }}  </a></li>-->
                  <li><a href="{{ route('community.create.form') }}">{{ trans('general.nav.create_sharing_hub') }} </a></li>
								</ul>

							</nav>
						</div>

					</div>
				</header>
				<!-- /Top Nav -->

			</div>
