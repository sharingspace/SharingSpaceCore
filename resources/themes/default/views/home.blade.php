@extends('layouts.master')

@section('content')

	<section class="padding-top-0">
		<div class="page_banner sharing_fixed_banner"  style="height:400px;">
       <h1 style="font-size:56px!important;color:white;text-align:center;padding-top:125px;margin-bottom:-5px; ">{{ trans('home.home_headline') }}</h1>
       <h2 style="font-size:40px!important;font-weight:400;color:white;text-align:center;">{{ trans('home.subhome_headline') }}</h2>
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
							<p>A <span class="weight-700 font-style-italic">{{ trans('home.learn_more_p1a')}}</span> {{ trans('home.learn_more_p1b')}}</p>
              <p>{{ trans('home.learn_more_p2')}}</p>
						</div>

            <div class="col-sm-6 hidden-xs-down">
              <img class="img-responsive" src='assets/img/backgrounds/hp/regional_football.png') alt='regional mens football sharing hub' />
          	</div>
					</div>
				</div>
			</section>



			<!-- /ABOUT -->
      <!-- BUTTON CALLOUT -->
      <div class="callout callout-dark margin-bottom-10">
              <div class="container">

        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"><!-- left text -->
              <h2 style="font-size:36px;" class="pull-right">Try a sharing hub free for 30 days</h2>

            </div><!-- /left text -->
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 "><!-- right btn -->
              <a href="#" class="btn btn-warning size-20 hidden-xs pull-left" style="background-color:#EC971F">{{ trans('general.nav.try_it') }}</a>
              <a href="#" class="btn btn-success btn-sm size-12 hidden-sm hidden-md hidden-lg">{{ trans('general.nav.try_it') }}</a>
            </div><!-- /right btn -->
          </div>
        </div>
      </div>
      <!-- /BUTTON CALLOUT -->


      <!-- -->
  		<section id="features">
  			<div class="container">
  				<!-- FEATURED BOXES 3 -->
  				<div class="row">
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
      <div class="callout callout-dark margin-bottom-0 text-center" style="background-color:#AFDBDB;">
        <div class="container">
          <div class="row text-center">
            <div class="col-lg-8 col-md-8 col-sm-8 col-md-offset-2">
              <div class="row">
                <h2 style="font-weight:800;">Explore more</h2>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><!-- left text -->
                  <a href="coop" class="btn btn-success btn-lg margin-right-20">The Cooperative</a> <a href="pricing" class="btn btn-success btn-lg">See Pricing</a>
                </div> <!-- col 12 -->
                
              </div> <!-- row -->
            </div> <!-- col 8 -->
          </div> <!-- row -->
        </div> <!-- container -->
      </div> <!-- callout -->
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

      <section id="pricing" class="callout-theme-color">
        <div class="container">

          <header class="text-center margin-bottom-10">
            <h2>Pricing</h2>
          </header>

          <div class="row">
           <div class="col-sm-10 col-sm-offset-1 margin-bottom-0" >
            <div class="row dark">

							<table class="table">
                <thead>
                <tr>
                	<th>Gift</th>
                	<th>$10 a month</th>
                </tr>
                </thead>
              	<tbody>
                <tr>
                	<td><p>For groups that don't have the budget to pay for a subscription.</p>
                  <p>We ask you to apply for the gift, by stating your intention with AnyShare and why you don't have the budget to pay.</p></td>
                	<td style="text-align: center;border:none;"><p style="margin-left:15px;">Hosted Solution</p>
                  	<p>Email Support</p>
                    <p>Automatic Backups</p>
                    <p>Automatic Upgrades</p></td>
                </tr>
                <tr>
                	<td><a href="#" class="btn btn-info btn-sm" style="border-color:#ccc;background-color:white;color:#F07057;">Apply Now</a></td>
                	<td><a href="#" class="btn btn-info btn-sm" style="border-color:#ccc;background-color:white;color:#F07057;">Join Free for a Month</a></td>
                </tr>
              </tbody>
            </table>
   					</div> <!-- dark row row -->
          </div> <!-- col 8 -->
   			</div> <!-- row -->
      </div> <!-- container -->
  	</section>
  	@endif
<!-- /COMMUNITIES  -->


@stop
