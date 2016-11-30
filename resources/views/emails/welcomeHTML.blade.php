@extends('emails/layouts/html')
@section('header')
@if (empty($logo))
    Welcome to {{$community_name}}
@else
    <img src='{{$logo}}' height="41" alt="" style="line-height: 1;mso-line-height-rule: exactly;outline: none;border: 0;text-decoration: none;-ms-interpolation-mode: bicubic;">
@endif
@stop
@section('content')
<div class="email_content">
    <p>Hi {{ $name }}!</p>

    <p>Your new Share is ready! Click the link below to finalize your Share settings.</p>

    <p><a href="https://{{ $subdomain }}.{{ config('app.domain') }}">{{ $subdomain }}.{{ config('app.domain') }}</a></p>

    <p>Sincerely,</p>
    <p>Your {{$community_name}} bot</p>
</div>
@stop
