@extends('layouts.master')

@section('content')

<section class="padding-top-0">
  <div class='page_banner sharing_fixed_banner'>
    <h1 class="sr-only">About</h1>
  </div>
</section>

<section id="why" class="padding-xxs">
  <div class="container">

    <header class="text-center margin-bottom-60">
      <h2 style="font-size:48px;">{{ trans('about.why_headline') }}</h2>
      <p class="lead font-lato">{{ trans('about.mission_subheadline') }}</p>
    </header>

    <div class="row">
      <div class="col-md-6">
        <h3 class="about-subheading">The Problem</h3>
        <p class="about-description">Earth has enough. It contains the physical, emotional, mental, and spiritual resources 
        for us all. &nbsp;Access within this growing "world community" is increasing quickly too. 
        For example, Internet use has grown from 400m in 2000 to 3.2b in 2015!</p>
      
        <p>Despite our world beginning to connect, we have not comprehensively secured access to life-supporting resources 
        to all beings on Earth. Why?</p>
        <p class="margin-bottom-0">"Scarcity" is multi-dimensional problem. It attacks our perception, identity, bank account, and more. 
        It causes war, censorship, jealousy, and control.</p>
      </div> <!-- col-md-6 -->

      <div class="col-md-6">
        <h3 id="mission" class="about-subheading">The Solution</h3>
        <p class="about-description">Scarcity must be met with multi-dimensional abundance otherwise the solution is only surface. 
        For example, it is impossible to solve an issue of a neighborhood not having healthy food by giving them vegetables. 
        We must also ask how the neighborhood has been viewed in the first place. Are it's assets identified and appreciated? 
        We must look at the entire picture to fix the entire picture.</p>
        <p class="margin-bottom-0">AnySha.re is approaching scarcity as a multi-dimensional way. We are evolving the way communities identify 
        abundance, the business structures that power us, and the relationships that hold us. 
        Read below to learn more!</p>
      </div> <!-- col-md-6 -->
    </div> <!-- row -->
  </div> <!-- container -->
</section>


<div class="callout callout-theme-color text-center hidden-xs" style="height:350px;background-color: black;">
<img  class="img-responsive" src='assets/img/backgrounds/mm_on_tablet.jpg' alt='tablet displaying peoples wants and haves on anyshare'>
</div>
    
<!-- /COMMUNITIES  -->

<section id="who_when" class="padding-xxs">
  <div class="container">

    <header class="text-center margin-bottom-60">
      <h2 style="font-size:48px;">{{ trans('about.what_how') }}</h2>
      <p class="lead font-lato">{{ trans('about.what_how_subheadline') }}</p>
    </header>

    <div class="row">
      <div class="col-md-6">
       <h3 class="about-subheading">About AnyShare</h3>
        <p>Our official name is AnyShare Society and we've made the 
        <a href="https://anysha.re" target="_blank">AnySha.re website</a>. Here you can make a 
        "sharing hub," for helping people identify, collect, and exchange their value. </p>
        <p>Sharing Hubs allow all kinds of entries - things, skills, dreams, ideas, services, 
        and more. Your community can use its imagination to think of new ways to use sharing 
        hubs to unlock many types of "hidden value" that is trapped within people and groups.</p>
      </div> <!-- col-md-6 -->
    
      <div class="col-md-6">
        <h3 class="about-subheading">An All-Inclusive COOP</h3>
        <p>AnySha.re is the first completely cooperative business in the USA, and first 
        FairShares internet company and community in the world.</p> 
        <p>Our members co-own, vote, and get profits from our unique community. We are a multi-stakeholder 
        cooperative where everyone effected by our work can participate. We believe it's essential 
        that everyone is owning, voting, and profiting on whatever we build. <a href="/coop">Learn more</a>.</p>
        
      </div> <!-- col-md-6 -->
    </div> <!-- row -->
    
    <div class="row">
      <div class="col-md-6">
        <h3 class="about-subheading">The Backstory</h3>
        <p class="about-description">AnySha.re was formerly called <a href="#">Mass Mosaic</a>. 
        The vision was to collect a global collection of value (needs/resources). 
        It was co-founded by Rob Jameson, Eric Doriean, Alison Gianotto, and David Linnard. 
        We tested Mass Mosaic in various communities around the world, and one day asked ourselves, 
        "If we started over, how would it work?" The result is AnyShare.</p>
        <p>The co-founders invested years of sweat-equity, raised small funding, and eventually 
        found the right formula to grow. Rob and Eric were able to live together and 
        experiment at <a href="#">Arcosanti</a>, and Alison and David committed the code 
        for the website we all use now.<br><br>We believe the timing is perfect for AnyShare. 
        In late 2015, the JOBS Act changed the legal landscape for startups in the United States. 
        We're excited to be on the leading edge of this innovation with many years of experimenting 
        and refinement in our DNA.</p>
      </div> <!-- col-md-6 -->
    
      <div class="col-md-6">
        <h3 class="about-subheading">The Team</h3>
        <div style="position:relative;">
          <ul id="rslides">
            <li>
              <img src="assets/img/backgrounds/rob.jpg" alt="">
              <span class="caption">Rob</span>
            </li>
            <li>
              <img src="assets/img/backgrounds/eric.jpg" alt="">
              <span class="caption">Eric</span>
            </li>
            <li>
              <img src="assets/img/backgrounds/alison.jpg" alt="">
              <span class="caption">Alison</span>
            </li>
            <li>
              <img src="assets/img/backgrounds/david.jpg" alt="">
              <span class="caption">David</span>
            </li>
          </ul>
        </div>
          
        <p>Our COOP organization gives great opportunities and culture for the right people. 
        If you're interested, email us at info@anysha.re with information about yourself. We are a remote organization, 
        so your location doesn't matter.</div><div class="photo-credit">Photo credit: Schill via VisualHunt / CC BY-NC</p>
      </div> <!-- col-md-6 -->
    </div> <!-- row -->
  </div> <!-- container -->
</section>

<!-- /BUTTON CALLOUT -->

<script src="/assets/js/extensions/responsiveslider/responsiveslides.min.js"></script>

<script>

jQuery(document).ready(function () {
    $("#rslides").responsiveSlides({
      auto: true,
      pagination: true,
      nav: true,
      fade: 500,
      prevText: "Previous",   // String: Text for the "previous" button
      nextText: "Next",       // String: Text for the "next" buttons
      pauseControls: true,    // Boolean: Pause when hovering controls, true or false
    });
});

</script>
@stop
