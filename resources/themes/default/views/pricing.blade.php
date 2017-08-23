@extends('layouts.master')

@section('content')

<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Pricing
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->
<section class="section bg-gray">
    <div class="container">
        <div class="row gap-y text-center">
            <div class="col-12 col-md-6">
                <div class="pricing-1">
                    <p class="plan-name">Member</p>
                    <br />
            
                    <h2 class="price">free</h2>
                    <br />

                    <i class="ti-check text-success mr-8"></i><small>Join Sharing Networks</small><br>
                    <i class="ti-check text-success mr-8"></i><small>Exchange with Members</small><br>
                    <i class="ti-check text-success mr-8"></i><small>Sharing Network Trial</small><br>
                    <br />
                    <p class="text-center py-3"><a class="btn btn-malibu" href="#">Get started</a></p>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="pricing-1">
                    <p class="plan-name">Owner</p>
                    <br />
            
                    <h2 class="price"><span class="price-unit">$</span> 10<span class="price-unit">+/mo</span></h2>
                    <br />

                    <i class="ti-check text-success mr-8"></i><small>Own a Sharing Network</small><br>
                    <i class="ti-check text-success mr-8"></i><small>Up to 10 members</small><br>
                    <i class="ti-check text-success mr-8"></i><small>5 GB storage</small><br>

                    <br />
                    <p class="text-center py-3"><a class="btn btn-malibu" href="signup.html">Get started</a></p>
                </div>
            </div>

            <!--<div class="col-12 col-md-4">
            <div class="pricing-1">
            <p class="plan-name">Pro</p>
            <br>
            <h2 class="price"><span class="price-unit">$</span> 50<span class="price-unit">+</span></h2>
            <br>

            <small>Unlimited Members</small><br>
            <small>Priority support</small><br>
            <br>
            <p class="text-center py-3"><a class="btn btn-malibu" href="#">Contact Us</a></p>
            </div>
            </div> -->

        </div>
    </div>
</section>


<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| FAQ
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->
<section class="section">
    <div class="container">
        <header class="section-header">
            <small>Faq</small>
        
            <h2>Frequently Asked Questions</h2>
            <hr />
            <p class="lead">Please contact us if you couldn't find an answert to your question in the following list.</p>
        </header>


        <div class="row gap-y gap-3">
            <div class="col-12 col-md-6 col-lg-4">
                <h6 class="fw-400">Free account vs. a paid account?</h6>
                <p>Free accounts only let you join existing Sharing Networks. Owner accounts let you start your own.</p>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <h6 class="fw-400">Can I try all features for free?</h6>
                <p>Yes, we have a 30-day free trial for Sharing Networks that you make. You will not be billed until after this period. You can cancel anytime.</p>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <h6 class="fw-400">What payment services do you support?</h6>
                <p>We accept all major credit cards.</p>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <h6 class="fw-400">How do I update my plan and/or credit card details?</h6>
                <p>Please contact us to do so using the Help button on the bottom right of this page.</p>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <h6 class="fw-400">How long are your contracts?</h6>
                <p>You can upgrade, downgrade, or cancel your monthly account at any time with no further obligation.</p>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <h6 class="fw-400">Other questions?</h6>
                <p>We're always available by clicking the Help button on the bottom right of this page.</p>
            </div>
        </div>
    </div>
</section>

@stop
