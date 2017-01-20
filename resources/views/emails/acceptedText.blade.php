@extends('emails/layouts/text')

Hi {{$name}}
You just joined the {{$uc_subdomain}} Share.
Visit http://{{$subdomain}}.{{ config('app.domain') }} to get started!
Sincerely,
AnyShare Society