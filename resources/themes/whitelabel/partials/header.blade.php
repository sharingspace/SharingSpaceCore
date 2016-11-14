
<!-- Top Bar -->
  <div id="topBar">
    <div class="container">

      <!-- right -->
      <ul class="top-links list-inline pull-right">


        @if (Auth::check())
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="{{ Auth::user()->gravatar_img() }}" class="avatar-sm">{{ Auth::user()->getDisplayName() }} <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('account.memberships.view') }}"><i class="fa fa-users"></i> Memberships</a></li>
            <li><a href="{{ route('user.profile', Auth::user()->id) }}"><i class="fa fa-user"></i> {{ trans('general.nav.profile') }}</a></li>
            <li><a href="{{ route('user.settings.view') }}"><i class="fa fa-gears"></i> {{ trans('general.nav.settings') }}</a></li>
            <li><a href="{{ route('logout') }}"><i class="fa fa-power-off"></i> {{ trans('general.nav.logout') }} </a></li>
          </ul>
        </li>

        <!-- NOTIFICATION BOX -->
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
                  {{ Auth::user()->getUnreadMessagesCount() }} new messages
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
							<a href="/account/messages" class="btn btn-primary btn-xs pull-right">View all Messages</a>
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
      <ul class="top-links list-inline hide">
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
            @if ($whitelabel_group->location!='')
              <span class="block-inline pull-right margin-left-10">
                &ndash; {{ $whitelabel_group->location}}
              </span>
            @endif
          @endif
        </a>

        @if (Auth::check() && Auth::user()->canSeeCommunity($whitelabel_group))
        <div class="navbar-header pull-right">
          <ul class="nav navbar-nav">
            <li class="add_entry_button">
              <a href="{{ route('entry.create.form') }}">
                <button type="button" class="btn btn-sm btn-warning" title="Add entry"><i class="fa fa-plus"></i><span class="hidden-xs"> Entry</span></button>
              </a>
            </li>
          </ul>
        </div>
        @endif

        <div class="margin-left-10 navbar-collapse pull-right nav-main-collapse collapse">
          <nav class="nav-main">
            <ul id="topMain" class="nav nav-pills nav-main nav-onepage">
            @if ((Auth::check()) && (!Auth::user()->isMemberOfCommunity($whitelabel_group)))
              <li>
                <a style="color:white;" href="{{ route('join-community') }}">
                  <button type="button" class="btn btn-warning btn-sm">
                    Join this Share
                  </button>
                </a>
              </li>
            @endif

            @can('view-browse', $whitelabel_group)
              <li {!! (Route::is('home') ? ' class="active"' : '') !!}>
                <a href="{{ route('home') }}">
                  {{ trans('general.nav.browse') }}
                  {!! (Route::is('home') ? '<span class="sr-only">(current)</span>' : '') !!}
                </a>
              </li>
              <li{!! (Route::is('members') ? ' class="active"' : '') !!}>
                <a href="{{ route('members') }}">
                  {{ trans('general.nav.members') }}
                  {!! (Route::is('members') ? '<span class="sr-only">(current)</span>' : '') !!}
                </a>
              </li>
            @endcan

            @if ((strlen($whitelabel_group->about) && 
                (($whitelabel_group->group_type!='S') || 
                (Auth::user()->isMemberOfCommunity($whitelabel_group) || 
                $user->isSuperAdmin()))))
              <li><a href="" id="display_about">About</a></li>
            @endif

            @can('update-community', $whitelabel_group)
              <li>
                <a href="{{ route('community.edit.form')}}"><i class="fa fa-lg fa-cog"></i></a>
              </li>
              @if ($whitelabel_group->requestCount())
              <li id="numberRequests">
                <a href="{{ route('join-requests')}}"><i class="fa fa-lg text-info fa-user-plus"></i> (<span>{{$whitelabel_group->requestCount()}}</span>)</a>
              </li>
              @endif
            @endcan
					</ul>

					</nav>
				</div>

			</div>
		</header>
		<!-- /Top Nav -->

			</div>
@if ($whitelabel_group->getCover())
  <div class="row wl_usercover" style="position:relative; background-image: url({{ $whitelabel_group->getCover() }});"></div>
@endif

@if( strlen($whitelabel_group->about))
<div class="container" style="position:relative;">
  <div id="about_panel" style="top:0;right: 0;bottom: 0;left: auto;position: absolute;">
    <div class="row">
      <div class="col-xs-12">
        <div class="about_content">
          <i class="close_about pull-right fa fa-times fa-2x margin-right-10 margin-top-10"></i>
          <p class="margin-left-15 margin-right-15 padding-top-30 padding-bottom-15">{{ $whitelabel_group->about }}</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endif


