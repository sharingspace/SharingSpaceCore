@extends('emails/layouts/text')
@section('content')
Hello {{{ $data['firstName'] }}} {{{ $data['lastName'] }}} ,

You're almost done setting up your Anyshare account. Just click below to finish:

{{{ $activationUrl }}}

@stop
