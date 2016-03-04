@extends('layouts.master')
@section('content')

<section class="padding-top-0">
  <div class='page_banner coop_banner'>
    <h1 style="font-size:56px!important;color:white;text-align:center;padding-top:125px;margin-bottom:-5px;">{{ trans('coop.coop_headline') }}</h1>
  </div>
</section>

<section id="why" class="padding-xxs">
  <div class="container">

    <header class="text-center margin-bottom-60">
      <h2>{{ trans('coop.first_coop') }}</h2>
    </header>

    <div class="row">
      <div class="col-md-6">
        <h3 class="about-subheading">The Problem</h3>
        <p>There are many disadvantages from how current corporations hurt our communities, 
        selves, and Earth. They are solvable problems. For example:</p>

        <p><span class="darkGrey">Corporate Greed</span> - Primarily befitting the 1% richest people. 
        We all need to share in the benefits of tomorrow's businesses.</p>

        <p><span class="darkGrey">Silenced Voice</span> - We need to be heard. Everybody having a say, 
        will ensure a business is truly representative of those it works for.</p>

        <p><span class="darkGrey">Broken Community</span> - Inequity is breaking the fabric of our society. 
        Sharing value created with all, empowers our communities.</p>

        <p><span class="darkGrey">Environmental Cost</span> - Both profits and the environment are important. 
        People-powered businesses won't stand for environmental destruction.</p>
        </ul>
      </div> <!-- col-md-6 -->

      <div class="col-md-6">
        <h3 id="mission" class="about-subheading">Imagine for a Moment</h3>
        <p>Imagine a cooperative company where Community, Employees, Investors and Founders all 
        have a voice and profits from its growth. AnyShare is the first online 
        completely cooperative company to make that vision a reality.</p>

        <p>AnySha.re is the first <a href="http://www.fairshares.coop/">FairShares Cooperative</a> in the USA, and first FairShares 
        internet company and community in the world. This means we are a multi-stakeholder 
        cooperative where everyone effected by our work can participate. We believe it's 
        essential that everyone is owning, voting, and profiting on whatever we build.</p>

        <p>Our mission is to end scarcity through community. We do this on the most fundamental 
        level – by placing today’s paradigm of “value” (i.e. money, trade, etc), into a "container" 
        that is universal. Our mission is carried out though our community, so we feel that the 
        value made is shared by all.</p>
      </div> <!-- col-md-6 -->
    </div> <!-- row -->
  </div> <!-- container -->
</section>


<div class="callout callout-theme-color" style="margin-bottom-0;background-image: url('assets/img/backgrounds/london.jpg'); height:350px;background-position: 50% 0px;background-color: black;    background-size: contain;background-repeat: no-repeat;">
</div>

  <section id="coop_features">
    <div class="container">
      <header class="text-center margin-bottom-40">
        <h2 style="font-size:46px;">Coop Features</h2>
        <p>{{ trans('coop.all_inclusive_sub') }}</p>

      </header>

      <!-- FEATURED BOXES 3 -->
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
          <div class="text-center">
            <i class="ico-color-grey ico-lg ico-rounded fa fa-comment"></i>
            <h3>Your Voice</h3>
            <p class="font-lato size-20">Members can appoint directors and can propose resolutions for the direction of AnyShare.</p>
          </div>
        </div>
       
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
          <div class="text-center">
            <i class="ico-color-grey ico-lg ico-rounded fa fa-credit-card"></i>
            <h3>Your Profit</h3>
            <p class="font-lato size-20">Customers, Employees, Investors and Founders all get to share in the profit. </p>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
          <div class="text-center">
            <i class="ico-color-grey ico-lg ico-rounded fa fa-lightbulb-o"></i>
            <h3>A Real Solution</h3>
            <p class="font-lato size-20">You are being part of the core solution to the wide spread inequality we see today.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
          <div class="text-center">
            <i class="ico-color-grey ico-lg ico-rounded fa fa-check"></i>
            <h3>Voting for all</h3>
            <p class="font-lato size-20">All stakeholders will be able to create and vote on resolutions 
            on the companies direction.</p>
          </div>
        </div>
       
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
          <div class="text-center">
            <i class="ico-color-grey ico-lg ico-rounded fa fa-money"></i>
            <h3>Share in surplus profits</h3>
            <p class="font-lato size-20">When Directors decide that surplus profits will be returned to stakeholders, 
            they are returned to all stakeholders.</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
          <div class="text-center">
            <i class="ico-color-grey ico-lg ico-rounded fa fa-users"></i>
            <h3>Empower communities</h3>
            <p class="font-lato size-20">Empowering communities to steer 
            the direction of the company in ways that best help them.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
          <div class="text-center">
            <i class="ico-color-grey ico-lg ico-rounded fa fa-globe"></i>
            <h3>Appoint Directors</h3>
            <p class="font-lato size-20">Each stakeholder group can appoint Directors to oversee the operations of the business.</p>
          </div>
        </div>
       
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
          <div class="text-center">
            <i class="ico-color-grey ico-lg ico-rounded fa fa-bank"></i>
            <h3>Reduce inequality</h3>
            <p class="font-lato size-20">Sharing the value created with all stakeholders, reduces income and wealth inequality in our communities.</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
          <div class="text-center">
            <i class="ico-color-grey ico-lg ico-rounded fa fa-heartbeat"></i>
            <h3>Make a difference</h3>
            <p class="font-lato size-20">By contributing to a company that is equitable at it's core, you are part of the solution to wide spread inequality.</p>
          </div>
        </div>

      </div>
      <!-- /FEATURED BOXES 3 -->

    </div>
  </section>
  <!-- / -->


@stop
