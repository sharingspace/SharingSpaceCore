@extends('layouts.master')

{{-- Page title --}}
@section('title')
     {{ trans('general.nav.members') }} ::
@parent
@stop


@section('content')

<!-- -->
			<section>
				<div class="container">

					<!-- LEFT -->
					<div class="col-lg-3 col-md-3 col-sm-4">

						<div class="thumbnail text-center">
              <img src="{{ $user->gravatar() }}?s=400" alt="" />
							<h2 class="size-18 margin-top-10 margin-bottom-0">{{ $user->getDisplayName() }}</h2>
							<h3 class="size-11 margin-top-0 margin-bottom-10 text-muted">{{ $user->location }}</h3>
						</div>

						<!-- info -->
						<div class="box-light margin-bottom-30"><!-- .box-light OR .box-light -->
							<div class="row margin-bottom-20">
								<div class="col-md-4 col-sm-4 col-xs-4 text-center bold">
									<h2 class="size-30 margin-top-10 margin-bottom-0 font-raleway">12</h2>
									<h3 class="size-11 margin-top-0 margin-bottom-10 text-info">ENTRIES</h3>
								</div>

								<div class="col-md-4 col-sm-4 col-xs-4 text-center bold">
									<h2 class="size-30 margin-top-10 margin-bottom-0 font-raleway">34</h2>
									<h3 class="size-11 margin-top-0 margin-bottom-10 text-info">FOLLOWING</h3>
								</div>

								<div class="col-md-4 col-sm-4 col-xs-4 text-center bold">
									<h2 class="size-30 margin-top-10 margin-bottom-0 font-raleway">32</h2>
									<h3 class="size-11 margin-top-0 margin-bottom-10 text-info">UPLOADS</h3>
								</div>
							</div>
							<!-- /info -->

							<div class="text-muted">

								<ul class="list-unstyled nomargin">
                  @if ($user->website)
                    <li class="margin-bottom-10"><i class="fa fa-globe width-20 hidden-xs hidden-sm"></i> <a href="{{ $user->website }}">{{ $user->website }}</a></li>
                  @endif

                  @if ($user->twitter_url)
                    <li class="margin-bottom-10"><i class="fa fa-twitter width-20 hidden-xs hidden-sm"></i> <a href="{{ $user->twitter_url }}">{{ '@'.$user->twitter_url }}</a></li>
                  @endif

                  @if ($user->fb_url)
                    <li class="margin-bottom-10"><i class="fa fa-facebook width-20 hidden-xs hidden-sm"></i> <a href="{{ $user->fb_url }}">{{ '@'.$user->fb_url }}</a></li>
                  @endif

								</ul>
							</div>

						</div>

					</div>


					<!-- RIGHT -->
					<div class="col-lg-9 col-md-9 col-sm-8">

						<!-- BIO BOX -->
						<div class="box-icon box-icon-center box-icon-round box-icon-large text-center nomargin">
							<div class="front">
								<div class="box1 noradius">
									<div class="box-icon-title">
										<h2>{{ $user->getDisplayName() }} &ndash; Profile</h2>
									</div>
									<p>{{ $user->bio }}</p>
								</div>
							</div>
						</div>
						<!-- /BIO BOX -->


						<div class="box-light"><!-- .box-light OR .box-dark -->

							<div class="row">

								<!-- ENTRIES -->
								<div class="col-md-12 col-sm-12">

									<div class="box-inner">
										<h3>
											ENTRIES
										</h3>
										<div>

											<div class="clearfix margin-bottom-10"><!-- post item -->
												<img class="thumbnail pull-left" src="/assets/img/demo/people/300x300/b-min.jpg" width="60" height="60" alt="" />
												<h4 class="size-13 nomargin noborder nopadding"><a href="#">Nullam Vitae Nibh Un Odiosters</a></h4>
												<span class="size-11 text-muted">June 29, 2015</span>
											</div><!-- /post item -->

											<div class="clearfix margin-bottom-10"><!-- post item -->
												<img class="thumbnail pull-left" src="/assets/img/demo/people/300x300/6-min.jpg" width="60" height="60" alt="" />
												<h4 class="size-13 nomargin noborder nopadding"><a href="#">Nullam Vitae Nibh Un Odiosters</a></h4>
												<span class="size-11 text-muted">June 29, 2015</span>
											</div><!-- /post item -->

											<div class="clearfix margin-bottom-10"><!-- post item -->
												<img class="thumbnail pull-left" src="/assets/img/demo/people/300x300/d-min.jpg" width="60" height="60" alt="" />
												<h4 class="size-13 nomargin noborder nopadding"><a href="#">Nullam Vitae Nibh Un Odiosters</a></h4>
												<span class="size-11 text-muted">June 29, 2015</span>
											</div><!-- /post item -->

											<div class="clearfix margin-bottom-10"><!-- post item -->
												<img class="thumbnail pull-left" src="/assets/img/demo/people/300x300/a-min.jpg" width="60" height="60" alt="" />
												<h4 class="size-13 nomargin noborder nopadding"><a href="#">Nullam Vitae Nibh Un Odiosters</a></h4>
												<span class="size-11 text-muted">June 29, 2015</span>
											</div><!-- /post item -->

											<div class="clearfix margin-bottom-10"><!-- post item -->
												<img class="thumbnail pull-left" src="/assets/img/demo/people/300x300/5-min.jpg" width="60" height="60" alt="" />
												<h4 class="size-13 nomargin noborder nopadding"><a href="#">Nullam Vitae Nibh Un Odiosters</a></h4>
												<span class="size-11 text-muted">June 29, 2015</span>
											</div><!-- /post item -->

										</div>
									</div>
								</div>
								<!-- /ENTRIES -->

						</div>


						<form method="post" action="#" class="box-light margin-top-20"><!-- .box-light OR .box-dark -->
							<div class="box-inner">
								<h4 class="uppercase">LEAVE A MESSAGE FOR <strong>{{ strtoupper($user->getDisplayName()) }} </strong></h4>

								<textarea required class="form-control word-count" data-maxlength="100" rows="5" placeholder="Type your message here..."></textarea>
								<div class="text-muted text-right margin-top-3 size-12 margin-bottom-10">
									<span>0/100</span> Words
								</div>

								<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> SEND MESSAGE</button>
							</div>
						</form>

					</div>

				</div>
			</section>
			<!-- / -->

@stop
