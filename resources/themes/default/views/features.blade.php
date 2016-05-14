@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
            <div class="row feature-row">
                <div class="col-md-6" style="position:relative;">
                    <h2 class="feature-heading">Exchange How You Like</h2>
                    <p class="features-text">Set how your users can exchange on your own sharing website. Rent, Trade, Gift, Borrow, Buy/Sell or any combination of these you desire.</p>
                </div>

                <div class="col-md-6">
                    <img class="feature_image" src="{{ asset('assets/img/features/exchange_how_u_like.png') }}">
                </div>
            </div>

            <div class="row feature-row">
                <div class="col-md-6">
                    <img class="feature_image" src="{{ asset('assets/img/features/exchange_what_u_like.png') }}">
                </div>

                <div class="col-md-6">
                    <h2 class="feature-heading">Exchange What You Like</h2>
                    <p class="features-text">Any kind of thing, skill, knowledge, opportunity or anything you can think of can be exchanged.</p>
                </div>
            </div>

            <div class="row feature-row">
                <div class="col-md-6">
                    <h2 class="feature-heading">Interactive Entries View</h2>
                    <p class="features-text">Entries can be interacted in a powerful list view, with search and sortable columns. Plus download the entries in either csv, txt, json or xml formats.</p>
                </div>

                <div class="col-md-6">
                    <img src="{{ asset('assets/img/features/interactive_entries.png') }}">
                </div>
            </div>

            <div class="row feature-row">
                <div class="col-md-6">
                    <img src="{{ asset('assets/img/features/community.png') }}">
                </div>

                <div class="col-md-6">
                    <h2 class="feature-heading">Community</h2>
                    <p class="features-text">Build a community where members can find and communicate with each other.</p>
                </div>
            </div>

            <div class="row feature-row">
                <div class="col-md-6">
                    <h2 class="feature-heading">Unlimited Size</h2>
                    <p class="features-text">Sharing Websites can be from 1 - 100k members and from anyplace on the Earth.</p>
                </div>

                <div class="col-md-6">
                    <img src="{{ asset('assets/img/features/unlimited_size.png') }}">
                </div>
            </div>
            
            <div class="row feature-row">
                <div class="col-md-6">
                    <img src="{{ asset('assets/img/features/custom_look.png') }}">
                </div>

                <div class="col-md-6">
                    <h2 class="feature-heading">Custom Look &amp; Feel</h2>
                    <p class="features-text">Choose different colors, layouts, and branded themes for your Sharing Website.</p>
                </div>
            </div>

            <div class="row feature-row">
                <div class="col-md-6">
                    <h2 class="feature-heading">Full Privacy Control</h2>
                    <p class="features-text">Public, private, and secret Sharing Websites make it easy for you to control visibility.</p>
                </div>

                <div class="col-md-6">
                    <img src="{{ asset('assets/img/features/privacy_control.png') }}">
                </div>
            </div>

            <div class="row feature-row">
                <div class="col-md-6">
                    <img src="{{ asset('assets/img/features/social.png') }}">
                </div>
                
                <div class="col-md-6">
                    <h2 class="feature-heading">Social Media Sign up and Login</h2>
                    <p class="features-text">Your users can signup and login using Facebook, Twitter, Github or Google Plus.</p>
                </div>
            </div>

            <div class="row feature-row">
                <div class="col-md-6">
                    <h2 class="feature-heading">API</h2>
                    <p class="features-text">Access entries and user data through your own API.</p>
                </div>

                <div class="col-md-6">
                    <img src="{{ asset('assets/img/features/api.png') }}">
                </div>
            </div>

            <div class="row feature-row">
                <div class="col-md-6">
                    <img src="{{ asset('assets/img/features/slack.png') }}">
                </div>

                <div class="col-md-6">
                    <h2 class="feature-heading">Slack Integration</h2>
                    <p class="features-text">Your Sharing Website can integrate with Slack so you can receive notifications for new entries where your team best needs them.</p>
                </div>
            </div>

            <div class="row feature-row">
                <div class="col-md-6">
                    <h2 class="feature-heading">Google Analytics</h2>
                    <p class="features-text">Keep track of who’s visiting your Sharing Website and all the analytics that Google analytics brings you.</p>
                </div>

                <div class="col-md-6">
                    <img src="{{ asset('assets/img/features/google_anal.png') }}">
                </div>
            </div>
        </div>
    </div>
</div

@stop

