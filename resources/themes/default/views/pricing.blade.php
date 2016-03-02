@extends('layouts.master')

@section('content')


<section class="padding-top-0">
  <div class='page_banner sharing_fixed_banner'>
    <h1 style="font-size:56px!important;color:white;text-align:center;padding-top:125px;margin-bottom:-5px;">{{trans('pricing.headline') }}</h1>
  </div>
</section>

  <section id="pricing">
    <div class="container">
      <div class="table-responsive">
        <table class="table margin-top-30 margin-bottom-0" style="color:#222;font-size:16px;font-weight:500;">
        <caption class='sr-only'>Pricing table</caption>
          <thead>
            <tr style="background-color:#ddd;"><th style="width:60%;">Feature</th>
            <th>$10 a month or $100 a year <i class="fa fa-asterisk"></th>
          </thead>
          <tbody>
            <tr><td>Unlimited users</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>Unlimited entries</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>Your logo</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>API</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>Google Analytics<td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>Open or closed community<td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>SSL security<td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>Email support</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>Automatic backups</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>Automatic upgrades</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>Social media sign up/login</td><td><i class='fa fa-check fa-check'></i></td></tr>
            <tr><td>No setup fees, cancel anytime</td><td><i class='fa fa-check fa-check'></i></td></tr>            
            <tr><td></td><td><a href="{{ route('community.create.form') }}"><button type="button" class="btn btn-sm btn-warning">{{ trans('pricing.startTrial') }}</button></a></td></tr>        
          </tbody>
        </table>
        <p class="small"><i class="fa fa-asterisk"></i> All fees in US dollars</p>
      </div> 
    </div>
  </section>
  <!-- / -->


<script>

jQuery(document).ready(function ($) {


});

</script>
@stop
