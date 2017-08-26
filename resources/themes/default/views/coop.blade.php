@extends('layouts.master')
@section('content')

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<section class="section overflow-hidden py-120 bg-grey">
    <div class="container">
        <div class="row">
            <div class="col-10 col-lg-6 text-center text-lg-left">
                <h3>The first complete Cooperative in the USA</h3>
                <p class="lead">AnyShare Society is the first company in the United States (and online company in the World) to include ALL stakeholder groups in voting and dividend sharing.</p>

                <p class="lead">This is a BIG milestone in how ethical companies are structured! It also lets anyone become an AnyShare cooperative member and support this movement!</p>


                <div class="partner-coop">
                    <a href="http://fairshares.coop" target="_blank"><img src="{{ asset('assets/corporate/img/coop-fairshares.png')}}" alt="FairShares"></a>
                    <a href="https://blog.p2pfoundation.net/why-anyshare-is-the-first-complete-cooperative-in-the-us/2017/04/03" target="_blank"><img src="{{ asset('assets/corporate/img/coop-p2p-foundation.png')}}" alt="P2P Foundation"></a>
                    <img src="{{ asset('assets/corporate/img/coop-coop-marque.png')}}" alt="Coop">
                </div>

            </div>

            <div class="col-lg-5 hidden-md-down align-self-center">
                <img src="{{ asset('assets/corporate/img/cooperative.jpg')}}" alt="..." data-aos="slide-left" data-aos-duration="1500">
            </div>
        </div>
    </div>
</section>


<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Section dialog
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->
<section class="section py-150" style="background-image: url({{ asset('assets/corporate/img/bg-coop-letter.jpg')}})" data-overlay="5">
    <div class="container">
        <div class="section-dialog text-justify">
            <h5>Dear Reader,</h5>
            <p>For over a decade, we've asked ourselves how our business can enhance everyone’s life… from Day 1. Today, it’s common for multi-national corporations to extract value from local communities. This does not have to be the case.</p>

            <p>Our path is revolutionary.</p>

            <p>AnyShare Society is the first “Complete Cooperative” in the United States. We are the first to structure ourselves so every group we impact can co-own, vote, and receive profits from our success. It is not business as usual, which aims to widen the gap between the rich and poor.</p>

            <p>We invite you to join us and co-create a business which will be a model in itself for businesses of the future. By doing this, you’re doing more than just supporting AnyShare Society… you’re creating an abundant future for us all!</p>

            <p>Sincerely,</p>

            <img src="{{ asset('assets/corporate/img/rob-jameson-signature.png')}}" alt="Rob Jameson">

            <img src="{{ asset('assets/corporate/img/eric_doriean_signature.png')}}" alt="Eric Doriean">

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
        <div class="row gap-y gap-3">
            <div class="col-12 col-md-4 feature-2">
                <h4 class="fw-400">What's it cost?</h4>
                <p>Coop Membership costs a once only <strong>US$50</strong> fee.</p>
                <p>To be active beyond the first year, all Coop Members need to spend $10 or contribute 1 hour of volunteer time within that year.</p>
            </div>

            <div class="col-12 col-md-4 feature-2">
                <h4 class="fw-400">As a Coop Member you receive:</h4>
                <p>
                    <i class="ti-check text-success mr-8"></i>Voting Rights - You can propose and vote on resolutions.<br />
                    <i class="ti-check text-success mr-8"></i>Dividends - 70% of Net Profits are distributed back to our members.<br />
                    <i class="ti-check text-success mr-8"></i>Access - to member-only resources
                </p>
            </div>

            <div class="col-12 col-md-4 feature-2">
                <h4 class="fw-400">Gateway to co-ownership</h4>
                <p>This makes you a Community Cooperative Member of AnyShare. If you'd like more substantial opportunities and rewards, consider joining our other stakeholder groups after you've become a Community Cooperative member.</p>
            </div>
        </div>

        <div class="pt-30 center">
            <h4 class="fw-400">Want to know more?</h4>
            <p>We've prepared a support website to answer any queries you may have. <a href="https://anyshare.freshdesk.com/support/solutions/folders/17000002903" target="_blank">Visit it here</a>.</p>
        </div>
    </div>
</section>



<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| CTA 7
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->

<section class="section text-center py-150" style="background-image: url({{ asset('assets/corporate/img/bg-thunder.jpg')}})" data-overlay="6">
    <div class="container">
        <h5 class="fs-30 text-white fw-300">21st Century Way to <strong>Be the Change</strong></h5>
    </div>
</section>



<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Content 2
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->

<section class="section">
    <div class="container">
        <div class="row gap-y align-items-center">
            <div class="col-sm-10 offset-sm-1 col-12">
                @if ($signedIn)
                <form method="post" action="#" id="payment-form" enctype="multipart/form-data" class="sky-form boxed">
                    {!! csrf_field() !!}
                    <header>
                        <h2>AnyShare Coop Registration</h2>
                    </header>

                    <fieldset class="nomargin padding-bottom-0">
                        <label class="input" for="name">Name:
                            <input data-name="Name" id="name" maxlength="256" name="name" placeholder="Enter your name" type="text">
                        </label>

                        <label class="input" for="email">Email Address:
                            <input data-name="Email" id="email" maxlength="256" name="email" placeholder="Enter your email address" required="required" type="email">
                        </label>

                        <div class="form-group">
                            <label class="input" for="field">Your Interest:
                                {{Form::select('interest', ['' => 'Pick an interest...',
                                'General' => 'General', 
                                'Supporting a good idea' => 'Supporting a good idea',
                                'Partnerships' => 'Partnerships',
                                'Equity' => 'Equity',
                                'Employment' => 'Employment'], null, ['required', 'class' => 'form-control'])}}
                            </label>
                        </div>

                        <label class="checkbox input">
                            {{ Form::checkbox('involved', '1', null) }}
                            <i></i> I'd like to see how I can get involved
                        </label>
                    </fieldset>

                    <fieldset class="nomargin padding-bottom-0">
                        <!-- Error box for payment errors -->
                        <div class="form-group payment-errors alert alert-mini alert-danger margin-bottom-10" style="display: none; margin-left: 15px;">
                        </div>

                        <div class="form-group" id="form-card-number">
                            <label for="card-number">Card Number *
                                <i class="fa fa-cc-visa help-text"></i>
                                <i class="fa fa-cc-amex"></i>
                                <i class="fa fa-cc-mastercard"></i>
                                <i class="fa fa-cc-diners-club"></i>
                                <i class="fa fa-cc-jcb"></i>
                                <i class="fa fa-cc-discover"></i>
                            </label>

                            <input id="card-number" type="text" class="card-number form-control input" size="20" data-stripe="number" {!! (!App::environment('production') ? ' value="4242424242424242"' : '') !!} />
                        </div>
                    </fieldset>

                    <fieldset class="nomargin padding-top-0">
                        <div class="row">
                            <div class="form-group col-md-3 col-sm-12">
                                <label for="exp_month" class="input">{{trans('general.community.month')}} *
                                    <input id="exp_month" type="text" class="card-expiry-month form-control" placeholder="01" {!! (!App::environment('production') ? ' value="01"' : '') !!} data-stripe="exp-month">
                                </label>
                            </div>

                            <div class="col-md-3 col-12">
                                <label for="exp_year" class="input">{{ trans('general.community.year') }} *
                                    <input id="exp_year" type="text" class="card-expiry-year form-control" placeholder="2016" {{ (date('Y') + 3) }}" {!! (!App::environment('production') ? ' value="'.(date('Y') + 3).'"' : '') !!} data-stripe="exp-year">
                                </label>
                            </div>

                            <div class="col-md-3 col-12">
                                <label for="cvc" class="input">{{ trans('general.community.cvc') }} *
                                    <input id="cvc" type="text" class="card-cvc form-control" placeholder="123" {!! (!App::environment('production') ? ' value="123"' : '') !!} data-stripe="cvc" />
                                </label>
                            </div>

                            <div class="fcol-lg-8 col-md-8 col-12">
                                <div class="payment-errors-generic alert alert-mini alert-danger margin-bottom-30" style="display: none">
                                    {{trans('general.community.wrong')}}
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <input class="btn btn-malibu margin-top-0" id="coop_signup" data-wait="Please wait..." type="submit" value="Join">

                    <footer class="form_note">
                        Note: This is for joining our cooperative. If you'd like to signup for the website, <a href="{{ route('login') }}" class="link">{{ trans('general.click_here') }}</a>.
                    </footer>
                </form>

                @else
                <h3 class="coop-now-heading">To become a Coop Member, please <a href="{{ route('login') }}"  class="malibu">{{ trans('general.nav.login') }} </a> or <a href="{{ route('register') }}" class="malibu">{{ trans('general.nav.register') }} </a> and return here to complete your application.</h3>
                @endif
            </div>
        </div>
    </div>
</section>



@section('moar_scripts')

<script type="text/javascript">
// This identifies your website in the createToken call below
Stripe.setPublishableKey('{{ config('services.stripe.key') }}');

$(function(){
  $('#payment-form').submit(function(event) {
    var $form = $(this);

    // Disable the submit button to prevent repeated clicks
    $('#create_community').prop('disabled', true);

    Stripe.card.createToken({
      number: $('.card-number').val(),
      cvc: $('.card-cvc').val(),
      exp_month: $('.card-expiry-month').val(),
      exp_year: $('.card-expiry-year').val()
    }, stripeResponseHandler);

    // Prevent the form from submitting with the default action
    return false;
  });
});

function stripeResponseHandler(status, response) {
  var $form = $('#payment-form');

  if (response.error) {
    // Show the errors on the form
    $('.payment-errors').show().text(response.error.message);
    $('.payment-errors-generic').show();
    $('#coop_signup').prop('disabled', false);
  }
  else {
    // response contains id and card, which contains additional card details
    var token = response.id;
    // Insert the token into the form so it gets submitted to the server
    $form.append($('<input type="hidden" name="stripeToken" />').val(token));
    // and submit
    $form.get(0).submit();
  }
};
</script>

@stop
@stop
