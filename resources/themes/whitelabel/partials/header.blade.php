
<!-- Top Bar -->
  <div id="topBar">
    <div class="container">
      <!-- right -->
      <ul class="top-links list-inline pull-right">

        @if (Auth::check())
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="{{ Auth::user()->gravatar_img() }}" class="avatar-sm">{{ Auth::user()->getDisplayName() }} <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('account.memberships.view') }}"><i class="fa fa-users"></i> {{ trans('general.memberships') }}</a></li>
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
                  {{ Auth::user()->getUnreadMessagesCount() }} {{ trans('general.nav.new_messages') }}
              </div>
              @foreach (Auth::user()->getLimitedUnreadMessages() as $unread_messages)
                <div class="unread clearfix margin-bottom-10 member_thumb">
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
				<!-- /QUICK SHOP CART -->

        @else
          <li><a href="{{ route('login') }}">{{ trans('general.nav.login') }} </a> </li>
          <li><a href="{{ route('user.register') }}">{{ trans('general.nav.register') }} </a></li>
        @endif
      </ul>

      <!-- left -->
      <ul class="top-links"> 
        <li class="dropdown languages">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            {{App::getLocale()}}
            <span class="caret"></span>
          </a>
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

	<div id="header" class="sticky clearfix header-sm">

		<!-- TOP NAV -->
		<header id="topNav">
			<div class="container">

				<!-- Mobile Menu Button -->
        @if (Auth::check() || $whitelabel_group->scopeIsPublic())
        <button class="btn btn-mobile" data-toggle="collapse" data-target=".nav-main-collapse">
          <i class="fa fa-bars"></i>
        </button>
        @endif

				<!-- Logo -->
        <a class="logo pull-left navbar-brand" href="{{ route('home') }}">
          @if ($whitelabel_group->logo!='')
            <img src="{{ $whitelabel_group->getLogo() }}">
          @else
            {{ $whitelabel_group->name }}
          @endif
        </a>

        @if (Auth::check() && Auth::user()->canSeeCommunity($whitelabel_group))
        <div class="navbar-header pull-right">
          <ul class="nav navbar-nav">
            <li class="add_entry_button {!! (Route::is('entry.create.form') ? ' active' : '') !!}">
              <a href="{{ route('entry.create.form') }}">
                <button type="button" class="btn btn-sm btn-colored" title="Add entry"><i class="fa fa-plus"></i><span class="hidden-xs"> {{ trans('general.entries.create_entry') }}</span></button>
              </a>
            </li>
          </ul>
        </div>
        @endif

        <div class="margin-left-10 navbar-collapse pull-right nav-main-collapse collapse">
          <nav class="nav-main">
            <ul id="topMain" class="nav nav-pills nav-main nav-onepage">
            @if ((Auth::check()) && (!Auth::user()->isMemberOfCommunity($whitelabel_group)) && !$whitelabel_group->getRequestCount(Auth::user()->id))
              <li>
                <a style="color:white;" href="{{ route('community.request-access.form') }}">
                  <button type="button" class="btn btn-colored btn-sm">
                    {{ trans('general.register.join_share') }}
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
              <li {!! (Route::is('members') ? ' class="active"' : '') !!}>
                <a href="{{ route('members') }}">
                  {{ trans('general.our_members') }}
                  {!! (Route::is('members') ? '<span class="sr-only">(current)</span>' : '') !!}
                </a>
              </li>
            @endcan

            @if ($whitelabel_group->scopeIsPublic())
              <li {!! (Route::is('about') ? ' class="active"' : '') !!}>
                <a href="" data-toggle="modal" data-target="#aboutModal">{{ trans('general.about') }}</a>
              </li>
            @elseif (Auth::check())
              @can('view-about', $whitelabel_group)
                <li{!! (Route::is('about') ? ' class="active"' : '') !!}>
                  <a href="" data-toggle="modal" data-target="#aboutModal">{{ trans('general.about') }}</a>
                </li>
              @endcan
            @endif

            @can('update-community', $whitelabel_group)
              <li{!! (Route::is('community.edit.form') ? ' class="active"' : '') !!}>
                <a href="{{ route('community.edit.form')}}"><i class="fa fa-lg fa-cog"></i></a>
              </li>
              @if ($whitelabel_group->requestCount())
              <li id="numberRequests" {!! (Route::is('join-requests') ? ' class="active"' : '') !!}>
                <a href="{{ route('join-requests')}}"><i class="fa fa-lg fa-user-plus"></i> (<span>{{$whitelabel_group->requestCount()}}</span>)</a>
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
@else
  <div class="margin-y-55"></div>
@endif


<div id="aboutModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">About the <em>{{$whitelabel_group->name}}</em> Share</h4>
      </div>
      <div class="modal-body">
      <p  class="about_info"><strong>Started:</strong> <span>{{$whitelabel_group->created_at->format('F jS, Y')}}</span>
      @if (!empty($whitelabel_group->location))
        <br><strong>Location:</strong> <span class="about_info">{{$whitelabel_group->location}}</span>
      @endif
      @if ($whitelabel_group->group_type == 'O')
        <br><strong>Privacy:</strong> <span class="about_info">Open Membership</span> 
        <a href="#" title="An open Share lets anyone join and exchange. It is the most permissive way to build members.""><i class="fa fa-info-circle"></i></a>

      @elseif ($whitelabel_group->group_type == 'C')
        <br><strong>Privacy:</strong> <span class="about_info">Closed, Membership requires approval</span> 
        <a href="#" title="A closed Share lets you approve members before they join. You can also invite members! Visitors can see basic information in its content, but not the details."><i class="fa fa-info-circle"></i></a>
      @else
        <br><strong>Privacy:</strong> <span class="about_info">Secret, Membership is by invitation only</span> 
        <a href="" data-toggle="modal" data-target="#learnPrivacy"><i class="fa fa-info-circle"></i></a>
      @endif
        <br><strong>{{ trans_choice('general.community.exchange_types.title', $whitelabel_group->exchangeTypes->count()) }}</strong>
        <span class="about_info">
          @if ($whitelabel_group->exchangeTypes->count() == 10)
            {{ trans('general.community.exchange_types.all_allowed') }}
          @else
            {{--*/ $exchangeTypes = array() /*--}}
            @foreach ($whitelabel_group->exchangeTypes as $exchange_type)
              {{--*/ $exchangeTypes[] = $exchange_type->name /*--}}
            @endforeach
            {{ implode(', ', $exchangeTypes)}}
            <a href="#" title="This shows options for member exchange on this Share"><i class="fa fa-info-circle"></i></a>
          @endif
        </span>
        <br><strong>Total members:</strong> {{$whitelabel_group->members()->count()}}<br>
        <strong>Total entries:</strong> {{$whitelabel_group->entries()->count()}}
        (wants:</span> {{$whitelabel_group->entries()->where('post_type', 'want')->count()}}
        <a href="#" title="All the needs of the members"><i class="fa fa-info-circle"></i></a>, 
        haves:</span> {{$whitelabel_group->entries()->where('post_type', 'have')->count()}}
        <a href="#" title="All the resources of the members"><i class="fa fa-info-circle"></i></a>)
        </p>

      {!! Markdown::convertToHtml($whitelabel_group->about) !!} 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('general.close')}}</button>
      </div>
    </div>
  </div>
</div>

