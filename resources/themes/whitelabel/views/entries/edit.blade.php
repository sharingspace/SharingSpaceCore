@extends('layouts/master')

{{-- Page title --}}
@section('title')
     {{ trans('general.entries.create') }} ::
@parent
@stop


{{-- Page content --}}
@section('content')

<!-- -->
			<section>

				<div class="container margin-top-20">

					<div class="row">


						<!-- Entry -->
						<div class="col-md-12">


                <h2 class="size-16 uppercase">{{ trans('general.entries.create') }}</h2>
  							<!-- entry form -->
  							<form method="post" action="{{ route('entry.create.save') }}" enctype="multipart/form-data" autocomplete="off" class="nomargin">
                  {!! csrf_field() !!}

  								<div class="clearfix">

                    <fieldset class="nomargin">

                      <div class="col-md-3 margin-bottom-10{{ $errors->first('post_type', ' has-error') }}">
        									<select class="form-control" name="post_type" id="post_type">
                            <option value="want">I want</option>
                            <option value="have">I have</option>
        									</select>
                      </div>
                      <div class="col-md-8 margin-bottom-10{{ $errors->first('title', ' has-error') }}">
                        <!-- Name -->
                        <label class="input">
        									<input type="text" name="title" class="form-control" placeholder="Description">
                        </label>
                      </div>
                      <div class="col-md-1">
                        <a href="#" class="btn btn-default"><i class="fa fa-ellipsis-h"></i></a>
                      </div>
    									<div class="col-md-12 col-sm-12 col-xs-12 text-right">
    										<button class="btn btn-primary">Create Entry</button>
    									</div>

                  </fieldset>


							</form>
						</div>
					</div>


				</div>
			</section>
			<!-- / -->



@stop
