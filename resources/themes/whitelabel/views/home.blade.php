@extends('layouts.master')

@section('content')
<script src="/js/extensions/mobile/bootstrap-table-mobile.js"></script>

<section class="container">
  <div class="row">

        <p>
          @if ($whitelabel_group->about!='')
            {{ $whitelabel_group->about }}
          @else
            The owner of this group has not entered any information about it yet.
          @endif
        </p>

        <p class="text-center"><a href="" class="btn btn-default">{{ trans('general.browse_button') }}</a></p>
  </div><!--end row-->
</section>
@stop
