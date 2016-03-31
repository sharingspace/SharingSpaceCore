@extends('emails/layouts/text')
@section('content')
Hello {{{ $user->first_name }}},

You're almoooooosssssst done setting up your Mass Mosaic account. Just click below to finish:

{{{ $activationUrl }}}

@stop
