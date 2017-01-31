@extends('layouts.master')

@section('content')

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
          <div class="row">
            <div class="col-md-4 col-xs-12 aligner">
              <div class="aligner-item">
                <h2>{{ trans('general.share') }}<sup class="smaller">1</sup>&nbsp;&nbsp;&nbsp;<span>/SHer/</span></h2>
                <p><em class="smaller">{{ trans('features.noun') }}</em></p>
                <ol><li>{{ trans('features.noun_desc') }}</li></ol>
              </div>
            </div>
            <div class="col-md-8 col-xs-12 videoWrapper">
              <video autoplay class="img-responsivee">
                <source src="{{ asset('assets/movies/product_movie1.mp4') }}" type="video/mp4">
              </video>
            </div>
          </div>
        </div>

        <div class="item">
          <div class="row">
            <div class="col-md-4 col-xs-12 aligner">
              <div class="aligner-item">
                <h2>{{ trans('features.simple_entry') }}</h2>
                <p>{{ trans('features.simple_entry_desc') }}</p>
              </div>
            </div>
            <div class="col-md-8 col-xs-12 videoWrapper">
              <video autoplay class="img-responsivee">
                <source src="{{ asset('assets/movies/product_movie2.mp4') }}" type="video/mp4">
              </video>
            </div>
          </div>
        </div>

        <div class="item">
          <div class="row">
            <div class="col-md-4 col-xs-12 aligner">
              <div class="aligner-item">
                <h2>{{ trans('features.opportunities')}}</h2>
                <p>{{ trans('features.opportunities_desc')}}</p>
              </div>
            </div>
            <div class="col-md-8 col-xs-12 videoWrapper">
              <video autoplay class="img-responsivee">
                <source src="{{ asset('assets/movies/product_movie3.mp4') }}" type="video/mp4">
              </video>
            </div>
          </div>
        </div>

        <!-- Left and right controls -->
        <div class="pagination_arrows">
          <a class="carousel-control" href="#featureCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control" href="#featureCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

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

@section('moar_scripts')

<script type="text/javascript">
$( window ).on( "load", function() {
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

  $('.carousel-control').show();

  function equalHeights()
  {
    // Select and loop the container element of the elements you want to equalise
    $('.container').each(function(){  
      var highestBox = 0;

      // Select and loop the elements you want to equalise
      $('.carousel-inner .col-xs-12', this).each(function() {
        // If this box is higher than the cached highest then store it
        if($(this).height() > highestBox) {
          highestBox = $(this).height(); 
        }
      });  
        
      // Set the height of all those children to whichever was highest 
      $('.carousel-inner .col-xs-12', this).height(highestBox);
    });
  }

  if ($(window).width() >= 990) {
    equalHeights();
  }

  $(window).resize(function() {
    $('.carousel-inner .col-xs-12').height('auto');
    if ($(window).width() >= 990) {
      equalHeights();
    }
  });
});

</script>
@stop
@stop