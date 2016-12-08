@extends('layouts/master')

{{-- Page title --}}
@section('title')
     {{ trans('general.nav.login') }} ::
@parent
@stop


{{-- Page content --}}
@section('content')


<!-- -->
<section class="margin-top-30">
  <div class="container margin-top-40">

    <div class="row">

      <!-- LOGIN -->
      <div class="col-xs-12 size-18 margin-bottom-30">
        {!! trans('auth.no_account') !!} <a href="../auth/register">{{ trans('general.nav.register') }}</a> {{ strtolower(trans('general.first')) }}
      </div>

      <div class="col-sm-6 col-xs-12 margin-bottom-10">
        <!-- register form -->
        <form class="nomargin sky-form boxed" method="post" action="{{ route('login') }}">
          {!! csrf_field() !!}
          <header>
            <i class="fa fa-sign-in"></i> {{ trans('general.user.login_by_email') }}
          </header>

          <fieldset class="nomargin">

            <div class="margin-bottom-10{{ $errors->first('email', ' has-error') }}">
              <label class="input">
                <i class="ico-append fa fa-envelope"></i>
                <input type="text" placeholder="{{ trans('general.email') }}" name="email" value="{{ old('email') }}">
              </label>
              {!! $errors->first('email', '<span class="help-block alert-info ">:message</span>') !!}
            </div>

            <div class="margin-bottom-10{{ $errors->first('password', ' has-error') }}">
              <label class="input">
                <i class="ico-append fa fa-lock"></i>
                <input type="password" placeholder="{{ trans('general.password') }}" name="password">
                <b class="tooltip tooltip-bottom-right">{{ trans('general.latin_chars') }}</b>
              </label>
              {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
            </div>


          <div class="row margin-bottom-20">
            <div class="col-md-12">
              <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> {{ trans('general.nav.login') }}</button>
            </div>
          </div>

          <footer>
           Forgot your password? <a href="{{ route('forgot_password.email.form') }}">Click here.</a>
          </footer>
        </form>
        <!-- /register form -->

      </div>
      <!-- /LOGIN -->

      <!-- SOCIAL LOGIN -->
      <div class="col-sm-6 col-xs-12">
        <form action="#" method="post" class="sky-form boxed">

          <header>
            &hellip; {{ trans('general.user.login_by_social') }}
          </header>

          <fieldset class="nomargin">

            <div class="row">

              <div class="col-md-8 col-md-offset-2">

                <a class="btn btn-block btn-social btn-facebook margin-bottom-10" href="/auth/facebook">
                    <i class="fa fa-facebook"></i> {{ trans('auth.sign_in_with',  ['social_network' => 'Facebook']) }}
                </a>

                <a class="btn btn-block btn-social btn-twitter margin-bottom-10" href="/auth/twitter">
                 <i class="fa fa-twitter"></i> {{ trans('auth.sign_in_with',  ['social_network' => 'Twitter']) }}
                </a>

                <a class="btn btn-block btn-social btn-google margin-bottom-10" href="/auth/google">
                  <i class="fa fa-google"></i> {{ trans('auth.sign_in_with',  ['social_network' => 'Google']) }}
                </a>

                <a class="btn btn-block btn-social btn-github margin-bottom-10" href="/auth/github">
                   <i class="fa fa-github"></i> {{ trans('auth.sign_in_with',  ['social_network' => 'Github']) }}
                </a>
              </div>
            </div>

          </fieldset>
        </form>
      </div>
      <!-- /SOCIAL LOGIN -->
    </div>


  </div>
</section>
<!-- / -->
<script type="text/javascript">
$( document ).ready(function() {

});
</script>
@stop
