@extends('layouts.master')

@section('content')

 
<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Request form
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-5 align-self-center text-center">
                <h3 class="heading-alt fw-300">Join the Waitlist</h3><br />
                <p>Simply fill in your details below. The first 1000 people to signup are eligible for early access and discounts.</p>
                <br />

                <form action="https://anysha.us4.list-manage.com/subscribe/post?u=1d066d4c6fdd81c10e74307cc&amp;id=46d1651b63" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Name" name="NAME" NAMEid="mce-NAME">
                    </div>

                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Company name (optional)" name="ONAME" id="mce-ONAME">
                    </div>

                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Email" name="EMAIL" id="mce-EMAIL">
                    </div>

                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Phone number" name="PHONE" id="mce-PHONE">
                    </div>

                    <button class="btn btn-malibu btn-block" type="submit" name="subscribe" id="mc-embedded-subscribe">Join Wait List</button>
                </form>
            </div>

            <div class="col-12 offset-lg-1 col-lg-6 p-90 hidden-md-down">
                <img src="{{ asset('assets/corporate/img/ss/ss-kiosk2.png') }}" alt="Sharing Spaces" data-aos="fade-up">
            </div>
        </div>
    </div>
</section>

@stop
