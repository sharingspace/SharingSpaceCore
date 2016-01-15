@extends('layouts/master')

{{-- Page title --}}
@section('title')
     {{ trans('general.community.settings') }} ::
@parent
@stop


{{-- Page content --}}
@section('content')

<style>
.checkbox input {
  left: 10px;
}
.checkbox label {
  padding-left: 5px;
}
</style>

<!-- -->
			<section>
				<div class="container margin-top-20">

					<div class="row">



						<!-- COMMUNITY -->
						<div class="col-md-4">

							<h2 class="size-16">EDIT COMMUNITY</h2>

							<!-- login form -->
							<form method="post" action="{{ route('community.edit.save') }}" enctype="multipart/form-data" autocomplete="off">
                {!! csrf_field() !!}

								<div class="clearfix">

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

								</div>

								<div class="row">

									<div class="col-md-12 col-sm-12 col-xs-12 text-right">
										<button class="btn btn-primary">{{ trans('general.community.save') }}</button>
									</div>

								</div>


						</div>
            <!-- RIGHT TEXT -->
            <div class="col-md-8">
              <h2 class="size-16">HOW SHOULD PEOPLE EXCHANGE?</h2>

              <div class="checkbox col-md-12">
              @foreach (\App\ExchangeType::all() as $exchange_types)
              <div class="col-md-3 pull-left">
              <label>
                {{ Form::checkbox('community_exchange_types['.$exchange_types->id.']', $exchange_types->id, $exchange_types->id) }}
                {{ $exchange_types->name }}
              </label>
            </div>
              @endforeach
              </div>

            </div>
            <!-- /LEFT TEXT -->


					</div>
				</div>
			</section>
			<!-- / -->

      </form>



@stop
