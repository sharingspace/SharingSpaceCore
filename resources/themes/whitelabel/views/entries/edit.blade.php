@extends('layouts/master')

{{-- Page title --}}
@section('title')
     {{ trans('general.entries.edit') }} ::
@parent
@stop


{{-- Page content --}}
@section('content')

<!-- -->
			<section>

				<div id="add_tile_wrapper" class="container margin-top-20">
					<div class="row">
						<!-- Entry -->
						<div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
							<div class="row">

                <h1 class="size-16 uppercase">{{ trans('general.entries.edit') }}</h1>
                <p>{{ trans('general.entries.create_subheadline') }}</p>
                <!-- entry form -->

                <form method="post" action="{{ route('entry.edit.save', $entry->id) }}" enctype="multipart/form-data" autocomplete="off" class="nomargin">
                  {!! csrf_field() !!}
                  <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="4096000" />


                  <div class="clearfix"></div>
                  <fieldset class="nomargin">

                    <div class="col-md-2 margin-bottom-10 {{ $errors->first('post_type', ' has-error') }}">
                        {!! Form::select('post_type', $post_types, $entry->post_type) !!}

                    </div>
                    <div class="col-md-7 margin-bottom-10 {{ $errors->first('title', ' has-error') }}">
                      <!-- Name -->
                      <label class="input">
                        <input type="text" name="title" id="title" class="form-control" placeholder="Description" value="{{ Input::old('title', $entry->title) }}">
                      </label>
                    </div>

                    <div class="col-md-3 margin-bottom-10">
                      <button class="btn btn-success" style="margin-right:10px;float:right;"><i class="fa fa-sign-in fa-lg" style="margin-right:5px;"></i>Save</button>

                    </div>

                    <!-- checkbox -->
                    <div class="col-md-11 margin-bottom-10">
                      <div class="checkbox">
                      @foreach ($whitelabel_group->exchangeTypes as $exchange_types)
                        <label class="checkbox">
                          {{ Form::checkbox('entry_exchange_types['.$exchange_types->id.']', $exchange_types->id, $exchange_types->id) }}
                          <i></i> {{ $exchange_types->name }}
                        </label>
                      @endforeach
                      </div>
                    </div>



                    {!! Form::close() !!}



@stop
