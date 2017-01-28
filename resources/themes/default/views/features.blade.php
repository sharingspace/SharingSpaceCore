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
        <h2 class="feature-heading text-center">{{trans('general.slack')}}</h2>
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


<section>
  <div class="container">
    <div id="featureCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
         <h2>share<sup class="smaller">1</sup>&nbsp;&nbsp;&nbsp;&nbsp;<span>SHer/</span></h2>
          <div class="row">
            <div class="col-md-4 col-xs-12">
              <p><em class="smaller">noun</em></p>
              <ol><li>a part or portion of a larger amount that is divided among a number of people, or to which a number of people contribute.</li></ol>
              <p><em class="smaller">verb</em></p>
              <ol><li>have a portion of (something) with another or others."he shared the pie with her" synonyms: split, divide, go halves on.</li></ol>
            </div>
            <div class="col-md-8 col-xs-12">
              <video controls autoplay class="img-responsive">
                <source src="{{ asset('assets/movies/product_movie1.mp4') }}" type="video/mp4">
              </video>
            </div>
          </div>
        </div>

        <div class="item">
          <h2>Simple Entry</h2>
          <div class="row">
            <div class="col-md-4 col-xs-12">
              <p>Members use the simple form to fill out entries. They select many the ways they’re open receive benefits, rather than simply one like money, time, or barter.</p>
            </div>
            <div class="col-md-8 col-xs-12">
              <video controls autoplay class="img-responsive">
                <source src="{{ asset('assets/movies/product_movie2.mp4') }}" type="video/mp4">
              </video>
            </div>
          </div>
        </div>

        <div class="item">
          <h2>Grow Your Opportunities</h2>
          <div class="row">
            <div class="col-md-4 col-xs-12">
              <p>The entries of your Share can be distributed in various ways, including through web, email, and physical lists. Learn more below!</p>
            </div>
            <div class="col-md-8 col-xs-12">
              <video controls autoplay class="img-responsive">
                <source src="{{ asset('assets/movies/product_movie3.mp4') }}" type="video/mp4">
              </video>
            </div>
          </div>
        </div>
      </div>

      <!-- Left and right controls -->
      <a class="left carousel-control" href="#featureCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#featureCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div>
</section>


<section class="cta">
  <div class="container">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2">
        <div class="row">
          <div class="col-sm-9 col-xs-12 margin-bottom-0">
            <h2 class="white-secondary-heading">{{trans('home.cta')}}</h2>
          </div>
          <div class="col-sm-3 col-xs-12 margin-bottom-0">
            <a href="{{ route('community.create.form') }}" class="btn center-xs pull-right-sm size-18 weight-700 font-smoothing" style="background-color:black;color:white">{{ trans('general.nav.start_now') }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script type="text/javascript">
$( document ).ready(function() {
  // Activate Carousel
  $("#featureCarousel").carousel();

  // Enable Carousel Indicators
  $(".item").click(function(){
      $("#featureCarousel").carousel(1);
  });

  // Enable Carousel Controls
  $(".left").click(function(){
      $("#featureCarousel").carousel("prev");
  });
});
</script>
@stop