@extends('emails/layouts/text')

@section('content')
{{{ $data['subject'] }}}

Name: {{{ $data['firstName'] }}} {{{ $data['lastName'] }}} 
Email: {{{ $data['email'] }}}

How will you use Anysha.re: {{{ $data['howUse'] }}}

Explain why you don’t have the budget to pay? {{{$data['budget']}}}

Is this budget limitation temporary or will it continue indefinitely? {{{$data['timePeriod']}}}

How will you market your Share? {{{$data['market']}}}

@stop
