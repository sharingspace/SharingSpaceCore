@extends('layouts.master')

@section('content')

	<section class="padding-top-0">
		<div class="page_banner sharing_fixed_banner_5"  style="height:400px;">
        <h1></h1>

    <h2 class="subheadline" style="font-size:64px!important;font-style:italic; ">{{ trans('home_five.home_headline') }}</h2>
      <h2 class="subheadline"><img src="/assets/img/backgrounds/hp/vegetables.png"></h2>
      <h2 class="subheadline"><img src="/assets/img/backgrounds/hp/tools.png"></h2>
      <h2 class="subheadline"><img src="/assets/img/backgrounds/hp/book.png"></h2>
      <h2 class="subheadline"><img src="/assets/img/backgrounds/hp/food.png"></h2>
      <h2 class="subheadline"><img src="/assets/img/backgrounds/hp/house.png"></h2>
    </div>
	</section>


      <!-- CALLOUT -->
			<!-- <section class="callout-light heading-title heading-arrow-bottom" style="z-index:100;">
				<div class="container">

					<div class="text-center">
						<h3 class="size-30">{{ trans('home.callout_headline') }}</h3>
						<p>{{ trans('home.callout_subheadline') }}</p>
					</div>

				</div>
			</section> -->
			<!-- /CALLOUT -->


      <!-- ABOUT -->
			<section id="about" class="padding-xxs">
				<div class="container">

					<div class="row">

						<div class="col-sm-6 col-xs-12">
            <h2 class="text-center size-30">What is AnyShare?</h2>
							<p>{{ trans('home_five.learn_more_p1')}}</p>
						</div>

            <div class="col-sm-6 hidden-xs-down">
              <img class="img-responsive" src='assets/img/backgrounds/hp/regional_football.png') alt='regional mens football sharing hub' />
          	</div>
					</div>
				</div>
			</section>

      <!-- -->
  		<section id="features">
  			<div class="container">
  				<!-- FEATURED BOXES 3 -->
  				<div class="row">
          <h2 class="size-40 text-center">Community Options</h2>
  					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10 margin-top-20">
  						<div class="text-center">
  							<i class="ico-color-lightblue  ico-lg ico-rounded ico-hover fa fa-random"></i>
  							<h3 class="margin-bottom-0">Exchange Anything</h3>
  							<p class="font-lato size-20">Any kind of thing, skill, knowledge, opportunity and more can be included.</p>
  						</div>
  					</div>
           
  					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10 margin-top-20">
  						<div class="text-center">
  							<i class="ico-color-lightblue ico-lg ico-rounded ico-hover fa fa-users"></i>
  							<h3 class="margin-bottom-0">Unlimited Size</h3>
  							<p class="font-lato size-20">Hubs can be from 1 - 100k members and from anyplace on the Earth.</p>
  						</div>
  					</div>
  					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10 margin-top-20">
  						<div class="text-center">
  							<i class="ico-color-lightblue ico-lg ico-rounded ico-hover fa fa-wrench"></i>
  							<h3 class="margin-bottom-0">Custom Look &amp; Feel</h3>
  							<p class="font-lato size-20">Choose different colors, layouts, and branded themes for your hub.</p>
  						</div>
  					</div>
  					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-20">
  						<div class="text-center">
  							<i class="ico-color-lightblue ico-lg ico-rounded ico-hover fa fa-university"></i>
  							<h3 class="margin-bottom-0">Professional Options</h3>
  							<p class="font-lato size-20">Administrators can make money building access!</p>
  						</div>
  					</div>
  					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-20">
  						<div class="text-center">
  							<i class="ico-color-lightblue ico-lg ico-rounded ico-hover fa fa-eye-slash"></i>
  							<h3 class="margin-bottom-0">Full Privacy Control</h3>
  							<p class="font-lato size-20">Public, private, and secret hubs make it easy for you to control visibility.</p>
  						</div>
  					</div>
  					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-20">
  						<div class="text-center">
  							<i class="ico-color-lightblue ico-lg ico-rounded ico-hover fa fa-code"></i>
  							<h3 class="margin-bottom-0">API + More</h3>
  							<p class="font-lato size-20">Display your entries and data on the websites you choose!</p>
  						</div>
  					</div>

  				</div>
  				<!-- /FEATURED BOXES 3 -->

  			</div>
  		</section>

      <!-- BUTTON CALLOUT -->
      <div class="callout margin-bottom-0 text-center" style="background-color:#AFDBDB;">
        <div class="container">
          <div class="row text-center">
            <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12 col-md-offset-1">
              <h2 style="font-size:36px;" class="pull-left">Try a sharing hub free for 30 days</h2>
              <a href="{{ route('community.create.form') }}" class="btn btn-default size-20 pull-right">{{ trans('general.nav.try_it') }}</a>
 
            </div> <!-- col 8 -->
          </div> <!-- row -->
        </div> <!-- container -->
      </div> <!-- callout -->
      <!-- /BUTTON CALLOUT -->
  		
 
  		
 
<!-- /COMMUNITIES  -->
<script type="text/javascript">
$( document ).ready(function() {

    var subhead = $(".subheadline");
    var subIndex = -1;
    
    function showNextSubheader() {
      ++subIndex;
      subhead.eq(subIndex % subhead.length)
        .fadeIn(2000)
        .delay(2000)
        .fadeOut(2000, showNextSubheader);
    }
    
    showNextSubheader();
});
</script>
@stop
