@extends('emails/layouts/html')

@section('content')
<div class="email_content">
    <p>Hi {{ $name }}!</p>

    <p>Your new Sharing Website is ready!</p>

    <p><a class="hub_link" href="http://{{ $subdomain}}.anysha.re">{{ $subdomain}}.anysha.re</a></p>

    <p>Keep being awesome.</p>
</div>
@stop