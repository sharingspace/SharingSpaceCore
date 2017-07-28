@extends('layouts.master')
@section('content')

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<div id="coop_page">
  <section id="imagine_coop" class="margin-top-30">
    <div class="container">
      <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-xs-12 letter-text">
          <p>Dear Reader,</p>

          <p>For over a decade, we've asked ourselves how our business can enhance everyone’s life&hellip; from Day 1. Today, it’s common for multi-national corporations to extract value from local communities. This does not have to be the case.</p> 

          <p>Our path is revolutionary.</p>

          <p>AnyShare Society is the first “Complete Cooperative” in the United States. We are the first to structure ourselves so every group we impact can co-own, vote, and receive profits from our success. It is not business as usual, which aims to widen the gap between the rich and poor.</p>

          <p>We invite you to join us and co-create a business which will be a model in itself for businesses of the future. By doing this, you’re doing more than just supporting AnyShare Society… you’re creating an abundant future for us all!</p>

          <p class="text-center">Sincerely,</p>

          <div class="row">
            <div class="col-xs-6 text-center">
              <div class="text-center">
                <img class="sig" src="{{asset('assets/img/coop/rob-jameson-signature.png')}}">
                <br>Rob Jameson
              </div>
            </div>
            <div class="col-xs-6 text-center">
              <div class="text-center">
                <img class="sign2" src="{{asset('assets/img/coop/eric_doriean_signature.png')}}">
                <br>Eric Doriean
              </div>
            <div>
          </div>
        </div>
      </div> <!-- row -->
    </div> <!-- container -->
  </section>

  <section class="margin-top-20">
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">

          @if ($signedIn)
          <h4 class="form_header">AnyShare Coop Member Registration Form</h4>
          <div class="form_note">
            Note: This is for joining our cooperative. If you'd like to signup for the website, go <a href="{{ route('login') }}" class="link">here</a>.
          </div>

          <form method="post" action="#" id="payment-form" enctype="multipart/form-data">
            {!! csrf_field() !!}

            <label class="field" for="name">Name:</label>
            <input  data-name="Name" id="name" maxlength="256" name="name" placeholder="Enter your name" type="text">

            <label class="field" for="email">Email Address:</label>
            <input data-name="Email" id="email" maxlength="256" name="email" placeholder="Enter your email address" required="required" type="email">

            <div class="form-group">
              <label class="field" for="field">Your Interest:</label>
              {{Form::select('interest', ['' => 'Pick an interest...',
                                          'General' => 'General', 
                                          'Supporting a good idea' => 'Supporting a good idea',
                                          'Partnerships' => 'Partnerships',
                                          'Equity' => 'Equity',
                                          'Employment' => 'Employment'], null, ['required', 'class' => 'form-control'])}}
            </div>

            <label class="checkbox">
             {{ Form::checkbox('involved', '1', null) }}
              <i></i> I'd like to see how I can get involved
            </label>

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

              <input id="card-number" type="text" class="card-number form-control" size="20" data-stripe="number" {!! (!App::environment('production') ? ' value="4242424242424242"' : '') !!} />
            </div>

            <div class="row">
              <div class="form-group col-md-3 col-sm-12">
                <label for="exp_month">{{trans('general.community.month')}} *</label>
                <input id="exp_month" type="text" class="card-expiry-month form-control" placeholder="01" {!! (!App::environment('production') ? ' value="01"' : '') !!} data-stripe="exp-month">
              </div>

              <div class="form-group col-md-3 col-sm-12">
                <label for="exp_year">{{ trans('general.community.year') }} *</label>
                <input id="exp_year" type="text" class="card-expiry-year form-control" placeholder="2016" {{ (date('Y') + 3) }}" {!! (!App::environment('production') ? ' value="'.(date('Y') + 3).'"' : '') !!} data-stripe="exp-year">
              </div>

              <div class="form-group col-md-3 col-sm-12">
                <label for="cvc">{{ trans('general.community.cvc') }} *</label>
                <input id="cvc" type="text" class="card-cvc form-control" placeholder="123" {!! (!App::environment('production') ? ' value="123"' : '') !!} data-stripe="cvc" />
              </div>

              <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="payment-errors-generic alert alert-mini alert-danger margin-bottom-30" style="display: none">
                {{trans('general.community.wrong')}}
                </div>
              </div>

              <input class="submit" id="coop_signup" data-wait="Please wait..." type="submit" value="Join">
            </div>
          </form>
          @else
            <h3 class="coop-now-heading">To become a Coop Member, please <a href="{{ route('login') }}" class="">{{ trans('general.nav.login') }} </a> or <a href="{{ route('register') }}" class="btn btn-primary">{{ trans('general.nav.register') }} </a> and return here to complete your application.</h3>
          @endif
          <div class="w-form-done">
            Thank you! Your submission has been received!
          </div>
          <div class="w-form-fail">
            Oops! Something went wrong while submitting the form
          </div>

          <div class="text-center margin-top-30 margin-bottom-30">
            <a class="learn-more" href="#faq">Learn More</a>
        </div>
      </div>
    </div>
  </section>

  <section class="we_celebrate margin-top-30">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2 col-xs-12">
          <div class="quote">
            "&hellip;[We] celebrate how cooperatives build a better world by advancing sustainable development, social integration and decent work."
          </div>
          <div class="quote citation margin-bottom-30">- BAN KI MOON 
            <br><strong><em class="text-light">SECRETARY GENERAL OF UNITED NATIONS</em></strong>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container margin-top-30">
      <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-xs-12">
          <h2 id="faq">Learn More&hellip;</h2>
          
          <div class="row">
            <div class="col-sm-6 col-xs-12">
              <h5>Coop Membership costs a once only US $50 fee</h5>
              <p>To be active beyond the first year, all Coop Members need to spend $10 or contribute 1 hour of volunteer time within that year.</p>

              <h5>As a Coop Member you receive:</h5>
              <ul class="padding-left-20">
                <li>Voting Rights&nbsp;- You can propose and vote on resolutions.</li>
                <li>Dividends&nbsp;- 70% of Net Profits are distributed back to our members</li>
                <li>Access&nbsp;- to member-only resources</li>
              </ul>
            </div>
            <div class="col-sm-6 col-xs-12">
              <h5>This is the gateway to co-ownership</h5>
              <p>This makes you a cooperative member of AnyShare. If you'd like more substantial opportunities and rewards, consider joining our other stakeholder groups after you've completed the above membership.</p>
              <h5>Want to know more?</h5>
              <p>We've prepared a support website to answer any queries you may have.&nbsp;Visit it <a href="https://anyshare.freshdesk.com/support/solutions/folders/17000002903" target="_blank">here</a>.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="margin-top-20">
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-md-offset-2 text-center">
          <a href="http://www.fairshares.coop/" target="_blank">
            <img class="logo-for-fs" src="http://uploads.webflow.com/55eb2906a5a3360b1a16c05f/583692acb333a5214d2ad429_Screen%20Shot%202016-11-24%20at%2012.10.35%20AM.png">
          </a>
          <div class="fs-pitch">AnyShare Society is a FairShares Company</div>
        </div>
      </div>
    </div>
  </section>


  <section class="cta margin-top-30">
    <div class="container margin-top-20 text-center">
      <div class="row text-muted">
        <div class="col-md-9">
          <h2 class="white-secondary-heading">{{ trans('coop.make')}}</h2>
        </div>
        <div class="col-md-3">
          <a href="{{route('community.create.form')}}" class="w-button cta-button contained-button size-20">{{ trans('coop.start')}}</a>
        </div>
      </div>
    </div>
  </section>
</div>


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
  } else {
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
