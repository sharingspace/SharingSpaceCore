@extends('layouts.master')
@section('content')

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<section id="imagine_coop" class="margin-top-30">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <p class="lead">Imagine a cooperative business where everyone can share their voice and the profits. AnyShare is making this vision a reality!</p>
        <p class="lead">AnyShare is the the first business ever in the United States to share voting and profits with all stakeholder groups! We're also the first internet company in the world to it... whoo hoo! Read on to learn more...</p>
      </div>

      <div class="col-md-6 col-sm-6 hidden-xs">
        <img class="img-responsive" src="{{ Helper::cdn('img/coop/sparkler.jpg') }}">
      </div> <!-- col-md-6 -->
    </div> <!-- row -->
  </div> <!-- container -->
</section>

<section class="BanKiMoon margin-top-20">
  <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="quote">"...[We] celebrate how cooperatives build a better world by advancing sustainable development, social integration and decent work."</div>
          <div class="quote citation margin-bottom-30">- Ban Ki Moon
            <br><strong><em class="text-light">Secretary General of United Nations</em></strong>
          </div>
        </div>
    </div>
  </div>
</section>

<section>
  <div class="container margin-top-30">
    <div class="row">
      <div class="col-lg-8 col-md-7 col-sm-6 col-xs-12">
        <p class="lead">A Cooperative is collectively owned business that lets people meet economic, social, and cultural needs and aspirations together!</p>
        <p class="lead">AnyShare is a special type of cooperative called "FairShares." This is a way for managing the ways types of members, including employees, customers, founders, and investors!</p>
      </div>
      <div class="col-lg-4 col-md-5 col-sm-6 hidden-xs">
        <img class="img-responsive" style="max-width:300px;" src="{{ Helper::cdn('img/coop/coop-logos.jpg') }}">
      </div>
    </div>
  </div>
</section>

<section class="JohnDuda margin-top-20">
  <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="quote">
            "Without democratizing our economy we will just not have the kind of society that we want to have, or that we claim to have. We are just not going to be a democracy."
          </div>
          <div class="quote citation margin-bottom-30">- John Duda, PhD.
            <br><strong><em class="text-light">Director of Communications at Democracy Collaborative</em></strong>
          </div>
        </div>
    </div>
  </div>
</section>

<section>
  <div class="container margin-top-30">
    <div class="row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <p class="lead">By design, corporations benefit only the richest people, silence the people they impact, and hurt our environment.</p>
        <p class="lead">AnyShare lets anyone shape and share in the benefits of our work. Our mission is to end scarcity through community. This serious work is possible through members like you!</p>
      </div>
      <div class="col-md-6 col-sm-6 hidden-xs">
        <img class="img-responsive" src="{{ Helper::cdn('img/coop/blindFold.jpg') }}">
      </div>
    </div>
  </div>
</section>

<section class="TreborScholz margin-top-20">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="quote">
         "We cannot waste any more time. Politicians and platform owners have been promising social protections, access, and privacy, but we are demanding ownership. It’s time to realize that they will never deliver. They can’t. But we must."
        </div>
        <div class="quote citation">
          - Trebor Scholz
          <br><strong><em class="text-light">Director of Communications at Democracy Collaborative</em></strong>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="become_member margin-top-30">
  <div class="container">
    <h3 class="backstory-heading">Join the AnyShare Cooperative!</h3>
    <div class="row">
      <div class="col-md-6">
        <h4>Coop Membership costs a once only US $50 fee</h4>
        <p class="body-text">To be an active Coop Member beyond the first year, all Coop Members need to do is spend a minimum of $10 within&nbsp;the year with AnyShare or add 10 entries to any Sharing Website.</p>
        
        <h4>As a Coop Member you receive:</h4>
        <p class="body-text features-of-coop"><strong>Voting Rights</strong> - You can propose and vote on resolutions.
        <br>
        <strong>Dividends</strong> - 70% of Net Profits are distributed back to our members.
        <br>
        <strong>Access</strong> - to member-only resources
        <br><strong>Insight</strong> - you're making a real positive impact</p>
        
        <h4>Want to know more?</h4>
        <p class="body-text">We've prepared a FAQ to answer any queries you may have. <a href="https://anyshare.freshdesk.com/support/solutions/17000001928" rel="noopener noreferrer" target="_blank">Visit the Frequently Asked Questions</a>.</p>
      </div>

      <div class="col-md-6">
        <div class="coop-member-now-div">
        @if ($signedIn)
          <h3 class="coop-now-heading">Fill in the following to become an AnyShare Coop Member</h3>
          <!-- payment form -->
          <form method="post" action="#" id="payment-form" enctype="multipart/form-data" autocomplete="off">
            {!! csrf_field() !!}

            <!-- Error box for payment errors -->
            <div class="form-group col-md-12 payment-errors alert alert-mini alert-danger margin-bottom-10" style="display: none; margin-left: 15px;">
            </div>
        
            <div class="form-group col-md-12 col-sm-12" id="form-card-number">
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

            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 nomargin clearfix">
              <button type="submit" class="btn btn-primary" id="coop_signup">Signup</button>
            </div>

            <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
              <div class="payment-errors-generic alert alert-mini alert-danger margin-bottom-30" style="display: none">
              {{trans('general.community.wrong')}}
              </div>
            </div>
          </form>
        @else
          <h3 class="coop-now-heading">To become a Coop Member, please sign-in or sign-up and return here to complete your application.</h3>
          <p>
            <a href="{{ route('login') }}" class="btn btn-primary">{{ trans('general.nav.login') }} </a>
            <a href="{{ route('user.register') }}" class="btn btn-primary">{{ trans('general.nav.register') }} </a>
          </p>
        @endif
        </div>
      </div>
    </div>
  </div>
</section>
<!-- / -->

@section('moar_scripts')

<script type="text/javascript">
// This identifies your website in the createToken call below
Stripe.setPublishableKey('pk_test_TVE0hOGlAHi679PKRgU3R3wi');

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
