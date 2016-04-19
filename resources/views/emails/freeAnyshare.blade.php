@extends('emails/layouts/default')

@section('content')
<h1>Application for free Anyshare</h1>
<p>Name: {{{ $data['firstName'] }}} {{{ $data['lastName'] }}} </p>
<p>Email: {{{ $data['email'] }}}</p>

<p>How I will use Anysha.re: {{{ $data['howUse'] }}}</p>

<p>Explain why you don’t have the budget to pay? {{{$data['budget']}}}</p>

<p>Is this budget limitation temporary or will it continue indefinitely? {{{$data['timePeriod']}}}</p>

<p>How will you market your Sharing Hub? {{{$data['market']}}}</p>

@stop
