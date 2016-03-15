@extends('layouts.master')

{{-- Page title --}}
@section('title')
     {{ trans('general.nav.members') }} ::
@parent
@stop


@section('content')

<!-- -->
<section>
	<div class="container margin-top-20">
    <h1 class="margin-bottom-0 size-24 text-center">{{trans('general.user.change_settings')}}</h1>

		<!-- RIGHT -->
		<div class="col-lg-9 col-md-9 col-sm-8 col-lg-push-3 col-md-push-3 col-sm-push-4 margin-bottom-80 margin-top-20">

			<ul class="nav nav-tabs nav-top-border">
				<li class="active"><a href="#info" data-toggle="tab">Personal Info</a></li>
        <li><a href="#social" data-toggle="tab">Social</a></li>
				<li><a href="#avatar" data-toggle="tab">Avatar</a></li>
				<li><a href="#password" data-toggle="tab">Password</a></li>
				<li><a href="#privacy" data-toggle="tab">Privacy</a></li>
			</ul>

			<div class="tab-content margin-top-20">


				<!-- PERSONAL INFO TAB -->
				<div class="tab-pane fade in active" id="info">

          <form role="form" method="post" action="{{ route('user.settings.save') }}">
            {{ csrf_field() }}

            <!-- Display Name -->
            <div class="col-md-12 form-group {{ $errors->first('display_name', 'has-error') }}">
               <label class="control-label" for="display_name">Display Name</label>
                <input type="text" placeholder="Awesome66" class="form-control" name="display_name" value="{{ Input::old('display_name', Auth::user()->display_name) }}">
                {!! $errors->first('display_name', '<span class="help-block">:message</span>') !!}
            </div>

            <!-- Email  -->
            <div class="col-md-12 form-group {{ $errors->first('email', 'has-error') }}">
               <label class="control-label" for="email">Email</label>
                <input type="text" placeholder="you@example.com" class="form-control" name="email" autocomplete="off" value="{{ Input::old('email', Auth::user()->email) }}" readonly onfocus="this.removeAttribute('readonly');" style="background-color: white;">
                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
            </div>

            <!-- First Name -->
            <div class="col-md-12 form-group {{ $errors->first('first_name', 'has-error') }}">
               <label class="control-label" for="first_name">First Name</label>
                <input type="text" placeholder="Felicia" class="form-control" name="first_name" value="{{ Input::old('first_name', Auth::user()->first_name) }}">
                {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
            </div>

            <!-- Last Name -->
            <div class="col-md-12 form-group {{ $errors->first('last_name', 'has-error') }}">
               <label class="control-label" for="last_name">Last Name</label>
                <input type="text" placeholder="Doe" class="form-control" name="last_name" value="{{ Input::old('last_name', Auth::user()->last_name) }}">
                {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
            </div>

            <!-- About -->
            <div class="col-md-12 form-group {{ $errors->first('bio', 'has-error') }}">
               <label class="control-label" for="bio">About</label>
								 <textarea class="form-control" rows="3" placeholder="About Me..." name="bio">{{ Input::old('bio', Auth::user()->bio) }}</textarea>
                {!! $errors->first('bio', '<span class="help-block">:message</span>') !!}
            </div>

            <!-- Location -->
            <div class="col-md-12 form-group {{ $errors->first('location', 'has-error') }}">
              <label class="control-label" for="location">Location</label>
              <div class="input-group">
              <input type="text" class="form-control" id="location" name="location" placeholder="Near (optional)" aria-describedby="basic-addon2" value="{{{ Input::old('location', Auth::user()->location) }}}" placeholder="Address, City, Country">
              <div class="input-group-addon" id="basic-addon2"><i class="fa fa-location-arrow" id="geolocate"></i></div>
               {!! $errors->first('location', '<span class="help-block">:message</span>') !!}
             </div>
            </div>

            <!-- Website -->
            <div class="col-md-12 form-group {{ $errors->first('website', 'has-error') }}">
               <label class="control-label" for="website">Website Url</label>
                <input type="text" placeholder="http://www.yourwebsite.com" class="form-control" name="website" value="{{ Input::old('website', Auth::user()->website) }}">
                {!! $errors->first('website', '<span class="help-block">:message</span>') !!}
            </div>

						<div class="col-md-12 form-group">
							<button class="btn btn-primary">Save Personal Info Changes</button>
						</div>

          </form>

				</div> <!-- /PERSONAL INFO TAB -->

        <!-- SOCIAL TAB -->
				<div class="tab-pane fade" id="social">

          <form role="form" method="post" action="{{ route('user.social.save') }}">
            {{ csrf_field() }}

  					<div class="col-md-12">
            	<h4>Social Links &amp; Connections</h4>
            </div>

            <div class="col-md-12 social">
              <div class="col-md-7">
                <div class="form-group {{ $errors->first('fb_url', 'has-error') }}">
                    <input type="text" placeholder="https://facebook.com/username" class="form-control" id="fb_url" name="fb_url" value="{{{ Input::old('fb_url', Auth::user()->fb_url) }}}">
                    <label for="facebookURL" class="fa fa-facebook-square fa-lg grey" rel="tooltip" title="Facebook"></label>
                      {!! $errors->first('fb_url', '<span class="help-block">:message</span>') !!}
                </div>
              </div>  <!-- col-md-7 -->


              <div class="col-md-7">
                <div class="form-group {{ $errors->first('twitter', 'has-error') }}">
                  <input type="text" placeholder="https://twitter.com/username" class="form-control" id="twitter" name="twitter" value="{{{ Input::old('twitter', Auth::user()->twitter) }}}">
                  <label for="twitter" class="fa fa-twitter-square fa-lg grey" rel="tooltip" title="Twitter"></label>
                  {!! $errors->first('twitter', '<span class="help-block">:message</span>') !!}
                </div>
              </div> <!-- col-md-7 -->

              <div class="col-md-7">
                <div class="form-group {{ $errors->first('google', 'has-error') }}">
                  <input type="text" placeholder="https://plus.google.com/username" class="form-control" id="google" name="google" value="{{{ Input::old('google', Auth::user()->google) }}}">
                  <label for="google" class="fa fa-google-plus-square fa-lg grey" rel="tooltip" title="G+"></label>
                  {!! $errors->first('google', '<span class="help-block">:message</span>') !!}
                </div>
              </div> <!-- col-md-7 -->

              <div class="col-md-7">
                <div class="form-group {{ $errors->first('pinterest', 'has-error') }}">
                  <input type="text" placeholder="https://pinterest.com/username" class="form-control" id="pinterestURL" name="pinterest" value="{{{ Input::old('pinterest', Auth::user()->pinterest) }}}">
                  <label for="pinterest" class="fa fa-pinterest-square fa-lg grey" rel="tooltip" title="Pinterest"></label>
                  {!! $errors->first('pinterest', '<span class="help-block">:message</span>') !!}
                </div>
              </div> <!-- col-md-7 -->

              <div class="col-md-7">
                <div class="form-group {{ $errors->first('youtube', 'has-error') }}">
                  <input type="text" placeholder="https://youtube.com/username" class="form-control" id="youtube" name="youtube" value="{{{ Input::old('youtube', Auth::user()->youtube) }}}">
                  <label for="youtube" class="fa fa-youtube-square fa-lg grey" rel="tooltip" title="Youtube"></label>
                  {!! $errors->first('youtube', '<span class="help-block">:message</span>') !!}
                </div>
              </div> <!-- col-md-7 -->

              @if (Auth::user()->fb_user)
                <div class=" col-sm-10" style="margin-top: -5px">
                  <div class="checkbox">
                    <label>
                      {{ Form::checkbox('post_to_fb', '1', Input::old('post_to_fb', Auth::user()->post_to_fb)) }} Post my tiles to my Facebook profile
                    </label>
                  </div>
                </div> <!-- col-md-10 -->

                <div class=" col-sm-10" style="margin-top: -5px">
                  <div class="checkbox">
                    <label>
                      {{ Form::checkbox('fave_to_fb', '1', Input::old('fave_to_fb', Auth::user()->fave_to_fb)) }}
                      Post my faves to my Facebook profile
                    </label>
                  </div>
                </div> <!-- col-md-10 -->
              @endif

            </div> <!-- col-md-12 -->

            <div class="col-md-12 form-group">
							<button class="btn btn-primary">Save Social Link Changes</button>
						</div>
        </form>

  			</div> <!-- /SOCIAL TAB -->

				<!-- AVATAR TAB -->
				<div class="tab-pane fade" id="avatar">
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
										</div><input id="shadow_input" type="text" placeholder="no file selected" readonly>
									</label>
								</div>

								<a href="#" class="btn btn-danger btn-xs noradius"><i class="fa fa-times"></i> Remove Avatar</a>

								<div class="clearfix margin-top-20">
									<p>We recommend using an image that is a 250 pixels by 250 pixels.</p>
								</div>
							</div>
						</div>
					</div>

          <div class="col-md-12 form-group">
						<button class="btn btn-primary">Save Avatar Changes</button>
					</div>
				</div> <!-- /AVATAR TAB -->

				<!-- PASSWORD TAB -->
				<div class="tab-pane fade" id="password">
          <form role="form" method="post" action="{{ route('user.password.save') }}">
            {{ csrf_field() }}

						<div class="form-group">
							<label class="control-label">Current Password</label>
							<input type="password" class="form-control" name="password">
						</div>
						<div class="form-group">
							<label class="control-label">New Password</label>
							<input type="password" class="form-control" name="new_password">
						</div>
						<div class="form-group">
							<label class="control-label">Re-type New Password</label>
							<input type="password" class="form-control" name="confirm_password">
						</div>

            <div class="col-md-12 form-group">
							<button class="btn btn-primary">Save Password Changes</button>
						</div>
          </form>


				</div>
				<!-- /PASSWORD TAB -->

				<!-- PRIVACY TAB -->
				<div class="tab-pane fade" id="privacy">
          <form role="form" method="post" action="{{ route('user.privacy.save') }}">
            {{ csrf_field() }}
            <div class="col-md-12 pull-left margin-bottom-10">
              <label class="checkbox col-md-12 pull-left margin-bottom-10">Allow my entries to be seen by visitors
                {{ Form::checkbox('agree') }} <i></i> 
              </label>
            </div>

            <div class="col-md-12 pull-left margin-bottom-10">
              <label class="checkbox col-md-12 pull-left margin-bottom-10">Allow my profile to show on member page
                {{ Form::checkbox('agree') }} <i></i> 
              </label>
            </div>

            <div class="col-md-12 pull-left margin-bottom-10">
              <label class="checkbox col-md-12 pull-left margin-bottom-10">Allow members to contact me with offers
                {{ Form::checkbox('agree') }} <i></i> 
              </label>
            </div>

            <div class="col-md-12 pull-left margin-bottom-10">
              <label class="checkbox col-md-12 pull-left margin-bottom-10">Allow contact form on profile page
                {{ Form::checkbox('agree') }} <i></i> 
              </label>
            </div>

            <div class="col-md-12 form-group">
  						<button class="btn btn-primary">Save Privacy Changes</button>
  					</div>
          </form>

				</div> <!-- /PRIVACY TAB -->
			</div>
		</div>


		<!-- LEFT -->
		<div class="col-lg-3 col-md-3 col-sm-4 col-lg-pull-9 col-md-pull-9 col-sm-pull-8 margin-top-20">
			<div class="thumbnail text-center">
				<img src="{{ Auth::user()->gravatar() }}?s=400" alt="" />
				<h2 class="size-18 margin-top-10 margin-bottom-0">{{ Auth::user()->getDisplayName() }}</h2>
				<h3 class="size-11 margin-top-0 margin-bottom-10 text-muted">{{ Auth::user()->location }}</h3>
			</div>
		</div>
	</div>

	</div> <!-- container -->
</section>
<!-- / -->

<script type="text/javascript">

$( document ).ready(function() {

  $("#file").change(function() {
    $('#shadow_input').val($(this).val().replace("C:\\fakepath\\", ""));
  });
});

</script>
@stop
