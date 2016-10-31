@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
            <div class="row feature-row">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <h2 class="feature-heading text-center">Shares match needs &amp; resources</h2>
                    <p class="features-text">Your group or community can compile an inventory of its strengths and needs. Identify and match the value around you.</p>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
                    <img class="feature_image img-responsive" src="{{ asset('assets/img/features/community.png') }}">
                </div>
            </div>

            <div class="row feature-row">
                <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
                    <img class="feature_image img-responsive img-center" src="{{ asset('assets/img/features/exchange_how_u_like.png') }}">
                </div>

                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <h2 class="feature-heading text-center">Shares are hyper-flexible</h2>
                    <p class="features-text">Shares let groups and communities exchange in many ways. This includes gifting, trading, renting, sharing, selling, and more.</p>
                </div>
            </div>

            <div class="row feature-row">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <h2 class="feature-heading text-center">Shares are customizable</h2>
                    <p class="features-text">Customize your branding and control the visibility of your Share. Access can be public or private.</p>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
                    <img class="feature_image img-responsive" src="{{ asset('assets/img/features/custom_look.png') }}">
                </div>
            </div>

            <div class="row feature-row">
                <div class="col-lg-4 col-md-3 col-sm-4 hidden-xs">
                    <img class="feature_image img-responsive" src="{{ asset('assets/img/features/api.png') }}">
                </div>

                <div class="col-lg-8 col-md-9 col-sm-8 col-xs-12">
                    <h2 class="feature-heading text-center">Shares are expandable</h2>
                    <p class="features-text">View your data how you like. Use your real-time data anywhere using our API.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="w-section cta-section">
<div class="w-container">
  <div class="w-row">
    <div class="w-col w-col-9">
      <h2 class="white-secondary-heading">Make your own Share</h2>
    </div>
    <div class="w-col w-col-3">
      <a href="{{ route('community.create.form') }}" class="w-button cta-button">{{ trans('general.nav.start_now') }}</a>
    </div>
  </div>
</div>
</div>

@stop

