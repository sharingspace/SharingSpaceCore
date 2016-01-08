@extends('layouts/master')

{{-- Page title --}}
@section('title')
     {{ trans('general.nav.order_history') }} ::
@parent
@stop


{{-- Page content --}}
@section('content')


<!-- -->
			<section>
				<div class="container margin-top-20">
					<div class="row">


						<div class="col-md-11 col-md-offset-1">
              <h2 class="size-16 uppercase">{{ trans('general.nav.order_history') }}</h2>

              @foreach ($subscriptions as $subscription)
                <li>{{ $subscription->community->name }} - {{ $subscription->community->created_at }}
              @endforeach
            </div>

					</div>
				</div>
			</section>
			<!-- / -->


@stop
