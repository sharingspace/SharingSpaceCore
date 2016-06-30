@extends('layouts.master')

@section('content')

  <section class="overview-section">
    <div class="w-container">
      <div class="row">
        <div class="col-md-6 overview-column">
          <h3 id="opportunity">The Opportunity</h3>
          <p class="text">Make a Sharing Website for any group or community in under <strong>1 minute!</strong></p>
          <p class="text">In the past, it would cost over <strong>$10k</strong> for you to make a Sharing Economy Website to connect people's needs &amp; resources. With AnyShare, it's cheap and easy!</p>
        </div>
        <div class="col-md-6"><img src="{{ asset('assets/img/hp/anyshare-interface.jpg') }}" class="product-image">
        </div>
      </div>
    </div>
  </section>
  <section class="uses-section">
    <div class="container uses-container">
      <h2 class="white-secondary-heading">What can you do?</h2>
      <div class="row uses-row">
        <div class="col-md-3"><img width="100" height="100" src="{{ asset('assets/img/hp/gift-white.png') }}" class="use-icon">
          <h5 class="use-heading">Share with Many</h5>
          <p class="use-description">Your group or project is abundant with resources. Now you can list and exchange them.</p>
        </div>
        <div class="col-md-3"><img width="100" height="100" src="{{ asset('assets/img/hp/city-white.png') }}" class="use-icon">
          <h5 class="use-heading">Build a Community</h5>
          <p class="use-description">Towns and cities now have a way to manage needs and resources, whilst analyzing data trends.</p>
        </div>
        <div class="col-md-3"><img width="100" height="100" src="{{ asset('assets/img/hp/network.png') }}" class="use-icon">
          <h5 class="use-heading">Monetize a Network</h5>
          <p class="use-description">No need to spend big money on tech resources. Now anybody can run a network as a business.</p>
        </div>
        <div class="col-md-3"><img width="100" height="100" src="{{ asset('assets/img/hp/white.png') }}" class="use-icon">
          <h5 class="use-heading">Crowdsource in Groups</h5>
          <p class="use-description">Combine the needs of many people together to create a hub of opportunity.</p>
        </div>
      </div>
      <div class="disclaimer">* How you use a Sharing Website is limited only by your imagination!</div>
    </div>
  </section>
  <section class="bucky">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="quote">"For the first time in history it is now possible to take care of everybody at a higher standard of living than any have ever known"</div>
          <div class="quote citation">-BUCKMINSTER FULLER</div>
        </div>
        <div class="col-md-6">
          <div class="quote-description">AnyShare is heavily inspired by the work of Buckminster Fuller. Part of Bucky's work, shows how we can all live abundant lives. He says the first step to take on this path is to be able to view the whole earths resources. From there, you could easily see there is enough to go around for us all!
            <br>
            <br>So anytime you create an AnyShare Sharing Website, you're also playing a role in combating inequality and scarcity. Your Sharing Website not only helps build your own network, but also works towards solving one of human kinds greatest challenges.</div>
        </div>
      </div>
    </div>
  </section>

  <section class="cta-section">
    <div class="container">
      <div class="row">
        <div class="col-md-9">
          <h2 class="white-secondary-heading">Make your own Sharing Website</h2>
        </div>
        <div class="col-md-3">
          <a href="{{ route('community.create.form') }}" class="w-button cta-button">{{ trans('general.nav.start_now') }}</a>
        </div>
      </div>
    </div>
  </section>

@stop
