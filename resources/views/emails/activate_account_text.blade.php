@extends('emails/layouts/text')

@section('content')
Activate your account now
Simply click the button below

{{{ $data['activateAccountUrl'] }}}

@stop
