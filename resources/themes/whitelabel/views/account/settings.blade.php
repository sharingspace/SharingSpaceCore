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
				<li class="active"><a href="#info" data-toggle="tab">{{trans('general.settings.personal')}}</a></li>
        <li><a href="#social" data-toggle="tab">{{trans('general.settings.social')}}</a></li>
				<li><a href="#avatar" data-toggle="tab">{{trans('general.settings.avatar')}}</a></li>
				<li><a href="#password" data-toggle="tab">{{trans('general.settings.password')}}</a></li>
				<!-- <li><a href="#privacy" data-toggle="tab">{{trans('general.settings.privacy')}}Privacy</a></li> -->
			</ul>

			<div class="tab-content margin-top-20">


				<!-- PERSONAL INFO TAB -->
				<div class="tab-pane fade in active" id="info">

          <form role="form" method="post" action="{{ route('user.settings.save') }}">
            {{ csrf_field() }}

            <!-- Display Name -->
            <div class="col-md-12 form-group {{ $errors->first('display_name', 'has-error') }}">
               <label class="control-label" for="display_name">{{trans('general.settings.display_name')}}</label>
                <input type="text" placeholder="Awesome66" class="form-control" name="display_name" value="{{ Input::old('display_name', Auth::user()->display_name) }}">
                {!! $errors->first('display_name', '<span class="help-block">:message</span>') !!}
            </div>

            <!-- Email  -->
            <div class="col-md-12 form-group {{ $errors->first('email', 'has-error') }}">
               <label class="control-label" for="email">{{trans('general.settings.email')}}</label>
                <input type="text" placeholder="you@example.com" class="form-control" name="email" autocomplete="off" value="{{ Input::old('email', Auth::user()->email) }}" readonly onfocus="this.removeAttribute('readonly');" style="background-color: white;">
                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
            </div>

            <!-- First Name -->
            <div class="col-md-12 form-group {{ $errors->first('first_name', 'has-error') }}">
               <label class="control-label" for="first_name">{{trans('general.settings.first_name')}}</label>
                <input type="text" placeholder="{{trans('general.settings.first_name_placeholder')}}" class="form-control" name="first_name" value="{{ Input::old('first_name', Auth::user()->first_name) }}">
                {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
            </div>

            <!-- Last Name -->
            <div class="col-md-12 form-group {{ $errors->first('last_name', 'has-error') }}">
               <label class="control-label" for="last_name">{{trans('general.settings.last_name')}}</label>
                <input type="text" placeholder="{{trans('general.settings.last_name_placeholder')}}" class="form-control" name="last_name" value="{{ Input::old('last_name', Auth::user()->last_name) }}">
                {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
            </div>

            <!-- About -->
            <div class="col-md-12 form-group {{ $errors->first('bio', 'has-error') }}">
               <label class="control-label" for="bio">{{trans('general.settings.about_placeholder')}} ({{trans('general.markdown')}} <a href="
https://anyshare.freshdesk.com/support/solutions/articles/17000035463-using-markdown"><i style='color:#5bc0de;' class='fa fa-info-circle'></i></a> )</label>
								 <textarea class="form-control" rows="3" placeholder="{{trans('general.settings.about_placeholder')}}" name="bio">{{ Input::old('bio', Auth::user()->bio) }}</textarea>
                {!! $errors->first('bio', '<span class="help-block">:message</span>') !!}
            </div>

            <!-- Location -->
            <div class="col-md-12 form-group {{ $errors->first('location', 'has-error') }}">
              <label class="control-label" for="location">{{trans('general.settings.location')}}</label>
              <div class="input-group">
              <input type="text" class="form-control" id="location" name="location" placeholder="Near (optional)" aria-describedby="basic-addon2" value="{{{ Input::old('location', Auth::user()->location) }}}" placeholder="{{trans('general.settings.location_placeholder')}}">
              <div class="input-group-addon" id="basic-addon2"><i class="fa fa-location-arrow" id="geolocate"></i></div>
               {!! $errors->first('location', '<span class="help-block">:message</span>') !!}
             </div>
            </div>

            <!-- Website -->
            <div class="col-md-12 form-group {{ $errors->first('website', 'has-error') }}">
               <label class="control-label" for="website">{{trans('general.settings.web_url')}}</label>
                <input type="text" placeholder="{{trans('general.settings.web_placeholder')}}" class="form-control" name="website" value="{{ Input::old('website', Auth::user()->website) }}">
                {!! $errors->first('website', '<span class="help-block">:message</span>') !!}
            </div>

						<div class="col-md-12 form-group">
							<button class="btn btn-primary pull-right">{{trans('general.user.save_personal_info')}}</button>
						</div>

          </form>

				</div> <!-- /PERSONAL INFO TAB -->

        <!-- SOCIAL TAB -->
				<div class="tab-pane fade" id="social">

          <form role="form" method="post" action="{{ route('user.social.save') }}">
            {{ csrf_field() }}

  					<div class="col-md-12">
            	<h4>{{trans('general.settings.social_links')}} &amp; {{trans('general.settings.connections')}}</h4>
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
                      {{ Form::checkbox('post_to_fb', '1', Input::old('post_to_fb', Auth::user()->post_to_fb)) }} {{trans('general.settings.fb_post')}}
                    </label>
                  </div>
                </div> <!-- col-md-10 -->

                <div class=" col-sm-10" style="margin-top: -5px">
                  <div class="checkbox">
                    <label>
                      {{ Form::checkbox('fave_to_fb', '1', Input::old('fave_to_fb', Auth::user()->fave_to_fb)) }}
                      {{trans('general.settings.fb_fav')}}
                    </label>
                  </div>
                </div> <!-- col-md-10 -->
              @endif

            </div> <!-- col-md-12 -->

            <div class="col-md-12 form-group">
							<button class="btn btn-primary pull-right">{{trans('general.user.save_socials')}}</button>
						</div>
        </form>

  			</div> <!-- /SOCIAL TAB -->

				<!-- AVATAR TAB -->
				<div class="tab-pane fade" id="avatar">
          <form role="form" method="post" action="{{ route('user.avatar.save') }}" enctype='multipart/form-data'>
            {{ csrf_field() }}
						<div class="row">
              <!-- file upload -->
              <div class="col-md-8 margin-bottom-10">
                <div class="fancy-file-upload fancy-file-info">
                  <i class="fa fa-picture-o"></i>
                  <input id="choose-file" type="file" class="form-control"  accept="image/jpg,image/png,image/jpeg,image/gif"  name="avatar_img" onchange="jQuery(this).next('input').val(this.value);" />
                  <input id="shadow_input" type="text" class="form-control" placeholder="{{ trans('general.entries.file_placeholder')}}" readonly="" />
                  <span class="button">{{ trans('general.uploads.choose_file') }}</span>
                </div>  <!-- fancy -->
                <p class='too_large smooth_font' style="display:none;font-size:30px">{{ trans('general.entries.max_file_size')}}</p>
              </div> <!-- col 8 -->

              <div class="col-md-1" style="position:relative;height:50px;">
                <div id="image_box" class="pull-left" style="background-size: contain;
    position: absolute;background-position: center;background-repeat: no-repeat;height: 100%;width: 100%;background-image:url('{{ Auth::user()->gravatar_img() }}')">
                </div>
              </div>

              <div class="col-md-3">
                <button id="remove_img_button" class="pull-right smooth_font btn btn-warning btn-sm margin-left-10 margin-top-6">{{trans('general.entries.remove')}}</button>
                <label id="delete_img_checkbox_label" class="pull-right margin-top-6" for="delete_img">
                  {{ Form::checkbox('delete_img', 1, 0, ['id'=>'delete_img'])}}
                  <i></i> {{trans('general.settings.delete_image')}}
                </label>
              </div>

  						<div class="col-md-12 col-sm-12 margin-top-20">
  							<p>{{trans('general.settings.image_recommend')}}</p>
  						</div>
  					</div> <!-- row -->

            <div class="col-md-12 form-group">
  						<button class="btn btn-primary pull-right">{{trans('general.user.save_avatar')}}</button>
  					</div>
          </form>
				</div> <!-- /AVATAR TAB -->

				<!-- PASSWORD TAB -->
				<div class="tab-pane fade" id="password">
          <form role="form" method="post" action="{{ route('user.password.save') }}">
            {{ csrf_field() }}

						<div class="form-group">
							<label class="control-label">{{trans('general.settings.current_pw')}}</label>
							<input type="password" class="form-control" name="password">
						</div>
						<div class="form-group">
							<label class="control-label">{{trans('general.settings.new_pw')}}</label>
							<input type="password" class="form-control" name="new_password">
						</div>
						<div class="form-group">
							<label class="control-label">{{trans('general.settings.retype_pw')}}</label>
							<input type="password" class="form-control" name="confirm_password">
						</div>

            <div class="col-md-12 form-group">
							<button class="btn btn-primary pull-right">{{trans('general.user.save_password')}}</button>
						</div>
          </form>


				</div>
				<!-- /PASSWORD TAB -->
        @if (0)
				<!-- PRIVACY TAB -->
				<div class="tab-pane fade" id="privacy">
          <form role="form" method="post" action="{{ route('user.privacy.save') }}">
            {{ csrf_field() }}
            <div class="col-md-12 pull-left margin-bottom-10">
              <label class="checkbox col-md-12 pull-left margin-bottom-10">{{trans('general.settings.see_entries')}}
                {{ Form::checkbox(trans('general.settings.agree')) }} <i></i> 
              </label>
            </div>

            <div class="col-md-12 pull-left margin-bottom-10">
              <label class="checkbox col-md-12 pull-left margin-bottom-10">{{trans('general.settings.see_members')}}
                {{ Form::checkbox(trans('general.settings.agree')) }} <i></i> 
              </label>
            </div>

            <div class="col-md-12 pull-left margin-bottom-10">
              <label class="checkbox col-md-12 pull-left margin-bottom-10">{{trans('general.settings.contact')}}
                {{ Form::checkbox(trans('general.settings.agree')) }} <i></i> 
              </label>
            </div>

            <div class="col-md-12 pull-left margin-bottom-10">
              <label class="checkbox col-md-12 pull-left margin-bottom-10">{{trans('general.settings.contact_form')}}
                {{ Form::checkbox(trans('general.settings.agree')) }} <i></i> 
              </label>
            </div>

            <div class="col-md-12 form-group">
  						<button class="btn btn-primary pull-right">{{trans('general.user.save_privacy')}}</button>
  					</div>
          </form>

				</div> <!-- /PRIVACY TAB -->
        @endif
			</div>
		</div>


		<!-- LEFT -->
		<div class="col-lg-3 col-md-3 col-sm-4 col-lg-pull-9 col-md-pull-9 col-sm-pull-8 margin-top-20">
			<div class="thumbnail text-center">
				<img src="{{ Auth::user()->gravatar_img() }}?s=400" alt="" />
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
  $("#remove_img_button").hide();
  $("#delete_img_checkbox_label").hide();

  var image = "{{ Auth::user()->gravatar_img() }}";
  if (image) {
    $('#image_box').css("background-image", "url("+image+")");
    $("#delete_img_checkbox_label").show();
  }
  else {
    $('#image_box').css("background-image","none");
  }

  $("#file").change(function() {
    $('#shadow_input').val($(this).val().replace("C:\\fakepath\\", ""));
  });

  $('#choose-file').change( function() {
    var maxSize = $('#MAX_FILE_SIZE').val();
    $('#shadow_input').val($(this).val().replace("C:\\fakepath\\", ""));

    if ($("#choose-file")[0].files[0].size > maxSize) {
      $("#shadow_input").val("");
      $('p.too_large').show().addClass("error_message").fadeOut(5000, "swing");
    }
    else if (!$('#delete_img').prop('checked')) {
      var files = !!this.files ? this.files : [];
      if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

      if (/^image/.test( files[0].type)) { // only image file
        var reader = new FileReader(); // instance of the FileReader
        reader.readAsDataURL(files[0]); // read the local file

        reader.onloadend = function(){ // set insert image before button
          $('#image_box').css("background-image", "url("+this.result+")");
        }
      }
      $("#delete_img_checkbox_label").hide();

      $('#remove_img_button').show();
    }
    else {
      $('#delete_img').prop('checked') = true;
    }
    
    $('#remove_img_button').addClass('notUploaded');
  });


  $('#remove_img_button').click(function(e)
  {
    e.preventDefault(); // cancel default behavior

    if ($(this).hasClass('notUploaded')) {
      $(this).removeClass('notUploaded').hide();
      $('#image_box').css("background-image","none");
      $('#choose-file').val('');
      $('#shadow_input').val('');
      if (typeof image != 'undefined') {
        $('#image_box').css("background-image", "url('"+image+"')");
        $("#delete_img_checkbox_label").show();
      }
    }

    return false;
  });

});
</script>

@stop
