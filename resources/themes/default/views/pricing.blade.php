@extends('layouts.master')
<style>
table th:nth-child(2), td:nth-child(2) {
  text-align:center;
}
table caption {
  text-align:center;
  margin-bottom: 15px;
}
</style>
@section('content')


<section id='slider' style="width:100%;">					
  <div class='page_banner coop_banner'>
    <h1>{{trans('pricing.headline') }}</h1>
  </div>
</section>

  <section id="features">
    <div class="container">
      <div class="table-responsive">
        <table class="table margin-top-30 margin-bottom-0" style="color:#222;font-size:18px;font-weight:500;">
        <caption class='sr-only'>Pricing table</caption>
          <thead>
            <tr style="background-color:#ddd;"><th style="width:60%;">Feature</th>
            <th>$10 a month or $100 a year <i class="fa fa-asterisk"></th>
          </thead>
          <tbody>
            <tr><td>Unlimited Users</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>Unlimited Entries</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>Your logo</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>API</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>Google Analytics<td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>Open or closed community<td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>SSL Security<td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>Email Support</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>Automatic Backups</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>Automatic Upgrades</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td></td><td><a href="{{ route('community.create.form') }}"><button type="button" class="btn btn-sm btn-warning">{{ trans('pricing.startTrial') }}</button></a></td></tr>        
          </tbody>
        </table>
        <p class="small">No setup fees. Cancel anytime.<br>
        <i class="fa fa-asterisk"></i> All fees in US dollars</p>
      </div> 
    </div>
  </section>
  <!-- / -->


<script>

jQuery(document).ready(function ($) {


});

</script>
@stop
