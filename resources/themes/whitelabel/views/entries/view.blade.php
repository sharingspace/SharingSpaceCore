@extends('layouts/master')

{{-- Page title --}}
@section('title')
     {{ trans('general.entries.view') }} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<!-- -->
<section>
	<div id="entry_view" class="container padding-top-0">
		<div class="row">
    @if($images && $images[0]->filename)
    	<div class="col-lg-4 col-sm-5 col-xs-12 margin-top-20">
        <div id="image_box_container"> 
          <img id="entryImage" src="{{ Helper::cdn('uploads/entries/'.$entry->id.'/'.$images[0]->filename) }}">
        </div>
      </div> <!-- col-md-4 -->
      
      <div class="col-lg-4 col-sm-7 col-xs-12 margin-top-20">
      @else
      <div class="col-xs-12 margin-top-20">
      @endif
      	<div class="row">
        	<div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-10">
         		<h1 class="size-18 margin-bottom-0"><span class="sr-only">{{ trans('general.entries.view') }},</span> {{ strtoupper($entry->post_type) }}: {{ $entry->title }}</h1>
          </div>

          @if($entry->author->getDisplayName())
          <div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-3">
            <strong class="primaryText">{{ trans('general.entries.by') }}:</strong> {{$entry->author->getDisplayName()}}
          </div>
          @endif

          @if (count($entry->exchangeTypes) > 0)
          <div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-3">
            <?php  $exchanges = array(); ?>
            @for ($i = 0; $i < count($entry->exchangeTypes); $i++)
              <?php array_push($exchanges, strtolower($entry->exchangeTypes[$i]->name)); ?>
            @endfor
            <strong class="primaryText">{{ trans('general.type') }}:</strong> {{implode(', ', $exchanges)}}
          </div>
          @endif

          @if($entry->qty)
          <div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-3">
            <strong class="primaryText">{{ trans('general.entries.qty') }}:</strong> {{$entry->qty}}
          </div>
          @endif

          @if($entry->location)
          <div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-3">
            <strong class="primaryText">{{ trans('general.location') }}:</strong> {{ $entry->location }}
          </div>
          @endif

           @if($entry->description)
          <div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-3">
            <strong class="primaryText">{{ trans('general.entries.description') }}:</strong> {!! Markdown::convertToHtml($entry->description) !!}
          </div>
          @endif

          @if($entry->tags)
          <div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-3">
            <strong class="primaryText">{{ trans('general.keywords') }}:</strong> {{ $entry->tags }}
          </div>
          @endif

          <div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-3">
            <strong class="primaryText">{{ trans('general.entries.visibility') }}:</strong>
            @if($entry->visible)
              {{ trans('general.entries.visible') }}
            @else
              {{ trans('general.entries.not_visible') }}
            @endif          
          </div>

          <!-- if user is admin or owner -->
          <div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-3">
            @if (Auth::check())
            <div class="listing-actions" style="padding-top: 10px;">

              {{ Form::open(array('route'=>array('entry.delete.save',$entry->id))) }}
                {{ Form::token()}}

                @can('update-entry', $entry)
                  <a href="{{ route('entry.edit.form', $entry->id) }}" class="btn btn-xs btn-light-colored tooltipEnable" data-container="body" data-toggle="tooltip" data-placement="bottom" title="Edit This {{ strtoupper($entry->post_type) }}" data-mm-track-label="Edit from Tile View">
                  <i class="fa fa-pencil"></i> {{trans('general.entries.edit_entry')}}</a>

                  @if ($entry->completed_at=='')
                    <a href="{{ route('entry.completed', $entry->id) }}" class="btn btn-xs btn-colored tooltipEnable" data-container="body" data-toggle="tooltip" data-placement="bottom" title="Mark this {{ strtoupper($entry->post_type) }} as completed" data-mm-track-label="Mark as Completed from Tile View">
                    <i class="glyphicon glyphicon-ok"></i> {{ trans('general.entries.completed') }}</a>
                  @endif
                  <button type="submit" class="btn btn-xs btn-dark-colored"><i class='fa fa-trash'></i> {{trans('general.entries.delete')}}</button>
                @endcan

              {{ Form::close() }}
            </div> <!-- listing-actions -->
            @endif <!-- endif user is admin or owner -->
          </div>  <!-- col-md-12 -->
        </div> <!-- col-sm-8 -->
      </div>

  		<div class="col-xs-12 col-sm-12 col-md-12" style="margin-top:20px">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li class="active">
            <a href="#make_offer" role="tab" data-toggle="tab">
              @if (Auth::check())
                @if (Auth::user()->id == $entry->created_by)
                  {{ trans('general.entries.view_offer') }}
                @else
                  {{ trans('general.entries.make_offer') }}
                @endif
              @else
                {{ trans('general.entries.make_offer') }}
              @endif
            </a>
          </li>

          @if ($images && count($images) > 1)
          <li>
            <a href="#view_images_tab" role="tab" data-toggle="tab">{{ trans('general.entries.more_images') }}</a>
          </li>
          @endif

          <!-- <li><a id="view_map_tab" href="#view_map" role="tab" data-toggle="tab">View Map</a></li> -->
          <!-- <li>
            <a id="view_comment_tab" href="#comments" role="tab" data-toggle="tab">{{ trans('general.entries.comments_tab') }}</a>
          </li> -->
        </ul> <!-- nav-tabs -->

        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active" id="make_offer">
            <div class="col-xs-12 col-sm-12 col-md-12 margin-top-6">
              <div class="alert alert-dismissable" style="display: none;" id="offerStatusbox">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="fa fa-exclamation-circle"></i>
                <strong id="offerStatusText"></strong><span id="offerStatus"></span>
              </div> <!-- alert -->

              @if (Auth::check())
                @if (Auth::user()->id != $entry->created_by)
                  @if ((!$entry->expired) && ($entry->completed_at==''))
                  <form id="offerForm">
                    <p class='margin-bottom-6 pull-right size-11'><i class='fa fa-asterisk'></i> {{ trans('general.entries.only_owner') }}</p>

                    <!--MAKE AN OFFER-->
                    {!! csrf_field() !!}
                    <div class="col-md-12 margin-bottom-8 {{ $errors->first('title', ' has-error') }}">
                      <!-- Subject -->
                      <label class="input">
                        <input type="text" name="subject" class="form-control" placeholder="Subject &#133;" autofocus>
                      </label>
                    </div> <!-- col 12 -->

                    <div class="col-xs-12 col-sm-12 col-md-12 form-group clearfix">
                      <textarea rows="5" name="message" id="message" class="form-control" placeholder="{{ trans('general.entries.subject_placeholder') }}"></textarea>
                    </div>  <!-- col-xs-12 -->

                    <p class='margin-bottom-6 pull-left'>{{ trans('general.entries.i_would_like') }}</p>
                    <div class="col-xs-12 col-sm-12 col-md-12 padding-bottom-20">
                      <div class="form-group {{ $errors->first('message', 'has-error') }}">
                        <ul class="exchange_types">
                        @if (count($entry->exchangeTypes) > 0)
                          @for ($i = 0; $i < count($entry->exchangeTypes); $i++)
                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                              <input type="checkbox" name="exchange_types[]" value="{{ strtolower($entry->exchangeTypes[$i]->name) }}" id="{{strtolower($entry->exchangeTypes[$i]->name) }}"> 
                              {{ $entry->exchangeTypes[$i]->name }}
                            </div> <!-- col-sm-3 -->
                          @endfor
                        @endif
                        </ul> <!-- exchange_types -->
                      </div> <!-- form-group -->
                    </div> <!-- col-xs-12 -->

                    <div class="col-md-9 col-sm-12 col-xs-12 form-group" id="amountbox" style="display:none;">
                      <div class="col-md-3">
                        <p class="help-block">{{ trans('general.entries.offer_amount') }}</p>
                      </div>

                      <div class="input-group col-md-3">
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-usd"></span>
                        </span>
                        <input type="text" id="amount" name="amount" class="form-control" value="{{{ Input::old('amount') }}}">
                      </div>
                    </div>  <!-- col-md-9 -->

                    <div class="col-xs-12 col-sm-12  col-md-3  form-group pull-right">
                      <button type="submit" class="btn btn-warning pull-right" id="messageSubmit">{{ trans('general.entries.make_offer') }}</button>
                    </div>  <!-- col-md-3 -->
                  </form>

                  @else  <!-- expired -->
                    @if ($entry->expired)
                      <p>{{ trans('general.entries.sorry_expired') }}</p>
                    @elseif ($entry->completed_at!='')
                      <p>{{ trans('general.entries.completed_interest') }} <a href="{{ route('entry.create.form') }}">{{ trans('general.entries.list') }}</a></p>
                    @endif
                  @endif <!-- expired -->
                @else
                  <p>{{ trans('general.entries.offer_here') }}</p>
                @endif <!-- user -->
              @else
                <p>{{ trans('general.entries.please') }} <a class="btn btn-warning btn-xs" href="/auth/signin">{{ trans('general.entries.offer_here') }}{{ trans('general.entries.sign_in') }}</a> {{ trans('general.entries.or') }} <a class="btn btn-info btn-xs" href="/auth/signup">{{ trans('general.entries.sign_up') }}</a> {{ trans('general.entries.to_make_offer') }}</p>
              @endif <!-- logged in -->

            </div> <!-- col-xs-12 -->
          </div> <!-- tab-pane -->

          <div class="tab-pane" id="view_images_tab">
          @if($images)
            @foreach ($images as $image)
              <div class="col-xs-3 col-sm-3 col-md-3" style="margin-top:20px;object-fit:contain;">
                <img src="{{ Helper::cdn('uploads/entries/'.$entry->id.'/'.$image->filename) }}" height="250" width="250" border="1">
              </div>
            @endforeach
          @endif
          </div>

          <div class="tab-pane" id="view_map">
            <!--MAP-->
            @if (($entry->latitude!='') && ($entry->longitude!=''))
              <div id="map" style="height: 250px;"></div>
            @else
              <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top:20px;">
                <p>{{ trans('general.entries.no_location') }}</p>
              </div>
            @endif <!-- latitude, longitude -->
          </div> <!-- tab-pane -->

          <div class="tab-pane" id="comments">
            <p class="help-block">{{trans('general.entries.public_comments')}}</p>
            <div class="fb-comments" data-href="{{ URL::to('entry/'.$entry->id.'/view/') }}" data-numposts="5" data-colorscheme="light" data-width="800" style="width: 100%">
            </div>
          </div>  <!-- tab-pane -->
        </div> <!-- tab-content -->
      </div> <!-- col-xs-12 -->
    </div> <!-- row -->

    <!-- The Modal -->
    <div id="myModal" class="imageModal">
      <!-- The Close Button -->
      <span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>
      <!-- Modal Content (The Image) -->
      <img class="modal-content" id="img01">
    </div>
  </div>
</section>

<script>
$(document).ready(function () {

  // Get the modal
  var modal = document.getElementById('myModal');

  // Get the image and insert it inside the modal - use its "alt" text as a caption
  if ($("#entryImage").length) {
    var img = document.getElementById('entryImage');
    var modalImg = document.getElementById("img01");
    img.onclick = function(){
      modal.style.display = "block";
      modalImg.src = this.src;
    }
  }

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
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
