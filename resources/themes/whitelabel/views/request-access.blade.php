@extends('layouts/unbranded')

{{-- Page title --}}
@section('title')
     {{ trans('general.nav.login') }} ::
@parent
@stop


{{-- Page content --}}
@section('content')


<!-- -->
<section>
  <div class="container">

    <div class="row">

        <div class="col-md-6 col-md-offset-3">

            @if ($requests > 0)
                <!-- ALERT -->
               <div class="alert alert-mini alert-success margin-bottom-30">
                   <strong>Awesome!</strong> You have asked to become a member of this community.  You will be notified by email when an admin approves your membership.
               </div><!-- /ALERT -->
            @else


			<!-- ALERT -->
			<div class="alert alert-mini alert-danger margin-bottom-30">
				<strong>Oops!</strong> You must be a member of this community to view it.
			</div><!-- /ALERT -->

			<div class="box-static box-border-top padding-30">
				<div class="box-title margin-bottom-30">
					<h2 class="size-20">Request Access</h2>
				</div>

				<form class="nomargin" method="post" autocomplete="off" action="{{ route('community.request-access.save') }}">
                    {!! csrf_field() !!}
					<div class="clearfix">

                        <!-- Message -->
						<div class="form-group">
                            <label>Message to Hub Admin:</label>
                            <!-- textarea -->

							<textarea rows="3" class="form-control" data-maxlength="140" data-info="textarea-words-info" name="message" placeholder="Message to the admin... "></textarea>
							<span class="fancy-hint size-11 text-muted">
								<strong>Hint:</strong> Max 140 characters
								<span class="pull-right">
									<span id="charsLeft"></span> characters remaining
								</span>
							</span>
						</div>

					</div>

					<div class="row">

						<div class="col-md-6 col-sm-6 col-xs-6">
						</div>

						<div class="col-md-6 col-sm-6 col-xs-6 text-right">

							<button class="btn btn-primary">SUBMIT REQUEST</button>

						</div>

					</div>

				</form>
                @endif

			</div>

  		</div>

  </div>
</section>
<!-- / -->


<script src="{{ asset('assets/js/jquery.limit-1.2.js')}}"></script>
<script>
$('textarea').limit('140','#charsLeft');
</script>


@stop
