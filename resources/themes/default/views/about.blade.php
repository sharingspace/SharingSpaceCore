@extends('layouts.master')

@section('content')

 
<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Feature 3
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->

<section class="section">
    <div class="container">
      <header class="section-header">

        <p class="lead">Our mission is to provide simple tools for people to self-organize and share resources. Our vision is to do this planet-wide, and end human-made scarcity through sharing! </p>

      </header>

      <div class="row gap-y">

        <div class="col-12 col-md-6 col-xl-4 feature-1">
          <p class="feature-icon"><img src="{{ asset('assets/corporate/img/icon-dog.png')}}" alt="Who"></p>
          <h5>Who</h5>
          <p class="text-muted">AnyShare's team is distributed across various countries. We provide an <a href="https://anyshare.freshdesk.com/support/solutions/articles/17000057018-open-enrollment-policy" target="_blank">open enrolment policy</a>. </p>
        </div>

        <div class="col-12 col-md-6 col-xl-4 feature-1">
          <p class="feature-icon"><img src="{{ asset('assets/corporate/img/icon-planet.png')}}" alt="What"></p>
          <h5>What</h5>
          <p class="text-muted">Our products help people share with each other in <a href="{{route('_sharing_networks')}}">online</a> and <a href="{{route('_sharing_spaces')}}">offline</a> environments.</p>
        </div>

        <div class="col-12 col-md-6 col-xl-4 feature-1">
          <p class="feature-icon"><img src="{{ asset('assets/corporate/img/icon-rocket.png')}}" alt="Why"></p>
          <h5>Why</h5>
          <p class="text-muted">We dream and <a href="https://anyshare.github.io" target="_blank">build</a> better tools for creating access in a planetary ecosystem.</p>
        </div>

      </div>

    </div>
</section>


<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| CTA 7
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->

<section class="section text-center py-150" data-parallax="{{ asset('assets/corporate/img/trees.jpg')}}" data-overlay="4">
    <div class="container">
      <h5 class="fs-30 text-white fw-300 mb-190">Our <strong>Complete</strong> Cooperative</h5>
    </div>
</section>

<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Content 2
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->

<section class="section">
    <div class="container">
      <div class="row gap-y align-items-center">

        <div class="col-12 col-md-6 center-vh">
          <img class="rounded" style="width: 250px" src="{{ asset('assets/corporate/img/book.png')}}" alt="..." data-aos="fade-in">
        </div>


        <div class="col-12 col-md-6">
          <h3>Introducing a new Business Paradigm</h3>

          <p>We dream of a future where anybody can create abundance for themselves, their family and their community. We believe we must embody this change ourselves first, and so we began with our business structure.</p>
          <p>AnyShare Society modified the <a href="http://fairshares.coop" target="blank">FairShares Bylaws</a> to become the first United States company (and first online company in the World) to include <u>ALL</u> stakeholder groups in voting and dividend profit sharing.</p>
          <p>This is a BIG milestone in how ethical companies are structured! It also lets anyone become an AnyShare cooperative member</p>

          <a class="btn btn-outline btn-malibu no-shadow" href="{{route('coop')}}">Learn More<i class="fa fa-arrow-right fs-15 ml-8"></i></a>
        </div>

      </div>
    </div>
</section>


<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| CTA 7
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->

<section class="section text-center py-150" data-parallax="{{ asset('assets/corporate/img/journey.jpg')}}" data-overlay="4">
    <div class="container">
      <h5 class="fs-30 text-white fw-300 mb-190">Join <strong>Us</strong></h5>
    </div>
</section>



<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Content 2
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->

<section class="section">
    <div class="container">
      <div class="row gap-y align-items-center">

        <div class="col-12 col-md-6 center-vh">
          <img class="rounded" style="width: 250px" src="{{ asset('assets/corporate/img/painting.png')}}" alt="..." data-aos="fade-in">
        </div>


        <div class="col-12 col-md-6">
          <h3>4 Ways to Co-Create</h3>
          <p>AnyShare is built on the practices of sharing openly. For this reason, we invite you to become involved in various solutions we are developing.
            <ol>
              <li>First, view <em>our</em> <a href="https://anyshare.anyshare.coop" target="blank">Sharing Network</a> to see open opportunities with our organization.</li>
              <li>Next, consider joining our Cooperative! You get a voice and share in the surplus profits. Learn more <a href="https://anyshare.freshdesk.com/support/solutions/articles/17000001407-how-do-i-become-an-anyshare-coop-member-" target="blank">here</a>.</li>
              <li>Developers will be interested in our API and upcoming open source release. We're also working on the first Open Source reciprocity-based license called PEARL. <a href="https://anyshare.github.io" target="blank">Learn more</a>.</li>
              <li>Finally, we have various other experiments and collaborations in the mix. Stay current by joining our newsletter below.</li>
            </ol>

          <a class="btn btn-outline btn-malibu no-shadow" href="{{ route('coop') }}">Roll up your sleeves<i class="fa fa-arrow-right fs-15 ml-8"></i></a>

        </div>

      </div>
    </div>
</section>


<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Subscribe 3
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->

<section class="section section-inverse py-120" data-parallax="{{ asset('assets/corporate/img/icon.gif')}}" data-overlay="7">
    <div class="container text-center">

      <h2>Stay Tuned</h2>
      <br />
      <p class="lead">Subscribe to our newsletter and receive the latest news from AnyShare.</p>

      <br /><br />

      <form class="form-inline form-glass form-round justify-content-center" form action="https://massmosaic.us4.list-manage.com/subscribe/post?u=1d066d4c6fdd81c10e74307cc&amp;id=1ec2d33d62" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
        <div class="input-group">
          <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
          <input type="text" name="EMAIL" id="mce-EMAIL" class="form-control" placeholder="Email Address">
          <span class="input-group-btn">
            <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="btn btn-lg btn-white">
          </span>
        </div>
      </form>

    </div>
</section>

@stop
