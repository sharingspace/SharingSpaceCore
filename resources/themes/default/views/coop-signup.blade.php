@extends('layouts.master')
@section('content')

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    <!-- -->
    <section>
        <div class="container margin-top-20">
            <div class="row">

                <!-- payment form -->
                <form method="post" action="#" id="payment-form" enctype="multipart/form-data" autocomplete="off">
                    {!! csrf_field() !!}

                    <!-- PAYMENT -->
                    <div class="col-md-5">
                    <h2 class="size-16 text-muted">Coop Signup form</h2>

                        <!-- Error box for payment errors -->
                        <div class="form-group col-md-12 payment-errors alert alert-mini alert-danger margin-bottom-10" style="display: none; margin-left: 15px;">
                        </div>

                        <div class="form-group col-md-12 col-sm-12" id="form-card-number">
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

                        <div class="form-group col-md-3 col-sm-12">
                            <label for="exp_month">{{trans('general.community.month')}} *</label>
                            <input id="exp_month" type="text" class="card-expiry-month form-control" placeholder="01" {!! (!App::environment('production') ? ' value="01"' : '') !!} data-stripe="exp-month">
                        </div>

                        <div class="form-group col-md-3 col-sm-12">
                            <label for="exp_year">{{ trans('general.community.year') }} *</label>
                            <input id="exp_year" type="text" class="card-expiry-year form-control" placeholder=" {{ (date('Y') + 3) }}" {!! (!App::environment('production') ? ' value="'.(date('Y') + 3).'"' : '') !!} data-stripe="exp-year">
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
        Stripe.setPublishableKey('{{ Config::get('services.stripe.key') }}');

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
