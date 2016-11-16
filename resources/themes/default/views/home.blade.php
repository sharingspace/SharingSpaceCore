@extends('layouts.master')

@section('content')

  <section class="uses-sectionn">
    <div class="container uses-containerr">
      <div class="row">
        <div class="col-xs-10 col-xs-offset-1 text-center">
          <h2 class="section-title" style="text-align:center;">{{trans('home.share_heading')}}</h2>
          <div class="row uses-row">
            <div class="col-md-4"><img src="{{ Helper::cdn('img/hp/hands_around_people.png') }}" class="use-icon">
              <h3>{{trans('home.local')}}</h3>
              <p>{{trans('home.local_description')}}</p>
            </div>
            <div class="col-md-4"><img src="{{ Helper::cdn('img/hp/people.png') }}" class="use-icon">
              <h3>{{trans('home.crowdsource')}}</h3>
              <p>{{trans('home.crowdsource_description')}}</p>
            </div>
            <div class="col-md-4"><img src="{{ Helper::cdn('img/hp/earth_between_hands.png') }}" class="use-icon">
              <h3>{{trans('home.platform')}}</h3>
              <p>{{trans('home.platform_description')}}</p>
            </div>
          </div>
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

@stop
