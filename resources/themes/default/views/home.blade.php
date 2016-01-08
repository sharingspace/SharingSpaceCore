@extends('layouts.master')

@section('content')


<!-- OWL SLIDER -->
	<section id="slider">

				<div class="dark-overlay owl-carousel buttons-autohide controlls-over nomargin" data-plugin-options='{"singleItem": true, "autoPlay": true, "navigation": false, "pagination": false, "transitionStyle":"fade", "slideSpeed":300, "paginationSpeed" : 100}'>
					<div class="dark-overlay">
						<div style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('assets/img/backgrounds/hp/band.jpg'); background-position:center top; height:400px;">
              <h1>Sharing Hubs</h1>
              <h2>multi-person needs and resources</h2>
              <a href="#" class="btn btn-danger">Try</a>
              <a href="#about" class="btn btn-warning">Learn</a>
            </div>
					</div>
					<div>
						<div style="background-image: url('assets/img/backgrounds/hp/big_clothing_swap.jpg'); height:400px;">
              <h1>Sharing Hubs</h1>
              <h2>multi-person needs and resources</h2>
              <a href="#" class="btn btn-danger">Try</a>
              <a href="#about" class="btn btn-warning">Learn</a>
            </div>
					</div>
          <div>
						<div style="background-image: url('assets/img/backgrounds/hp/bike_workshop.jpg'); height:400px;">
              <h1>Sharing Hubs</h1>
              <h2>multi-person needs and resources</h2>
              <a href="#" class="btn btn-danger">Try</a>
              <a href="#about" class="btn btn-warning">Learn</a>
            </div>
					</div>
          <div>
						<div style="background-image: url('assets/img/backgrounds/hp/clothing_swap.jpg'); height:400px;">
              <h1>Sharing Hubs</h1>
              <h2>multi-person needs and resources</h2>
              <a href="#" class="btn btn-danger">Try</a>
              <a href="#about" class="btn btn-warning">Learn</a>
            </div>
					</div>
          <div>
						<div style="background-image: url('assets/img/backgrounds/hp/communal_garden.jpg'); height:400px;">
              <h1>Sharing Hubs</h1>
              <h2>multi-person needs and resources</h2>
              <a href="#" class="btn btn-danger">Try</a>
              <a href="#about" class="btn btn-warning">Learn</a>
            </div>
					</div>
          <div>
						<div style="background-image: url('assets/img/backgrounds/hp/farmer.jpg'); height:400px;">
              <h1>Sharing Hubs</h1>
              <h2>multi-person needs and resources</h2>
              <a href="#" class="btn btn-danger">Try</a>
              <a href="#about" class="btn btn-warning">Learn</a>
            </div>
					</div>
          <div>
						<div style="background-image: url('assets/img/backgrounds/hp/helping_hands.jpg'); height:400px;">
              <h1>Sharing Hubs</h1>
              <h2>multi-person needs and resources</h2>
              <a href="#" class="btn btn-danger">Try</a>
              <a href="#about" class="btn btn-warning">Learn</a>
            </div>
					</div>
          <div>
						<div style="background-image: url('assets/img/backgrounds/hp/knowledge_share.jpg'); height:400px;">
              <h1>Sharing Hubs</h1>
              <h2>multi-person needs and resources</h2>
              <a href="#" class="btn btn-danger">Try</a>
              <a href="#about" class="btn btn-warning">Learn</a>
            </div>
					</div>
          <div>
						<div style="background-image: url('assets/img/backgrounds/hp/mural.jpg'); height:400px;">
              <h1>Sharing Hubs</h1>
              <h2>multi-person needs and resources</h2>
              <a href="#" class="btn btn-danger">Try</a>
              <a href="#about" class="btn btn-warning">Learn</a>
            </div>
					</div>
          <div>
						<div style="background-image: url('assets/img/backgrounds/hp/tech_design.jpg'); height:400px;">
              <h1>Sharing Hubs</h1>
              <h2>multi-person needs and resources</h2>
              <a href="#" class="btn btn-danger">Try</a>
              <a href="#about" class="btn btn-warning">Learn</a>
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
						<p class="lead font-lato">{{ trans('home.learn_more_subheadline') }}</p>
					</header>


					<div class="row">

						<div class="col-sm-5">
							<p>{{ trans('home.learn_more_p1')}}</p>
              <p>{{ trans('home.learn_more_p2')}}</p>
							<hr />

						</div>
            
            <div class="col-sm-7">
            	<iframe width="560" height="315" src="https://www.youtube.com/embed/wF0-BvRPMss" frameborder="0" allowfullscreen></iframe>
          	</div>
					</div>
				</div>
			</section>
      
       
       
			<!-- /ABOUT -->
      <!-- BUTTON CALLOUT -->
      <div class="callout callout-theme-color margin-bottom-10">
        <div class="row">
          <div class="col-md-5 col-sm-12 col-md-offset-1"><!-- left text -->
<h4>Make a Sharing Hub in 1 minute!<br /><span style="font-size:small;display:inline-block;text-align:center;width:250px;color:white;">or click here to browse live hubs</span></h4>
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
  				<header class="text-center margin-bottom-40">
						<h2 style="font-size:46px;">Features</h2>
					</header>

  				<!-- FEATURED BOXES 3 -->
  				<div class="row">

  					<div class="col-md-4 col-xs-6">
  						<div class="text-center">
  							<i class="ico-color ico-lg ico-rounded ico-hover fa fa-compass"></i>
  							<h3>Exchange Anything</h3>
  							<p class="font-lato size-20">Any kind of thing, skill, knowledge, opportunity and more can be included.</p>
  						</div>
  					</div>
  					<div class="col-md-4 col-xs-6">
  						<div class="text-center">
  							<i class="ico-color ico-lg ico-rounded ico-hover fa fa-users"></i>
  							<h3>Unlimited Size</h3>
  							<p class="font-lato size-20">Hubs can be from 1 - 100k members and from anyplace on the Earth.</p>
  						</div>
  					</div>
  					<div class="col-md-4 col-xs-6">
  						<div class="text-center">
  							<i class="ico-color ico-lg ico-rounded ico-hover fa fa-random"></i>
  							<h3>Custom Look & Feel</h3>
  							<p class="font-lato size-20">Choose different colors, layouts, and branded themes for your hub.</p>
  						</div>
  					</div>
  					<div class="col-md-4 col-xs-6">
  						<div class="text-center">
  							<i class="ico-color ico-lg ico-rounded ico-hover fa fa-refresh"></i>
  							<h3>Professional Options</h3>
  							<p class="font-lato size-20">Administrators can make money building access as well as other benefits!</p>
  						</div>
  					</div>

  					<div class="col-md-4 col-xs-6">
  						<div class="text-center">
  							<i class="ico-color ico-lg ico-rounded ico-hover fa fa-recycle"></i>
  							<h3>Full Privacy Control</h3>
  							<p class="font-lato size-20">Public, private, and secret hubs make it easy for you to control the amount of visibility.</p>
  						</div>
  					</div>
  					<div class="col-md-4 col-xs-6">
  						<div class="text-center">
  							<i class="ico-color ico-lg ico-rounded ico-hover fa fa-image"></i>
  							<h3>API + More</h3>
  							<p class="font-lato size-20">Display your entries and data on the websites you choose! Extend the hub for your needs.</p>
  						</div>
  					</div>

  				</div>
  				<!-- /FEATURED BOXES 3 -->

  			</div>
  		</section>
      <!-- / -->



 			<!-- co-op -->
      <section id="examples" class="callout-theme-color">
        <div class="container">

          <header class="text-center margin-bottom-20">
            <h2>We're a CO-OP!</h2>
          </header>
          <p class="lead font-lato">AnyShare is the first Cooperative in the United States (and global community) to allow all stakeholders to own, vote, and share revenue! We're thrilled, and so are our members! After all, we ARE you. <a href="#">Read more</a>.</p>
			</div>
  		</section>
      <!-- COMMUNITIES -->
      <section id="examples" class="dark">
        <div class="container">

          <header class="text-center margin-bottom-60">
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
                    <img class="img-responsive" src="http://lorempixel.com/200/200/nature" width="200" height="200" alt="">

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
      
      <section id="pricing" class="dark">
        <div class="container">

          <header class="text-center margin-bottom-20">
            <h2>Pricing</h2>
          </header>
          
          <div class="row">
           <div class="col-sm-8 col-sm-offset-2" >
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
                	<td><a href="#" class="btn btn-success btn-md">Apply Now</a></td>
                	<td><a href="#" class="btn btn-success btn-md">Join Free for a Month</a></td>
                </tr>
              </tbody>
            </table>
   					</div> <!-- dark row row -->
          </div> <!-- col 8 -->
   			</div> <!-- row -->
      </div> <!-- container -->
  	</section>
<!-- /COMMUNITIES  -->

<!-- BUTTON CALLOUT -->
<div class="callout callout-theme-color margin-bottom-0">

  <div class="row">

    <div class="col-md-4 col-sm-12 col-md-offset-2"><!-- left text -->
      <h4>Launch Your Sharing Hub in 1 minute! <br /><span style="font-size:small;display:inline-block;text-align:center;width:250px;color:white">or click here to browse live hubs</span></h4>
    </div><!-- /left text -->
    <div class="col-md-4 col-sm-4 text-right"><!-- right btn -->
      <a href="#" class="btn btn-success btn-lg">30-day free trial</a>
    </div><!-- /right btn -->

  </div>

</div>
<!-- /BUTTON CALLOUT -->



@stop
