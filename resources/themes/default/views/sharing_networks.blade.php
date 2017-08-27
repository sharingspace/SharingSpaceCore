@extends('layouts.master')

@section('content')

 
<section class="section overflow-hidden bg-grey py-120">
    <div class="container-wide">
        <div class="row">
            <div class="offset-1 col-10 col-lg-6 offset-lg-1 text-center text-lg-left">
                <div class="row gap-y">
                    <div class="col-12 col-md-6">
                        <h3 class="mb-3 medium"><i class="fa fa-th text-primary fs-25 mb-3"></i> Share whatever you like</h3>
                       <p class="fs-14">Share anything such as things, skills, knowledge, ideas, resources, opportunities, and more. There is lots of flexability in the content you add to a Sharing Network.</p>
                    </div>

                    <div class="col-12 col-md-6">
                        <h3 class="mb-3 medium"><i class="fa fa-refresh text-primary fs-25 mb-3"></i> Person to Person Exchange</h3>
                        <p class="fs-14">People can directly exchange with others in your Sharing Network, using the inbuilt messaging system. Share, Rent, Trade, Gift, Borrow, Buy/Sell or any combination of these you desire.</p>
                    </div>

                    <div class="col-12 col-md-6">
                        <h3 class="mb-3 medium"><i class="fa fa-sort-alpha-asc text-primary fs-25 mb-3"></i> Interact with Entries</h3>
                        <p class="fs-14">Use the powerful list view, with search and sortable columns. Plus download your Sharing Network entries (csv, txt, json and xml formats) to print out on paper for meetings.</p>
                    </div>

                    <div class="col-12 col-md-6">
                        <h3 class="mb-3 medium"><i class="fa fa-users text-primary fs-25 mb-3"></i> Groups, Communities, and more …</h3>
                        <p class="fs-14">Sharing Networks can be customized for various uses, including by communities, meetups, schools, art and STEM projects, crowdsourcing, bio blitzes, apartment complexes, farmers markets, and more!</p>
                    </div>
                </div>
            </div>


            <div class="col-lg-5 hidden-md-down align-self-center">
                <img class="shadow-3" src="{{ asset('assets/corporate/img/sn/browse.jpg')}}" alt="..." data-aos="slide-left" data-aos-duration="1500">
            </div>

            <div class="center-h mt-60">
                <a class="btn btn-sm btn-malibu" href="{{ route('_how_it_works') }}">
                    How it works<i class="fa fa-arrow-right fs-12 ml-8"></i>
                </a>
                <a class="btn btn-sm btn-malibu" href="{{ route('_sharing_examples') }}">
                    Examples<i class="fa fa-arrow-right fs-12 ml-8"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Feature 11
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->



<section class="section">
    <div class="container">
        <header class="section-header">
            <h2>Features</h2>
            <hr>
            <p class="lead">The 6 Core Features of a Sharing Network</p>
        </header>

        <div class="row gap-y align-items-center">
            <div class="col-12 col-md-5 center-vh">
                <img src="{{ asset('assets/corporate/img/sn/features/customize.png')}}" alt="Custom Look & Feel" width="200">
            </div>

            <div class="col-12 col-md-7 features-rp">
                <h3>Custom Look &amp; Feel</h3>
                <p>Choose different color palettes and custom branding for your Sharing Network.</p>
            </div>
        </div>

        <hr />

        <div class="row gap-y align-items-center">
            <div class="col-12 col-md-5 center-vh">
                <img src="{{ asset('assets/corporate/img/sn/features/privacy.png')}}" alt="Full Privacy Control" width="200">
            </div>

            <div class="col-12 col-md-7 features-rp">
                <h3>Full Privacy Control</h3>
                <p>Control the visibility of your Sharing Network with public, private, and secret (coming soon) levels of access.</p>
            </div>
        </div>

        <hr />

        <div class="row gap-y align-items-center">
            <div class="col-12 col-md-5 center-vh">
                <img src="{{ asset('assets/corporate/img/sn/features/onboard.png')}}" alt="Convenient Signups" width="200">
            </div>

            <div class="col-12 col-md-7 features-rp">
                <h3>Convenient Signups</h3>
                <p>Let your members join your Sharing Network using email or their social media accounts (Facebook, Twitter, Github and Google Plus).</p>
            </div>
        </div>

        <hr />

        <div class="row gap-y align-items-center">
            <div class="col-12 col-md-5 center-vh">
                <img src="{{ asset('assets/corporate/img/sn/features/api.png') }}" alt="API" width="200">
            </div>

            <div class="col-12 col-md-7 features-rp">
                <h3>API</h3>
                <p>Access entries and user data through your own API. View your data in real-time.</p>
            </div>
        </div>

        <hr />

        <div class="row gap-y align-items-center">
            <div class="col-12 col-md-5 center-vh">
                <img src="{{ asset('assets/corporate/img/sn/features/size.png') }}" alt="Multilingual" width="200">
            </div>

            <div class="col-12 col-md-7 features-rp">
                <h3>Multilingual</h3>
                <p>Sharing Networks can be translated into any language. Contact us, if you're willing and able to translate into the langauge of your choice.</p>
            </div>
        </div>

        <hr />

        <div class="row gap-y align-items-center">
            <div class="col-12 col-md-5 center-vh">
                <img src="{{ asset('assets/corporate/img/sn/features/interact.png')}}" alt="Analytics" width="200">
            </div>

            <div class="col-12 col-md-7 features-rp">
                <h3>Analytics</h3>
                <p>Keep track of who’s visiting your Sharing Network with all the analytics that Google Analytics brings you.</p>
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
