@extends('emails/layouts/default')

@section('content')
<h1>Congratulations on creating your Sharing Hub called "whitelabel name"</h1>
<p>Hi firstName lastName,</p>

<p>"whitelabel name" is ready, and we're thrilled to have you aboard! Use the credentials below to login to your account to add new wants and haves and invite hub members.</p>

<p>Url: "whitelabel name".anysha.re
Email: sendto_email<br>
Password: password</p>

<p>(Please note - your password is encrypted on the server, so we can't send you your password again if you lose it, but it's super easy to reset if you forget it.)</p>

<p>Thanks! <br>
The Peeps at Anyshare</p>

@stop
