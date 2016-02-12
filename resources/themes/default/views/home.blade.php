@extends('layouts.master')

@section('content')


<!-- OWL SLIDER -->
	<section id="slider">

				<div class="dark-overlay owl-carousel buttons-autohide controlls-over nomargin" data-plugin-options='{"singleItem": true, "autoPlay": true, "navigation": false, "pagination": false, "transitionStyle":"fade", "slideSpeed":300, "paginationSpeed" : 100}'>
					<div class="dark-overlayy">
						<div class="page_banner band_banner">
              <h1>Sharing Hubs</h1>
              <h2>multi-person needs and resources</h2>
            </div>
					</div>
					<div>
						<div class="page_banner clothing_swap_banner">
              <h1>Sharing Hubs</h1>
              <h2>multi-person needs and resources</h2>
             </div>
					</div>
          <div>
						<div class="page_banner bike_banner">
              <h1>Sharing Hubs</h1>
              <h2>multi-person needs and resources</h2>
            </div>
					</div>
          <div>
						<div class="page_banner farmers_banner">
              <h1>Sharing Hubs</h1>
              <h2>multi-person needs and resources</h2>
            </div>
					</div>
          <div>
						<div class="page_banner helping_hands_banner">
              <h1>Sharing Hubs</h1>
              <h2>multi-person needs and resources</h2>
            </div>
					</div>
          <div>
						<div class="page_banner mural_banner">
              <h1>Sharing Hubs</h1>
              <h2>multi-person needs and resources</h2>
            </div>
					</div>
          <div>
          	<div class="page_banner tech_design_banner">
              <h1>Sharing Hubs</h1>
              <h2>multi-person needs and resources</h2>
            </div>
					</div>

				</div>

			</section>
			<!-- /OWL SLIDER -->


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

					<header class="text-center margin-bottom-60">
						<h2 style="font-size:48px;">{{ trans('home.learn_more_headline') }}</h2>
						<h3>{{ trans('home.home_subheadline') }}</h3>
					</header>

					<div class="row">

						<div class="col-sm-6 col-xs-12">
							<p>{{ trans('home.learn_more_p1')}}</p>
              <p>{{ trans('home.learn_more_p2')}}</p>
							<hr />

						</div>

            <div class="col-sm-6 hidden-xs-down">
              <img class="img-responsive" src='assets/img/backgrounds/hp/regional_football.png') alt='regional mens football sharing hub' />
          	</div>
					</div>
				</div>
			</section>



			<!-- /ABOUT -->
      <!-- BUTTON CALLOUT -->
      <div class="callout callout-theme-color margin-bottom-10 text-center">
        <div class="row">
          <div class="row text-center">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"><!-- left text -->
              <h2 style="font-size:36px;">Make a Sharing Hub in 1 minute!</h2>
            </div><!-- /left text -->
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><!-- right btn -->
              <a href="#" class="btn btn-success btn-lg hidden-xs">30-day free trial</a>
              <a href="#" class="btn btn-success btn-sm size-14 hidden-sm hidden-md hidden-lg">30-day free trial</a>
            </div><!-- /right btn -->
          </div>
        </div>
      </div>
      <!-- /BUTTON CALLOUT -->


      <!-- -->
  		<section id="features">
  			<div class="container">
  				<header class="text-center margin-bottom-40">
						<h2 style="font-size:46px;">Features</h2>
					</header>

  				<!-- FEATURED BOXES 3 -->
  				<div class="row">
  					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
  						<div class="text-center">
  							<i class="ico-color ico-lg ico-rounded ico-hover fa fa-random"></i>
  							<h3>Exchange Anything</h3>
  							<p class="font-lato size-20">Any kind of thing, skill, knowledge, opportunity and more can be included.</p>
  						</div>
  					</div>
           
  					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
  						<div class="text-center">
  							<i class="ico-color ico-lg ico-rounded ico-hover fa fa-users"></i>
  							<h3>Unlimited Size</h3>
  							<p class="font-lato size-20">Hubs can be from 1 - 100k members and from anyplace on the Earth.</p>
  						</div>
  					</div>
  					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
  						<div class="text-center">
  							<i class="ico-color ico-lg ico-rounded ico-hover fa fa-wrench"></i>
  							<h3>Custom Look &amp; Feel</h3>
  							<p class="font-lato size-20">Choose different colors, layouts, and branded themes for your hub.</p>
  						</div>
  					</div>
  					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
  						<div class="text-center">
  							<i class="ico-color ico-lg ico-rounded ico-hover fa fa-university"></i>
  							<h3>Professional Options</h3>
  							<p class="font-lato size-20">Administrators can make money building access as well as other benefits!</p>
  						</div>
  					</div>
  					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
  						<div class="text-center">
  							<i class="ico-color ico-lg ico-rounded ico-hover fa fa-eye-slash"></i>
  							<h3>Full Privacy Control</h3>
  							<p class="font-lato size-20">Public, private, and secret hubs make it easy for you to control the amount of visibility.</p>
  						</div>
  					</div>
  					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
  						<div class="text-center">
  							<i class="ico-color ico-lg ico-rounded ico-hover fa fa-code"></i>
  							<h3>API + More</h3>
  							<p class="font-lato size-20">Display your entries and data on the websites you choose! Extend the hub for your needs.</p>
  						</div>
  					</div>

  				</div>
  				<!-- /FEATURED BOXES 3 -->

  			</div>
  		</section>
      <!-- / -->



  		
  		<!-- BUTTON CALLOUT -->
      <div class="callout callout-dark margin-bottom-0 text-center">
        <div class="row text-center">
          <div class="col-lg-10 col-md-10 col-sm-10 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
            <h2 style="font-size:46px;">Learn More</h2>
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><!-- left text -->
                <a href="#" class="btn btn-success btn-lg">We're a CO-OP!</a>
              </div>
             
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><!-- left text -->
                <a href="pricing" class="btn btn-success btn-lg">View Pricing</a>
              </div> <!-- col 6 -->
            </div>
          </div>
        </div> <!-- row -->
      </div>
      <!-- /BUTTON CALLOUT -->
  		
      <!-- COMMUNITIES -->
      @if(0)
      <section id="examples">
        <div class="container">

          <header class="text-center margin-bottom-20">
            <h2>Want to See Examples?</h2>
            <p class="lead font-lato">Browse our favorite Sharing Hubs around the world! </p>
            <hr />
          </header>

          <!-- Communities  -->
          <div id="portfolio" class="clearfix portfolio-isotope portfolio-isotope-5">

            <!-- <ul class="nav nav-pills mix-filter margin-bottom-60">
              <li data-filter="all" class="filter active"><a href="#">All</a></li>
              <li data-filter="development" class="filter"><a href="#">Development</a></li>
              <li data-filter="photography" class="filter"><a href="#">Photography</a></li>
              <li data-filter="design" class="filter"><a href="#">Design</a></li>
            </ul>
            -->

              @foreach ($communities as $community)

              <!-- item -->
              <div class="portfolio-item">
                <div class="item-box">
                  <figure>
                    <span class="item-hover">
                      <span class="overlay dark-5"></span>
                      <span class="inner">
                        <h2 style="color: white;">{{ ucwords($community->name) }}</h2>
                        <br><br>
                        <!-- lightbox -->
                        <!-- <a class="ico-rounded lightbox" href="/assets/img/demo/mockups/1200x800/3-min.jpg" data-plugin-options='{"type":"image"}'>
                          <span class="fa fa-plus size-20"></span>
                        </a>
                        -->

                        <!-- details -->

                        <a class="ico-rounded" href="http://{{ $community->subdomain }}.{{ Config::get('app.domain') }}">
                          <span class="glyphicon glyphicon-option-horizontal size-20"></span>
                        </a>
                        <!-- <a class="ico-rounded" href="#">
                          <span class="glyphicon glyphicon-heart size-20"></span>
                        </a>
                        -->

                      </span>
                    </span>
                    <!-- <img class="img-responsive" src="http://lorempixel.com/{{ rand(100, 200) }}/{{ rand(100, 200) }}" width="600" height="399" alt=""> -->
                    @if ($community->getProfileImg()!='')
                        <img class="img-responsive" src="{{ $community->getProfileImg() }}" width="600" height="399" alt="">
                    @else
                          <img class="img-responsive" src="http://lorempixel.com/{{ rand(100,200) }}/{{ rand(100,200) }}/nature" width="200" height="200" alt="">
                    @endif


                  </figure>
                </div>

              </div><!-- /item -->

              @endforeach

            </div>
            <div class="text-center">
            	<a href="#about" class="btn btn-warning">See more</a>
          </div>

          </div>
      </section>

  	 @endif
<!-- /COMMUNITIES  -->


@stop
