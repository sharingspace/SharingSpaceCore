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
      <div class="col-md-6 col-sm-6">

        <!-- register form -->
        <form class="nomargin sky-form boxed" method="post">
          {!! csrf_field() !!}
          <header>
            <i class="fa fa-sign-in"></i>  {{ trans('general.nav.login') }}
          </header>

          <fieldset class="nomargin">

            <div class="margin-bottom-10{{ $errors->first('email', ' has-error') }}">
              <label class="input">
                <i class="ico-append fa fa-envelope"></i>
                <input type="text" placeholder="{{ trans('general.user.email') }}" name="email" value="{{ old('email') }}">
                <b class="tooltip tooltip-bottom-right">Needed to verify your account</b>
              </label>
              {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
            </div>

            <div class="margin-bottom-10{{ $errors->first('password', ' has-error') }}">
              <label class="input">
                <i class="ico-append fa fa-lock"></i>
                <input type="password" placeholder="{{ trans('general.user.password') }}" name="password">
                <b class="tooltip tooltip-bottom-right">Only latin characters and numbers</b>
              </label>
              {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
            </div>


          <div class="row margin-bottom-20">
            <div class="col-md-12">
              <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> {{ trans('general.nav.login') }}</button>
            </div>
          </div>

        </form>
        <!-- /register form -->

      </div>
      <!-- /LOGIN -->

      <!-- SOCIAL LOGIN -->
      <div class="col-md-6 col-sm-6">
        <form action="#" method="post" class="sky-form boxed">

          <header>
            <i class="fa fa-globe"></i> Register using your favourite social network
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

          <footer>
            <!-- {!! trans('auth.dont_have_account') !!} -->
          </footer>

        </form>

      </div>
      <!-- /SOCIAL LOGIN -->

    </div>


  </div>
</section>
<!-- / -->

@stop
