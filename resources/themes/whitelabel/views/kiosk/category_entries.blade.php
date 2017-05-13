@extends('layouts.kiosk')

@section('content')

<section class="container padding-top-0 kiosk-category">
  <h1>{{$tag}}</h1>
  <div class="margin-top-20 row">
    <?php
    foreach($entryList as $entry) { ?>
      <div class="col-xs-12 line-entry {{$entry['color']}}">
        <a href="{{route('kiosk_entry', ['entryId' => $entry['entryId']])}}" class="">
          {{ $entry['name']." ".$entry['type']." ".$entry['qty']." ".strtolower($entry['title'])}}
        </a>
      </div>
    <?php } ?>
    </div>
</section>

<div id="kiosk_footer">
  <a href="{{route('kiosk.categories')}}" class="margin-bottom-40 margin-left-30">
    <img src="/assets/img/kiosk/back_arrow.png" alt="go up a level">
  </a>
  <p>{{trans('footer.powered_by')}} <a href="{{config('app.url')}}"><img src="{{ Helper::cdn('img/hp/anyshare-logo-web-retina-100.png') }}" class="logo"></a></p>
</div>

<script type="text/javascript">
$( document ).ready(function() {
 
})

</script>

@stop
