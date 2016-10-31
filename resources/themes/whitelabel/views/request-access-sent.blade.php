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

			<!-- ALERT -->
			<div class="alert alert-mini alert-success margin-bottom-30">
				<strong>Awesome!</strong> Your invite has been sent. You will be notified by email when an admin approves your membership.
			</div><!-- /ALERT -->

			</div>
  		</div>

  </div>
</section>
<!-- / -->


<script src="{{ Helper::cdn('js/jquery.limit-1.2.js')}}"></script>
<script>
$('textarea').limit('140','#charsLeft');
</script>


@stop
