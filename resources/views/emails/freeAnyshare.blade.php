@extends('emails/layouts/html')

@section('content')
<h1>{{{ $data['subject'] }}}</h1>
<p>Name: {{{ $data['firstName'] }}} {{{ $data['lastName'] }}} </p>
<p>Email: {{{ $data['email'] }}}</p>

<h2>How will you use Anyshare.coop?</h2>
<p>{{{ $data['howUse'] }}}</p>

<h2>Explain why you don’t have the budget to pay?</h2>
<p>{{{$data['budget']}}}</p>

<h2>Is this budget limitation temporary or will it continue indefinitely?</h2>
<p>{{{$data['timePeriod']}}}</p>

<h2>How will you market your Sharing Network?</h2>
<p>{{{$data['market']}}}</p>

@stop
