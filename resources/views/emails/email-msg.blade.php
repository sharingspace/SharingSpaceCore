@extends('emails/layouts/html')

@section('logo')
    @if (isset($logo))
        <img src='{{$logo}}' height="41" alt="" style="line-height: 1;mso-line-height-rule: exactly; outline: none; border: 0;text-decoration: none;-ms-interpolation-mode: bicubic;margin: 0 auto 20px; display: block">
    @elseif (isset($community_name))
        <h1>{{$community_name}}</h1>
    @endif
@stop

@section('content')
    <p>Hi {{$sent_to}},</p>
    <p>Your entry <a href="{{$community_url}}/entry/{{$entry_id}}">{{$entry_name}}</a> has received a new offer.</p>
    <p>Sent by: {{$sent_by}}
    @if (!empty($exchanges)) 
        <p>Exchange types: {{$exchanges}}</p>
    @endif

    @if (isset($community_name))
        <p>Sharing network: <a href="{{$community_url}}">{{$community_name}}</a>
    @endif

    @if (0)
    @if (empty($thread_subject))
        <p>You've received a new message from the Share <strong><a href="{{$community_url}}">{{$community_name}}</a></strong></p>
    @else
        <p>You've received a new message to the thread <strong>{{$thread_subject}}</strong>, in the Share <strong><a href="{{$community_url}}">{{$community_name}}</a></strong></p>

    @endif
    @endif
 
    <p>Message: <em>{{ $offer }}</em> (or <a href="{{$community_url}}/account/message/thread/{{$thread_id}}">read online</a>)</p> 

@stop
