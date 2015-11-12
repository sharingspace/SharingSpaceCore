

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ route('home') }}"><img src="/assets/img/any-share-logo-cloud-400.png" class="logo" style="max-height: 30px;"></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">


      <ul class="nav navbar-nav navbar-right">
          <li><a href="#">About</a></li>
          <li><a href="#">Get Started</a></li>
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


      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<section class="container">
    <div class="row">
	<!-- Notifications -->
	@include('notifications')
	</div>
</section>
