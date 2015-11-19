@extends('layouts/master')

{{-- Page title --}}
@section('title')
     {{ trans('general.nav.create_community') }} ::
@parent
@stop


{{-- Page content --}}
@section('content')

<!-- -->
			<section>
				<div class="container margin-top-20">

					<div class="row">

						<!-- LEFT TEXT -->
						<div class="col-md-5 col-md-offset-1">

							<h2 class="size-16">CREATE A COMMUNITY ON ANYSHA.RE</h2>
							<p class="text-muted">Maecenas metus nulla, commodo a sodales sed, dignissim pretium nunc. Nam et lacus neque. Ut enim massa, sodales tempor convallis et, iaculis ac massa.</p>
							<p class="text-muted">Sodales sed, dignissim pretium nunc. Nam et lacus neque. Ut enim massa, sodales tempor convallis et, iaculis ac massa.</p>

						</div>
						<!-- /LEFT TEXT -->


						<!-- LOGIN -->
						<div class="col-md-4">

							<h2 class="size-16">NEW COMMUNITY</h2>

							<!-- login form -->
							<form method="post" action="{{ route('community.create.save') }}" enctype="multipart/form-data" autocomplete="off">
                {!! csrf_field() !!}

								<div class="clearfix">

									<!-- Name -->
									<div class="form-group">
										<input type="text" name="name" class="form-control" placeholder="Community Name" required="" value="{{ old('name') }}">
									</div>

                  <!-- Slug -->
									<div class="form-group">
										<input type="text" name="subdomain" class="form-control" placeholder="Subdomain" required="" value="{{ old('subdomain') }}">
									</div>

                  <div class="form-group">
											<input class="custom-file-upload" type="file" id="file" name="cover_img" data-btn-text="Cover Upload" />
											<small class="text-muted block">Max file size: 10Mb (gif/jpg/png)</small>
									</div>

								</div>

								<div class="row">

									<div class="col-md-12 col-sm-12 col-xs-12 text-right">
										<button class="btn btn-primary">Create Community</button>
									</div>

								</div>

							</form>
						</div>
					</div>


				</div>
			</section>
			<!-- / -->



@stop
