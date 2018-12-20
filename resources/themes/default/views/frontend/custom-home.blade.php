@extends('layouts/frontend-master')

@section('content')

<div id="main">
	<div class="page-title-bar">
		<div class="page-title-bar-overlay"></div>
		<div class="page-title-bar-inner">
			<div class="container">
				<div class="row row-xs-center">
					<div class="col-md-6">
						<div class="page-title-bar-heading">
							<h1 class="heading">{{$menu->page->title}}</h1>
						</div>
					</div>
					<div class="col-md-6">
						<div id="page-breadcrumb" class="page-breadcrumb">
							<ul class="breadcrumb">
								<li><a href="{{route('frontend.slug','home')}}">Home</a></li>
								<li class="sub tail current">Pricing Package</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /.row -->
			</div>
		</div>
	</div>
	<div class="container">
	    {!! $menu->page->body !!}	
	</div>
</div>
@endsection