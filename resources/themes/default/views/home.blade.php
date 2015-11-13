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
          <div id="portfolio" class="portfolio-nogutter">

            <ul class="nav nav-pills mix-filter margin-bottom-60">
              <li data-filter="all" class="filter active"><a href="#">All</a></li>
              <li data-filter="development" class="filter"><a href="#">Development</a></li>
              <li data-filter="photography" class="filter"><a href="#">Photography</a></li>
              <li data-filter="design" class="filter"><a href="#">Design</a></li>
            </ul>


            <div class="row mix-grid">

              <div class="col-md-3 col-sm-3 mix design"><!-- item -->

                <div class="item-box">
                  <figure>
                    <span class="item-hover">
                      <span class="overlay dark-5"></span>
                      <span class="inner">

                        <!-- lightbox -->
                        <a class="ico-rounded lightbox" href="assets/img/demo/mockups/1200x800/8-min.jpg" data-plugin-options='{"type":"image"}'>
                          <span class="fa fa-plus size-20"></span>
                        </a>

                        <!-- details -->
                        <a class="ico-rounded" href="portfolio-single-slider.html">
                          <span class="glyphicon glyphicon-option-horizontal size-20"></span>
                        </a>

                      </span>
                    </span>

                    <!-- carousel -->
                    <div class="owl-carousel buttons-autohide controlls-over nomargin" data-plugin-options='{"singleItem": true, "autoPlay": 4000, "navigation": false, "pagination": true, "transitionStyle":"goDown"}'>
                      <div>
                        <img class="img-responsive" src="assets/img/demo/mockups/600x399/8-min.jpg" width="600" height="399" alt="">
                      </div>
                      <div>
                        <img class="img-responsive" src="assets/img/demo/mockups/600x399/9-min.jpg" width="600" height="399" alt="">
                      </div>
                      <div>
                        <img class="img-responsive" src="assets/img/demo/mockups/600x399/10-min.jpg" width="600" height="399" alt="">
                      </div>
                    </div>
                    <!-- /carousel -->


                  </figure>

                  <div class="item-box-desc">
                    <h3>Street Photography</h3>
                    <ul class="list-inline categories nomargin">
                      <li><a href="#">Photography</a></li>
                      <li><a href="#">Design</a></li>
                    </ul>
                  </div>

                </div>

              </div><!-- /item -->


              <div class="col-md-3 col-sm-3 mix development"><!-- item -->

                <div class="item-box">
                  <figure>
                    <span class="item-hover">
                      <span class="overlay dark-5"></span>
                      <span class="inner">

                        <!-- lightbox -->
                        <a class="ico-rounded lightbox" href="assets/img/demo/mockups/1200x800/9-min.jpg" data-plugin-options='{"type":"image"}'>
                          <span class="fa fa-plus size-20"></span>
                        </a>

                        <!-- details -->
                        <a class="ico-rounded" href="portfolio-single-slider.html">
                          <span class="glyphicon glyphicon-option-horizontal size-20"></span>
                        </a>

                      </span>
                    </span>

                    <img class="img-responsive" src="assets/img/demo/mockups/600x399/9-min.jpg" width="600" height="399" alt="">
                  </figure>

                  <div class="item-box-desc">
                    <h3>Nature Photography</h3>
                    <ul class="list-inline categories nomargin">
                      <li><a href="#">Photography</a></li>
                      <li><a href="#">Design</a></li>
                    </ul>
                  </div>

                </div>

              </div><!-- /item -->


              <div class="col-md-3 col-sm-3 mix photography"><!-- item -->

                <div class="item-box">
                  <figure>
                    <span class="item-hover">
                      <span class="overlay dark-5"></span>
                      <span class="inner">

                        <!-- lightbox -->
                        <a class="ico-rounded lightbox" href="assets/img/demo/mockups/1200x800/10-min.jpg" data-plugin-options='{"type":"image"}'>
                          <span class="fa fa-plus size-20"></span>
                        </a>

                        <!-- details -->
                        <a class="ico-rounded" href="portfolio-single-slider.html">
                          <span class="glyphicon glyphicon-option-horizontal size-20"></span>
                        </a>

                      </span>
                    </span>

                    <img class="img-responsive" src="assets/img/demo/mockups/600x399/10-min.jpg" width="600" height="399" alt="">
                  </figure>

                  <div class="item-box-desc">
                    <h3>Fashion Design</h3>
                    <ul class="list-inline categories nomargin">
                      <li><a href="#">Photography</a></li>
                      <li><a href="#">Design</a></li>
                    </ul>
                  </div>

                </div>

              </div><!-- /item -->


              <div class="col-md-3 col-sm-3 mix design"><!-- item -->

                <div class="item-box">
                  <figure>
                    <span class="item-hover">
                      <span class="overlay dark-5"></span>
                      <span class="inner">

                        <!-- lightbox -->
                        <a class="ico-rounded lightbox" href="assets/img/demo/mockups/1200x800/11-min.jpg" data-plugin-options='{"type":"image"}'>
                          <span class="fa fa-plus size-20"></span>
                        </a>

                        <!-- details -->
                        <a class="ico-rounded" href="portfolio-single-slider.html">
                          <span class="glyphicon glyphicon-option-horizontal size-20"></span>
                        </a>

                      </span>
                    </span>

                    <img class="img-responsive" src="assets/img/demo/mockups/600x399/11-min.jpg" width="600" height="399" alt="">
                  </figure>

                  <div class="item-box-desc">
                    <h3>Ocean Project</h3>
                    <ul class="list-inline categories nomargin">
                      <li><a href="#">Photography</a></li>
                      <li><a href="#">Design</a></li>
                    </ul>
                  </div>

                </div>

              </div><!-- /item -->


              <div class="col-md-3 col-sm-3 mix design"><!-- item -->

                <div class="item-box">
                  <figure>
                    <span class="item-hover">
                      <span class="overlay dark-5"></span>
                      <span class="inner">

                        <!-- lightbox -->
                        <a class="ico-rounded lightbox" href="assets/img/demo/mockups/1200x800/12-min.jpg" data-plugin-options='{"type":"image"}'>
                          <span class="fa fa-plus size-20"></span>
                        </a>

                        <!-- details -->
                        <a class="ico-rounded" href="portfolio-single-slider.html">
                          <span class="glyphicon glyphicon-option-horizontal size-20"></span>
                        </a>

                      </span>
                    </span>

                    <img class="img-responsive" src="assets/img/demo/mockups/600x399/12-min.jpg" width="600" height="399" alt="">
                  </figure>

                  <div class="item-box-desc">
                    <h3>Architect Project</h3>
                    <ul class="list-inline categories nomargin">
                      <li><a href="#">Architecture</a></li>
                      <li><a href="#">Design</a></li>
                    </ul>
                  </div>

                </div>

              </div><!-- /item -->


              <div class="col-md-3 col-sm-3 mix development"><!-- item -->

                <div class="item-box">
                  <figure>
                    <span class="item-hover">
                      <span class="overlay dark-5"></span>
                      <span class="inner">

                        <!-- lightbox -->
                        <a class="ico-rounded lightbox" href="assets/img/demo/mockups/1200x800/13-min.jpg" data-plugin-options='{"type":"image"}'>
                          <span class="fa fa-plus size-20"></span>
                        </a>

                        <!-- details -->
                        <a class="ico-rounded" href="portfolio-single-slider.html">
                          <span class="glyphicon glyphicon-option-horizontal size-20"></span>
                        </a>

                      </span>
                    </span>

                    <img class="img-responsive" src="assets/img/demo/mockups/600x399/13-min.jpg" width="600" height="399" alt="">
                  </figure>

                  <div class="item-box-desc">
                    <h3>Speaker Design</h3>
                    <ul class="list-inline categories nomargin">
                      <li><a href="#">Audio</a></li>
                      <li><a href="#">Design</a></li>
                    </ul>
                  </div>

                </div>

              </div><!-- /item -->


              <div class="col-md-3 col-sm-3 mix photography"><!-- item -->

                <div class="item-box">
                  <figure>
                    <span class="item-hover">
                      <span class="overlay dark-5"></span>
                      <span class="inner">

                        <!-- lightbox -->
                        <a class="ico-rounded lightbox" href="assets/img/demo/mockups/1200x800/14-min.jpg" data-plugin-options='{"type":"image"}'>
                          <span class="fa fa-plus size-20"></span>
                        </a>

                        <!-- details -->
                        <a class="ico-rounded" href="portfolio-single-slider.html">
                          <span class="glyphicon glyphicon-option-horizontal size-20"></span>
                        </a>

                      </span>
                    </span>

                    <img class="img-responsive" src="assets/img/demo/mockups/600x399/14-min.jpg" width="600" height="399" alt="">
                  </figure>

                  <div class="item-box-desc">
                    <h3>Mobile Development</h3>
                    <ul class="list-inline categories nomargin">
                      <li><a href="#">Development</a></li>
                      <li><a href="#">Design</a></li>
                    </ul>
                  </div>

                </div>

              </div><!-- /item -->


              <div class="col-md-3 col-sm-3 mix design"><!-- item -->

                <div class="item-box">
                  <figure>
                    <span class="item-hover">
                      <span class="overlay dark-5"></span>
                      <span class="inner">

                        <!-- lightbox -->
                        <a class="ico-rounded lightbox" href="assets/img/demo/mockups/1200x800/15-min.jpg" data-plugin-options='{"type":"image"}'>
                          <span class="fa fa-plus size-20"></span>
                        </a>

                        <!-- details -->
                        <a class="ico-rounded" href="portfolio-single-slider.html">
                          <span class="glyphicon glyphicon-option-horizontal size-20"></span>
                        </a>

                      </span>
                    </span>

                    <img class="img-responsive" src="assets/img/demo/mockups/600x399/15-min.jpg" width="600" height="399" alt="">
                  </figure>

                  <div class="item-box-desc">
                    <h3>Nature Art</h3>
                    <ul class="list-inline categories nomargin">
                      <li><a href="#">Nature</a></li>
                      <li><a href="#">Art</a></li>
                    </ul>
                  </div>

                </div>

              </div><!-- /item -->


              <div class="col-md-3 col-sm-3 mix design"><!-- item -->

                <div class="item-box">
                  <figure>
                    <span class="item-hover">
                      <span class="overlay dark-5"></span>
                      <span class="inner">

                        <!-- lightbox -->
                        <a class="ico-rounded lightbox" href="assets/img/demo/mockups/1200x800/16-min.jpg" data-plugin-options='{"type":"image"}'>
                          <span class="fa fa-plus size-20"></span>
                        </a>

                        <!-- details -->
                        <a class="ico-rounded" href="portfolio-single-slider.html">
                          <span class="glyphicon glyphicon-option-horizontal size-20"></span>
                        </a>

                      </span>
                    </span>

                    <img class="img-responsive" src="assets/img/demo/mockups/600x399/16-min.jpg" width="600" height="399" alt="">
                  </figure>

                  <div class="item-box-desc">
                    <h3>Nature Art</h3>
                    <ul class="list-inline categories nomargin">
                      <li><a href="#">Nature</a></li>
                      <li><a href="#">Art</a></li>
                    </ul>
                  </div>

                </div>

              </div><!-- /item -->


              <div class="col-md-3 col-sm-3 mix photography"><!-- item -->

                <div class="item-box">
                  <figure>
                    <span class="item-hover">
                      <span class="overlay dark-5"></span>
                      <span class="inner">

                        <!-- lightbox -->
                        <a class="ico-rounded lightbox" href="assets/img/demo/mockups/1200x800/1-min.jpg" data-plugin-options='{"type":"image"}'>
                          <span class="fa fa-plus size-20"></span>
                        </a>

                        <!-- details -->
                        <a class="ico-rounded" href="portfolio-single-slider.html">
                          <span class="glyphicon glyphicon-option-horizontal size-20"></span>
                        </a>

                      </span>
                    </span>

                    <img class="img-responsive" src="assets/img/demo/mockups/600x399/1-min.jpg" width="600" height="399" alt="">
                  </figure>

                  <div class="item-box-desc">
                    <h3>Mobile Development</h3>
                    <ul class="list-inline categories nomargin">
                      <li><a href="#">Development</a></li>
                      <li><a href="#">Design</a></li>
                    </ul>
                  </div>

                </div>

              </div><!-- /item -->


              <div class="col-md-3 col-sm-3 mix design"><!-- item -->

                <div class="item-box">
                  <figure>
                    <span class="item-hover">
                      <span class="overlay dark-5"></span>
                      <span class="inner">

                        <!-- lightbox -->
                        <a class="ico-rounded lightbox" href="assets/img/demo/mockups/1200x800/2-min.jpg" data-plugin-options='{"type":"image"}'>
                          <span class="fa fa-plus size-20"></span>
                        </a>

                        <!-- details -->
                        <a class="ico-rounded" href="portfolio-single-slider.html">
                          <span class="glyphicon glyphicon-option-horizontal size-20"></span>
                        </a>

                      </span>
                    </span>

                    <img class="img-responsive" src="assets/img/demo/mockups/600x399/2-min.jpg" width="600" height="399" alt="">
                  </figure>

                  <div class="item-box-desc">
                    <h3>Nature Art</h3>
                    <ul class="list-inline categories nomargin">
                      <li><a href="#">Nature</a></li>
                      <li><a href="#">Art</a></li>
                    </ul>
                  </div>

                </div>

              </div><!-- /item -->


              <div class="col-md-3 col-sm-3 mix design"><!-- item -->

                <div class="item-box">
                  <figure>
                    <span class="item-hover">
                      <span class="overlay dark-5"></span>
                      <span class="inner">

                        <!-- lightbox -->
                        <a class="ico-rounded lightbox" href="assets/img/demo/mockups/1200x800/3-min.jpg" data-plugin-options='{"type":"image"}'>
                          <span class="fa fa-plus size-20"></span>
                        </a>

                        <!-- details -->
                        <a class="ico-rounded" href="portfolio-single-slider.html">
                          <span class="glyphicon glyphicon-option-horizontal size-20"></span>
                        </a>

                      </span>
                    </span>

                    <img class="img-responsive" src="assets/img/demo/mockups/600x399/3-min.jpg" width="600" height="399" alt="">
                  </figure>

                  <div class="item-box-desc">
                    <h3>Nature Art</h3>
                    <ul class="list-inline categories nomargin">
                      <li><a href="#">Nature</a></li>
                      <li><a href="#">Art</a></li>
                    </ul>
                  </div>

                </div>

              </div><!-- /item -->


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
