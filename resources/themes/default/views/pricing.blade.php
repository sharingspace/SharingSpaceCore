@extends('layouts.master')

@section('content')

<section id="pricing">
  <div class="container">
    <div class="row">
      <div class="col-sm-8 col-sm-offset-2 col-xs-12 text-center margin-bottom-20">
        <p>{{trans('pricing.intro_p1')}}</p>
        <p>{{trans('pricing.intro_p2')}}</p>
        <p>{{trans('pricing.intro_p3')}}</p>
        <p>{!!trans('pricing.intro_p4')!!} <a href="/coop">{!!trans('pricing.intro_p5')!!}</a></p>

      </div>
    </div>
    <div class="table-layout center-block">
      <div class="table-cell fixed-width-200">
        <!-- PERSONAL -->
        <div class="pricing_header">
          <h2 class="title">{{trans('pricing.beta_price')}}</h2>
          <!-- CONTENT -->
          <div class="content center-block">
            <p class="price">
              <sup>{{trans('pricing.currency')}}</sup>
              <span>{{trans('pricing.cost')}}</span>
              <sub>{{trans('general.month')}}</sub>
            </p>
          </div>
        </div>
        <!-- /CONTENT -->
        <!-- FEATURES -->
        <ul class="features">
          <li><i class="fa fa-group" aria-hidden="true"></i><a href="#" data-toggle="tooltip" data-placement="top" title="The maximum number of people in your Share!">{{trans('pricing.max_users')}}</a></li>
          <li><i class="fa fa-random" aria-hidden="true"></i><a href="#" data-toggle="tooltip" title="Gift, buy, trade, rent, collaborate, share and more">{{trans('pricing.ways_to_exchange')}}</a></li>
          <li><i class="fa fa-cog" aria-hidden="true"></i><a href="#" data-toggle="tooltip" title="Logo, profile, social networks">{{trans('pricing.your_branding')}}</a></li>
          <li><i class="fa fa-download" aria-hidden="true"></i><a href="#" data-toggle="tooltip" title="From csv to an API, you have options">{{trans('pricing.import_export')}}</a></li>
          <li><i class="fa fa-user-secret" aria-hidden="true"></i><a href="#" data-toggle="tooltip" title="Public or Private. Secret coming soon">{{trans('pricing.privacy_level')}}</a></li>
          <li><i class="fa fa-slack" aria-hidden="true"></i><a href="#" data-toggle="tooltip" title="Slack API">{{trans('general.slack')}}</a></li>
          <li><i class="fa fa-money" aria-hidden="true"></i><a href="#" data-toggle="tooltip" title="Guarantee of prices staying $10 for your Share">{{trans('pricing.price_security')}}</a></li>
        </ul>
        <!-- /FEATURES -->

        <!-- PT-FOOTER -->
        <div class="pricing-footer">
          <p class="price">
            <sup>{{trans('pricing.currency')}}</sup>
            <span>{{trans('pricing.cost')}}</span>
            <sub>{{trans('pricing.pay_period')}}</sub>
            
          </p>

        </div>
        <!-- /PT-FOOTER -->
      </div>
    </div>
  </div>
</section>

<section class="cta">
  <div class="container">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2">
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
