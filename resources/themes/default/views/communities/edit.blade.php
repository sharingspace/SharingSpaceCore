@extends('layouts/master')

{{-- Page title --}}
  @section('title')
    {{ trans('general.create') }} ::
  @parent
@stop


{{-- Page content --}}
@section('content')

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<!-- -->
<section>
	<div class="container margin-top-20">
		<div class="row">
      <!-- payment form -->
      <form method="post" action="#" id="payment-form" enctype="multipart/form-data" autocomplete="off" class="sky-form boxed clearfix">
        {!! csrf_field() !!}

        <header>
          <div class="col-12 text-muted">
            <h2>{!!trans('general.start_share') !!}</h2>
          </div>
        </header>

        <div class="row">
          <!-- LEFT TEXT -->
          <div class="col-sm-6 col-12">
            <fieldset class="nomargin">
              <!-- Name -->
              <div class="form-group {{ $errors->first('name', ' has-error') }}">
                <label for="name" class="input">{{trans('general.community.name')}} *
                  <input type="text" name="name" class="form-control" placeholder="{{trans('general.community.name_placeholder')}}" required="" value="{{ old('name') }}">
                  {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                </label>
              </div>

              <!-- Slug -->
              <div class="form-group {{ $errors->first('subdomain', ' has-error') }}" id="domain_input">
                <label for="subdomain" class="input">{{trans('general.community.subdomain')}} *
                  <div class="row margin-right-0">
                    <div class="col-8 padding-right-0">
                      <input type="text" size="20" name="subdomain" class="form-control" required="" value="{{ old('subdomain') }}">
                    </div>
                    <div class="col-4 anyshare_url">
                      .anyshare.coop
                    </div>
                  </div>
                  {!! $errors->first('subdomain', '<span class="help-block">:message</span>') !!}
                </label>
              </div>

              <!-- Type -->
              <div class="form-group {{ $errors->first('group_type', ' has-error') }}">
                <label for="share_privacy" class="input">{{trans('general.community.type')}}
                  {!! Form::community_types('group_type', Input::old('group_type', old('group_type'))) !!}
                  {!! $errors->first('group_type', '<span class="help-block">:message</span>') !!}
                </label>
              </div>
            </fieldset>
          </div> <!-- /LEFT TEXT -->

          <!-- PAYMENT -->
          <div class="col-sm-6 col-12">
            <fieldset class="nomargin">
              {{-- <h2 class="size-16 text-muted">{{ trans('general.community.payment_info') }}</h2> --}}

              <div class="row">
                <!-- Subscription -->
                <div class="form-group col-12">
                  <label for="cvc" class="input">{{ trans('general.community.sub_type') }} *
                    <select name="subscription_type">
                      <option value="MONTHLY-HUB-SUBSCRIPTION-10">{{ trans('general.community.monthly') }} ($10/{{ trans('general.community.month') }}) {{ trans('general.community.after_trial') }}</option>
                      <option value="ANNUAL-HUB-SUBSCRIPTION">{{ trans('general.community.annual') }} ($100/{{ trans('general.community.year') }})</option>
                    </select>
                  </label>
                </div>

                <!-- Error box for payment errors -->
                <div class="form-group col-12 payment-errors alert alert-mini alert-danger margin-bottom-10" style="display: none; margin-left: 15px;">
                </div>

                <div class="form-group col-12" id="form-card-number">
                  <label for="card-number" class="input">{{trans('general.community.card_num')}} *
                    <i class="fa fa-cc-visa help-text"></i>
                    <i class="fa fa-cc-amex"></i>
                    <i class="fa fa-cc-mastercard"></i>
                    <i class="fa fa-cc-diners-club"></i>
                    <i class="fa fa-cc-jcb"></i>
                    <i class="fa fa-cc-discover"></i>
                    <input id="card-number" type="text" class="card-number form-control" size="20" data-stripe="number" {!! (!App::environment('production') ? ' value="4242424242424242"' : '') !!} />
                  </label>
                </div>

                <div class="form-group col-md-3 col-sm-6 col-12">
                  <label for="exp_month" class="input">{{trans('general.community.month')}} *
                    <input id="exp_month" type="text" class="card-expiry-month form-control" placeholder="01" {!! (!App::environment('production') ? ' value="01"' : '') !!} data-stripe="exp-month">
                  </label>
                </div>

                <div class="form-group col-md-3 col-sm-6 col-12">
                  <label for="exp_year" class="input">{{ trans('general.community.year') }} *
                    <input id="exp_year" type="text" class="card-expiry-year form-control" placeholder=" {{ (date('Y') + 3) }}" {!! (!App::environment('production') ? ' value="'.(date('Y') + 3).'"' : '') !!} data-stripe="exp-year">
                  </label>
                </div>

                <div class="form-group col-md-3 col-sm-6 col-12">
                  <label for="cvc" class="input">{{ trans('general.community.cvc') }} *
                    <input id="cvc" type="text" class="card-cvc form-control" placeholder="123" {!! (!App::environment('production') ? ' value="123"' : '') !!} data-stripe="cvc" />
                  </label>
                </div>

                <div class="form-group col-md-3 col-sm-6 col-12 margin-bottom-5" id="coupon_question" style="cursor: pointer; ">
                  <span style="display:block;">{{trans('general.community.coupon')}} <i class="fa fa-ticket"></i></span>
                </div>

                <!-- Coupon -->
                <div class="form-group col-md-3 col-sm-6 col-12" id="coupon_field" style="display:none;">
                  <label for="coupon" class="sr-only">{{trans('general.community.coupon_code')}}
                    <input type="text" class="form-control col-md-6 col-sm-6" placeholder="" name="coupon"/>
                  </label>
                </div>

                <div class="form-group col-sm-8 col-12">
                  <div class="payment-errors-generic alert alert-mini alert-danger margin-bottom-10" style="display: none">
                    {{trans('general.community.wrong')}}
                  </div>
                </div>

                <div class="form-group col-sm-4 col-12 margin-top-10">
                  <button type="submit" class="btn btn-primary pull-right" id="create_community">{{trans('general.community.start_trial')}}</button>
                </div>
              </div>
            </div>
          </fieldset>
        </div>

        <footer>
          <div class="col-12">
            {{trans('general.community.p2')}} {{date('jS F, Y', strtotime("+30 days"))}}. {{trans('general.community.p3')}}
          </div>
        </footer>
      </form>
		</div>
	</div>
</section>
<!-- / -->

@section('moar_scripts')

      <script type="text/javascript">
        // This identifies your website in the createToken call below
        Stripe.setPublishableKey('{{ config('services.stripe.key') }}');
        // ...
      </script>

      <script>

      $(document).keydown(function() {
        var subdomain= $('input[name="subdomain"]').val();
        subdomain = subdomain.toLowerCase().replace(/ /g, '-');
        $('input[name="subdomain"]').val(subdomain);
      });


      $(function() {
        $("#coupon_question").click(function () {
            $("#coupon_field").animate({opacity: 'toggle'}, 'fast');
        });
      });

      function reportError(msg)
      {
        // Show the error in the form:
        $('.payment-errors').show().text(msg);
        $('.payment-errors-generic').show();

        // Re-enable the submit button:
        $('#create_community').prop('disabled', false);

        return false;
      }

      $(function() {
        $('#payment-form').submit(function(event) {
          var $form = $(this);
          error = false;

          // Disable the submit button to prevent repeated clicks
          $('#create_community').prop('disabled', true);

          // Get the values:
          var ccNum = $('.card-number').val();
          var cvcNum = $('.card-cvc').val();
          var expMonth = $('.card-expiry-month').val();
          var expYear = $('.card-expiry-year').val();

          // Validate the number:
          if (!Stripe.card.validateCardNumber(ccNum)) {
            error = true;
            reportError('The credit card number appears to be invalid.');
          }

          // Validate the CVC:
          if (!Stripe.card.validateCVC(cvcNum)) {
            error = true;
            reportError('The CVC number appears to be invalid.');
          }

          // Validate the expiration:
          if (!Stripe.card.validateExpiry(expMonth, expYear)) {
            error = true;
            reportError('The expiration date appears to be invalid.');
          }

          if (!error) {
            Stripe.card.createToken({
              number: ccNum,
              cvc: cvcNum,
              exp_month: expMonth,
              exp_year: expYear
            }, stripeResponseHandler);
          }

          // Prevent the form from submitting with the default action
          return false;
        });
      });

      function stripeResponseHandler(status, response)
      {
        if (response.error || (status != 200)) {
          // Show the errors on the form
          reportError(response.error.message);
        }
        else {
          // Get a reference to the form:
          var f = $('#payment-form');

          // response contains id and card, which contains additional card details
          var token = response.id;

          // Add the token to the form and submit
          f.append($('<input type="hidden" name="stripeToken" />').val(token));
          f.get(0).submit();
        }
      };
      </script>

  @stop
@stop
