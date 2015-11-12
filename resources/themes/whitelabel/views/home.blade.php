@extends('layouts.master')

@section('content')

<section class="container">
  <div class="row">

        <p>
          @if ($whitelabel_group->about!='')
            {{ $whitelabel_group->about }}
          @else
            {{ trans('general.no_about_data') }}
          @endif
        </p>

        <p class="text-center"><a href="{{ route('browse') }}" class="btn btn-default">{{ trans('general.browse_button') }}</a></p>
  </div><!--end row-->
</section>
@stop
