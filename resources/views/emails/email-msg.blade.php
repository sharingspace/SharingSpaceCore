@extends('emails/layouts/html')

@section('content')
    <p>Dear {{ $name }},</p>

    <p>You've received a new message to the  <strong>{{ $subject }}</strong> thread in <a href="{{ $community_url }}" style="color: white;">{{ $community }}</a>

    @if (isset($entry_name))
        on the entry titled <a href="{{ $community_url }}/entry/{{ $entry_id }}" style="color: white;">{{ $entry_name }}</a>
    @endif
        . </p>

    <p>{{ $offer }}</p>

@stop
