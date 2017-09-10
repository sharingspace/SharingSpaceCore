@extends('emails/layouts/html')
@section('logo')
    @if (!empty($logo))
        <img src='{{$logo}}' height="41" alt="" style="line-height: 1;mso-line-height-rule: exactly;outline: none;border: 0;text-decoration: none;-ms-interpolation-mode: bicubic;">
    @endif
@stop

@section('header')
    Welcome to {{$uc_subdomain}}
@stop

@section('content')
    <p>Hi {{$name}}!</p>
    <p>You just joined the Sharing Network {{$uc_subdomain}}.</p>
    <p>Visit <a class="hub_link" href="https://{{$subdomain}}.{{ config('app.domain') }}">{{$subdomain}}.{{ config('app.domain') }}</a> to get started!</p>
    <p>Sincerely,</p>
    <p>AnyShare Society</p>
@stop