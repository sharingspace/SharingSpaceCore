@extends('layouts.master')

@section('content')

  <section class="uses-sectionn">
    <div class="container uses-containerr">
      <div class="row">
        <div class="col-xs-10 col-xs-offset-1 text-center">
          <h2 class="section-title" style="text-align:center;">Ways to use a Share:</h2>
          <div class="row uses-row">
            <div class="col-md-4"><img src="{{ asset('assets/img/hp/hands_around_people.png') }}" class="use-icon">
              <h3>Local Exchange</h3>
              <p>From meetups to campuses, local groups now have a way to manage needs and resources.</p>
            </div>
            <div class="col-md-4"><img src="{{ asset('assets/img/hp/people.png') }}" class="use-icon">
              <h3>Crowdsource Together</h3>
              <p>From art projects to relief efforts, Shares let many people combine their needs and resources.</p>
            </div>
            <div class="col-md-4"><img src="{{ asset('assets/img/hp/earth_between_hands.png') }}" class="use-icon">
              <h3>Sharing Platforms</h3>
              <p>Want to start the next AirBnB or Uber in 1 minute? Use a Share to launch your very own platform cooperative.</p>
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
              <h2 class="white-secondary-heading">Make a Share for any Group</h2>
            </div>
            <div class="col-sm-3 col-xs-12 margin-bottom-0">
              <a href="{{ route('community.create.form') }}" class="btn center-xs pull-right-sm size-18 weight-700 font-smoothing" style="background-color:black;color:white">Try Now</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@stop
