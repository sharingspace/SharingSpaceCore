@extends('layouts.master')

@section('content')

 
<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| How it work steps
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->
<section class="section">
    <div class="container">
        <div class="row gap-y align-items-center mb-90">
            <div class="col-12 col-md-6 text-center hidden-sm-down">
                <img src="{{ asset('assets/corporate/img/sn/browse.jpg') }}" alt="...">
            </div>

            <div class="col-12 col-md-5 offset-md-1 text-center text-md-left">
                <p class="fs-60 fw-900 opacity-10">01</p>
                <h3 class="fw-300">Browse Entries</h3>
                <p>Browse and search what your community or group has added.</p>
            </div>
        </div>


        <div class="row gap-y align-items-center mb-90">
            <div class="col-12 col-md-5 text-center text-md-left">
                <p class="fs-60 fw-900 opacity-10">02</p>
                <h3 class="fw-300">Add Entries</h3>
                <p>Easily add skills, things, knowledge or ideas. Both what you want and have to share.</p>
            </div>

            <div class="col-12 col-md-6 offset-md-1 text-center hidden-sm-down">
                <img src="{{ asset('assets/corporate/img/sn/add.jpg') }}" alt="...">
            </div>
        </div>


        <div class="row gap-y align-items-center mb-90">
            <div class="col-12 col-md-6 text-center hidden-sm-down">
                <img src="{{ asset('assets/corporate/img/sn/offer.jpg') }}" alt="...">
            </div>

            <div class="col-12 col-md-5 offset-md-1 text-center text-md-left">
                <p class="fs-60 fw-900 opacity-10">03</p>
                <h3 class="fw-300">Make Offers</h3>
                <p>Use the inbuilt messaging or comments system to exchange or discuss.</p>
            </div>
        </div>
    </div>
</section>



<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| CTA 4
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->

<section class="section section-inverse" style="background-image: url({{ asset('assets/corporate/img/signup.png')}}" data-overlay="7">
    <div class="container">
        <div class="row gap-y align-items-center">
            <div class="col-12 col-md-6 text-center text-md-left">
                <h4 class="mb-0"><center>Start a Sharing Network free for 30 days!</center></h4>
            </div>

            <div class="col-12 col-md-6 text-center text-md-right">
                <div class="center-vh">
                    <a class="btn btn-lg btn-malibu" href="{{ route('register') }}">Get Started<i class="fa fa-arrow-right fs-15 ml-8"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>


@stop
