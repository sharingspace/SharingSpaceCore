@extends('emails/layouts/default')

@section('content')
<p>Hello {{{ $data['firstName'] }}} {{{ $data['lastName'] }}} ,</p>

<p>You're almost done setting up your Anyshare account. Just click below to finish: <br></p>

<center><p style="align: center;"><strong><a href="{{{ $activationUrl }}}" style="border: none; font-weight: bold; font-style: normal; color:#ffffff; text-decoration: none; background-color: #ff9933; padding: 10px; margin: 10px;" class="button">Click to activate</a></strong></p></center>

@stop
