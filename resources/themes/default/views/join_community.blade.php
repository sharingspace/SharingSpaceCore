@extends('layouts.unbranded')

{{-- Page title --}}
@section('title')
{{ trans('general.community.share_join') }} {{$shareName}}
@parent
@stop

@section('content')
<!-- -->
<section>
  <div class="container margin-top-80" style>
    <div class="row">
      <div class="col-md-10 col-md-offset-1 text-center">
        @if (isset($subdomain) && isset($host))
        <p class="size-40">{{ trans('general.community.account_great') }}</p>
        <p class="size-40">{{ trans('general.community.share_join') }} {{$shareName}}?</p>
        <p class="size-25 sr-only">{{ trans('general.community.closed_share') }}</p>
        <p class="size-40">
          <a style="color:white;" href="{{ route('join-community', ['subdomain'=>$subdomain]) }}">
            <button type="button" class="btn btn-warning btn-lg">{{ trans('general.community.share_join') }}</button>
          </a>
        </p>
        @endif
    </div>
  </div>
</section>
<!-- / -->



@stop
