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

p {
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
  <div class='page_banner coop_banner'>
    <h1>{{trans('pricing.headline') }}</h1>
  </div>
</section>

<section id="why" class="padding-xxs">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <p>AnySha.re is a Cooperative, Anysha.re is a FairShares Coop. Become a member 
        for discounts, a vote, and to share our profits. Learn more</p>

        <p>This means that you can "own" part of the network website you use here. 
        That means you share profits AND can change the direction we grow.</p>

        <p>A FairShares Cooperative is a new form of business structure where all 
        people are seen as shareholders. You, reader, can join us as customers, employees, and investors.</p> 

        <p>To join as a member, you can buy a one-time life membership for $60. 
        As long as you're actively using Anyshare by logging in 2x per month, 
        you will have unlimited votes on our policies (one vote per topic), 
        and receive payouts from dividends of our profits each year. Click here</p>

        <p>To join as an employee, see our current needs list on our hub here. 
        Feel free to propose ideas as well! WE are super flexible with win/win 
        employment contracts for equity, but we must measure results. Click here</p>

        <p>To join as an investor, you can signup for learn when our equity 
        crowdfund goes live! This will let you purchase shares directly thanks to 
        a new change in US Secutities law that anyone can fund companies (and coops!) 
        that will change the world. Click here.</p>
      </div> <!-- col-md-12 -->
    </div>
 
  </div> <!-- container -->
</section>


  <section id="features">
    <div class="container">
      <div class="table-responsive">
        <table class="table" style="color:#222;font-size:18px;font-weight:500;">
          <thead>
            <tr style="background-color:#ddd;"><th style="width:60%;">Feature</th>
            <th>Regular</th>
            <th>Members</th></tr>
          </thead>
          <tbody>
            <tr><td>Your own subdomain</td><td>X</td><td>X</td></tr>
            <tr><td>Unlimited members Hello this is an simple example of the usage of [tooltip title="Tooltip shortcode"] tooltip[/tooltip] shortcode</td><td>X</td><td>X</td></tr>
            <tr><td>Unlimited listings</td><td>X</td><td>X</td></tr>
            <tr><td>Email and social media sign up </td><td></td><td>X</td></tr>
            <tr><td>Customizable design<td></td><td>X</td></tr><tr><td>Your choice of exchange types
            <tr><td>Open or closed community<td></td><td>X</td></tr>
            <tr><td>Multiple Views (List, Grid and Map)<td></td><td>X</td></tr>
            <tr><td>Advanced Search<td></td><td>X</td></tr>
            <tr><td>Multi language support JSON RESTful API Google Analytics<td></td><td>X</td></tr>
            <tr><td>JSON RESTful API<td></td><td>X</td></tr>
            <tr><td>Google Analytics<td></td><td>X</td></tr>
            <tr><td><span class="sr-only">Price</span></td><td><a href="{{ route('community.create.form') }}" class="btn btn-primary" style="font-size:20px;">$10 / Month</a></td><td><a href="{{ route('community.create.form') }}" class="btn btn-primary" style="font-size:20px;">$6 / Month</a></td>           
          </tbody>
        </table>
      </div> 
    </div>
  </section>
  <!-- / -->


<script>

jQuery(document).ready(function ($) {


});

</script>
@stop
