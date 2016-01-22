@extends('layouts/master')

{{-- Page title --}}
@section('title')
     {{ trans('general.community.settings') }} ::
@parent
@stop


{{-- Page content --}}
@section('content')



<section class="container">
  <section>

    <div id="add_tile_wrapper" class="container margin-top-20">
      <div class="row">
        <!-- Entry -->
        <div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
          <div class="row">
            <h2 class="size-16 uppercase">EDIT COMMUNITY</h2>


            <div class="alert alert-danger" style="display:none" id="submission_error"></div>

            <!-- community form -->

            <form method="post" action="{{ route('community.edit.save') }}" enctype="multipart/form-data" autocomplete="off">
              {!! csrf_field() !!}
              <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="4096000" />


                <div class="col-md-3 col-sm-3 col-xs-3" style="border-right:#CCC thin solid;">

                  <div class="form-group" style="margin-bottom: 5px;">
                    <fieldset class="margin-bottom-10">

                      <legend class="sr-only">Exchange by:</legend>

                      {{ $errors->first('tile_exchange_type', '<div class="alert-no-fade alert-danger col-sm-12"><i class="icon-remove-sign"></i> :message</div>') }}
                      <div class="exchange_types">

                        <!-- checkboxes for exchange types -->
                          <div class="checkbox">

                          @foreach (\App\ExchangeType::all() as $exchange_types)
                          <div class="col-md-12 pull-left margin-bottom-10">
                            <label class="checkbox col-md-12 pull-left margin-bottom-10">
                            {{ Form::checkbox('exchange_types['.$exchange_types->id.']', $exchange_types->id, $exchange_types->id, ['class' => 'exchanges']) }}
                              <i></i> {{ $exchange_types->name }}
                            </label>
                          </div>
                          @endforeach
                        <div class="col-md-12 pull-left margin-bottom-10">
                          <label class="checkbox col-md-12 pull-left margin-bottom-10">
                            {{ Form::checkbox('select_all', 10, false, ['id' => 'select_all']) }}
                            <i></i> all exchanges
                          </label>
                          </div>
                       </div>
                      </div> <!-- exchange_types -->
                     </fieldset>
                    </div> <!-- form-group -->

                  </div> <!-- col-md-3 -->

                  <div class="col-md-9 col-sm-9 col-xs-9">

                  <fieldset class="nomargin">
                    <!-- Name -->
  									<div class="form-group{{ $errors->first('name', ' has-error') }}">
  										<input type="text" name="name" class="form-control" placeholder="Community Name" required="" value="{{ Input::old('name', $community->name) }}">
                      {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
  									</div>

                    <!-- Slug -->
      							<div class="form-group{{ $errors->first('subdomain', ' has-error') }}">
                      <label for="subdomain">Subdomain *</label>
      								  <input type="text" name="subdomain" class="form-control" placeholder="awesome.anysha.re" required="" value="{{ Input::old('subdomain', $community->subdomain) }}">
                      {!! $errors->first('subdomain', '<span class="help-block">:message</span>') !!}
      							</div>

                    <!-- Type -->
                    <div class="form-group">
                       {!! Form::community_types('group_type', Input::old('group_type', $community->group_type)) !!}
                       {!! $errors->first('group_type', '<span class="help-block">:message</span>') !!}
                    </div>

                    <!-- Theme -->
                    <div class="form-group">
                      {{ Form::select('theme', $themes, $community->theme, array('class'=>'select2', 'style'=>'width:100%')) }}
                      {!! $errors->first('theme', '<span class="help-block">:message</span>') !!}
                    </div>

                    <div class="form-group {{ $errors->first('welcome_text', 'has-error') }}">
                      <!-- Description -->
                      <label class="input">
                        <textarea name="welcome_text" rows="4" class="form-control" data-maxlength="200" id="welcome_text" data-info="textarea-words-info" placeholder="Welcome text..."></textarea>
                      </label>
                    </div>


                    <div class="form-group {{ $errors->first('about', 'has-error') }}">
                      <!-- Description -->
                      <label class="input">
                        <textarea name="about" rows="5" class="form-control" data-maxlength="200" id="description" data-info="textarea-words-info" placeholder="Detailed description..."></textarea>
                      </label>
                    </div>

                    <!-- Location -->
                    <div class="form-group {{ $errors->first('location', 'has-error') }}">
                      <label class="control-label sr-only" for="location">Location</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="location" name="location" placeholder="Near (optional)" aria-describedby="basic-addon2" value="{{{ Input::old('location', Auth::user()->location) }}}">
                        <div class="input-group-addon" id="basic-addon2">
                          <i class="fa fa-location-arrow" id="geolocate"></i>
                        </div>
                        {!! $errors->first('location', '<span class="help-block">:message</span>') !!}
                     </div>
                    </div>

                    <!-- File upload -->
                    <div class="form-group {{ $errors->first('file', 'has-error') }}">
                      <div class="fancy-file-upload fancy-file-info">
                        <i class="fa fa-picture-o"></i>
                        <input type="file" class="form-control" name="file" onchange="jQuery(this).next('input').val(this.value);" />
                        <input type="text" class="form-control" placeholder="no file selected" readonly="" />
                        <span class="button">{{ trans('general.uploads.choose_file') }}</span>
                      </div>
                    </div>

                    </div>

                    <div class="row">

    									<div class="col-md-12 col-sm-12 col-xs-12 text-right">
    										<button class="btn btn-primary">{{ trans('general.community.save') }}</button>
    									</div>

    								</div>

                    </div>
                  </fieldset>
                </div>

            </form>
          </div>
        </div>
      </div>


    </div>
  </section>
  <!-- / -->

      </form>



@stop
