@extends('emails/layouts/text')

Hi {{$name}}
You just joined the {{$subdomain}} Share.</p>
Visit http://{{$subdomain}}.{{ config('app.domain') }} to get started!
Sincerely,
AnyShare Society