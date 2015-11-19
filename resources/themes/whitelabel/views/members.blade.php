@extends('layouts.master')

{{-- Page title --}}
@section('title')
     {{ trans('general.nav.members') }} ::
@parent
@stop


@section('content')

<section class="container">
<div class="row">

  @foreach ($members as $member)
    <div class="col-md-4">
      <div class="col-md-4">
        <img src="{{ $member->gravatar() }}">
      </div>
      <div class="col-md-8">
        <h4>{{ $member->getDisplayName() }}</h4>
        <p>{{ $member->bio }}</p>
      </div>
    </div>
  @endforeach

  </div>
</section>


@stop
