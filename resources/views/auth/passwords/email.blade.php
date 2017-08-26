@extends('layouts/master')

{{-- Page title --}}
@section('title')
    Forgot Password
    @parent
@stop


<!-- Main Content -->
@section('content')
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-6 offset-3">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

                <form class="form-horizontal sky-form boxed" role="form" method="POST" action="{{ route('password.email') }}">
                    {!! csrf_field() !!}
                    <header>
                        <h2>{{ trans('auth.reset_password')}}</h2>
                    </header>

                    <div class="form-group  margin-left-20 {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="control-label">E-Mail Address</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                        </div>

                        <button type="submit" class="btn btn-malibu margin-bottom-10">
                            <i class="fa fa-btn fa-envelope"></i> Send Password Reset Link
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
