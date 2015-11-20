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

					<!-- RIGHT -->
					<div class="col-lg-9 col-md-9 col-sm-8 col-lg-push-3 col-md-push-3 col-sm-push-4 margin-bottom-80">

						<ul class="nav nav-tabs nav-top-border">
							<li class="active"><a href="#info" data-toggle="tab">Personal Info</a></li>
							<li><a href="#avatar" data-toggle="tab">Avatar</a></li>
							<li><a href="#password" data-toggle="tab">Password</a></li>
							<li><a href="#privacy" data-toggle="tab">Privacy</a></li>
						</ul>

						<div class="tab-content margin-top-20">

							<!-- PERSONAL INFO TAB -->
							<div class="tab-pane fade in active" id="info">
								<form role="form" action="#" method="post">
									<div class="form-group">
										<label class="control-label">First Name</label>
										<input type="text" placeholder="Felicia" class="form-control">
									</div>
									<div class="form-group">
										<label class="control-label">Last Name</label>
										<input type="text" placeholder="Doe" class="form-control">
									</div>
									<div class="form-group">
										<label class="control-label">Mobile Number</label>
										<input type="text" placeholder="+1800-1234-657" class="form-control">
									</div>
									<div class="form-group">
										<label class="control-label">Interests</label>
										<input type="text" placeholder="Development, C++, etc." class="form-control">
									</div>
									<div class="form-group">
										<label class="control-label">Occupation</label>
										<input type="text" placeholder="Webdeveloper" class="form-control">
									</div>
									<div class="form-group">
										<label class="control-label">About</label>
										<textarea class="form-control" rows="3" placeholder="About Me..."></textarea>
									</div>
									<div class="form-group">
										<label class="control-label">Website Url</label>
										<input type="text" placeholder="http://www.yourwebsite.com" class="form-control">
									</div>
									<div class="margiv-top10">
										<a href="#" class="btn btn-primary"><i class="fa fa-check"></i> Save Changes </a>
										<a href="#" class="btn btn-default">Cancel </a>
									</div>
								</form>
							</div>
							<!-- /PERSONAL INFO TAB -->

							<!-- AVATAR TAB -->
							<div class="tab-pane fade" id="avatar">

								<form class="clearfix" action="#" method="post" enctype="multipart/form-data">
									<div class="form-group">

										<div class="row">

											<div class="col-md-3 col-sm-4">

												<div class="thumbnail">
													<img class="img-responsive" src="{{ Auth::user()->gravatar() }}?s=300" alt="" />
												</div>

											</div>

											<div class="col-md-9 col-sm-8">

												<div class="sky-form nomargin">
													<label class="label">Select File</label>
													<label for="file" class="input input-file">
														<div class="button">
															<input type="file" id="file" onchange="this.parentNode.nextSibling.value = this.value">Browse
														</div><input type="text" readonly>
													</label>
												</div>

												<a href="#" class="btn btn-danger btn-xs noradius"><i class="fa fa-times"></i> Remove Avatar</a>

												<div class="clearfix margin-top-20">
													<span class="label label-warning">NOTE! </span>
													<p>
														Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt laoreet!
													</p>
												</div>

											</div>

										</div>

									</div>

									<div class="margiv-top10">
										<a href="#" class="btn btn-primary">Save Changes </a>
										<a href="#" class="btn btn-default">Cancel </a>
									</div>

								</form>

							</div>
							<!-- /AVATAR TAB -->

							<!-- PASSWORD TAB -->
							<div class="tab-pane fade" id="password">

								<form action="#" method="post">

									<div class="form-group">
										<label class="control-label">Current Password</label>
										<input type="password" class="form-control">
									</div>
									<div class="form-group">
										<label class="control-label">New Password</label>
										<input type="password" class="form-control">
									</div>
									<div class="form-group">
										<label class="control-label">Re-type New Password</label>
										<input type="password" class="form-control">
									</div>

									<div class="margiv-top10">
										<a href="#" class="btn btn-primary"><i class="fa fa-check"></i> Change Password</a>
										<a href="#" class="btn btn-default">Cancel </a>
									</div>

								</form>

							</div>
							<!-- /PASSWORD TAB -->

							<!-- PRIVACY TAB -->
							<div class="tab-pane fade" id="privacy">

								<form action="#" method="post">
									<div class="sky-form">

										<table class="table table-bordered table-striped">
											<tbody>
												<tr>
													<td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam.</td>
													<td>
														<div class="inline-group">
															<label class="radio nomargin-top nomargin-bottom">
																<input type="radio" name="radioOption" checked=""><i></i> Yes
															</label>

															<label class="radio nomargin-top nomargin-bottom">
																<input type="radio" name="radioOption" checked=""><i></i> No
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam.</td>
													<td>
														<label class="checkbox nomargin">
															<input type="checkbox" name="checkbox" checked=""><i></i> Yes
														</label>
													</td>
												</tr>
												<tr>
													<td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam.</td>
													<td>
														<label class="checkbox nomargin">
															<input type="checkbox" name="checkbox" checked=""><i></i> Yes
														</label>
													</td>
												</tr>
												<tr>
													<td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam.</td>
													<td>
														<label class="checkbox nomargin">
															<input type="checkbox" name="checkbox" checked=""><i></i> Yes
														</label>
													</td>
												</tr>
											</tbody>
										</table>

									</div>

									<div class="margin-top-10">
										<a href="#" class="btn btn-primary"><i class="fa fa-check"></i> Save Changes </a>
										<a href="#" class="btn btn-default">Cancel </a>
									</div>

								</form>

							</div>
							<!-- /PRIVACY TAB -->

						</div>

					</div>


					<!-- LEFT -->
					<div class="col-lg-3 col-md-3 col-sm-4 col-lg-pull-9 col-md-pull-9 col-sm-pull-8">

						<div class="thumbnail text-center">
							<img src="{{ Auth::user()->gravatar() }}?s=400" alt="" />
							<h2 class="size-18 margin-top-10 margin-bottom-0">{{ Auth::user()->getDisplayName() }}</h2>
							<h3 class="size-11 margin-top-0 margin-bottom-10 text-muted">{{ Auth::user()->location }}</h3>
						</div>

						<!-- completed -->
						<div class="margin-bottom-30">
							<label>88% completed profile</label>
							<div class="progress progress-xxs">
								<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="width: 88%; min-width: 2em;"></div>
							</div>
						</div>
						<!-- /completed -->

						<!-- SIDE NAV -->
						<ul class="side-nav list-group margin-bottom-60" id="sidebar-nav">
							<li class="list-group-item"><a href="#"><i class="fa fa-eye"></i> SUBNAV</a></li>
							<li class="list-group-item"><a href="#"><i class="fa fa-comments-o"></i> SUBNAV</a></li>
							<li class="list-group-item"><a href="#"><i class="fa fa-history"></i> SUBNAV</a></li>
							<li class="list-group-item active"><a href="#"><i class="fa fa-gears"></i> SUBNAV</a></li>
						</ul>
						<!-- /SIDE NAV -->


            <!-- info -->
						<div class="box-light margin-bottom-30">

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
									<h3 class="size-11 margin-top-0 margin-bottom-10 text-info">COMMUNITIES</h3>
								</div>

							</div>
							<!-- /info -->

              <!-- social / stats -->
              <div class="text-muted">

                <ul class="list-unstyled nomargin">
                  @if (Auth::user()->website)
                    <li class="margin-bottom-10"><i class="fa fa-globe width-20 hidden-xs hidden-sm"></i> <a href="{{ Auth::user()->website }}">{{ Auth::user()->website }}</a></li>
                  @endif

                  @if (Auth::user()->twitter)
                    <li class="margin-bottom-10"><i class="fa fa-twitter width-20 hidden-xs hidden-sm"></i> <a href="{{ Auth::user()->twitter }}">Twitter</a></li>
                  @endif

                  @if (Auth::user()->facebook)
                    <li class="margin-bottom-10"><i class="fa fa-facebook width-20 hidden-xs hidden-sm"></i> <a href="{{ Auth::user()->facebook }}">Facebook</a></li>
                  @endif

                  @if (Auth::user()->pinterest)
                    <li class="margin-bottom-10"><i class="fa fa-pinterest width-20 hidden-xs hidden-sm"></i> <a href="{{ Auth::user()->pinterest }}">Pinterest</a></li>
                  @endif

                  @if (Auth::user()->google)
                    <li class="margin-bottom-10"><i class="fa fa-google width-20 hidden-xs hidden-sm"></i> <a href="{{ Auth::user()->google }}">Google +</a></li>
                  @endif

                </ul>
              </div>
              <!-- /social / stats -->

						</div>

					</div>

				</div>
			</section>
			<!-- / -->

@stop
