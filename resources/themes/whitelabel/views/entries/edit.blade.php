@extends('layouts/master')

{{-- Page title --}}
@section('title')
     {{ trans('general.nav.create_entry') }} ::
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

							<h2 class="size-16">CREATE A NEW ENTRY</h2>
							<p class="text-muted">Maecenas metus nulla, commodo a sodales sed, dignissim pretium nunc. Nam et lacus neque. Ut enim massa, sodales tempor convallis et, iaculis ac massa.</p>
							<p class="text-muted">Sodales sed, dignissim pretium nunc. Nam et lacus neque. Ut enim massa, sodales tempor convallis et, iaculis ac massa.</p>

						</div>
						<!-- /LEFT TEXT -->


						<!-- LOGIN -->
						<div class="col-md-4">

							<h2 class="size-16">NEW ENTRY</h2>

							<!-- login form -->
							<form method="post" action="{{ route('entry.create.save') }}" enctype="multipart/form-data" autocomplete="off">
                {!! csrf_field() !!}

								<div class="clearfix">

									<!-- Name -->
									<div class="form-group">
										<input type="text" name="title" class="form-control" placeholder="Entry Title" required="" value="{{ old('title') }}">
									</div>

								</div>

								<div class="row">

									<div class="col-md-12 col-sm-12 col-xs-12 text-right">
										<button class="btn btn-primary">Create Entry</button>
									</div>

								</div>

							</form>
						</div>
					</div>


				</div>
			</section>
			<!-- / -->



@stop
