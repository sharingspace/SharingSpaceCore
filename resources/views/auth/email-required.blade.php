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
            <h3>Enter your Email</h3>
            <form class="form form--login" id="login-form" name="login-form" action="/auth/add-email" method="post">
                {!! csrf_field() !!}
                <input name="email" type="text" placeholder="Email">
                <button type="submit" class="btn btn-primary btn-submit">Submit</button>
            </form>
        </div><!--end col-sm-6-->
        <!-- End login form -->
    </div><!--end row-->
</section>


@stop
