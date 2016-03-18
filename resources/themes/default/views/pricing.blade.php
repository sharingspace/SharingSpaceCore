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
        <table class="table margin-top-30 margin-bottom-0">
        <caption class='sr-only'>{{ trans('pricing.headline') }}</caption>
          <thead>
            <tr style="background-color:#ddd;"><th style="width:60%;">{{ trans('pricing.feature') }}</th>
            <th>{{ trans('pricing.cost') }} <i class="fa fa-asterisk"></th>
          </thead>
          <tbody>
            <tr><td>{{ trans('pricing.unlimited_users') }}</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>{{ trans('pricing.unlimited_entries') }}</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>{{ trans('pricing.your_logo') }} Your logo</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>{{ trans('pricing.api') }}</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>{{ trans('pricing.analytics') }}<td><i class='fa fa-check fa-check'></i></td></tr>
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
        <dt>{{ trans('pricing.q_a.q1') }}</dt>
        <dd>{{ trans('pricing.q_a.a1') }} <strong><a href="{{route('assistance')}}">{{ trans('pricing.apply_now') }}</a></strong></dd>
        <dt>{{ trans('pricing.q_a.q2') }}</dt>
        <dd>{{ trans('pricing.q_a.a2') }}</dd>
      </dl>

    </div>
  </section>
  <!-- / -->


<script>

jQuery(document).ready(function ($) {


});

</script>
@stop
