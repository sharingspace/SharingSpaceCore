@extends('emails/layouts/text')

Welcome to {{$community_name}}

Hi {{ $name }}!

Your new Sharing Network is ready! Click the link below to configure your Sharing Network.

{{ $subdomain }}.{{ config('app.domain') }}

Sincerely,
Your {{$community_name}} bot