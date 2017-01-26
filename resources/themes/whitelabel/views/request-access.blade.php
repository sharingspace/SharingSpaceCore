@extends('layouts/master')

{{-- Page title --}}
@section('title')
  {{ trans('general.nav.login') }} ::
@parent
@stop

{{-- Page content --}}
@section('content')
<!-- this does a lot:
1) If Closed it displays a form
2) If they have submitted the form they get an awsome, your request to join has been sent message. (request count = 0)
3) If closed and they have already asked to join it displays a message telling them that their request is pending (request count > 0)
Your request to become a member of this Share is still pending'
-->

<section>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1 class="margin-bottom-20 size-24 text-center">{{ trans('general.user.request_access.request_access') }} {{ucfirst($name)}}</h1>
      </div>
      <div class="col-sm-8 col-md-offset-2 col-xs-12">
        @if (empty($request_count) || (!empty($request_count) && $request_count==0))
        <div class="alert alert-warning">
          <p>{{ trans('general.user.request_access.sorry_closed') }}</p>
        </div>
        @endif

        @if (!empty($request_count) && $request_count)
        <!-- ALERT -->
        <div class="alert alert-mini alert-success margin-bottom-30">
          <button type="button" class="close" data-dismiss="alert alert-info" aria-hidden="true">&times;</button>

          @if ($request_count==1)
            <p class="size-20"><strong>{{ trans('general.headline')}}</strong> {{ trans('general.user.request_access.your_request')}}</p>
            <p class="size-14">{{ trans('general.notified')}}</p>
          @else
            <p class="size-20">{{ trans('general.user.request_access.still_pending')}}</p>
          @endif
        </div><!-- /ALERT -->
        @else
        <div class="box-static box-border-top padding-30">
          

          <form class="nomargin" method="post" autocomplete="off" action="{{ route('community.request-access.save') }}">
            {!! csrf_field() !!}
            <div class="clearfix">

              <!-- Message -->
              <div class="form-group">
                <label>{{ trans('general.user.request_access.admin_msg')}}</label>
                <!-- textarea -->

                <textarea rows="3" class="form-control" data-maxlength="140" data-info="textarea-words-info" name="message" placeholder="{{ trans('general.user.request_access.admin_msg_placeholder')}}"></textarea>
                <span class="fancy-hint size-11 text-muted">
                  <strong>{{ trans('general.user.request_access.hint')}}</strong>{{ trans('general.user.request_access.max_140')}}
                  <span class="pull-right">
                    <span id="charsLeft">
                    </span> 
                    {{ trans('general.user.request_access.chars_remain')}}
                  </span>
                </span>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-6">
              </div>

              <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                <button class="btn btn-colored">{{ trans('general.user.request_access.submit')}}</button>
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


<script src="{{ Helper::cdn('js/jquery.limit-1.2.js')}}"></script>
<script type="text/javascript">
$( document ).ready(function() {
  if($('textarea').length) {
    $('textarea').limit('140','#charsLeft');
  }
});
</script>

@stop
