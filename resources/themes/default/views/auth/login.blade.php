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
            <div class="col-12">
                <p class="lead margin-all-0">
                    {!! trans('auth.no_account') !!} <a href="{{ route('register') }}">{{ trans('general.nav.register') }}</a> {{ strtolower(trans('general.first')) }}
                </p>
            </div>

            <!-- LOGIN -->
            <div class="col-6">
                <!-- register form -->
                <form class="nomargin sky-form boxed" method="post">
                  {!! csrf_field() !!}
                  <header>
                    <i class="fa fa-sign-in"></i> {{ trans('general.user.login_by_email') }}
                  </header>

                  <fieldset class="nomargin">
                    <div class="margin-bottom-10{{ $errors->first('email', ' has-error') }}">
                      <label class="input">
                        <i class="ico-append fa fa-envelope"></i>
                        <input type="text" placeholder="{{ trans('general.email_address') }}" name="email" value="{{ old('email') }}">
                        <b class="tooltip tooltip-bottom-right">{{ trans('general.verify') }}</b>
                      </label>
                      {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                    </div>

                    <div class="{{ $errors->first('password', ' has-error') }}">
                      <label class="input">
                        <i class="ico-append fa fa-lock"></i>
                        <input type="password" placeholder="{{ trans('general.password') }}" name="password">
                        <b class="tooltip tooltip-bottom-right">{{ trans('general.latin_chars') }}</b>
                      </label>
                      {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                    </div>
                  </fieldset>

                  <div class="row margin-bottom-20">
                    <div class="col-md-12">
                      <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> {{ trans('general.nav.login') }}</button>
                    </div>
                  </div>
                  <footer>
                   {{ trans('auth.forgot_password') }} <a href="{{ route('password.request') }}">{{ trans('general.click_here') }}.</a>
                  </footer>
                </form>
                <!-- /register form -->
            </div>
            <!-- /LOGIN -->

            <!-- SOCIAL LOGIN -->
            <div class="col-6">
                <form action="#" method="post" class="sky-form boxed">
                    <header>
                        <h2><i class="fa fa-users"></i> {{ trans('auth.social') }}</h2>
                    </header>

                    <fieldset class="nomargin">
                        <div class="row">
                            <div class="col-8 offset-2">
                                <a class="btn btn-block btn-social btn-facebook margin-left-0" href="/login/facebook">
                                    <i class="fa fa-facebook"></i> {{ trans('auth.sign_in_with', ['social_network' => 'Facebook']) }}
                                </a>

                                <a class="btn btn-block btn-social btn-twitter margin-left-0" href="/login/twitter">
                                    <i class="fa fa-twitter"></i> {{ trans('auth.sign_in_with', ['social_network' => 'Twitter']) }}
                                </a>

                                <a class="btn btn-block btn-social btn-google margin-left-0" href="/login/google">
                                    <i class="fa fa-google"></i> {{ trans('auth.sign_in_with', ['social_network' => 'Google']) }}
                                </a>

                                <a class="btn btn-block btn-social btn-github margin-left-0" href="/login/github">
                                    <i class="fa fa-github"></i> {{ trans('auth.sign_in_with', ['social_network' => 'Github']) }}
                                </a>
                            </div>
                        </div>
                    </fieldset>

                    <footer>
                        {{ trans('auth.forgot_password') }} <a href="{{ route('password.request') }}">{{ trans('general.click_here') }}.</a>
                    </footer>
                </form>
            </div>
            <!-- /SOCIAL LOGIN -->
        </div>
    </div>
</section>

@stop
