@extends('emails/layouts/default')

@section('content')

<p>Hi this is <a mailto:'{{{$email}}}'>{{{ $sender_name }}}</a> and I'd like to invite you to be part of the <strong><a href="{{{ $seo_url }}}/">{{{ $hubgroup_name }}}</a></strong> sharing hub which is an online sharing community on <a href="{{{ Config::get('app.url') }}}">Anysha.re</a>.</p>

@if( $description)
<p>{{{ $hubgroup_name }}} can be best explained by:</p>
<blockquote><em>{{{$description}}}</em></blockquote>
@endif

<p><strong><a href="https://{{$subdomain}}.{{{ Config::get('app.domain') }}}/groups/accept/?email={{{ $email }}}&token={{{ $token }}}">Click here to join the {{{ $hubgroup_name }}} sharing hub. It would be great if you would join and it's free!</a></strong></p>

<p>Thanks! <br>
{{{ $sender_name }}} </p>

@stop
