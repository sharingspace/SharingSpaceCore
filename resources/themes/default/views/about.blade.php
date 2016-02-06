@extends('layouts.master')
<style>

.about-section-2 {
  height: 350px;
  margin-bottom: 0px;
  background-color: #000;
  background-image: url("http://uploads.webflow.com/564b3e094801fab237b6b158/564d780e5e1ff0f11ea54aba_sitting.jpg");
  background-position: 50% 0px;
  background-size: contain;
  background-repeat: no-repeat;
}

.about-section-3 {
  margin-top: 0px;
  margin-bottom: 0px;
  padding-top: 43px;
  padding-bottom: 50px;
  background-color: transparent;
}

section p {
  font-family: Montserrat, sans-serif;
  font-size: 15px;
}

#team_slider {
  position: relative;
  overflow: hidden;
  margin: 20px 0 0 0;
}

#team_slider ul {
  position: relative;
  margin: 0;
  padding: 0;
  list-style: none;
}

#team_slider ul li {
  position: relative;
  display: block;
  float: left;
  margin: 0;
  padding: 0;
  max-height: 366px;
  max-width: 550px;
  text-align: center;
  background-repeat: no-repeat;
  height: 100%;
  width: 100%;
  background-size:contain;
}

ul li span {
    display:table-cell;
    vertical-align: bottom;
    height: 366px;
    width: 550px;
    color:white;
    font-size: 24px;
}

a.control_prev, a.control_next {
  position: absolute;
  top: 40%;
  z-index: 999;
  display: block;
  padding: 4% 3%;
  width: auto;
  height: auto;
  color: #fff;
  text-decoration: none;
  font-weight: 600;
  font-size: 18px;
  opacity: 0.8;
  cursor: pointer;
}

a.control_prev:hover, a.control_next:hover {
  opacity: 1;
  -webkit-transition: all 0.2s ease;
}

a.control_prev {
  border-radius: 0 2px 2px 0;
}

a.control_next {
  right: 0;
  border-radius: 2px 0 0 2px;
}

.slider_option {
  position: relative;
  margin: 10px auto;
  width: 160px;
  font-size: 18px;
}

</style>
@section('content')


<section id='slider' style="width:100%;">					
  <div style="background-color:rgba(0, 0, 0, 0.45);background-image: url('assets/img/backgrounds/nepal_tech.jpg'); height:400px;width:100%;background-position: 50% 0px;background-size: cover;background-repeat: no-repeat;">
    <h1>Sharing Hubs</h1>
    <h2 style="text-align:center;">multi-person needs and resources</h2>
    <div style="text-align:center;"><a href="#" class="btn btn-danger">Try</a>
    <a href="#about" class="btn btn-warning w-button slider-buttons button-variation">Learn</a></div>
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
        <p>"Scarcity" is multi-dimensional problem. It attacks our perception, identity, bank account, and more. 
        It causes war, censorship, jealousy, and control.</p>
      </div> <!-- col-md-6 -->

      <div class="col-md-6">
        <h3 id="mission" class="about-subheading">The Solution</h3>
        <p class="about-description">Scarcity must be met with multi-dimensional abundance... otherwise the solution is only surface. 
        For example, it is impossible to solve an issue of a neighborhood not having healthy food by giving them vegetables. 
        We must also ask how the neighborhood has been viewed in the first place. Are it's assets identified and appreciated? 
        We must look at the entire picture to fix the entire picture.</p>
        <p>AnySha.re is approaching scarcity as a multi-dimensional way. We are evolving the way communities identify 
        abundance, the business structures that power us, and the relationships that hold us. 
        Read below to learn more!</p>
      </div> <!-- col-md-6 -->
    </div> <!-- row -->
  </div> <!-- container -->
</section>


<div class="callout callout-theme-color" style="margin-bottom-0;background-image: url('assets/img/backgrounds/mm_on_tablet.jpg'); height:350px;background-position: 50% 0px;background-color: black;    background-size: contain;background-repeat: no-repeat;">

</div>
    
<!-- /COMMUNITIES  -->

<section id="what_how" class="padding-xxs">
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
  </div> <!-- container -->
</section>


<section id="who_when" class="padding-xxs">
  <div class="container">

    <header class="text-center margin-bottom-60">
      <h2 style="font-size:48px;">{{ trans('about.when_who') }}</h2>
      <p class="lead font-lato">{{ trans('about.when_who_subheadline') }}</p>
    </header>

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
        <div id="team_slider">
          <a href="" class="control_next"><i class="fa fa-2x fa-chevron-right"></i><span class="sr-only">next image</span></a>
          <a href="" class="control_prev"><i class="fa fa-2x fa-chevron-left"></i><span class="sr-only">previous image</span></a>
          <ul>
            <li style="background-image:url('assets/img/backgrounds/rob.jpg');"><span>Rob</span></li>
            <li style="background-image:url('assets/img/backgrounds/eric.jpg');"><span>Eric</span></li>
            <li style="background-image:url('assets/img/backgrounds/alison.jpg');"><span>Alison</span></li>
            <li style="background-image:url('assets/img/backgrounds/david.jpg');"><span>David</span></li>
          </ul>  
        </div> <!-- slider -->
          
        <p>Our COOP organization gives great opportunities and culture for the right people. 
        If you're interested, email us at info@anysha.re with information about yourself. We are a remote organization, 
        so your location doesn't matter.</div><div class="photo-credit">Photo credit: Schill via VisualHunt / CC BY-NC</p>
      </div> <!-- col-md-6 -->
    </div> <!-- row -->
  </div> <!-- container -->
</section>

<!-- /BUTTON CALLOUT -->

<!-- <div id="slider">
  <a href="" class="control_next"><i class="fa fa-2x fa-chevron-right"></i><span class="sr-only">next image</span></a>
  <a href="" class="control_prev"><i class="fa fa-2x fa-chevron-left"></i><span class="sr-only">previous image</span></a>
  <ul>
    <li style="background-image:url('assets/img/backgrounds/rob.jpg');"><span>Rob</span></li>
    <li style="background-image:url('assets/img/backgrounds/eric.jpg');"><span>Eric</span></li>
    <li style="background-image:url('assets/img/backgrounds/alison.jpg');"><span>Alison</span></li>
    <li style="background-image:url('assets/img/backgrounds/david.jpg');"><span>David</span></li>
  </ul>  
</div> -->

<script>

jQuery(document).ready(function ($) {

  setInterval(function () {
      moveRight();
  }, 3000);
  
	var slideCount = $('#team_slider ul li').length;
	var slideWidth = $('#team_slider ul li').width();
	var slideHeight = $('#team_slider ul li').height();
	var sliderUlWidth = slideCount * slideWidth;
	
	$('#team_slider').css({ width: slideWidth, height: slideHeight });
	
	$('#team_slider ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });
	
    $('#team_slider ul li:last-child').prependTo('#team_slider ul');

    function moveLeft() {
        $('#team_slider ul').animate({
            left: + slideWidth
        }, 200, function () {
            $('#team_slider ul li:last-child').prependTo('#team_slider ul');
            $('#team_slider ul').css('left', '');
        });
    };

    function moveRight() {
        $('#team_slider ul').animate({
            left: - slideWidth
        }, 200, function () {
            $('#team_slider ul li:first-child').appendTo('#team_slider ul');
            $('#team_slider ul').css('left', '');
        });
    };

    $('a.control_prev').click(function (e) {
    e.preventDefault();
        moveLeft();
    });

    $('a.control_next').click(function (e) {
      e.preventDefault();
      moveRight();
    });
});

</script>
@stop
