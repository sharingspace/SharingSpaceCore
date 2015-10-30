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
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="/css/bootstrap-social.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

		<!-- Bootstrap Table style -->
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.8.1/bootstrap-table.min.css" type="text/css" media="screen" />

		<!-- jQuery 2.1.3-->
		<script src="//code.jquery.com/jquery-2.1.3.min.js"></script>

		<!-- Bootstrap 3 and Bootstrap Table Javascript -->
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.8.1/bootstrap-table-all.js"></script>

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
      <a class="navbar-brand" href="{{ Config::get('app.url') }}">My Awesome Site</a>
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
