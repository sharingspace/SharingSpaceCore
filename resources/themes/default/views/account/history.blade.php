@extends('layouts/master')

{{-- Page title --}}
@section('title')
  {{ trans('general.nav.my_orders') }} ::
@parent
@stop


{{-- Page content --}}
@section('content')


<!-- -->
<section class="section" id="history">
    <div class="container">
        <header class="section-header">
            <h2>{{ trans('general.nav.billing_history') }}</h2>
        </header>
        
        <div class="row gap-y gap-3">
            <div class="col-12">
                <h2 class="size-16 uppercase"></h2>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ trans('general.share')}}</th>
                                <th>{{ trans('general.date')}}</th>
                                <th>{{ trans('general.community.fee')}}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($subscriptions as $subscription)
                            <tr>
                                <td>
                                @if ($subscription->community)
                                    <a href="https://{{ $subscription->community->subdomain}}.anyshare.coop">{{ $subscription->community->name }}</a>
                                @endif
                                </td>
                                <td>
                                @if ($subscription->community)
                                    {{ $subscription->community->created_at->format('M j, Y') }}
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
<!--
<section class="cta">
    <div class="container">
        <div class="row">
            <div class="col-8 col-offset-2">
                <div class="row">
                    <div class="col-12 col-sm-9 margin-bottom-0">
                        <h2 class="white-secondary-heading">{{ trans('general.make_share_now')}}</h2>
                    </div>
                    <div class="col-12 col-sm-3 margin-bottom-0">
                        <a href="{{ route('community.create.form') }}" class="btn center-xs pull-right-sm size-18 weight-700 font-smoothing" style="background-color:black;color:white">{{ trans('general.nav.start_now') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
-->
<!-- / -->

@stop
