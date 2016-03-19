@extends('emails/layouts/text')
@section('content')
Hi this is <a mailto:'{{{$email}}}'>{{{ $sender_name }}}</a> and I'd like to invite you to be part of the <strong><a href="{{{ $seo_url }}}/">{{{ $hubgroup_name }}}</a></strong> sharing hub which is an online sharing community on <a href="{{{ Config::get('app.url') }}}">Anysha.re</a>.

@if( $description)
{{{ $hubgroup_name }}} can be best explained by:

{{{$description}}}
@endif

<a href="https://{{$subdomain}}.{{{ Config::get('app.domain') }}}/groups/accept/?email={{{ $email }}}&token={{{ $token }}}">Click here to join the {{{ $hubgroup_name }}} sharing hub. It would be great if you would join and it's free!</a>

Thanks!
{{{ $sender_name }}}
@stop

