@extends('layouts.master')

@section('content')

<section id="pricing">
  <div class="container">
    <h2>{{trans('pricing.free_vs_paid')}}</h2>

    <div class="row">
      <div class="col-sm-1">
      </div>
      <div class="col-sm-5 col-xs-12 margin-bottom-20">
        <p>{{trans('pricing.free')}}</p>
      </div>
      <div class="col-sm-5 col-xs-12 margin-bottom-20">
        <p>{{trans('pricing.paid')}}</p>
      </div>
      <div class="col-sm-1">
      </div>
    </div>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>{{trans('pricing.feature')}}</th>
          <th>{{trans('pricing.free_header')}}</th>
          <th>{{trans('pricing.paid_header')}}</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{trans('pricing.join_sharing_networks')}}</td>
          <td>x</td>
          <td>x</td>
        </tr>
        <tr>
          <td>{{trans('pricing.build')}}</td>
          <td>x</td>
          <td>x</td>
        </tr>
        <tr>
          <td>{{trans('pricing.start')}}</td>
          <td>-</td>
          <td>x</td>
        </tr>
        <tr>
          <td>{{trans('pricing.customize')}}</td>
          <td>-</td>
          <td>x</td>
        </tr>
        <tr>
          <td>{{trans('pricing.price_security')}}</td>
          <td>-</td>
          <td>x</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td></td>
          <td>{{trans('pricing.free_header')}}</td>
          <td>{{trans('pricing.currency')}} {{trans('pricing.cost')}} {{trans('pricing.pay_period')}}</td>
        </tr>       
      </tfoot>
    </table>
  </div>
</section>

<section class="cta">
  <div class="container">
    <div class="row">
      <div class="col-xs-10 col-xs-offset-1">
        <div class="row">
          <div class="col-sm-9 col-xs-12 margin-bottom-0">
            <h2 class="white-secondary-heading">{{trans('general.make_share_now')}}</h2>
          </div>
          <div class="col-sm-3 col-xs-12 margin-bottom-0">
            <a href="{{ route('community.create.form') }}" class="btn center-xs pull-right-sm size-18 weight-700 font-smoothing" style="background-color:black;color:white">{{ trans('general.nav.start_now') }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- / -->

@stop
