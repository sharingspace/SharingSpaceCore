@extends('emails/layouts/text')
@section('content')
Welcome to Anyshare

Hi firstName lastName,

Your new account at Anyshare is ready, and we're thrilled to have you aboard! Use the credentials below to login to your account to add new wants and haves, or to reply to wants and haves from your community members.

Email: sendto_email
Password: password 

(Please note - your password is encrypted on the server, so we can't send you your password again if you lose it, but don't worry it's super easy to reset if you forget it.)

Thanks!
sender_name

@stop
