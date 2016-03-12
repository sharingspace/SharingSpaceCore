@extends('layouts/master')

{{-- Page title --}}
@section('title')
  {{ trans('general.community.settings') }} ::
@parent
@stop


{{-- Page content --}}
@section('content')
<h1 class="sr-only">{{ trans('general.community.settings') }} :: {{ $whitelabel_group->name }}</h1>

<section class="container">

  <div id="edit_wrapper" class="container margin-top-20">
    <div class="row">
      <!-- Entry -->
      <div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
        <ul class="nav nav-tabs nav-top-border">
          <li class="active"><a href="#info" data-toggle="tab">Basic</a></li>
          <li><a href="#hub_images" data-toggle="tab">Images</a></li>
          <li><a href="#advanced" data-toggle="tab">Advanced</a></li>
        </ul>


        <form method="post" action="{{ route('community.edit.save') }}" enctype="multipart/form-data" autocomplete="off">
          {!! csrf_field() !!}
          <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="4096000" />
          <div class="tab-content margin-top-20">
            <!-- PERSONAL INFO TAB -->
            <div class="tab-pane fade in active" id="info">
              <h2 class="size-16 uppercase">EDIT SHARING HUB</h2>
              <div class="alert alert-danger" style="display:none" id="submission_error"></div>

              <!-- community form -->
              <div class="row">
                <div class="col-md-8 col-sm-8 col-xs-8">
                  <fieldset class="nomargin">
                    <div class="form-group{{ $errors->first('name', ' has-error') }}">
                      <label class="control-label" for="name">Sharing Hub Name *</label>
                      <input type="text" name="name" class="form-control" placeholder="Give your sharing hub a name" required="" value="{{ Input::old('name', $community->name) }}">
                      {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                    </div> <!-- form-group -->
                  </fieldset>

                  <!-- Slug -->
                  <div class="form-group{{ $errors->first('subdomain', ' has-error') }}">
                    <label for="subdomain">Subdomain *</label>
                    <input type="text" name="subdomain" class="form-control" placeholder="awesome.anysha.re" required="" value="{{ Input::old('subdomain', $community->subdomain) }}">
                    {!! $errors->first('subdomain', '<span class="help-block">:message</span>') !!}
                  </div>

                  <!-- Type -->
                  <div class="form-group">
                    <label for="group_type">Type of sharing hub</label>
                    {!! Form::community_types('group_type', Input::old('group_type', $community->group_type)) !!}
                    {!! $errors->first('group_type', '<span class="help-block">:message</span>') !!}
                  </div> <!-- Type -->

                  <!-- Welcome text -->
                  <div class="form-group {{ $errors->first('welcome_text', 'has-error') }}">
                    <label class="input">Welcome appears on your home page
                      <textarea name="welcome_text" rows="4" class="form-control" data-maxlength="200" id="welcome_text" data-info="textarea-words-info" placeholder="Welcome text...">{{ Input::old('welcome_text', $community->welcome_text) }}</textarea>
                    </label>
                  </div> <!-- Welcome text -->

                  <!-- Description -->
                  <div class="form-group {{ $errors->first('about', 'has-error') }}">
                    <label class="input">
                      <textarea name="about" rows="5" class="form-control" data-maxlength="200" id="about" data-info="textarea-words-info" placeholder="Detailed description">{{ Input::old('about', $community->about) }}</textarea>
                    </label>
                  </div> <!-- Description -->

                  <!-- Location -->
                  <div class="form-group {{ $errors->first('location', 'has-error') }}">
                    <label class="control-label sr-only" for="location">Location</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="location" name="location" placeholder="Near (optional)" aria-describedby="basic-addon2" value="{{{ Input::old('location', $community->location) }}}">
                      <div class="input-group-addon" id="basic-addon2">
                        <i class="fa fa-location-arrow" id="geolocate"></i>
                      </div>
                      {!! $errors->first('location', '<span class="help-block">:message</span>') !!}
                   </div>
                  </div> <!-- Location -->                 
                </div> <!-- col-md-8 -->

                <div class="col-md-4 col-sm-4 col-xs-4" style="border-right:#CCC thin solid;">
                  <div class="form-group" style="margin-bottom: 5px;">
                    <fieldset class="margin-bottom-10">

                      <legend class="size-14"><p>Select which exchange types you wish to use for this sharing hub</p></legend>
                      {{ $errors->first('tile_exchange_type', '<div class="alert-no-fade alert-danger col-sm-12"><i class="icon-remove-sign"></i> :message</div>') }}
                      <div class="exchange_types">
                        <!-- checkboxes for exchange types -->
                        <div class="checkbox">
                          <div class="row">
                            @foreach (\App\ExchangeType::all() as $exchange_types)
                            <div class="col-md-12 pull-left margin-bottom-10">
                              <label class="checkbox col-md-12 pull-left margin-bottom-10">
                              {{ Form::checkbox('exchange_types['.$exchange_types->id.']', $exchange_types->id, $exchange_types->id, ['class' => 'exchanges']) }}
                                <i></i> {{ $exchange_types->name }}
                              </label>
                            </div> <!-- col-md-12 -->
                            @endforeach
                            <div class="col-md-12 pull-left margin-bottom-10">
                              <label class="checkbox col-md-12 pull-left margin-bottom-10">
                                {{ Form::checkbox('select_all', 10, false, ['id' => 'select_all']) }}
                                <i></i> all exchanges
                              </label>
                            </div> <!-- col-md-12 -->
                          </div> <!-- row -->
                        </div> <!-- checkbox -->
                      </div> <!-- exchange_types -->
                    </fieldset>
                  </div> <!-- form-group -->
                </div> <!-- col-md-4 -->
              </div> <!-- row -->
            </div> <!-- PERSONAL INFO TAB -->


            <!-- IMAGES TAB -->
            <div class="tab-pane fade" id="hub_images">
             <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <!-- Cover upload -->
                <div class="form-group {{ $errors->first('file', 'has-error') }}">
                  <label for="cover_img">Cover image</label>
                  <div class="fancy-file-upload fancy-file-info">
                    <i class="fa fa-picture-o"></i>
                    <input type="file" class="form-control" name="cover_img" onchange="jQuery(this).next('input').val(this.value);" />
                    <input type="text" class="form-control" placeholder="Cover image upload - no file selected" readonly="" />
                    <span class="button">{{ trans('general.uploads.choose_file') }}</span>
                  </div>
                  <p>Tip: best image size is 1300 x 300px (short &amp; wide image)</p>
                </div>
              </div>
              <div class="col-md-10 col-sm-10 col-md-offset-1 col-xs-12 margin-bottom-30" >
                <img src="{{ $whitelabel_group->getCover() }}" style=" width: 100%;height: 100%;object-fit:cover;overflow: hidden;">
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <!-- Avatar upload -->
                <div class="form-group {{ $errors->first('file', 'has-error') }}">
                  <label for="cover_img">Profile image (not sure where this is used?)</label>
                  <div class="fancy-file-upload fancy-file-info">
                    <i class="fa fa-picture-o"></i>
                    <input type="file" class="form-control" name="profile_img" onchange="jQuery(this).next('input').val(this.value);" />
                    <input type="text" class="form-control" placeholder="Avatar upload - no file selected" readonly="" />
                    <span class="button">{{ trans('general.uploads.choose_file') }}</span>
                  </div>
                </div>
              </div>

              <!-- Logo upload -->


              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group {{ $errors->first('file', 'has-error') }}">
                <label for="cover_img">Logo image</label>
                  <div class="fancy-file-upload fancy-file-info">
                    <i class="fa fa-picture-o"></i>
                    <input type="file" class="form-control" name="logo" onchange="jQuery(this).next('input').val(this.value);" />
                    <input type="text" class="form-control" placeholder="Logo upload - no file selected" readonly="" />
                    <span class="button">{{ trans('general.uploads.choose_file') }}</span>
                  </div>
                  <p>Tip: best image size is 250 x 40px (short &amp; wide image)</p>
                </div>
              </div>
              <div class="col-md-10 col-sm-10 col-md-offset-1 col-xs-12 margin-bottom-10" style="background-color:#fff;height:60px">
                <div class="col-md-4 col-md-offset-4" style="position:absolute;top:35%;">
                  <img src="{{ $whitelabel_group->getLogo() }}" style=" width: 100%;height: 100%;object-fit:cover;overflow: hidden;background-color:white">
                </div>
              </div>
              </div> <!-- row -->
            </div> <!-- IMAGES TAB -->


            <!-- ADVANCED TAB -->
            <div class="tab-pane fade" id="advanced">

              <!-- Theme -->
              <div class="form-group">
                <label for="theme">Available themes</label>
                {{ Form::select('theme', $themes, $community->theme, array('class'=>'select2', 'style'=>'width:100%')) }}
                {!! $errors->first('theme', '<span class="help-block">:message</span>') !!}
              </div> <!-- Theme -->

              <fieldset class="nomargin">
                <legend>Slack integration</legend>
                <!-- Slack endpoint -->
                <div class="form-group{{ $errors->first('slack_endpoint', ' has-error') }}">
                  <label for="slack_endpoint">Slack endpoint</label>
                  <input type="text" name="slack_endpoint" class="form-control" placeholder="Slack endpoint" value="{{ Input::old('slack_endpoint', $community->slack_endpoint) }}">
                  {!! $errors->first('slack_endpoint', '<span class="help-block">:message</span>') !!}
                </div> <!-- Slack endpoint -->

                <!-- Slack botname -->
                <div class="form-group{{ $errors->first('slack_botname', ' has-error') }}">
                  <label for="slack_botname">Slack bot name</label>
                  <input type="text" name="slack_botname" class="form-control" placeholder="Slack botname" value="{{ Input::old('slack_botname', $community->slack_botname) }}">
                  {!! $errors->first('slack_botname', '<span class="help-block">:message</span>') !!}
                </div> <!-- Slack botname -->

                <!-- Slack channel -->
                <div class="form-group{{ $errors->first('slack_channel', ' has-error') }}">
                  <label for="slack_channel">Slack channel name</label>
                  <input type="text" name="slack_channel" class="form-control" placeholder="Slack channel" value="{{ Input::old('slack_channel', $community->slack_channel) }}">
                  {!! $errors->first('slack_channel', '<span class="help-block">:message</span>') !!}
                </div> <!-- Slack channel -->
              </fieldset>

              <fieldset class="nomargin">
                <legend>Analytics</legend>
                <!-- Google analytics ID -->
                <div class="form-group{{ $errors->first('ga', ' has-error') }}">
                  <label for="slack_channel">Google analytics tracking id</label>

                  <input type="text" name="ga" class="form-control" placeholder="Google Analytics ID" value="{{ Input::old('ga', $community->ga) }}">
                  {!! $errors->first('ga', '<span class="help-block">:message</span>') !!}
                </div> <!-- Google analytics ID -->
              </fieldset>        
            </div> <!-- ADVANCED TAB -->

          </div> <!-- tab-content -->

          <div class="col-md-12 col-sm-12 col-xs-12 text-right">
            <button class="btn btn-primary">{{ trans('general.community.save') }}</button>
          </div>
        </form>
      </div> <!-- col-10 -->
    </div> <!-- row -->
  </div> <!-- edit_wrapper -->
</section> <!-- container -->
<!-- / -->

<script type="text/javascript">

$( document ).ready(function() {

  $("#file").change(function() {
    $('#shadow_input').val($(this).val().replace("C:\\fakepath\\", ""));
  });
});

</script>
@stop
