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

							<h2 class="size-16 uppercase">{{ trans('general.nav.create_community') }}</h2>

							<!-- login form -->
							<form method="post" action="{{ route('community.create.save') }}" enctype="multipart/form-data" autocomplete="off">
                {!! csrf_field() !!}

								<div class="clearfix">

									<!-- Name -->
									<div class="form-group margin-bottom-10{{ $errors->first('name', ' has-error') }}">
										<label class="input">
                      <input type="text" name="name" class="form-control" placeholder="Community Name" required="" value="{{ old('name') }}">
                    </label>
                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
									</div>

                  <!-- Slug -->
									<div class="form-group margin-bottom-10{{ $errors->first('subdomain', ' has-error') }}">
                    <label class="input">
										  <input type="text" name="subdomain" class="form-control" placeholder="Subdomain" required="" value="{{ old('subdomain') }}">
                    </label>
                    {!! $errors->first('subdomain', '<span class="help-block">:message</span>') !!}
									</div>

                  <!-- Type -->
                  <div class="form-group margin-bottom-10{{ $errors->first('group_type', ' has-error') }}">
                    <label class="input">
                      {!! Form::community_types('group_type', Input::old('group_type', old('group_type'))) !!}
                      </label>
                      {!! $errors->first('group_type', '<span class="help-block">:message</span>') !!}
                  </div>

                  <!-- Theme -->
                  <div class="form-group margin-bottom-10{{ $errors->first('theme', ' has-error') }}">
                    <label class="input">
                      {{ Form::select('theme', $themes, old('theme'), array('class'=>'select2', 'style'=>'width:100%')) }}
                    </label>
                  </div>

                  <div class="form-group">
                    <label class="input">
											<input class="custom-file-upload" type="file" id="file" name="cover_img" data-btn-text="Cover Upload" />
											<small class="text-muted block">Max file size: 10Mb (gif/jpg/png)</small>
                    </label>
                    {!! $errors->first('cover_img', '<span class="help-block">:message</span>') !!}
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
