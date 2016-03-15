@extends('layouts.master')

@section('content')


<section class="padding-top-0">
  <div class="page_banner sharing_fixed_banner">
    <h1>{{trans('pricing.headline') }}</h1>
  </div>
</section>
  <section id="pricing">
    <div class="container">
      <div class="table-responsive">
        <table class="table margin-top-30 margin-bottom-0" style="color:#222;font-size:16px;font-weight:500;">
        <caption class='sr-only'>{{ trans('pricing.headline') }}</caption>
          <thead>
            <tr style="background-color:#ddd;"><th style="width:60%;">Feature</th>
            <th>$10 a month or $100 a year <i class="fa fa-asterisk"></th>
          </thead>
          <tbody>
            <tr><td>{{ trans('pricing.unlimited_users') }}</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>{{ trans('pricing.unlimited_entries') }}</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>{{ trans('pricing.your_logo') }} Your logo</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>{{ trans('pricing.API') }}</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>{{ trans('pricing.analytics') }} Google Analytics<td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>{{ trans('pricing.ssl') }}<td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>{{ trans('pricing.email_support') }}</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>{{ trans('pricing.backups') }}</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>{{ trans('pricing.upgrades') }}</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>{{ trans('pricing.no_setup_fees') }}</td><td><i class='fa fa-check fa-check'></i></td></tr>            
            <tr><td></td><td><a href="{{ route('community.create.form') }}"><button type="button" class="btn btn-sm btn-warning">{{ trans('pricing.startTrial') }}</button></a></td></tr>        
          </tbody>
        </table>
        <p class="small"><i class="fa fa-asterisk"></i> {{ trans('pricing.fees_us_dollars') }}</p>
      </div> 

      <dl>
        <dt>Q. I can’t afford AnyShare right now. Can I still use it?</dt>
        <dd>A. We don’t want to stop groups that don’t have the budget to pay, from using AnyShare.<br>If this applies to you, you can apply to receive AnyShare for free. <strong><a href="/financial_assist">Apply Now</a></strong></dd>
        <dt>Q. What if I want to cancel my subscription?</dt>
        <dd>You can cancel your subscription at any time. Before doing so, you can keep your data, by using the inbuilt api.</dd>
      </dl>

    </div>
  </section>
  <!-- / -->


<script>

jQuery(document).ready(function ($) {


});

</script>
@stop
