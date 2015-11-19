@extends('layouts.master')

{{-- Page title --}}
@section('title')
     {{ trans('general.nav.members') }} ::
@parent
@stop


@section('content')

<section class="container">
<div class="row margin-top-30">

  @foreach ($members as $member)
    <div class="col-md-4">

        <img src="{{ $member->gravatar() }}" class="thumbnail pull-left">
        <div>
          <h4 class="size-13 nomargin noborder nopadding">{{ $member->getDisplayName() }}</h4>
          <p class="size-11 text-muted">{{ substr_replace($member->bio, '...', 100) }} <a href="{{ route('user.profile', [$member->id]) }}">more</a></p>
        </div>

    </div>
  @endforeach

  </div>
</section>


@stop
