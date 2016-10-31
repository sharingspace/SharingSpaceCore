@extends('layouts.master')

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="row feature-row">
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h2 class="feature-heading text-center">Exchange How You Like</h2>
        <p class="features-text">Share, Rent, Trade, Gift, Borrow, Buy/Sell or any combination of these you desire.</p>
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
        <h2 class="feature-heading text-center">&hellip; and What You Want</h2>
        <p class="features-text">Exchange any value, like things, skills, knowledge, ideas, resources, opportunities, and more.</p>
      </div>
    </div>

    <div class="row feature-row">
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h2 class="feature-heading text-center">Interact with Entries</h2>
        <p class="features-text">Use the powerful list view, with search and sortable columns. Plus download your Share entries (csv, txt, json and xml formats) to print out on paper for meetings</p>
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
        <h2 class="feature-heading text-center">Groups, Communities, and more &hellip;</h2>
        <p class="features-text">Shares can be customized for various uses, including by communities, meetups, schools, art and STEM projects, crowdsourcing, bio blitzes, apartment complexes, farmers markets, and more!</p>
      </div>
    </div>

    <div class="row feature-row">
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h2 class="feature-heading text-center">Grow with you</h2>
        <p class="features-text">Shares can be any size and local or globally located. Translate a Share into the language(s) that are right for your members!</p>
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
        <h2 class="feature-heading text-center">Custom Look &amp; Feel</h2>
        <p class="features-text">Choose different colors, layouts, and branded themes for your Share</p>
      </div>
    </div>

    <div class="row feature-row">
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h2 class="feature-heading text-center">Full Privacy Control</h2>
        <p class="features-text">Control the visibility of your Share with public, private, and secret (coming soon) levels of access.</p>
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
        <h2 class="feature-heading text-center">Convenient Signups</h2>
        <p class="features-text">Let your members join your Share using email or their social media accounts (Facebook, Twitter, Github and Google Plus).</p>
      </div>
    </div>

    <div class="row feature-row">
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h2 class="feature-heading text-center">API</h2>
        <p class="features-text">Access entries and user data through your own API.</p>
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
        <h2 class="feature-heading text-center">Slack Integration</h2>
        <p class="features-text">Your Share can send needs and resources from Slack, so you can log this valuable information right as your team uncovers it</p>
      </div>
    </div>

    <div class="row feature-row">
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h2 class="feature-heading text-center">Google Analytics</h2>
        <p class="features-text">Keep track of who’s visiting your Share and all the analytics that Google analytics brings you.</p>
      </div>

      <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
        <img class="feature_image img-responsive" src="{{ asset('assets/img/features/google_anal.png') }}">
      </div>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
            <div class="row feature-row">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <h2 class="feature-heading text-center">Shares match needs &amp; resources</h2>
                    <p class="features-text">Your group or community can compile an inventory of its strengths and needs. Identify and match the value around you.</p>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
                    <img class="feature_image img-responsive" src="{{ Helper::cdn('img/features/community.png') }}">
                </div>
            </div>

            <div class="row feature-row">
                <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
                    <img class="feature_image img-responsive img-center" src="{{ Helper::cdn('img/features/exchange_how_u_like.png') }}">
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
                    <img class="feature_image img-responsive" src="{{ Helper::cdn('img/features/custom_look.png') }}">
                </div>
            </div>

            <div class="row feature-row">
                <div class="col-lg-4 col-md-3 col-sm-4 hidden-xs">
                    <img class="feature_image img-responsive" src="{{ Helper::cdn('img/features/api.png') }}">
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
      <h2 class="white-secondary-heading">Make your Share now!</h2>
    </div>
    <div class="w-col w-col-3">
      <a href="{{ route('community.create.form') }}" class="w-button cta-button">{{ trans('general.nav.start_now') }}</a>
    </div>
  </div>
</div>
</div>

@stop

