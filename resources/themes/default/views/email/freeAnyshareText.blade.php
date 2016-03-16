@extends('email/layouts/text')

@section('content')
Application for free Anyshare 
Name: {{{ $data['firstName'] }}} {{{ $data['lastName'] }}} 
Email: {{{ $data['email'] }}}

How I will use Anysha.re: {{{ $data['howUse'] }}}

Explain why you don’t have the budget to pay? {{{$data['budget']}}}

Is this budget limitation temporary or will it continue indefinitely? {{{$data['timePeriod']}}}

How will you market your Sharing Hub? {{{$data['market']}}}

@stop
