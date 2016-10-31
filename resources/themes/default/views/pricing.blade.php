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
          <li><i class="fa fa-group" aria-hidden="true"></i><a href="#" data-toggle="tooltip" data-placement="top" title="The maximum number of people in your Share!">1000 Users</a></li>
          <li><i class="fa fa-random" aria-hidden="true"></i><a href="#" data-toggle="tooltip" title="Gift, buy, trade, rent, collaborate, share and more">10 Ways to Exchange</a></li>
          <li><i class="fa fa-cog" aria-hidden="true"></i><a href="#" data-toggle="tooltip" title="Logo, profile, social networks">Customize Your Branding</a></li>
          <li><i class="fa fa-download" aria-hidden="true"></i><a href="#" data-toggle="tooltip" title="From csv to an API, you have options">Dynamic Import/Export options</a></li>
          <li><i class="fa fa-user-secret" aria-hidden="true"></i><a href="#" data-toggle="tooltip" title="Public or Private. Secret coming soon">Choose your Privacy Level</a></li>
          <li><i class="fa fa-slack" aria-hidden="true"></i><a href="#" data-toggle="tooltip" title="Slack API">Slack Integration</a></li>
          <li><i class="fa fa-money" aria-hidden="true"></i><a href="#" data-toggle="tooltip" title="Guarantee of prices staying $10 for your Share">Price Security</a></li>
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
      <h2 class="white-secondary-heading">Make your Share now!</h2>
    </div>
    <div class="w-col w-col-3">
      <a href="{{ route('community.create.form') }}" class="w-button cta-button">{{ trans('general.nav.start_now') }}</a>
    </div>
  </div>
</div>
</div>
<!-- / -->

@stop
