@extends('emails/layouts/default')

@section('content')

<p>Hi firstName lastName,</p>

<p>Your new account at Anyshare is ready, and we're thrilled to have you aboard! Use the credentials below to login to your account to add new wants and haves, or to reply to wants and haves from your community members. </p>

<p>Email: sendto_email<br>
Password: $password</p>

<p>(Please note - your password is encrypted on the server, so we can't send you your password again if you lose it, but don't worry it's super easy to reset if you forget it.)</p>

<p>Thanks! <br>
The Peeps at Anyshare</p>

@stop
