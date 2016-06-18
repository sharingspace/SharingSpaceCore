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


						<div class="col-md-12">
              <h2 class="size-16 uppercase">{{ trans('general.nav.order_history') }}</h2>

              <div class="table-responsive">
              	<table class="table table-bordered table-striped">
              		<thead>
              			<tr>
              				<th>Community</th>
              				<th>Date</th>
                      <th>Amount</th>
              			</tr>
              		</thead>
              		<tbody>
                    @foreach ($subscriptions as $subscription)
                      <tr>
                        <td>
							@if ($subscription->community)
								<a href="https://{{ $subscription->community->subdomain}}.anysha.re">{{ $subscription->community->name }}</a>
							@endif
						</td>
                        <td>
							@if ($subscription->community)
								{{ $subscription->community->created_at }}
							@endif
						</td>
                        <td></td>
                      </tr>
                    @endforeach

                  </tbody>
                </table>
              </div>

            </div>

					</div>
				</div>
			</section>
			<!-- / -->


@stop
