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
      <form method="post" action="#" id="payment-form" enctype="multipart/form-data" autocomplete="off" class="clearfix row">
        {!! csrf_field() !!}

        <div class="col-xs-12 text-muted">
          <p>{{trans('general.community.p2')}} {{date('jS F, Y', strtotime("+30 days"))}}. {{trans('general.community.p3')}}</p>
        </div>

        <!-- LEFT TEXT -->
        <div class="col-sm-6 col-xs-12">
          <!-- Name -->
          <div class="form-group{{ $errors->first('name', ' has-error') }}">
            <label for="name">{{trans('general.community.name')}} *</label>
            <input type="text" name="name" class="form-control" placeholder="{{trans('general.community.name_placeholder')}}" required="" value="{{ old('name') }}">
            {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
          </div>

          <!-- Slug -->
          <div class="form-group{{ $errors->first('subdomain', ' has-error') }}" id="domain_input">
            <label for="subdomain">{{trans('general.community.subdomain')}} *</label>
            <div class="row margin-right-0">
              <div class="col-xs-8 padding-right-0">
                <input type="text" size="20" name="subdomain" class="form-control" required="" value="{{ old('subdomain') }}">
              </div>
              <div class="col-xs-4 anyshare_url">
                .anyshare.coop
              </div>
            </div>
            {!! $errors->first('subdomain', '<span class="help-block">:message</span>') !!}
          </div>

          <!-- Type -->
          <div class="form-group{{ $errors->first('group_type', ' has-error') }}">
            <label for="group_type">{{trans('general.community.type')}}</label>
            {!! Form::community_types('group_type', Input::old('group_type', old('group_type'))) !!}
            {!! $errors->first('group_type', '<span class="help-block">:message</span>') !!}
          </div>
        </div> <!-- /LEFT TEXT -->

        <!-- PAYMENT -->
        <div class="col-sm-6 col-xs-12">
          {{-- <h2 class="size-16 text-muted">{{ trans('general.community.payment_info') }}</h2> --}}

          <div class="row">
            <!-- Subscription -->
            <div class="form-group col-xs-12">
              <label for="cvc">{{ trans('general.community.sub_type') }} *</label>
              <select class="form-control" name="subscription_type">
                <option value="MONTHLY-HUB-SUBSCRIPTION-10">{{ trans('general.community.monthly') }} ($10/{{ trans('general.community.month') }}) {{ trans('general.community.after_trial') }}</option>
                <option value="ANNUAL-HUB-SUBSCRIPTION">{{ trans('general.community.annual') }} ($100/{{ trans('general.community.year') }})</option>
              </select>
            </div>

            <!-- Error box for payment errors -->
            <div class="form-group col-xs-12 payment-errors alert alert-mini alert-danger margin-bottom-10" style="display: none; margin-left: 15px;">
            </div>

            <div class="form-group col-xs-12" id="form-card-number">
              <label for="card-number">{{trans('general.community.card_num')}} *
                <i class="fa fa-cc-visa help-text"></i>
                <i class="fa fa-cc-amex"></i>
                <i class="fa fa-cc-mastercard"></i>
                <i class="fa fa-cc-diners-club"></i>
                <i class="fa fa-cc-jcb"></i>
                <i class="fa fa-cc-discover"></i>
              </label>
              <input id="card-number" type="text" class="card-number form-control" size="20" data-stripe="number" {!! (!App::environment('production') ? ' value="4242424242424242"' : '') !!} />
            </div>

            <div class="form-group col-md-3 col-sm-6 col-xs-12">
              <label for="exp_month">{{trans('general.community.month')}} *</label>
              <input id="exp_month" type="text" class="card-expiry-month form-control" placeholder="01" {!! (!App::environment('production') ? ' value="01"' : '') !!} data-stripe="exp-month">
            </div>

            <div class="form-group col-md-3 col-sm-6 col-xs-12">
              <label for="exp_year">{{ trans('general.community.year') }} *</label>
              <input id="exp_year" type="text" class="card-expiry-year form-control" placeholder=" {{ (date('Y') + 3) }}" {!! (!App::environment('production') ? ' value="'.(date('Y') + 3).'"' : '') !!} data-stripe="exp-year">
            </div>

            <div class="form-group col-md-3 col-sm-6 col-xs-12">
              <label for="cvc">{{ trans('general.community.cvc') }} *</label>
              <input id="cvc" type="text" class="card-cvc form-control" placeholder="123" {!! (!App::environment('production') ? ' value="123"' : '') !!} data-stripe="cvc" />
            </div>

            <div class="form-group col-md-3 col-sm-6 col-xs-12 margin-bottom-5" id="coupon_question" style="cursor: pointer; ">
              <span style="display:block;">{{trans('general.community.coupon')}} <i class="fa fa-ticket"></i></span>
            </div>

            <!-- Coupon -->
            <div class="form-group col-md-3 col-sm-6 col-xs-12" id="coupon_field" style="display:none;">
              <label for="coupon" class="sr-only">{{trans('general.community.coupon_code')}}</label>
              <input type="text" class="form-control col-md-6 col-sm-6" placeholder="" name="coupon" />
            </div>

            <div class="form-group col-md-8 col-xs-12">
              <div class="payment-errors-generic alert alert-mini alert-danger margin-bottom-10" style="display: none">
                {{trans('general.community.wrong')}}
              </div>
            </div>

            <div class="form-group col-md-4 col-xs-12 margin-top-10">
              <button type="submit" class="btn btn-primary pull-right" id="create_community">{{trans('general.community.start_trial')}}</button>
            </div>
          </div>
        </div>
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
        //console.dir(response);


        if (response.error) {
          //alert(response.error.message);
          // Show the errors on the form
          $('.payment-errors').show().text(response.error.message);
          $('.payment-errors-generic').show();
          $('#create_community').prop('disabled', false);
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
