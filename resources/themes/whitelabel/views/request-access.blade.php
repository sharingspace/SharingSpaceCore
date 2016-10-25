@extends('layouts/master')

{{-- Page title --}}
@section('title')
  {{ trans('general.nav.login') }} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<section>
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        @if (!empty($error))
        <div class="alert alert-info alert-close">
          <p>{{$error}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></p>
        </div>
        @endif


        @if (!empty($requests))
        <!-- ALERT -->
        <div class="alert alert-mini alert-success margin-bottom-30">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <p class="size-20"><strong>Great!</strong> A request has been sent.</p>
          <p class="size-14">You will be notified by email when an admin approves your membership.</p>
        </div><!-- /ALERT -->
        @else
        <div class="box-static box-border-top padding-30">
          <div class="box-title margin-bottom-30">
            <h1 class="size-20 margin-bottom-10">Request to join <em>{{ucfirst($name)}}</em></h1>
          </div>

          <form class="nomargin" method="post" autocomplete="off" action="{{ route('community.request-access.save') }}">
            {!! csrf_field() !!}
            <div class="clearfix">

              <!-- Message -->
              <div class="form-group">
                <label>Message to  Admin:</label>
                <!-- textarea -->

                <textarea rows="3" class="form-control" data-maxlength="140" data-info="textarea-words-info" name="message" placeholder="Please let the admin know why you wish to join"></textarea>
                <span class="fancy-hint size-11 text-muted">
                  <strong>Hint:</strong> Max 140 characters
                  <span class="pull-right">
                    <span id="charsLeft">
                    </span> 
                    characters remaining
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
        </div>
        @endif
      </div>
    </div>
  </div>
</section>
<!-- / -->


<script src="{{ asset('assets/js/jquery.limit-1.2.js')}}"></script>
<script type="text/javascript">
$( document ).ready(function() {
  if($('textarea').length) {
    $('textarea').limit('140','#charsLeft');
  }
});
</script>

@stop
