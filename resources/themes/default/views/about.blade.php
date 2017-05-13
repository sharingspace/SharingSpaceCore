@extends('layouts.master')

@section('content')

<section id="why" class="margin-top-30">
  <div class="container">
    <div class="row  text-center">
      <div class="col-xs-12">
        <h3 class="fancy_font">{{trans('about.we_believe')}}</h3>
      </div>
      <div class="col-sm-4 col-xs-12">
        <img src="{{ asset('assets/img/about/earth_green.jpg') }}">
        <p class="about_intro">{{trans('about.we_are_intro')}}</p>
        <h4 class="about_headline">{{trans('about.we_are_headline')}}</h4>
        <p>{{trans('about.we_are_desc')}}</p>
      </div> <!-- col-sm-4 -->

      <div class="col-sm-4 col-xs-12">
        <img src="{{ asset('assets/img/about/orbits.jpg') }}">
        <p class="about_intro">{{trans('about.our_plan_intro')}}</p>
        <h4 class="about_headline">{{trans('about.our_plan_headline')}}</h4>
        <p>{{trans('about.our_plan_desc')}}<a href="http://support.anyshare.coop/support/solutions/articles/17000001406-why-does-anyshare-call-itself-the-first-complete-cooperative-in-the-usa-" target="_blank">{{trans('about.our_plan_desc2')}}</a>{{trans('about.our_plan_desc3')}}</p>
      </div> <!-- col-sm-4 -->

      <div class="col-sm-4 col-xs-12">
        <img src="{{ asset('assets/img/about/crowd.jpg') }}">
        <p class="about_intro">{{trans('about.before_this_intro')}}</p>
        <h4 class="about_headline">{{trans('about.before_this_headline')}}</h4>
        <p>{{trans('about.before_this_desc')}}</p>
      </div> <!-- col-sm-4 -->
    </div> <!-- row -->
  </div> <!-- container -->
</section>

<section class="orange_cta ">
  <div class="container">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2">
        <h2>{!!trans('about.cta')!!}</h2>
        <img src="{{ asset('assets/img/about/coop_fairshares.png')}}" alt="fairshares coop">
      </div>
    </div>
  </div>
</section>

<section id="why" class="margin-top-30">
  <div class="container">
    <div class="row  text-center">
      <div class="col-xs-12">
        <h3 class="fancy_font">{{trans('about.complete_coop')}}</h3>
      </div>
      <div class="col-sm-4 col-xs-12">
        <img src="{{ asset('assets/img/about/crowd.jpg') }}">
        <p class="about_intro">{{trans('about.background_intro')}}</p>
        <h4 class="about_headline">{{trans('about.background_headline')}}</h4>
        <p>{!!trans('about.background_desc')!!} <a href="http://www.fairshares.coop/" target="_blank">FairShares Coop</a> {!!trans('about.background_desc2')!!}</p>
      </div> <!-- col-sm-4 -->

      <div class="col-sm-4 col-xs-12">
        <img src="{{ asset('assets/img/about/orbits.jpg') }}">
        <p class="about_intro">{{trans('about.invited_intro')}}</p>
        <h4 class="about_headline">{{trans('about.invited_headline')}}</h4>
        <p>{{trans('about.invited_desc')}}</p>
      </div> <!-- col-sm-4 -->

      <div class="col-sm-4 col-xs-12">
        <img src="{{ asset('assets/img/about/earth_green.jpg') }}">
        <p class="about_intro">{{trans('about.what_next_intro')}}</p>
        <h4 class="about_headline">{{trans('about.what_next_headline')}}</h4>
        <p>{!!trans('about.what_next_desc')!!} <a href="http://support.anyshare.coop/support/solutions/articles/17000001408-can-you-explain-who-the-stakeholder-groups-are-" target="_blank">{!!trans('about.what_next_desc2')!!}</a>{!!trans('about.what_next_desc3')!!}</p>
      </div> <!-- col-sm-4 -->
    </div> <!-- row -->
  </div> <!-- container -->
</section>

<!-- /BUTTON CALLOUT -->
<section class="cta about_cta">
  <div class="container">
    <div class="flex-container space-between">
      <div>
        <h2 class="white-secondary-heading pull-left margin-bottom-10">{{trans('about.you_can_own')}}</h2>
      </div>
      <div>
        <a class="text-white bold btn" style="background-color:black" href="{{ route('coop') }}" style="width:100%">{{ trans('about.lets_go') }}</a>
      </div>
    </div>
  </div>
</section>

@stop
