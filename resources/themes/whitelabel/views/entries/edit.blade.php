@extends('layouts/master')

{{-- Page title --}}
@section('title')
     {{ trans('general.entries.edit') }} ::
@parent
@stop


{{-- Page content --}}
@section('content')

<style>
.fancy-form-select:before {
  right: 17px;
}

.fancy-form > .fancy-arrow {
  left: 115px;
}

.checkbox {
  display: block;
}


</style>
<!-- -->
			<section>

				<div id="add_tile_wrapper" class="container margin-top-20">
					<div class="row">
						<!-- Entry -->
						<div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
							<div class="row">

                <h1 class="size-16 uppercase">{{ trans('general.entries.edit') }}</h1>

                <!-- entry form -->

                <form method="post" action="{{ route('entry.edit.save', $entry->id) }}" enctype="multipart/form-data" autocomplete="off" class="nomargin">
                  {!! csrf_field() !!}
                  <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="4096000" />


                  <div class="clearfix"></div>
                  <fieldset class="nomargin">

                    <div class="col-md-2 margin-bottom-10 fancy-form fancy-form-select{{ $errors->first('post_type', ' has-error') }}">
                        {!! Form::select('post_type', $post_types, $entry->post_type, array('class'=>'form-control', 'style'=>'width: 100%')) !!}
                        	<i class="fancy-arrow"></i>
                    </div>




                    <div class="col-md-2 margin-bottom-10">
                      <!-- stepper -->
                      <input type="text" value="{{ Input::old('qty', $entry->qty) }}" min="1" max="1000" class="form-control stepper" name="qty">
                    </div>

                    <div class="col-md-8 margin-bottom-10 {{ $errors->first('title', ' has-error') }}">
                      <!-- Name -->
                      <label class="input">
                        <input type="text" name="title" id="title" class="form-control" placeholder="Description" value="{{ Input::old('title', $entry->title) }}">
                      </label>
                    </div>

                    <div class="col-md-12 margin-bottom-10 {{ $errors->first('title', ' has-error') }}">
                      <!-- Description -->
                      <label class="input">
                        <textarea name="description" rows="5" class="form-control" data-maxlength="200" data-info="textarea-words-info" placeholder="Detailed description...">{{ Input::old('description', $entry->description) }}</textarea>
                      </label>
                    </div>

                    <!-- checkbox -->
                    <div class="col-md-12 margin-bottom-10">
                      <div class="checkbox">
                      @foreach ($whitelabel_group->exchangeTypes as $exchange_types)
                      <div class="col-md-2 pull-left margin-bottom-10">
                        <label class="checkbox col-md-3 pull-left margin-bottom-10">
                          {{ Form::checkbox('entry_exchange_types['.$exchange_types->id.']', $exchange_types->id, $exchange_types->id) }}
                          <i></i> {{ $exchange_types->name }}
                        </label>
                      </div>
                      @endforeach
                      </div>
                    </div>

                    <div class="col-md-12 margin-bottom-10 text-right">
                      <button class="btn btn-success"><i class="fa fa-sign-in fa-lg" style="margin-right:5px;"></i>Save</button>
                    </div>




                    {!! Form::close() !!}



@stop
