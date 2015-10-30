@extends('layouts/default')

{{-- Page title --}}
@section('title')
     Login ::
@parent
@stop


{{-- Page content --}}
@section('content')

<!-- *** Page section *** -->
<section class="container">
    <div class="row">
        <!-- Login form -->
        <div class="col-sm-6">
            <h3>Login</h3>
            <form class="form" id="login-form" name="login-form" action="/auth/login" method="post">
                {!! csrf_field() !!}
                <input name="email" type="text" placeholder="Email">
                <input name="password" type="password" placeholder="Password">
                <div class="checkbox">
                    <input id="check-log" name="remember" type="checkbox" checked>
                    <label for="check-log">Remember me</label>
                </div>
                <a class="form__link" href="#" title="Forgot password">Forgot password?</a>
                <button type="submit" class="btn btn-primary btn-submit">Login</button>
            </form>
        </div><!--end col-sm-6-->
        <!-- End login form -->

        <!-- Begin social login form -->
        <div class="col-sm-6 col-md-3 col-xs-12">

            <a class="btn btn-block btn-social btn-facebook" href="/auth/facebook">
                <i class="fa fa-facebook"></i> Sign in with Facebook
            </a>

            <a class="btn btn-block btn-social btn-twitter" href="/auth/twitter">
             <i class="fa fa-twitter"></i> Sign in with Twitter
            </a>

            <a class="btn btn-block btn-social btn-google" href="/auth/google">
              <i class="fa fa-google"></i> Sign in with Google
            </a>

            <a class="btn btn-block btn-social btn-github" href="/auth/github">
               <i class="fa fa-github"></i> Sign in with Github
            </a>


        </div><!--end col-sm-6-->

    </div><!--end row-->
</section>


@stop
