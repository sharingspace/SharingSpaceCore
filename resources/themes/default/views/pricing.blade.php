@extends('layouts.master')

@section('content')

<section id="pricing">
  <div class="container">
    <div class="row">
      <div class="col-sm-8 col-sm-offset-2 col-xs-12 text-center margin-bottom-20">
        <p>It's 100% free to join and use AnyShare.</p>
        <p>If you want to make your own Share that people can join, you get a 30 day free trial.</p>
        <p>Then, a guarantee of $10/mo for life. (This is just for our beta period.)</p>
        <p>We're a cooperative, so if you want to join us click <a href="/coop">here!</a></p>
      </div>
    </div>
    <div class="table-layout center-block">
      <div class="table-cell fixed-width-200">
        <!-- PERSONAL -->
        <div class="pricing_header">
          <h2 class="title">Beta Price Offer</h2>
          <!-- CONTENT -->
          <div class="content center-block">
            <p class="price">
              <sup>$</sup>
              <span>10</span>
              <sub>/mo.</sub>
            </p>
          </div>
        </div>
        <!-- /CONTENT -->
        <!-- FEATURES -->
        <ul class="features">
          <li><i class="fa fa-group"></i>1000 Users</li>
          <li><i class="fa fa-random"></i>10 Ways to Exchange</li>
          <li><i class="fa fa-cog"></i>Customize Your Branding</li>
          <li><i class="fa fa-user-secret"></i>Choose your Privacy Level</li>
          <li><i class="fa fa-slack"></i>Integrations (Slack, Google Analytics, and more!)</li>
          <li><i class="fa fa-money"></i>Price Security</li>
        </ul>
        <!-- /FEATURES -->

        <!-- PT-FOOTER -->
        <div class="pricing-footer">
          <p class="price">
            <sup>$</sup>
            <span>10</span>
            <sub>/mo.</sub>
            
          </p>

        </div>
        <!-- /PT-FOOTER -->
      </div>
    </div>
  </div>
</section>

<div class="w-section cta-section">
<div class="w-container">
  <div class="w-row">
    <div class="w-col w-col-9">
      <h2 class="white-secondary-heading">Make your own Sharing Website</h2>
    </div>
    <div class="w-col w-col-3">
      <a href="{{ route('community.create.form') }}" class="w-button cta-button">{{ trans('general.nav.start_now') }}</a>
    </div>
  </div>
</div>
</div>
<!-- / -->

@stop
