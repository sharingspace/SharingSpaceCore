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
          <p>{{$error}} <strong>{{$name}}</strong>. Do you want to join? <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></p>
        </div>
        @endif
      </div>

      <div class="col-md-12 text-center">
        <a class="btn btn-warning btn-lg" href="{{ route('join-community') }}">Yes I want to join</a>
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
