@extends('emails/layouts/html')
@section('logo')
    <img src='{{$logo}}' height="41" alt="" style="line-height: 1;mso-line-height-rule: exactly;outline: none;border: 0;text-decoration: none;-ms-interpolation-mode: bicubic;">
@stop

@section('header')
    You are a Coop Member!
@stop
{{-- Page content --}}
@section('content')

<p>Hi {{ $name }}!</p>

<p>Thank you for joining the AnyShare Cooperative!</p>

<p>You've taken a powerful step in becoming a Coop Member, and are now entitled to voting and profit sharing within our organization. This is an exemplary step for fixing the wrongs done by modern cooperations and we are grateful to have you as one of us.</p>

<p>You stated that your interest in becoming a Coop Member was "<em>{{$interest}}</em>"
@if (isset($involved))
 and that you would like see how you could be involved with the Coop in the future.</p>
@else
.</p>
@endif

<p>Thank you,</p>
<p>The AnyShare Coop Team</p>
@stop