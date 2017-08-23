@extends('layouts/master')

{{-- Page title --}}
@section('title')
     {{ trans('general.nav.login') }} ::
@parent
@stop


{{-- Page content --}}
@section('content')

<section class="section">
    <div class="container">
        <div class="row gap-y">
            <div class="col-12 feature-1">
                <p class="lead">{!! trans('auth.no_account') !!} <a href="{{ route('register') }}">{{ trans('general.nav.register') }}</a> {{ strtolower(trans('general.first')) }}</p>
            </div>

            <!-- LOGIN -->
            <div class="col-6">
                <!-- register form -->
                <form class="nomargin sky-form boxed" method="post">
                    {!! csrf_field() !!}
                    <header>
                        <h3><i class="fa fa-sign-in"></i> {{ trans('general.user.login_by_email') }}</h3>
                    </header>

                    <fieldset class="nomargin">
                        <div class="margin-bottom-10{{ $errors->first('email', ' has-error') }}">

                                <div class="input-group">
                                  <input class="form-control form-control-lg" type="text" placeholder="{{ trans('general.email_address') }}" name="email" value="{{ old('email') }}">
                                  <span class="input-group-addon fa fa-envelope" id="basic-addon2"></span>
                                  <b class="tooltip tooltip-bottom-right">{{ trans('general.verify') }}</b>
                                </div>

                                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                        </div>
                        <br />

                        <div class="margin-bottom-10{{ $errors->first('password', ' has-error') }}">

                                <div class="input-group">
                                  <input class="form-control form-control-lg" type="password" placeholder="{{ trans('general.password') }}" name="password">
                                  <span class="input-group-addon fa fa-lock" id="basic-addon2"></span>
                                  <b class="tooltip tooltip-bottom-right">{{ trans('general.latin_chars') }}</b>
                                </div>

                                {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                        </div>
                        <br />
                    </fieldset>

                            <button type="submit" class="btn btn-malibu"><i class="fa fa-check"></i> {{ trans('general.nav.login') }}</button>


                    <footer>
                        Forgot your password? <a href="{{ route('password.request') }}">Click here.</a>
                    </footer>
                </form>
                <!-- /register form -->
            </div>
            <!-- /LOGIN -->

            <!-- SOCIAL LOGIN -->
            <div class="col-6">
                <form action="#" method="post" class="sky-form boxed">
                    <header>
                        <h3><i class="fa fa-users"></i> {{ trans('auth.social') }}</h3>
                    </header>

                    <fieldset class="nomargin">
                        <div class="row">
                            <div class="col-8">
                                <a class="btn btn-block btn-social btn-facebook margin-bottom-10" href="/login/facebook">
                                    <i class="fa fa-facebook"></i> {{ trans('auth.sign_in_with',  ['social_network' => 'Facebook']) }}
                                </a>

                                <a class="btn btn-block btn-social btn-twitter margin-bottom-10" href="/login/twitter">
                                    <i class="fa fa-twitter"></i> {{ trans('auth.sign_in_with',  ['social_network' => 'Twitter']) }}
                                </a>

                                <a class="btn btn-block btn-social btn-google margin-bottom-10" href="/login/google">
                                    <i class="fa fa-google"></i> {{ trans('auth.sign_in_with',  ['social_network' => 'Google']) }}
                                </a>

                                <a class="btn btn-block btn-social btn-github margin-bottom-10" href="/login/github">
                                    <i class="fa fa-github"></i> {{ trans('auth.sign_in_with',  ['social_network' => 'Github']) }}
                                </a>
                            </div>
                        </div>
                    </fieldset>

                    <footer>
                        <!-- {!! trans('auth.no_account') !!} -->
                    </footer>
                </form>
            </div>
            <!-- /SOCIAL LOGIN -->
        </div>
    </div>
</section>


@stop
