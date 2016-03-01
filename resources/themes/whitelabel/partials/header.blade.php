
<!-- Top Bar -->
  <div id="topBar">
    <div class="container">

      <!-- right -->
      <ul class="top-links list-inline pull-right">


        @if (Auth::check())
        <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="{{ Auth::user()->gravatar() }}" class="avatar-sm">{{ Auth::user()->getDisplayName() }} <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="{{ route('user.profile', Auth::user()->id) }}"><i class="fa fa-user"></i> {{ trans('general.nav.profile') }}</a></li>
                <li><a href="{{ route('user.settings.view') }}"><i class="fa fa-gears"></i> {{ trans('general.nav.settings') }}</a></li>
                <li><a href="{{ route('logout') }}"><i class="fa fa-power-off"></i> {{ trans('general.nav.logout') }} </a></li>
              </ul>
        </li>

        <!-- NOTIFICATION BOX -->
				<li class="notifications-popdown">
					<a href="#">
						<span class="badge badge-red btn-xs badge-corner-sm">2</span>
						<i class="fa fa-envelope-o"></i>
					</a>
					<div class="notifications-popdown-box" style="display: none;">
						<div class="notifications-popdown-wrapper">

              <div class="clearfix margin-bottom-20"><!-- notification item -->
  							<span class="label label-success label-square pull-left">
  								<i class="fa fa-comment"></i>
  							</span>
  							<span class="size-14 text-muted">
                  <b>New Comment</b>: Lorem ipsum Dolor
                </span>
              </div><!-- /notification item -->

              <div class="clearfix margin-bottom-20"><!-- notification item -->
								<span class="label label-danger label-square pull-left">
									<i class="fa fa-heart-o"></i>
								</span>
								<span class="size-14 text-muted"><b>Fav'd</b>: Lorem ipsum Dolor</span>
							</div><!-- /notification item -->

						</div>

						<!-- quick cart footer -->
						<div class="notifications-popdown-footer clearfix">
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

						<div class="navbar-collapse pull-right nav-main-collapse collapse">
							<nav class="nav-main">

								<ul id="topMain" class="nav nav-pills nav-main nav-onepage">
                  <li{!! (Route::is('browse') ? ' class="active"' : '') !!}>
                    <a href="{{ route('browse') }}">
                      {{ trans('general.nav.browse') }}
                      {!! (Route::is('browse') ? '<span class="sr-only">(current)</span>' : '') !!}
                    </a>
                  </li>
                  <li{!! (Route::is('members') ? ' class="active"' : '') !!}>
                    <a href="{{ route('members') }}">
                      {{ trans('general.nav.members') }}
                      {!! (Route::is('members') ? '<span class="sr-only">(current)</span>' : '') !!}
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('entry.create.form') }}">
                      <button type="button" class="btn btn-sm btn-warning">
                        {{ trans('general.nav.create') }}
                      </button>
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('community.edit.form')}}">
                      <i class="fa fa-cogs"></i>
                      {!! (Route::is('community.edit.form') ? '<span class="sr-only">(current)</span>' : '') !!}
                    </a>
                  </li>
                  <!-- SEARCH -->
    							<li class="search">
    								<a href="javascript:;">
    									<i class="fa fa-search"></i>
    								</a>
    								<div class="search-box">
    									<form action="#" method="get">
    										<div class="input-group">
    											<input type="text" name="src" placeholder="Search this Community" class="form-control" />
    											<span class="input-group-btn">
    												<button class="btn btn-primary" type="submit">Search</button>
    											</span>
    										</div>
    									</form>
    								</div>
    							</li>
    							<!-- /SEARCH -->



								</ul>

							</nav>
						</div>

					</div>
				</header>
				<!-- /Top Nav -->

			</div>

  <div class="col-md-12 wl_usercover" style="background-image: url({{ $whitelabel_group->getCover() }});">

  </div>
