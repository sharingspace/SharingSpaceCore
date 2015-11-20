@extends('layouts.master')

@section('content')


<!-- OWL SLIDER -->
			<section id="slider">

				<div class="owl-carousel buttons-autohide controlls-over nomargin" data-plugin-options='{"singleItem": true, "autoPlay": true, "navigation": false, "pagination": false, "transitionStyle":"fade"}'>
					<div>
						<img class="img-responsive" src="assets/img/demo/panorama/1-min.jpg" alt="">
					</div>
					<div>
						<img class="img-responsive" src="assets/img/demo/panorama/2-min.jpg" alt="">
					</div>
				</div>

			</section>
			<!-- /OWL SLIDER -->


      <!-- CALLOUT -->
			<section class="callout-light heading-title heading-arrow-bottom" style="z-index:100;">
				<div class="container">

					<div class="text-center">
						<h3 class="size-30">{{ trans('home.callout_headline') }}</h3>
						<p>{{ trans('home.callout_subheadline') }}</p>
					</div>

				</div>
			</section>
			<!-- /CALLOUT -->


      <!-- ABOUT -->
			<section id="about" class="padding-md">
				<div class="container">

					<header class="text-center margin-bottom-60">
						<h2>The Basics</h2>
						<p class="lead font-lato">Learn about "Sharing Hubs" and how they help you!</p>
					</header>


					<div class="row">

						<div class="col-sm-5">
							<img class="img-responsive" src="http://uploads.webflow.com/564b3e094801fab237b6b158/564d8a476299d232614b4711_iPad-%26-iPhone-%26-iMac.png" style="max-width: 350px" alt="" />
						</div>

						<div class="col-sm-7">
							<p>A Sharing Hub is a collection of what people want and have. It's very simple... you can add skills, things, ideas, projects, and much more. </p>

              <p>The Hub then quickly turns a crowd of viewers into a community! People can exchange with you in any way you choose, including gifting, buying, trading, collaborating, and much more.</p>

							<hr />

							<div class="row text-center">

								<img src="http://placehold.it/125x125" class="thumbnail pull-left">
                <img src="http://placehold.it/125x125" class="thumbnail pull-left">
                <img src="http://placehold.it/125x125" class="thumbnail pull-left">

							</div>

						</div>
					</div>
				</div>

			</section>
			<!-- /ABOUT -->
      <!-- BUTTON CALLOUT -->
      <div class="callout alert alert-success margin-bottom-60">
        <div class="row">
          <div class="col-md-5 col-sm-12 col-md-offset-1"><!-- left text -->
            <h4>Make a multi-person exchange network in 1 minute!</h4>
          </div><!-- /left text -->
          <div class="col-md-4 col-sm-4 text-right"><!-- right btn -->
            <a href="#" class="btn btn-success btn-lg">30-day free trial</a>
          </div><!-- /right btn -->
        </div>
      </div>
      <!-- /BUTTON CALLOUT -->


      <!-- -->
  		<section id="features">
  			<div class="container">

  				<p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur pellentesque neque eget diam posuere porta. Quisque ut nulla at nunc vehicula lacinia. Proin adipiscing porta tellus, ut feugiat nibh adipiscing sit amet.</p>

  				<div class="divider divider-center divider-color"><!-- divider -->
  					<i class="fa fa-chevron-down"></i>
  				</div>

  				<!-- FEATURED BOXES 3 -->
  				<div class="row">

  					<div class="col-md-4 col-xs-6">
  						<div class="text-center">
  							<i class="ico-color ico-lg ico-rounded ico-hover fa fa-compass"></i>
  							<h4>Something</h4>
  							<p class="font-lato size-20">Lorem ipsum dolor sit amet.</p>
  						</div>
  					</div>
  					<div class="col-md-4 col-xs-6">
  						<div class="text-center">
  							<i class="ico-color ico-lg ico-rounded ico-hover fa fa-users"></i>
  							<h4>Something</h4>
  							<p class="font-lato size-20">Donec id elit non mi porta gravida.</p>
  						</div>
  					</div>
  					<div class="col-md-4 col-xs-6">
  						<div class="text-center">
  							<i class="ico-color ico-lg ico-rounded ico-hover fa fa-random"></i>
  							<h4>Something</h4>
  							<p class="font-lato size-20">Donec id elit non mi porta gravida.</p>
  						</div>
  					</div>
  					<div class="col-md-4 col-xs-6">
  						<div class="text-center">
  							<i class="ico-color ico-lg ico-rounded ico-hover fa fa-refresh"></i>
  							<h4>Something</h4>
  							<p class="font-lato size-20">Donec id elit non mi porta gravida.</p>
  						</div>
  					</div>

  					<div class="col-md-4 col-xs-6">
  						<div class="text-center">
  							<i class="ico-color ico-lg ico-rounded ico-hover fa fa-recycle"></i>
  							<h4>Something</h4>
  							<p class="font-lato size-20">Donec id elit non mi porta gravida.</p>
  						</div>
  					</div>
  					<div class="col-md-4 col-xs-6">
  						<div class="text-center">
  							<i class="ico-color ico-lg ico-rounded ico-hover fa fa-image"></i>
  							<h4>Something</h4>
  							<p class="font-lato size-20">Donec id elit non mi porta gravida.</p>
  						</div>
  					</div>

  				</div>
  				<!-- /FEATURED BOXES 3 -->

  			</div>
  		</section>
      <!-- / -->



      <!-- COMMUNITIES -->
      <section id="examples" class="dark">
        <div class="container">

          <header class="text-center margin-bottom-60">
            <h2>Examples</h2>
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
                    <img class="img-responsive" src="http://lorempixel.com/{{ rand(100, 200) }}/{{ rand(100, 200) }}" width="600" height="399" alt="">
                  </figure>
                </div>

              </div><!-- /item -->

              @endforeach

            </div>
          </div>
      </section>
<!-- /COMMUNITIES  -->

<!-- BUTTON CALLOUT -->
<div class="callout callout-theme-color margin-bottom-0">

  <div class="row">

    <div class="col-md-5 col-sm-12 col-md-offset-1"><!-- left text -->
      <h4>Make a multi-person exchange network in 1 minute!</h4>
    </div><!-- /left text -->
    <div class="col-md-4 col-sm-4 text-right"><!-- right btn -->
      <a href="#" class="btn btn-success btn-lg">30-day free trial</a>
    </div><!-- /right btn -->

  </div>

</div>
<!-- /BUTTON CALLOUT -->



@stop
