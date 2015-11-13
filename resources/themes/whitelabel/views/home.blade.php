@extends('layouts.master')

@section('content')

<section class="container">
  <div class="row">

        <p>
          @if ($whitelabel_group->about!='')
            {{ $whitelabel_group->about }}
          @else
            {{ trans('general.no_about_data') }}
          @endif
        </p>

        <p class="text-center"><a href="{{ route('browse') }}" class="btn btn-default">{{ trans('general.browse_button') }}</a></p>
  </div><!--end row-->
</section>

<!-- -->
			<section>
				<div class="container">

					<ul id="portfolio_filter" class="nav nav-pills margin-bottom-60">
						<li class="filter active"><a data-filter="*" href="#">All</a></li>
						<li class="filter"><a data-filter=".gift" href="#">Gift</a></li>
						<li class="filter"><a data-filter=".buy" href="#">Buy / Sell</a></li>
						<li class="filter"><a data-filter=".trade" href="#">Trade</a></li>
					</ul>

					<div id="portfolio" class="clearfix portfolio-isotope portfolio-isotope-5">

						<div class="portfolio-item gift"><!-- item -->

							<div class="item-box">
								<figure>
									<span class="item-hover">
										<span class="overlay dark-5"></span>
										<span class="inner">

											<!-- lightbox -->
											<a class="ico-rounded lightbox" href="/assets/img/demo/mockups/1200x800/20-min.jpg" data-plugin-options='{"type":"image"}'>
												<span class="fa fa-plus size-20"></span>
											</a>

											<!-- details -->
											<a class="ico-rounded" href="#">
												<span class="glyphicon glyphicon-option-horizontal size-20"></span>
											</a>

										</span>
									</span>
									<img class="img-responsive" src="/assets/img/demo/720x400/20-min.jpg" width="600" height="399" alt="">
								</figure>
							</div>

						</div><!-- /item -->


						<div class="portfolio-item buy"><!-- item -->

							<div class="item-box">
								<figure>
									<span class="item-hover">
										<span class="overlay dark-5"></span>
										<span class="inner">

											<!-- lightbox -->
											<a class="ico-rounded lightbox" href="/assets/img/demo/mockups/1200x800/19-min.jpg" data-plugin-options='{"type":"image"}'>
												<span class="fa fa-plus size-20"></span>
											</a>

											<!-- details -->
											<a class="ico-rounded" href="#">
												<span class="glyphicon glyphicon-option-horizontal size-20"></span>
											</a>

										</span>
									</span>
									<img class="img-responsive" src="/assets/img/demo/mockups/600x399/19-min.jpg" width="600" height="399" alt="">
								</figure>
							</div>

						</div><!-- /item -->


						<div class="portfolio-item trade"><!-- item -->

							<div class="item-box">
								<figure>
									<span class="item-hover">
										<span class="overlay dark-5"></span>
										<span class="inner">

											<!-- lightbox -->
											<a class="ico-rounded lightbox" href="/assets/img/demo/mockups/1200x800/3-min.jpg" data-plugin-options='{"type":"image"}'>
												<span class="fa fa-plus size-20"></span>
											</a>

											<!-- details -->
											<a class="ico-rounded" href="#">
												<span class="glyphicon glyphicon-option-horizontal size-20"></span>
											</a>

										</span>
									</span>
									<img class="img-responsive" src="/assets/img/demo/content_slider/3-min.jpg" width="600" height="399" alt="">
								</figure>
							</div>

						</div><!-- /item -->


						<div class="portfolio-item trade"><!-- item -->

							<div class="item-box">
								<figure>
									<span class="item-hover">
										<span class="overlay dark-5"></span>
										<span class="inner">

											<!-- lightbox -->
											<a class="ico-rounded lightbox" href="/assets/img/demo/720x400/12-min.jpg" data-plugin-options='{"type":"image"}'>
												<span class="fa fa-plus size-20"></span>
											</a>

											<!-- details -->
											<a class="ico-rounded" href="#">
												<span class="glyphicon glyphicon-option-horizontal size-20"></span>
											</a>

										</span>
									</span>
									<img class="img-responsive" src="/assets/img/demo/mockups/600x399/12-min.jpg" width="600" height="399" alt="">
								</figure>
							</div>

						</div><!-- /item -->


						<div class="portfolio-item gift"><!-- item -->

							<div class="item-box">
								<figure>
									<span class="item-hover">
										<span class="overlay dark-5"></span>
										<span class="inner">

											<!-- lightbox -->
											<a class="ico-rounded lightbox" href="/assets/img/demo/mockups/1200x800/13-min.jpg" data-plugin-options='{"type":"image"}'>
												<span class="fa fa-plus size-20"></span>
											</a>

											<!-- details -->
											<a class="ico-rounded" href="#">
												<span class="glyphicon glyphicon-option-horizontal size-20"></span>
											</a>

										</span>
									</span>
									<img class="img-responsive" src="/assets/img/demo/mockups/600x399/13-min.jpg" width="600" height="399" alt="">
								</figure>
							</div>

						</div><!-- /item -->


						<div class="portfolio-item buy"><!-- item -->

							<div class="item-box">
								<figure>
									<span class="item-hover">
										<span class="overlay dark-5"></span>
										<span class="inner">

											<!-- lightbox -->
											<a class="ico-rounded lightbox" href="/assets/img/demo/mockups/1200x800/14-min.jpg" data-plugin-options='{"type":"image"}'>
												<span class="fa fa-plus size-20"></span>
											</a>

											<!-- details -->
											<a class="ico-rounded" href="#">
												<span class="glyphicon glyphicon-option-horizontal size-20"></span>
											</a>

										</span>
									</span>
									<img class="img-responsive" src="/assets/img/demo/720x400/14-min.jpg" width="600" height="399" alt="">
								</figure>
							</div>

						</div><!-- /item -->


						<div class="portfolio-item trade"><!-- item -->

							<div class="item-box">
								<figure>
									<span class="item-hover">
										<span class="overlay dark-5"></span>
										<span class="inner">

											<!-- lightbox -->
											<a class="ico-rounded lightbox" href="/assets/img/demo/mockups/1200x800/15-min.jpg" data-plugin-options='{"type":"image"}'>
												<span class="fa fa-plus size-20"></span>
											</a>

											<!-- details -->
											<a class="ico-rounded" href="#">
												<span class="glyphicon glyphicon-option-horizontal size-20"></span>
											</a>

										</span>
									</span>
									<img class="img-responsive" src="/assets/img/demo/mockups/600x399/15-min.jpg" width="600" height="399" alt="">
								</figure>
							</div>

						</div><!-- /item -->


						<div class="portfolio-item trade"><!-- item -->

							<div class="item-box">
								<figure>
									<span class="item-hover">
										<span class="overlay dark-5"></span>
										<span class="inner">

											<!-- lightbox -->
											<a class="ico-rounded lightbox" href="/assets/img/demo/mockups/1200x800/1-min.jpg" data-plugin-options='{"type":"image"}'>
												<span class="fa fa-plus size-20"></span>
											</a>

											<!-- details -->
											<a class="ico-rounded" href="#">
												<span class="glyphicon glyphicon-option-horizontal size-20"></span>
											</a>

										</span>
									</span>
									<img class="img-responsive" src="/assets/img/demo/720x400/1-min.jpg" width="600" height="399" alt="">
								</figure>
							</div>

						</div><!-- /item -->


						<div class="portfolio-item buy"><!-- item -->

							<div class="item-box">
								<figure>
									<span class="item-hover">
										<span class="overlay dark-5"></span>
										<span class="inner">

											<!-- lightbox -->
											<a class="ico-rounded lightbox" href="/assets/img/demo/mockups/1200x800/11-min.jpg" data-plugin-options='{"type":"image"}'>
												<span class="fa fa-plus size-20"></span>
											</a>

											<!-- details -->
											<a class="ico-rounded" href="#">
												<span class="glyphicon glyphicon-option-horizontal size-20"></span>
											</a>

										</span>
									</span>

									<!-- carousel -->
									<div class="flexslider" data-arrowNav="false" data-slideshowSpeed="3000">
										<ul class="slides">

											<!-- Slide 1 -->
											<li>
												<a href="#">
													<img class="img-responsive" src="/assets/img/demo/mockups/600x399/8-min.jpg" width="600" height="399" alt="">
												</a>
											</li>

											<!-- Slide 2 -->
											<li>
												<a href="#">
													<img class="img-responsive" src="/assets/img/demo/mockups/600x399/9-min.jpg" width="600" height="399" alt="">
												</a>
											</li>

											<!-- Slide 3 -->
											<li>
												<a href="#">
													<img class="img-responsive" src="/assets/img/demo/mockups/600x399/10-min.jpg" width="600" height="399" alt="">
												</a>
											</li>

										</ul>
									</div>
									<!-- /carousel -->

									</figure>
							</div>

						</div><!-- /item -->


						<div class="portfolio-item buy"><!-- item -->

							<div class="item-box">
								<figure>
									<span class="item-hover">
										<span class="overlay dark-5"></span>
										<span class="inner">

											<!-- lightbox -->
											<a class="ico-rounded lightbox" href="/assets/img/demo/mockups/1200x800/2-min.jpg" data-plugin-options='{"type":"image"}'>
												<span class="fa fa-plus size-20"></span>
											</a>

											<!-- details -->
											<a class="ico-rounded" href="#">
												<span class="glyphicon glyphicon-option-horizontal size-20"></span>
											</a>

										</span>
									</span>
									<img class="img-responsive" src="/assets/img/demo/720x400/2-min.jpg" width="600" height="399" alt="">
								</figure>
							</div>

						</div><!-- /item -->


						<div class="portfolio-item trade"><!-- item -->

							<div class="item-box">
								<figure>
									<span class="item-hover">
										<span class="overlay dark-5"></span>
										<span class="inner">

											<!-- lightbox -->
											<a class="ico-rounded lightbox" href="/assets/img/demo/mockups/1200x800/10-min.jpg" data-plugin-options='{"type":"image"}'>
												<span class="fa fa-plus size-20"></span>
											</a>

											<!-- details -->
											<a class="ico-rounded" href="#">
												<span class="glyphicon glyphicon-option-horizontal size-20"></span>
											</a>

										</span>
									</span>
									<img class="img-responsive" src="/assets/img/demo/mockups/600x399/10-min.jpg" width="600" height="399" alt="">
								</figure>
							</div>

						</div><!-- /item -->


						<div class="portfolio-item gift"><!-- item -->

							<div class="item-box">
								<figure>
									<span class="item-hover">
										<span class="overlay dark-5"></span>
										<span class="inner">

											<!-- lightbox -->
											<a class="ico-rounded lightbox" href="/assets/img/demo/mockups/1200x800/4-min.jpg" data-plugin-options='{"type":"image"}'>
												<span class="fa fa-plus size-20"></span>
											</a>

											<!-- details -->
											<a class="ico-rounded" href="#">
												<span class="glyphicon glyphicon-option-horizontal size-20"></span>
											</a>

										</span>
									</span>
									<img class="img-responsive" src="/assets/img/demo/720x400/4-min.jpg" width="600" height="399" alt="">
								</figure>
							</div>

						</div><!-- /item -->


						<div class="portfolio-item buy"><!-- item -->

							<div class="item-box">
								<figure>
									<span class="item-hover">
										<span class="overlay dark-5"></span>
										<span class="inner">

											<!-- lightbox -->
											<a class="ico-rounded lightbox" href="/assets/img/demo/mockups/1200x800/5-min.jpg" data-plugin-options='{"type":"image"}'>
												<span class="fa fa-plus size-20"></span>
											</a>

											<!-- details -->
											<a class="ico-rounded" href="#">
												<span class="glyphicon glyphicon-option-horizontal size-20"></span>
											</a>

										</span>
									</span>
									<img class="img-responsive" src="/assets/img/demo/720x400/5-min.jpg" width="600" height="399" alt="">
								</figure>
							</div>

						</div><!-- /item -->


						<div class="portfolio-item trade"><!-- item -->

							<div class="item-box">
								<figure>
									<span class="item-hover">
										<span class="overlay dark-5"></span>
										<span class="inner">

											<!-- lightbox -->
											<a class="ico-rounded lightbox" href="/assets/img/demo/mockups/1200x800/6-min.jpg" data-plugin-options='{"type":"image"}'>
												<span class="fa fa-plus size-20"></span>
											</a>

											<!-- details -->
											<a class="ico-rounded" href="#">
												<span class="glyphicon glyphicon-option-horizontal size-20"></span>
											</a>

										</span>
									</span>
									<img class="img-responsive" src="/assets/img/demo/720x400/6-min.jpg" width="600" height="399" alt="">
								</figure>
							</div>

						</div><!-- /item -->


						<div class="portfolio-item gift"><!-- item -->

							<div class="item-box">
								<figure>
									<span class="item-hover">
										<span class="overlay dark-5"></span>
										<span class="inner">

											<!-- lightbox -->
											<a class="ico-rounded lightbox" href="/assets/img/demo/mockups/1200x800/7-min.jpg" data-plugin-options='{"type":"image"}'>
												<span class="fa fa-plus size-20"></span>
											</a>

											<!-- details -->
											<a class="ico-rounded" href="#">
												<span class="glyphicon glyphicon-option-horizontal size-20"></span>
											</a>

										</span>
									</span>
									<img class="img-responsive" src="/assets/img/demo/720x400/7-min.jpg" width="600" height="399" alt="">
								</figure>
							</div>

						</div><!-- /item -->

					</div>

				</div>
			</section>
			<!-- / -->
@stop
