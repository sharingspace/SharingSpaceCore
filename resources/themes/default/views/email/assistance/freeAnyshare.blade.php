@extends('email/layouts/text')

@section('content')
<h1>Application for free Anyshare Sharing Hub</h1> 
<p>From: {{{ $data['firstName'] }}} {{{ $data['lastName'] }}}<br> 
Email: {{{ $data['email'] }}}</p>

<dl>
<dt>How I will use Anysha.re?</dt>
<dd>{{{ $data['howUse'] }}}</dd>

<dt>Explain why you don’t have the budget to pay?</dt>
<dd>{{{$data['budget']}}}</dd>

<dt>Is this budget limitation temporary or will it continue indefinitely?</dt>
<dd>{{{$data['timePeriod']}}}</dd>

<dt>How will you market your Sharing Hub?</dt>
<dd>{{{$data['market']}}}</dd>
</dl>
@stop
