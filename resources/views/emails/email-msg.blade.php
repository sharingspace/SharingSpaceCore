@extends('emails/layouts/html')

@section('logo')
    @if (empty($logo))
        Welcome to {{$community_name}}
    @else
        <img src='{{$logo}}' height="41" alt="" style="line-height: 1;mso-line-height-rule: exactly;outline: none;border: 0;text-decoration: none;-ms-interpolation-mode: bicubic;">
    @endif
@stop

@section('header')
    You have an offer concerning {{$entry_name}}
@stop

@section('content')
    <p style="margin-top:10px;">Dear {{$name}},</p>

    @if (empty($thread_subject))
        <p>You've received a new message from the Share <strong><a href="{{$community_url}}">{{ $community }}</a></strong>
    @else
        <p>You've received a new message to the thread <strong>{{$thread_subject}}</strong>, in the Share <strong><a href="{{$community_url}}">{{ $community }}</a></strong>
    @endif

    @if (!empty($entry_name))
        on the entry titled <strong><a href="{{$community_url}}/entry/{{$entry_id}}">{{$entry_name}}</a></strong>
    @endif
:</p>

    <blockquote>&ldquo;<em>{{ $offer }}</em>&rdquo;</blockquote>

    @if (!empty($exchanges)) 
        <p>Exchange options listed: {{$exchanges}}</p>
    @endif

    <p style="text-align: center">
        <strong>
            <a href="{{$community_url}}/account/message/thread/{{$thread_id}}">
                Click here to view this message online
            </a>
        </strong>
    </p>

@stop
