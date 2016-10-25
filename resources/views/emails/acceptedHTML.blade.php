@extends('emails/layouts/html')

@section('content')
<div class="email_content">
    <p>Hi {{$name}}!</p>
    <p>You just joined the {{$uc_subdomain}} Share.</p>
    <p>Visit <a class="hub_link" href="https://{{$subdomain}}.anysha.re">{{$subdomain}}.anysha.re</a> to get started!</p>
    <p>Sincerely,</p>
    <p>AnyShare Society</p>
</div>
@stop