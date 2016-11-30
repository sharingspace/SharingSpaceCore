<!DOCTYPE html>
<html lang="en-us">

<head>
	<!-- *** General page information *** -->
		<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge" /><![endif]-->
		<meta charset="UTF-8"/>
        <title>
            @section('title')
             My Awesome Site
            @show
        </title>
		<!-- Mobile Specific Metas-->
		<metja name="viewport" content="width=device-width, initial-scale=1">
		<!-- Template info -->
		<meta name="author" content="A. Gianotto">
		<meta name="description" content="">
		<meta name="keywords" content="">

		<!-- Latest compiled and minified CSS -->
    	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha256-916EbMg70RQy9LHiGkXzG8hSg9EdNy97GazNG/aiY1w=" crossorigin="anonymous" type="text/css" />
    	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.0.0/bootstrap-social.min.css" integrity="sha256-aNI8KR/Gy4Hb87gooy9+CAjWOeVdSA0S5sd9XMmj4Xo=" crossorigin="anonymous" type="text/css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha256-ZT4HPpdCOt2lvDkXokHuhJfdOKSPFLzeAJik5U/Q+l4=" crossorigin="anonymous" />
		<!-- Bootstrap Table style -->
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.css" integrity="sha256-lHY6r+cFHp2F/XXDvi4iczsIj7nl0r+CBVFD8KdtFqc=" crossorigin="anonymous" type="text/css" media="screen" />

	    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

		<!-- Bootstrap 3 and Bootstrap Table Javascript -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha256-U5ZEeKfGNOja007MMD3YBI0A3OSZOQbeG6z2f2Y0hu8=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.js" integrity="sha256-OOtvdnMykxjRaxLUcjV2WjcyuFITO+y7Lv+3wtGibNA=" crossorigin="anonymous"></script>
		
		<link rel="stylesheet" href="/css/app.css">


</head>

<body>

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
      <a class="navbar-brand" href="{{ config('app.url') }}">My Awesome Site</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Link</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
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

<!-- Content -->
@yield('content')


	</body>
</html>
