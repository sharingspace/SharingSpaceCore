@extends('layouts.master')
@section('content')

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<section id="imagine_coop" class="padding-xxs">
  <div class="container">

    <div class="row">
      <div class="col-md-12">
        <h3 class="margin-bottom-30 text-center">Imagine a Cooperative Business where everyone impacted has a voice and a share in the profits</h3>
      </div>
      <div class="col-md-6">
        <p class="lead">AnyShare is making this vision a reality. We are the first business in the USA ever to include all stakeholder groups - and the first internet company in the world to do so too.</p>
        <p class="lead">Founders, Investors, Employees, Customers AND Nature all benefit from our success.</p>
      </div> <!-- col-md-6 -->

      <div class="col-md-6">
      <img class="coop-image" src="/assets/img/coop/cooperative_tablet.jpg">
      <div class="small">
        <a target="_blank" href="http://creativecommons.org/licenses/by-sa/3.0/" rel="noopener noreferrer">CC BY-SA 3.0</a> Creator: <a target="_blank" href="http://nyphotographic.com/" rel="noopener noreferrer">NY</a>
      </div>
      </div> <!-- col-md-6 -->
    </div> <!-- row -->
  </div> <!-- container -->
</section>


<section id="we-the-people">
  <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="quote">"Without democratizing our economy we will just not have the kind of society that we want to have, or that we claim to have. We are just not going to be a democracy."</div>
          <div class="quote citation margin-bottom-30">- John Duda, Democracy Collaborative</div>
        </div>
    </div>
  </div>
</section>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="small pull-right">
        <a target="_blank" href="https://creativecommons.org/licenses/by/2.0/" rel="noopener noreferrer">CC BY 2.0</a>&nbsp;Creator:&nbsp;<a href="http://www.rollingrebellion.org/" target="_blank" rel="noopener noreferrer">Rolling Rebellion for Real Democracy</a>
      </div>
    </div>
  </div>
</div>

<section id="fairshairs">
  <div class="container text-center">
      <div class="row">
        <div class="col-md-6">
          <img src="/assets/img/coop/FairShares-logo.png">
          <p class="margin-top-20">AnyShare is a FairShares Cooperative.</p>
          <p>FairShares is a philosophy for creating and sustaining multi-stakeholder Cooperatives that share power and wealth amongst their entrepreneurs (founders), producers (employees), consumers (customers) and investors. AnyShare also chooses to pay a percentage of our profits to environmental causes to make us the first complete Cooperative in the USA.</p>
          <p><a href="http://fairshares.coop" rel="noopener">For more information visit the FairShares Website</a></p>
        </div>
        
        <div class="col-md-6 margin-top-20">
          <img src="/assets/img/coop/coop_logo.png" alt="co op">
          
          <p class="margin-top-20">A Cooperative (also known as coop, co-operative or co-op) is an autonomous association of people united voluntarily to meet their common economic, social, and cultural needs and aspirations through a jointly owned and democratically controlled business.</p>
          <p>As businesses driven by values not just profit, Cooperatives share internationally agreed principles and act together to build a better world through co-operation.</p>
          <p><a href="http://ica.coop/en/whats-co-op/co-operative-identity-values-principles" rel="noopener">Learn about the Cooperative Principles</a></p>
        </div>
      </div>
      <!-- /FEATURED BOXES 3 -->
    </div>
  </section>
  <!-- / -->

<section id="people-power">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="quote">
         "We cannot waste any more time. Politicians and platform owners have been promising social protections, access, and privacy, but we are demanding ownership. It’s time to realize that they will never deliver. They can’t. But we must."
        </div>
      </div>
      <div class="quote citation">- Trebor Scholz</div>
    </div>
  </div>
</section>

<section id="become_member">
  <div class="container">
    <h3 class="backstory-heading">Become a Coop Member Now</h3>
    <div class="row">
      <div class="col-md-6">
        <h4>Coop Membership costs a once only US $50 fee</h4>
        <p>To be an active Coop Member beyond the first year, all Coop Members need to do is spend a minimum of $10 within&nbsp;the year with AnyShare or add 10 entries to any Sharing Website.</p>
        <h4>As a Coop Member you receive:</h4>
        <h5>Voting Rights</h5>
        <p>You get to propose and vote on resolutions in our Annual General Meeting.</p>
        <h5>Dividends</h5>
        <p>70% of Net Profits are distributed back to Founders, Investors, Employees, Customers and Nature each year.</p>
        <h5>Access to Coop Member only resources</h5>
        <p>We will create online resources for Coop Members only.</p>
        <h5>Knowledge you're making a real positive impact</h5>
        <p>Becoming a Coop Member supports not only AnyShare, but a whole new way of doing business. AnyShare's success will encourage other businesses to share their success with everybody as well.</p>
      </div>

      <div class="col-md-6">
        <h4>Want to know more?</h4>
        <p>We've prepared a Frequently Asked Questions to answer any queries you may have. If after reading the FAQ you still aren't clear, please contact the AnyShare support team and they will happily answer any questions you may have.</p>

        <p><a href="https://anyshare.freshdesk.com/support/solutions/17000001928" rel="noopener">Visit the Frequently Asked Questions</a></p>

        <h3 class="coop-now-heading">Fill in the following to become an AnyShare Coop Member</h3>
        <!-- payment form -->
        <form method="post" action="#" id="payment-form" enctype="multipart/form-data" autocomplete="off">
            {!! csrf_field() !!}

        <!-- Error box for payment errors -->
          <div class="form-group col-md-12 payment-errors alert alert-mini alert-danger margin-bottom-10" style="display: none; margin-left: 15px;">
          </div>
          <div class="form-group col-md-12 col-sm-12">
            <label class="coop-form-headings" for="name">Name:</label>
            <input class="w-input" data-name="Name" id="name" maxlength="256" name="name" value="David"  placeholder="Enter your name" type="text">
            <label class="coop-form-headings" for="email">Email Address:</label>
            <input class="w-input" data-name="Email" value="dslinnard@yahoo.com" id="email" maxlength="256" name="email" placeholder="Enter your email address" required="required" type="email">
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

            <input id="card-number" type="text" class="card-number form-control" size="20" data-stripe="number" value="4242424242424242" />
          </div>

          <div class="form-group col-md-3 col-sm-12">
            <label for="exp_month">Month *</label>
            <input id="exp_month" type="text" class="card-expiry-month form-control" value="01" data-stripe="exp-month">
          </div>

          <div class="form-group col-md-3 col-sm-12">
            <label for="exp_year">Year *</label>
            <input id="exp_year" type="text" class="card-expiry-year form-control" value="2019" data-stripe="exp-year">
          </div>

          <div class="form-group col-md-3 col-sm-12">
            <label for="cvc">CVC *</label>
            <input id="cvc" type="text" class="card-cvc form-control" value="123" data-stripe="cvc" />
          </div>

          <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 nomargin clearfix">
            <button type="submit" class="btn btn-primary" id="coop_signup">Signup</button>
          </div>

          <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <div class="payment-errors-generic alert alert-mini alert-danger margin-bottom-30" style="display: none">
              Something went wrong :(
            </div>
          </div>
        </form>
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
