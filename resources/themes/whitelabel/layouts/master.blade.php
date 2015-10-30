<!DOCTYPE html>
<html lang="en-us">

<head>
	<!-- *** General page information *** -->
		<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge" /><![endif]-->
		<meta charset="UTF-8"/>
        <title>
            @section('title')
             {{ $whitelabel_group->name }}
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
    <link rel="stylesheet" href="{{ Theme::asset('css/styles.css', null, true) }}"/>


</head>

<body>

	<div>@include('partials.header')</div>

	<div>@yield('content')</div>

	<div>@include('partials.footer')</div>

</body>
</html>
