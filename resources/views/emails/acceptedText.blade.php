@extends('emails/layouts/text')

Hi {{$name}}
You just joined the Sharing Network {{$uc_subdomain}}.
Visit http://{{$subdomain}}.{{ config('app.domain') }} to get started!
Sincerely,
AnyShare Society