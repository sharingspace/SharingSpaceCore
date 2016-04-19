@extends('layouts/master')

{{-- Page title --}}
@section('title')
     {{ trans('general.entries.edit') }} ::
@parent
@stop


{{-- Page content --}}
@section('content')

<!-- -->
<section>
  <div id="edit_entry" class="container margin-top-20">
    <div class="row">
      <h1 class="margin-bottom-20 size-24 text-center">{{ trans('general.entries.edit') }}</h1>
			<!-- Entry -->

      <!-- entry form -->
      <form method="post" action="{{ route('entry.edit.save', $entry->id) }}" enctype="multipart/form-data" autocomplete="off" class="nomargin">
        {!! csrf_field() !!}
        <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value={{ trans('general.entries.max_size')}} />

        <div class="col-md-3 col-sm-4 col-xs-12" style="border-right:#CCC thin solid;">
          <div class="form-group" style="margin-bottom: 5px;">
            <fieldset class="margin-bottom-10">
              <legend class="sr-only">Exchange by:</legend>

              {{ $errors->first('tile_exchange_type', '<div class="alert-no-fade alert-danger col-sm-12">
                <i class="icon-remove-sign"></i> :message</div>') }}

              <div class="exchange_types">
                <!-- checkboxes for exchange types -->
                <div class="checkbox">
                  @foreach ($whitelabel_group->exchangeTypes as $exchange_types)
                    <div class="col-md-12 pull-left margin-bottom-10">
                      <label class="checkbox col-md-3 pull-left margin-bottom-10">
                        @if (array_key_exists($exchange_types->id, $selected_exchanges))
                          {{ Form::checkbox('exchange_types['.$exchange_types->id.']', $exchange_types->id, true,
                          ['class' => 'exchanges']) }}
                        @else
                          {{ Form::checkbox('exchange_types['.$exchange_types->id.']', $exchange_types->id, false,
                          ['class' => 'exchanges']) }}
                        @endif
                        <i></i>{{ $exchange_types->name }}
                      </label>
                    </div>
                  @endforeach

                  <div class="col-md-12 pull-left margin-bottom-10">
                    <label class="checkbox col-md-12 pull-left margin-bottom-10">
                      {{ Form::checkbox('select_all', 10, false, ['id' => 'select_all']) }}
                      <i></i> all exchanges
                    </label>
                  </div>
                </div>
              </div> <!-- exchange_types -->
            </fieldset>
          </div> <!-- form-group -->
        </div> <!-- col-md-3 -->


        <div class="col-md-9 col-sm-8 col-xs-12">
          <div class="row">
            <div class="col-md-3 margin-bottom-10 {{ $errors->first('post_type', ' has-error') }}">
              <select class="form-control" name="post_type" id="post_type">
              @foreach($post_types as $key=>$val)
                @if ($entry->post_type == $key)
                  <option value="{{ $key }}" selected>{{ $val }}</option>
                @else
                  <option value="{{ $key }}">{{ $val }}</option>
                @endif
              @endforeach
              </select>
            </div> <!-- col 3 -->

            <div class="col-md-3 margin-bottom-10">
                      <!-- stepper -->
              <input type="text" value="{{ Input::old('qty', $entry->qty) }}" min="1" max="1000" class="form-control stepper" id="qty" name="qty">
            </div> <!-- col 3 -->

            <div class="col-md-6 margin-bottom-8 {{ $errors->first('title', ' has-error') }}">
              <!-- Name -->
              <label class="input">
                <input type="text" name="title" id="title" class="form-control" placeholder="Description" value="{{ Input::old('title', $entry->title) }}" autofocus>
              </label>
            </div> <!-- col 6 -->

            <!-- file upload -->
            <div class="col-md-8 margin-bottom-10">
              <div class="fancy-file-upload fancy-file-info">
                <i class="fa fa-picture-o"></i>
                <input  id="choose-file" type="file" class="form-control"  accept="image/jpg,image/png,image/jpeg,image/gif"  name="file" onchange="jQuery(this).next('input').val(this.value);" />
                <input id="shadow_input" type="text" class="form-control" placeholder="{{ trans('general.entries.file_placeholder')}}" readonly="" />
                <span class="button">{{ trans('general.uploads.choose_file') }}</span>
              </div>  <!-- fancy -->
              <p class='too_large smooth_font' style="display:none;font-size:30px">{{ trans('general.entries.max_file_size')}}</p>
            </div> <!-- col 8 -->

            <div class="col-md-1" style="position:relative;height:50px;">
             <div id="image_box" class="pull-left" style="background-size: contain;
position: absolute;background-position: center;background-repeat: no-repeat;height: 100%;width: 100%;">
              </div>
            </div>

            <div class="col-md-3">
              <button id="remove_img_button" class="pull-right smooth_font btn btn-warning btn-sm margin-left-10 margin-top-6">Remove</button>
              <label id="delete_img_checkbox_label" class="pull-right margin-top-6" for="delete_img">
                {{ Form::checkbox('delete_img', 1, 0, ['id'=>'delete_img'])}}
                <i></i> Delete image
              </label>
            </div>

            <div class="col-md-12 margin-bottom-10 {{ $errors->first('title', ' has-error') }}">
              <!-- Description -->
              <label class="input">
                <textarea name="description" rows="5" class="form-control" data-maxlength="200" data-info="textarea-words-info" placeholder="Detailed description...">{{ Input::old('description', $entry->description) }}</textarea>
              </label>
            </div> <!-- col 12 -->

            <div class="col-md-12">
              <!-- Tags -->
              <div class="form-group {{ $errors->first('tags', 'has-error') }}">
                <label class="input">
                  <input type="text" name="tags" id="tags" class="form-control" placeholder="Keywords, comma-separated" value="{{ Input::old('tags', $entry->tags) }}" data-role="tagsinput">
                </label>
              </div> <!-- tags -->
            </div> <!-- col 12 -->

            <!-- Location -->
            <div class="col-md-12 form-group {{ $errors->first('location', 'has-error') }}">
              <label class="control-label" for="location">Location</label>
              <div class="input-group">
                <input type="text" class="form-control" id="location" name="location" placeholder="Near (optional)" aria-describedby="basic-addon2" value="{{{ Input::old('location', $entry->location) }}}" placeholder="Address, City, Country">
                <div class="input-group-addon" id="basic-addon2"><i class="fa fa-location-arrow" id="geolocate"></i></div>
                {!! $errors->first('location', '<span class="help-block">:message</span>') !!}
              </div>
            </div>

            <div class="col-md-10 col-sm-10 col-xs-10">
              <label class="checkbox pull-left" for="visible_checkbox">
                {{ Form::checkbox('private', 1, !Input::old('visible', $entry->visible), array('id'=>'visible_checkbox')) }}
                <i></i> Visible only to you
              </label>
            </div> <!-- col 10 -->

            <!-- save button -->
            <div class="col-md-2 col-sm-2 col-xs-2 margin-bottom-10 text-right">
              <button class="btn btn-info">Save</button>
            </div>
          </div> <!-- row -->
        </div> <!-- col 9 -->
      </form>
    </div>
  </div>
</section>
image = {{$image}}
<script type="text/javascript">
$("#remove_img_button").hide();
$("#delete_img_checkbox_label").hide();

$( document ).ready(function() {
  var image = '{{$image}}';
  var entry_id = '{{$entry->id}}';

  if (image) {
    $('#image_box').css("background-image", "url('/assets/uploads/entries/"+entry_id+"/"+image+"')");
    $("#delete_img_checkbox_label").show();
  }
  else {
    $('#image_box').css("background-image","none");
  }


 $('#choose-file').change( function() {
    var maxSize = $('#MAX_FILE_SIZE').val();
    $('#shadow_input').val($(this).val().replace("C:\\fakepath\\", ""));

    if ($("#choose-file")[0].files[0].size > maxSize) {
      $("#shadow_input").val("");
      $('p.too_large').show().addClass("error_message").fadeOut(5000, "swing");
    }
    else if (!$('#delete_img').prop('checked')) {
      var files = !!this.files ? this.files : [];
      if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

      if (/^image/.test( files[0].type)) { // only image file
        var reader = new FileReader(); // instance of the FileReader
        reader.readAsDataURL(files[0]); // read the local file

        reader.onloadend = function(){ // set insert image before button
          $('#image_box').css("background-image", "url("+this.result+")");
        }
      }
      $("#delete_img_checkbox_label").hide();

      $('#remove_img_button').show();
    }
    else {
      $('#delete_img').prop('checked') = true;
    }
    
    $('#remove_img_button').addClass('notUploaded');
  });

  $('#remove_img_button').click(function(e)
  {
    if ($(this).hasClass('notUploaded')) {
      $(this).removeClass('notUploaded').hide();
      $('#image_box').css("background-image","none");
      $('#choose-file').val('');
      $('#shadow_input').val('');
      if (image) {
        $('#image_box').css("background-image", "url('/assets/uploads/entries/"+entry_id+"/"+image+"')");
        $("#delete_img_checkbox_label").show();
      }
    }

    return false;
  });

  $(document).on( "click", "#select_all", function( e ) {
    $('.exchanges').prop('checked', $(this).prop("checked"));
  });

  $(document).on( "click", ".exchanges", function( e ) {
    $('#select_all').prop('checked', false);
  });
});
</script>
@stop
