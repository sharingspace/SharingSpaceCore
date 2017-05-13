@extends('layouts.kiosk')

{{-- Page title --}}
@section('title')
  {{ trans('general.entries.view') }} ::
  @parent
@stop

{{-- Page content --}}
@section('content')

<!-- -->
<section>
  <div id="entry_view" class="container-fluid">
    <div class="row margin-bottom-20">
      @if(isset($images) && (count($images) > 0) && $images[0]->filename)
      <div class="col-md-5 col-sm-5 col-xs-12 margin-top-20">
        <div id="image_box_containerr"> 
          <img class="img-responsive" src="{{ Helper::cdn('uploads/entries/'.$entry->id.'/'.$images[0]->filename) }}">
        </div>
      </div> <!-- col-md-4 -->
      
      <div class="col-md-7 col-sm-7 col-xs-12 margin-top-20">
      @else
      <div class="col-xs-12 margin-top-20">
      @endif
        <h1 class="size-60 margin-bottom-10 {{$entry->post_type}}_color">
          {{ $entry->author->getDisplayName()." ".$natural_type." ".$entry->qty." ".$entry->title}}
        </h1>

        @if($entry->description)
        <div class="margin-bottom-5 margin-top-30">
          <h2>{{ trans('general.entries.description') }}:</h2>
          <p>{!! Markdown::convertToHtml($entry->description) !!}</p>
        </div>
        @endif

        <a href="{{route('entry.view', $entry->id)}}" class="more_info">More information</a>
      </div> <!-- col-8/12 -->
    </div> <!-- row -->
  </div> <!-- container -->
</section>

<div id="kiosk_footer">
  <a href="{{route('kiosk.categories', ['tag' => $category])}}" class="margin-bottom-40 margin-left-30">
    <img src="/assets/img/kiosk/back_arrow.png" alt="go up a level">
  </a>
  <p>{{trans('footer.powered_by')}} <a href="{{config('app.url')}}"><img src="{{ Helper::cdn('img/hp/anyshare-logo-web-retina-100.png') }}" class="logo"></a></p>
</div>

<script>
$(document).ready(function () {

  //$("#messageSubmit").attr('disabled','disabled'); // disable button until message has been types

  $("#offerForm").submit(function(){
    $('#offerStatusbox').hide();
    $('#offerStatusText').html('');
    $('#offerStatus').html('');
    $('#offerStatusbox').removeClass('alert alert-success alert-danger');
    $('#offerStatusbox').show();

    $.ajax({
      type: "POST",
      url: "{{ route('messages.create.save', [$entry->created_by, $entry->id]) }}",
      data: $('#offerForm').serialize(),

      success: function(data, textStatus, xhr){
        if (data.success) {
          $('#offerStatusbox').addClass('alert alert-success');
          $('#offerStatusText').html('Success! ');
          $('#offerStatus').html(data.message);
        } else {
          $('#offerStatusbox').addClass('alert alert-danger');
          $('#offerStatusText').html('Error: ');
          $('#offerStatus').html(data.message);
        }
      },
      error: function(xhr, textStatus, errorThrown) {
        console.log('xhr.status = ' + xhr.status + '\n' +
          'thrown error = ' + errorThrown + '\n' +
          'xhr.statusText = '  + xhr.statusText + '\n' +
          'textStatus = '  + textStatus + '\n' +
          'responseText = ' + xhr.responseText);

        $('#offerStatusbox').addClass('alert alert-danger');
        $('#offerStatus').html('Something went wrong :(');
      }
    });

    return false;
  });
});

</script>

@stop
