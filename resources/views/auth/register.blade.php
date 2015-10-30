@extends('layouts/default')

{{-- Page title --}}
@section('title')
     Register ::
@parent
@stop


{{-- Page content --}}
@section('content')

<section class="container">
    <div class="row">

        <div class="col-md-7 col-sm-12 col-xs-12">

        <form method="POST" action="/auth/register" class="form-horizontal">
            {!! csrf_field() !!}

            <div class="form-group col-md-12 {{ $errors->first('first_name', ' has-error') }}">
                <div class="col-md-3">
                    <label for="first_name"{{ $errors->first('first_name', ' aria-invalid="true"') }}>First Name</label>
                </div>
                <div class="col-md-9">
                    <input type="text" name="first_name" value="{{ old('first_name') }}">
                    {!! $errors->first('first_name', '<br><span class="has-error">:message</span>') !!}
                </div>
            </div>

            <div class="form-group col-md-12 {{ $errors->first('last_name', ' has-error') }}">
                <div class="col-md-3">
                    <label for="last_name"{{ $errors->first('last_name', ' aria-invalid="true"') }}>Last Name</label>
                </div>
                <div class="col-md-9">
                    <input type="text" name="last_name" value="{{ old('last_name') }}">
                    {!! $errors->first('last_name', '<br><span class="has-error">:message</span>') !!}
                </div>
            </div>

            <div class="form-group col-md-12 {{ $errors->first('email', ' has-error') }}">
                <div class="col-md-3">
                    <label for="email"{{ $errors->first('email', ' aria-invalid="true"') }}>Email</label>
                </div>
                <div class="col-md-9">
                    <input type="email" name="email" value="{{ old('email') }}">
                    {!! $errors->first('email', '<br><span class="has-error">:message</span>') !!}
                </div>
            </div>

            <div class="form-group col-md-12 {{ $errors->first('password', ' has-error') }}">
                <div class="col-md-3">
                    <label for="password"{{ $errors->first('password', ' aria-invalid="true"') }}>Password</label>
                </div>
                <div class="col-md-9">
                    <input type="password" name="password" value="{{ old('password') }}">
                    {!! $errors->first('password', '<br><span class="has-error">:message</span>') !!}
                </div>
            </div>

            <div class="form-group col-md-12 {{ $errors->first('password_confirmation', ' has-error') }}">
                <div class="col-md-3">
                    <label for="password_confirmation"{{ $errors->first('password_confirmation', ' aria-invalid="true"') }}>Confirm Password</label>
                </div>
                <div class="col-md-9">
                    <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}">
                    {!! $errors->first('password_confirmation', '<br><span class="has-error">:message</span>') !!}
                </div>
            </div>


            <div class="form-group col-md-3">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>

    </div><!--end row-->
</section>
@stop
