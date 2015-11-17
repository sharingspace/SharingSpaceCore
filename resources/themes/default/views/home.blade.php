@extends('layouts.master')

@section('content')


<!-- SLIDER -->
			<section id="slider" class="halfheight" style="background-image:url('assets/img/demo/1200x800/34-min.jpg');">
				<div class="overlay dark-5"><!-- dark overlay [0 to 9 opacity] --></div>

				<div class="display-table">
					<div class="display-table-cell vertical-align-middle">
						<div class="container">

							<div class="slider-featured-text text-center">
								<h1 class="text-white wow fadeInUp" data-wow-delay="0.4s">
									{{ trans('home.home_headline') }}
								</h1>
								<h2 class="weight-300 text-white wow fadeInUp" data-wow-delay="0.8s">{{ trans('home.home_subheadline') }}</h2>
								<a class="btn btn-primary btn-lg wow fadeInUp" data-wow-delay="1s" href="#">DO STUFF</a>
							</div>

						</div>
					</div>
				</div>

			</section>
			<!-- /SLIDER -->
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
			<section id="about" class="padding-xs">
				<div class="container">

					<header class="text-center margin-bottom-60">
						<h2>We Are AnySha.re</h2>
						<p class="lead font-lato">Lorem ipsum dolor sit amet adipiscium elit</p>
						<hr />
					</header>


					<div class="row">

						<div class="col-sm-6">
							<img class="img-responsive" src="https://snipeitapp.com/assets/img/demo/desktop_snipe.png" alt="" />
						</div>

						<div class="col-sm-6">
							<p class="dropcap">Lorem ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen.Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>

							<hr />

							<div class="row countTo-sm text-center">

								<div class="col-xs-6 col-sm-4">
									<i class="fa fa-users size-20"></i> &nbsp;
									<span class="countTo" data-speed="3000" style="color:#59BA41">1303</span>
									<h6>HAPPY CLIENTS</h6>
								</div>

								<div class="col-xs-6 col-sm-4">
									<i class="fa fa-briefcase size-20"></i> &nbsp;
									<span class="countTo" data-speed="3000" style="color:#774F38">56000</span>
									<h6>FINISHED PROJECTS</h6>
								</div>

								<div class="col-xs-6 col-sm-4">
									<i class="fa fa-twitter size-20"></i> &nbsp;
									<span class="countTo" data-speed="3000" style="color:#C02942">4897</span>
									<h6>TWITTER FOLLOWERS</h6>
								</div>

							</div>

						</div>

					</div>


				</div>
			</section>
			<!-- /ABOUT -->

      <!-- WORK -->
      <section id="examples">
        <div class="container">

          <header class="text-center margin-bottom-60">
            <h2>{{ trans('home.our_communities') }}</h2>
            <p class="lead font-lato">Lorem ipsum dolor sit amet adipiscium elit</p>
            <hr />
          </header>


          <!-- PORTFOLIO -->
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

                        <a class="ico-rounded" href="#">
                          <span class="glyphicon glyphicon-option-horizontal size-20"></span>
                        </a>
                        <a class="ico-rounded" href="#">
                          <span class="glyphicon glyphicon-heart size-20"></span>
                        </a>


                      </span>
                    </span>
                    <img class="img-responsive" src="http://lorempixel.com/{{ rand(100, 200) }}/{{ rand(100, 200) }}" width="600" height="399" alt="">
                  </figure>
                </div>

              </div><!-- /item -->

              @endforeach

            </div>

          </div>
          <!-- /PORTFOLIO -->


          <!-- CONTACT US -->
                    <div class="callout alert alert-transparent noborder margin-top-60 margin-bottom-60">

                      <div class="text-center">

                        <h3>Call now at <strong>+800-565-2390</strong> and get 15% discount!</h3>
                        <p class="font-lato size-20">
                          We truly care about our users and our product.
                        </p>

                        <a href="#contact" class="scrollTo btn btn-default btn-lg margin-top-30">CONTACT US</a>

                      </div>

                    </div>
                    <!-- /CONTACT US -->

                  </div>
                </section>
                <!-- /WORK -->


@stop
