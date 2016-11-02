@extends('emails/layouts/html')

@section('preheader')
@if ($entry_name)
    You have an offer concerning {{$entry_name}}
@endif
@stop

@section('logo')
@if (empty($logo))
    {{$community}}
@else
    <img src='{{$logo}}' height="41" alt="" style="line-height: 1;mso-line-height-rule: exactly;outline: none;border: 0;text-decoration: none;-ms-interpolation-mode: bicubic;">
@endif
@stop

@section('content')
    <p>Dear {{$name}},</p>

    @if (empty($thread_subject))
        <p>You've received a new message from the Share <strong><a href="{{$community_url}}" style="color: white;">{{ $community }}</a></strong>
    @else
        <p>You've received a new message to the thread <strong>{{$thread_subject}}</strong>, in the Share <strong><a href="{{$community_url}}" style="color: white;">{{ $community }}</a></strong>
    @endif

    @if (isset($entry_name))
        on the entry titled <strong><a href="{{$community_url}}/entry/{{$entry_id}}" style="color: white;">{{$entry_name}}</a></strong>
    @endif
:</p>

    <blockquote>&ldquo;<em>{{ $offer }}</em>&rdquo;</blockquote>
    @if (!empty($exchanges)) 
        <p>Exchange options listed: {{$exchanges}}</p>
    @endif

    <p style="text-align: center">
        <strong>
            <a href="{{$community_url}}/account/message/{{$thread_id}}"  style="color: white;">
                Click here to view this message online
            </a>
        </strong>
    </p>

@stop
