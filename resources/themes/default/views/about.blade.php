@extends('layouts.master')

@section('content')

<section id="why" class="padding-xxs">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <p class="lead font-lato">The Earth is abundant, yet scarcity attacks our perception, identity, bank account, and more. It causes war, censorship, jealousy, control and inequality.</p>
      
        <p class="lead font-lato">Our 'leaders' cannot deliver solutions to fix the world. We need to put faith in ourselves and unite together. AnyShare empowers you and your community to do just that with:</p>
      </div> <!-- col-md-6 -->

      <div class="col-md-6">
       <img class="abundance-image" src="/assets/img/about/earth.jpg">
      </div> <!-- col-md-6 -->
    </div> <!-- row -->
  </div> <!-- container -->
</section>

<section id="features" class="padding-xxs">
  <div class="container">
    <div class="row">
      <div class="col-md-4 text-center">
        <img class="about-icon" src="/assets/img/about/app.png" width="100">
        <h3 class="feature-heading">Sharing Websites</h3>
        <p class="paragraph-text">A Web based product for any group or community to share needs and resources together.</p>
        <div>
          <a class="about-learn-more" href="/features">Learn more</a>
        </div>
      </div>
      <div class="col-md-4 text-center">
        <img src="/assets/img/about/men-carrying-a-box.png" width="100">
        <h3 class="feature-heading">The Complete Cooperative</h3>
        <p class="paragraph-text">We’re passionate about helping businesses act ethically and collaboratively.</p>
        <div>
          <a class="about-learn-more" href="/coop">Learn more</a>
        </div>
      </div>
      <div class="col-md-4 text-center">
        <img src="/assets/img/about/holding-hands-in-a-row.png" width="100">
        <h3 class="feature-heading">AnyShare Community</h3>
        <p class="paragraph-text">Share news, questions, and ideas for making a abundant world for everyone.</p>
        <div>
          <a class="about-learn-more" href="http://blog.massmosaic.com/" target="_blank" rel="noopener noreferrer">Learn more</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="about-picture-bg">
  <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="quote">“In this world there is room for everyone, and the good earth is rich and can provide for everyone. The way of life can be free and beautiful, but we have lost the way.”</div>
          <div class="quote citation">- Charlie Chaplin</div>
        </div>
    </div>
  </div>
</section>

<section id="backstory">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h3 class="backstory-heading">The Backstory</h3>
        <p class="lead font-lato">AnyShare was formerly called Mass Mosaic. It was a global collection of value (needs/resources). Mass Mosaic was tested with various communities and groups from 2006-2015.</p>
        
        <p class="lead font-lato">One day, we asked ourselves, "If we started over, how would we accomplish our mission more efficiently?" The result is AnyShare. The co-founders invested years of sweat-equity, raised small funding, and eventually found the right formula to grow.</p>

        <p class="lead font-lato">We believe the timing is perfect for AnyShare. Uber, Airbnb and others have given us a glimpse of the benefits of sharing websites. Now AnyShare puts the technology and the knowledge in the hands of everybody.</p>

        <h4 class="backstory-heading">The Team</h4>
      </div>

      <div class="row text-center">
        <div class="col-md-3">
          <img class="team-headshot" height="200" src="/assets/img/about/rob.jpg" width="200">
          <h4 class="name">Rob Jameson <a href="https://twitter.com/robjameson" target="_blank" rel="noopener noreferrer"><img class="twitter-follow" src="assets/img/social/twitter-color.png" width="20"></a></h4>
          <h4 class="role">Co-Founder / CEO</h4>
        </div>
        <div class="col-md-3">
        <img class="team-headshot" height="200" src="/assets/img/about/eric.jpg" width="200">
          <h4 class="name">Eric Doriean <a href="https://twitter.com/EricDoriean" target="_blank" rel="noopener noreferrer"><img class="twitter-follow" src="assets/img/social/twitter-color.png" width="20"></a></h4>
          <h4 class="role">Co-Founder / COO</h4>
        </div>
        <div class="col-md-3">
        <img class="team-headshot" height="200" src="/assets/img/about/alison.jpg" width="200">
          <h4 class="name">Alison Gianotto <a href="https://twitter.com/snipeyhead" target="_blank" rel="noopener noreferrer"><img class="twitter-follow" src="assets/img/social/twitter-color.png" width="20"></a></h4>
          <h4 class="role">Co-Founder / CTO </h4>
        </div>
        <div class="col-md-3">
        <img class="team-headshot" height="200" src="/assets/img/about/david.jpg" width="200">
          <h4 class="name">David Linnard</h4>
          <h4 class="role">Co-Founder / Sr. Developer</h4>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- /BUTTON CALLOUT -->
<section class="cta">
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <h2 class="white-secondary-heading">Make your own Sharing Website</h2>
      </div>
      <div class="col-md-3">
        <a href="https://massmosaic.app/community/new" class="w-button cta-button contained-button size-15">START NOW</a>
      </div>
  </div>
</section>

@stop
