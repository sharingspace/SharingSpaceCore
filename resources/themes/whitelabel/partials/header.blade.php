

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ route('home') }}">
        @if ($whitelabel_group->logo!='')
          <img src="{{ $whitelabel_group->getLogo() }}" style="max-height: 30px;">
        @else
          {{ $whitelabel_group->name }}
        @endif
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <ul class="nav navbar-nav navbar-right">
        <li><a href="{{ route('browse') }}">{{ trans('general.nav.browse') }} <span class="sr-only">(current)</span></a></li>
        <li><a href="#">{{ trans('general.nav.add') }}  </a></li>

		  @if (Auth::check())
		  <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="{{ $user->gravatar() }}" class="avatar">{{ $user->name }} <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="{{ route('logout') }}">{{ trans('general.nav.logout') }} </a></li>
            </ul>
          </li>

		  @else
		  	<li><a href="{{ route('login') }}">{{ trans('general.nav.login') }} </a> </li>
			  <li><a href="{{ route('register') }}">{{ trans('general.nav.register') }} </a></li>
		  @endif



      <li>
            <a class="dropdown-toggle no-text-underline" data-toggle="dropdown" href="#">{{ LaravelLocalization::getCurrentLocaleName() }}</a>

            <ul class="dropdown-menu">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <li>
                        <a rel="alternate" hreflang="{{$localeCode}}" href="{{ LaravelLocalization::getLocalizedURL($localeCode) }} ">
                          <img src="/assets/img/flags/{{ $localeCode }}.png" width="16" height="11" alt="lang" />
                            {{{ $properties['native'] }}}
                        </a>
                    </li>
                @endforeach
            </ul>
          </li>



      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


<div class="col-md-12" style="height: 200px;background-image: url({{ $whitelabel_group->getCover() }});">

</div>



<section class="container">
    <div class="row">
	<!-- Notifications -->
	@include('notifications')
	</div>
</section>
