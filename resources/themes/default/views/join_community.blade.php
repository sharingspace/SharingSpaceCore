@extends('layouts.unbranded')

{{-- Page title --}}
@section('title')
Join shahring hub {{$subdomain}}
@parent
@stop

@section('content')
<!-- -->
<section>
  <div class="container margin-top-80" style>
    <div class="row">
      <div class="col-md-10 col-md-offset-1 text-center">
        @if (!empty($subdomain) && !empty($host))
        <p class="size-40">Great, you've created an account with AnyShare</p>
        <p class="size-40">Do you wish to join {{ucfirst($subdomain)}}?</p>
        <p class="size-25 sr-only">If this is a closed hub, you will need to request to join.</p>
        <p class="size-40">
          <a style="color:white;" href="{{ route('join-community', ['subdomain'=>$subdomain]) }}">
            <button type="button" class="btn btn-warning btn-lg">Join</button>
          </a>
        </p>
        @endif
    </div>
  </div>
</section>
<!-- / -->



@stop
