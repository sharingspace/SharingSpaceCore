@extends('layouts.master')

@section('content')

   <!-- Main container -->
    <main class="main-content">

      <!--
      |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
      | Feature 5
      |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
      !-->
      <section class="section p-0" id="section-intro">
        <div class="container-wide bg-grey">
          <div class="row no-gap text-center">

            <div class="col-12 col-md-6 p-70">
              <div style="position: relative;">
                <div>
                  <img src="{{ asset('assets/corporate/img/sn-screenshot-fp.jpg')}}" class="shadow-2 rounded" alt="Sharing Networks">
                </div>
                <br /><br />
                <h3>Sharing Networks</h3>
                <div class="max-300 mx-auto text-center">
                  <p>Cloud-based solution for sharing within a community or group.</p>
                </div>
                <div class="center-vh"><a class="btn btn-sm btn-malibu" href="{{ route('_sharing_networks') }}">Learn More<i class="fa fa-arrow-right fs-12 ml-8"></i></a></div>
              </div>
            </div>


            <div class="col-12 col-md-6 p-70">
              <div style="position: relative;">
                <div>
                  <img src="{{ asset('assets/corporate/img/ss-screenshot-fp.jpg')}}" class="shadow-2 rounded" alt="Sharing Spaces">
                </div>
                <br /><br />
                <h3>Sharing Spaces</h3>
                <div class="max-300 mx-auto text-center">
                  <p>Enhance sharing in physical spaces with smart displays.</p>
                </div>
                <center><a class="btn btn-sm btn-malibu" href="{{ route('_sharing_spaces') }}">Learn More<i class="fa fa-arrow-right fs-12 ml-8"></i></a></center>
            </div>
          </div>
          </div>
        </div>
      </section>

      <!--
      |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
      | CTA 4
      |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
      !-->

      <section class="section section-inverse" style="background-image: url({{ asset('assets/corporate/img/signup.png')}})" data-overlay="7">
        <div class="container">
          <div class="row gap-y align-items-center">
            <div class="col-12 col-md-6 text-center text-md-left">
              <h4 class="mb-0"><center>Start a Sharing Network free for 30 days!</center></h4>
            </div>

            <div class="col-12 col-md-6 text-center text-md-right">
              <div class="center-vh"><a class="btn btn-lg btn-malibu" href="{{ route('register') }}">Get Started<i class="fa fa-arrow-right fs-15 ml-8"></i></a></div>
            </div>
          </div>
        </div>
      </section>

 
@section('moar_scripts')
@stop

@stop
