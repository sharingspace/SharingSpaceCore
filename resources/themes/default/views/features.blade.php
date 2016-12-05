@extends('layouts.master')

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="row feature-row">
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h2 class="feature-heading text-center">{{trans('features.exchange_heading')}}</h2>
        <p class="features-text">{{trans('features.exchange_feature')}}</p>
      </div>

      <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
        <img class="feature_image img-responsive" src="{{ asset('assets/img/features/exchange_how_u_like.png') }}">
      </div>
    </div>

    <div class="row feature-row">
      <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
        <img class="feature_image img-responsive img-center" src="{{ asset('assets/img/features/exchange_what_u_like.png') }}">
      </div>

      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h2 class="feature-heading text-center">&hellip; {{trans('features.want_heading')}}</h2>
        <p class="features-text">{{trans('features.want_feature')}}</p>
      </div>
    </div>

    <div class="row feature-row">
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h2 class="feature-heading text-center">{{trans('features.interact_heading')}}</h2>
        <p class="features-text">{{trans('features.interact_feature')}}</p>
      </div>

      <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
        <img class="feature_image img-responsive" src="{{ asset('assets/img/features/interactive_entries.png') }}">
      </div>
    </div>

    <div class="row feature-row">
      <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
        <img class="feature_image img-responsive" src="{{ asset('assets/img/features/community.png') }}">
      </div>

      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h2 class="feature-heading text-center">{{trans('features.groups_heading')}} &hellip;</h2>
        <p class="features-text">{{trans('features.groups_feature')}}</p>
      </div>
    </div>

    <div class="row feature-row">
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h2 class="feature-heading text-center">{{trans('features.grow_heading')}}</h2>
        <p class="features-text">{{trans('features.grow_feature')}}</p>
      </div>

      <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
        <img class="feature_image img-responsive" src="{{ asset('assets/img/features/unlimited_size.png') }}">
      </div>
    </div>
    
    <div class="row feature-row">
      <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
        <img class="feature_image img-responsive" src="{{ asset('assets/img/features/custom_look.png') }}">
      </div>

      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h2 class="feature-heading text-center">{{trans('features.custom_heading')}}</h2>
        <p class="features-text">{{trans('features.custom_feature')}}</p>
      </div>
    </div>

    <div class="row feature-row">
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h2 class="feature-heading text-center">{{trans('features.privacy_heading')}}</h2>
        <p class="features-text">{{trans('features.privacy_feature')}}</p>
      </div>

      <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
        <img class="feature_image img-responsive" src="{{ asset('assets/img/features/privacy_control.png') }}">
      </div>
    </div>

    <div class="row feature-row">
      <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
        <img class="feature_image img-responsive" src="{{ asset('assets/img/features/social.png') }}">
      </div>

      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h2 class="feature-heading text-center">{{trans('features.signups_heading')}}</h2>
        <p class="features-text">{{trans('features.signups_feature')}}</p>
      </div>
    </div>

    <div class="row feature-row">
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h2 class="feature-heading text-center">{{trans('features.expandable_heading')}}</h2>
        <p class="features-text">{{trans('features.expandable_feature')}}</p>
      </div>

      <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
        <img class="feature_image img-responsive" src="{{ asset('assets/img/features/api.png') }}">
      </div>
    </div>

    <div class="row feature-row">
      <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
        <img class="feature_image img-responsive" src="{{ asset('assets/img/features/slack.png') }}">
      </div>

      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h2 class="feature-heading text-center">{{trans('features.slack_heading')}}</h2>
        <p class="features-text">{{trans('features.slack_feature')}}</p>
      </div>
    </div>

    <div class="row feature-row">
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h2 class="feature-heading text-center">{{trans('general.ga')}}</h2>
        <p class="features-text">{{trans('features.google_feature')}}</p>
      </div>

      <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
        <img class="feature_image img-responsive" src="{{ asset('assets/img/features/google_anal.png') }}">
      </div>
    </div>
  </div>
</div>

<div class="w-section cta-section">
<div class="w-container">
  <div class="w-row">
    <div class="w-col w-col-9">
      <h2 class="white-secondary-heading">{{trans('general.make-now')}}</h2>
    </div>
    <div class="w-col w-col-3">
      <a href="{{ route('community.create.form') }}" class="w-button cta-button">{{ trans('general.nav.start_now') }}</a>
    </div>
  </div>
</div>
</div>

@stop