@extends('emails/layouts/text')

Welcome to {{$community_name}}

Hi {{ $name }}!

Your new Share is ready! Use the link below to finalize your Share settings.

{{ $subdomain }}.{{ config('app.domain') }}

Sincerely,
Your {{$community_name}} bot