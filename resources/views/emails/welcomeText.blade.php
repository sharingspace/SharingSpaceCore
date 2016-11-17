@extends('emails/layouts/text')

Hi {{ $name }}!

Your new Sharing Website is ready!

https://{{ $subdomain}}.{{ config('app.domnain') }}

Keep being awesome.
