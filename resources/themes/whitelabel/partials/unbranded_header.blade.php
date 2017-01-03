
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
                {{ Auth::user()->getUnreadMessagesCount() }} new messages
            </div>
            @foreach (Auth::user()->getLimitedUnreadMessages() as $unread_messages)
              <div class="clearfix margin-bottom-20">
                 <!-- notification item -->
                	<img src="{{ $unread_messages->sender->gravatar_img() }}" class="avatar-sm pull-left" style="margin-left: 5px; margin-top: 5px;">
                <span class="size-14 text-muted">
                  <b>New Message</b> from {{ $unread_messages->sender->getDisplayName() }}:
                  <a href="/account/message/{{ $unread_messages->conversation->id }}">{{ $unread_messages->message }}</a>
                </span>
              </div><!-- /notification item -->
            @endforeach

            <!-- quick cart footer -->
            <div class="notifications-popdown-footer clearfix">
              <a href="/account/messages" class="btn btn-primary btn-xs pull-right">VIEW ALL MESSAGES</a>
            </div>
            <!-- /quick cart footer -->
          </div>
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
          <img src="{{ Helper::cdn('img/flags/'.$localeCode.'.png') }}" width="16" height="11" alt="lang" />
          {{{ $properties['native'] }}}
        </a>
      </li>
      @endforeach
    </ul>
  </div>
</div>
<!-- /Top Bar -->

