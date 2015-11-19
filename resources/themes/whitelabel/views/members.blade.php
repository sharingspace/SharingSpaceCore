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
    <li>{{ $member->email }}
  @endforeach

  </div>
</section>


@stop
