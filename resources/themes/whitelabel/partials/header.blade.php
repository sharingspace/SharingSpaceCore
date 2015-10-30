

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
      <a class="navbar-brand" href="{{ url('home') }}">
        @if ($whitelabel_group->logo!='')
          <img src="{{ $whitelabel_group->getCover() }}" style="max-height: 30px;">
        @else
          {{ $whitelabel_group->name }}
        @endif
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Browse <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Add <span class="sr-only">(current)</span></a></li>

		  @if (Auth::check())
		  <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="{{ $user->gravatar() }}" class="avatar">{{ $user->name }} <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="{{ route('logout') }}">Logout</a></li>
            </ul>
          </li>

		  @else
		  	<li><a href="{{ route('login') }}">Login</a> </li>
			<li><a href="{{ route('register') }}">Register</a></li>
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
