@extends('layouts/master')

{{-- Page title --}}
@section('title')
     {{ trans('general.entries.create') }} ::
@parent
@stop

{{-- Page content --}}
@section('content')
  <section class="container">
    <div class="row">
     <h1 class="margin-bottom-0 size-24 text-center">{{ trans('general.entries.create') }}</h1>

      <!-- Added tiles .... -->
      <div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12 margin-bottom-0">
        <table class="table" id="create_table" style="display:none;">
          <caption>You Added</caption>
          <thead>
            <tr>
              <th>{{ trans('general.entries.post_type') }}</th>
              <th>{{ trans('general.entries.qty') }}</th>
              <th>{{ trans('general.entries.title') }}</th>
              <th>{{ trans('general.entries.exchange_types') }}</th>
              <th>{{ trans('general.entries.keywords') }}</th>
              <th>Action</th>
              <th style='display:none'></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </section>

	<section>
  	<div id="add_tile_wrapper" class="container">
  		<div class="row">
  			<!-- Entry -->
  			<div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
  				<div class="row">
            <div id="submission_error" class="alert" style="display:none" >
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <i class="fa margin-right-10"></i>{{ trans('general.entries.messages.errors') }}
            </div>
          </div>
        </div> <!-- col 10 -->

        <!-- entry form -->
        <form method="post" action="{{ route('entry.create.ajax.save') }}" enctype="multipart/form-data" autocomplete="off" class="nomargin" id='entry_form'>
          {!! csrf_field() !!}
          <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value={{ trans('general.entries.max_size')}} />
					<input type="hidden" name="upload_key" id="upload_key" value="" />
          <div class="row">
            <div class="col-md-9 col-sm-8 col-xs-12 col-md-push-3 col-sm-push-4">
          		<div class="row">
            		<div class="col-md-3 margin-bottom-10">
                	<select class="form-control" name="post_type" id="post_type">
                  	<option value="want">{{ trans('general.entries.want')}}</option>
                  	<option value="have">{{ trans('general.entries.have')}}</option>
                	</select>
            		</div> <!-- col 3 -->
                <div class="col-md-3 margin-bottom-10">
                  <!-- stepper -->
                  <input type="text" value="{{ Input::old('qty', 1) }}" min="1" max="1000" class="form-control stepper" id="qty" name="qty">
                </div> <!-- col 3 -->
            		<div class="col-md-6 margin-bottom-8">
              		<!-- Name -->
              		<label class="input">
      		          <input type="text" name="title" id="title" required='' class="form-control" placeholder="{{ trans('general.entries.title_placeholder')}}" autofocus>
              		</label>
            		</div> <!-- col 6 -->

                <!-- File upload   -->
                <div class="col-md-8 col-sm-8 col-xs-12 form-group">
                  <div class="fancy-file-upload fancy-file-info">
                    <i class="fa fa-picture-o"></i>
                    <input id="choose-file" type="file" class="form-control" accept="image/jpg,image/png,image/jpeg,image/gif" name="file" onchange="jQuery(this).next('input').val(this.value);"/>
                    <input id="shadow_input" type="text" class="form-control" placeholder="{{ trans('general.entries.file_placeholder')}}" readonly="" />
                    <span class="button">{{ trans('general.uploads.choose_file') }}</span>
                  </div> <!-- fancy -->
                  <p class='too_large smooth_font' style="display:none;font-size:30px">{{ trans('general.entries.max_file_size')}}</p>
                </div> <!-- col 11 -->

                <div class="col-md-1 col-sm-4 col-xs-12" id="current_image" style="position:relative;height:50px;">
                 <div id="image_box" class="pull-left" style="background-size: contain;
  position: absolute;background-position: center;background-repeat: no-repeat;height: 100%;width: 100%;">
                  </div>
                </div>
                <div class="col-md-3">
                  <button id="delete_img_button" class="pull-right smooth_font btn btn-warning btn-sm margin-left-10 margin-top-6">Remove</button>
                  <label id="delete_img_checkbox_label" class="pull-right margin-top-6" for="delete_img">
                    {{ Form::checkbox('delete_img', 1, 0)}}
                    <i></i> Delete image
                  </label>
                </div>

             		<div class="col-md-12">
                  <div class="form-group">
                    <!-- Description -->
                    <label class="input">
                      <textarea name="description" rows="5" class="form-control" data-maxlength="200" id="description" data-info="textarea-words-info" placeholder="{{ trans('general.entries.details_placeholder')}}"></textarea>
                    </label>
                  </div> <!-- form group -->
                </div> <!-- col 12 -->

                <div class="col-md-12">
                  <!-- Tags -->
                  <div class="form-group">
                    <label class="input">
                  		<input data-role="tagsinput" type="text" name="tags" id="tags"  class="col-md-12 form-control" placeholder="{{ trans('general.entries.tag_placeholder')}}">
                		</label>
                  </div> <!-- tags -->
                </div> <!-- col 12 -->
                
                <div class="col-md-12">
                  <!-- Location -->
                  <div class="form-group">
                    <label class="control-label sr-only" for="location">Location</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="location" name="location" placeholder="{{ trans('general.entries.location_placeholder')}}" aria-describedby="basic-addon2" value="{{{ Input::old('location', Auth::user()->location) }}}">
                      <div class="input-group-addon" id="basic-addon2">
                        <i class="fa fa-location-arrow" id="geolocate"></i>
                      </div>
                    </div> <!-- input-group -->
                  </div> <!-- form-group -->
                </div>

                <div class="col-md-10 col-sm-10 col-xs-10">
                  <label class="checkbox pull-left" for="visible_checkbox">
                    {{ Form::checkbox('private', 1, 0, array('id'=>'visible_checkbox')) }}
                    <i></i> {{ trans('general.entries.visible')}}
                  </label>
                </div> <!-- col 10 -->

                <div class="col-md-2 col-sm-2 col-xs-2 ">
                  <button class="btn btn-info pull-right" id="ajaxAdd" name="ajaxAdd" value="ajaxAdd">{{ trans('general.entries.save') }}</button>
                </div> <!-- col 2 -->
              </div> <!-- row -->
            </div> <!-- col 9 -->

            <div class="col-md-3 col-sm-4 col-xs-12 col-md-pull-9 col-sm-pull-8" > <!-- style="border-right:#CCC thin solid;" -->
              <div class="form-group" style="margin-bottom: 5px;">
                <fieldset class="margin-bottom-10">

                  <legend class="sr-only">Exchange by:</legend>
                  <div class="exchange_types">
                    <!-- checkboxes for exchange types -->
                    <div class="checkbox">
                      @foreach ($whitelabel_group->exchangeTypes as $exchange_types)
                        <div class="col-md-12 pull-left margin-bottom-10">
                          <label class="checkbox col-md-12 pull-left margin-bottom-10 padding-left-10">
                            {{ Form::checkbox('exchange_types['.$exchange_types->id.']', $exchange_types->id, true, ['class' => 'exchanges']) }}
                            <i></i> {{ $exchange_types->name }}
                          </label>
                        </div>
                      @endforeach
                      <div class="col-md-12 pull-left margin-bottom-10">
                        <label class="checkbox col-md-12 pull-left margin-bottom-10">
                          {{ Form::checkbox('select_all', 10, false, ['id' => 'select_all']) }}
                          <i></i> {{trans('general.community.all_exchanges')}}
                        </label>
                      </div>
                    </div>
                  </div> <!-- exchange_types -->
                </fieldset>
              </div> <!-- form-group -->
            </div> <!-- col-md-3 -->
          </div>  <!-- row -->
        </form>
      </div> <!-- row -->
		</div> <!-- add_tile_wrapper -->
	</section>
	<!-- / -->


<script type="text/javascript">

$("#ajaxAdd").attr('disabled','disabled'); // disable add button until page has loaded
$("#create_table").hide(); // hide entry table
$("#delete_img_button").hide();
$("#delete_img_checkbox_label").hide();

$( document ).ready(function() {
	$("#ajaxAdd").removeAttr('disabled');//enable add button	now page has loaded

	$(document).on( "click", ".button_edit", function( e ) {
		e.preventDefault();
		editEntry($(this));
	});

	$(document).on( "click", ".button_delete", function( e ) {
		e.preventDefault();
		deleteEntry($(this));
    });

	$(document).on( "click", "#select_all", function( e ) {
    $('.exchanges').prop('checked', $(this).prop("checked"));
			});

	$(document).on( "click", ".exchanges", function( e ) {
		$('#select_all').prop('checked', false);
	});

  $(document).on( "click", "#ajaxAdd", function( e ) {
    // finish_submit will get invoked later, after
    // we handle the file upload.
    e.preventDefault();
    var newUpload_key = Math.random().toString(36).substring(7);
    $('#upload_key').val(newUpload_key);

    // do what you like with the input, if we have an image, handle that separately
    if ($('#choose-file').val()) {
      uploadFiles();
		}
		else {
      finish_submit()
		}
  });

  $("#choose-file").change(function() {
    $('#shadow_input').val($(this).val().replace("C:\\fakepath\\", ""));
    var files = !!this.files ? this.files : [];
    if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

    if (/^image/.test( files[0].type)){ // only image file
      var reader = new FileReader(); // instance of the FileReader
      reader.readAsDataURL(files[0]); // read the local file

      reader.onloadend = function(){ // set insert image before button
        $('#image_box').css("background-image", "url("+reader.result+")");
      }
    }
    $('#delete_img_button').addClass('notUploaded').show();
  });

  $('#delete_img_button').click(function(e)
  {
    if ($(this).hasClass('notUploaded')) {
      $(this).removeClass('notUploaded').hide();
      $('#image_box').css("background-image","none");
      $('#choose-file').val('');
    }
    return false;
  });

  $('#choose-file').change( function() {
    var maxSize = $('#MAX_FILE_SIZE').val();
    if ($("#choose-file")[0].files[0].size > maxSize) {
      $("#shadow_input").val("");
      $('p.too_large').show().addClass("error_message").fadeOut(5000, "swing");
      }
  });

  function finish_submit(e, data)
  {
    entry_id = isEdit(); 
    if (entry_id) {
      create = false;
        post_url=entry_id+"/edit/ajax";
  		}
    else {
      create = true;
      post_url="new/ajax";
    }

    // start the create or save ajax call off
    $.post(post_url,$('#entry_form').serialize(),function (data)
    {
      if (data.success) {
          if( $('#create_table tr').length == 1) {
            $('#create_table').show();
          }

          resetForm();
          // clear allc heckboxes and then select the ones we want
          $('input:checkbox[class=exchanges]').prop('checked',false);
          jQuery.each(data.typeIds, function(index, item) {
            $('input:checkbox[class=exchanges][value='+item+']').prop('checked',true);
          });
          var exchanges = null;
          if (data.exchange_types) {
            exchanges=data.exchange_types.join(", ");
          }

          if (data.typeIds.length) {
            exchangeIds=data.typeIds.join(",");
          }

          if (data.create) {
            addTableRow(data, exchanges, exchangeIds);
          }
  			else
        {
          updateTableRow(data, exchanges, exchangeIds)
        }
      } 
      else {
        // clear any old error lists
        $('#error-list').remove();
        errorsHtml='<ul id="error-list" class="list-unstyled margin-bottom-0">';
        $.each( data.errors, function( key, value ) {
          errorsHtml += '<li class="margin-left-20"><strong>' + value + '</strong></li>'; 
        });
        errorsHtml+='</ul>';
        displayFlashMessage("danger",errorsHtml);
      }
    }).fail(function (jqxhr,errorStatus) {
      parseAndDisplayError(errorStatus);
    });
  }

  // Catch the form submit and upload the files
  function uploadFiles()
  {
    // Create a formdata object and add the files
    var data = new FormData();
    var image=$('input[type=file]')[0].files[0];
    var upload_key = Math.random().toString(36).substring(7);
    $('#upload_key').val(upload_key);
    data.append('_token', $('input[name=_token]').val());
    data.append('image', image);
    data.append('upload_key', upload_key);

    entry_id = isEdit(); 
    if (entry_id) {
      data.append('entry_id', entry_id);
    }

    $.ajax(
    { 
      url:'/entry/upload',
      type: 'POST',
      data: data,
      dataType: 'json',
      processData: false, // Don't process the files
      contentType: false, // Set content type to false as jQuery will tell the server it i
                          // is a query string request. This is why we can't use $.post here
      timeout: 15000, // 15 second timeout
      success: function(data, textStatus, jqXHR)
      {
        if (data.success) {
          // Success so call function to process the form
          finish_submit(event, data);
        }
        else {
          // Handle errors here
          displayFlashMessage("danger", data.errors);
        }
          },
      error: function(jqXHR, textStatus, errorThrown)
      {
        // Handle errors here
        displayFlashMessage("danger",textStatus);
      }
    });
  }

  function editEntry(object)
  {
    var entry_id = object.attr('data-entryid') ;

    $.get(entry_id+"/ajaxgetentry",function (data)
    {
      if (data.success) {
        // reload our form
        $("#post_type").val(data.post_type);
        $("#title").val(data.title).addClass( "update_"+data.entry_id);
        $('#qty').val(data.qty);
        $('#description').val(data.description);
        $('#location').val(data.location);
        $(".bootstrap-tagsinput input").val(data.tags);
        // uncheck all exchange checkboxes
        $('input:checkbox[class=exchanges]').prop('checked',false);
        // now check the one we want checked
        jQuery.each(data.exchange_type_ids, function(index, item) {
          $('input:checkbox[class=exchanges][value='+item+']').prop('checked',true);
        });
        $('input:checkbox[id=visible_checkbox]').prop('checked',!data.visible);

        if (data.image) {
          $("#delete_img_checkbox_label").show();
          $('#image_box').css("background-image", "url('/assets/uploads/entries/"+data.entry_id+"/"+data.image+"')");
        }
      }
      else {
        displayFlashMessage("danger",data.errors);
      }
    }).fail(function (jqxhr,errorStatus) {
      parseAndDisplayError(errorStatus);
	});
  }

  function deleteEntry(object)
  {
    var entry_id = object.data("entryid");
    var myrow = object.closest('tr');

    $.post(entry_id+"/delete/ajax",{_token: $('input[name=_token]').val()},function (replyData)
    {
      if (replyData.success) {
        myrow.remove();
        // count how many rows we have, if we only have the header row hide the table
        if ($('#create_table tr').length == 1) {
          $('#create_table').css('display','none');
        }

        // were we editing it at the time?
        if ($("#title").hasClass("update_"+entry_id)) {
          $("#title").removeClass( "update_"+entry_id);
          $('input:checkbox[id=visible_checkbox]').prop('checked',false);
          resetForm();
		    }
      } 
      else {
        displayFlashMessage("danger",replyData.error);
      }
    }).fail(function (jqxhr,errorStatus) {
      parseAndDisplayError(errorStatus);
	});
  }

  function displayFlashMessage(status, message)
  {
    if ('success' == status ) {
      $('#submission_error i').addClass("fa-check").removeClass("fa-exclamation-circle");
		}
		else {
      $('#submission_error i').addClass("fa-exclamation-circle").removeClass("fa-check");
		}

    $('#submission_error').append(message);
    $('#submission_error').addClass("alert-"+status).show();
  }

  function restorePlaceholder(element, ph_text)
  {
    $(element).val("");
    $(element).attr('placeholder',ph_text);
  }

  function resetForm()
  {
    // reset the form and tagsinput
    $('#entry_form')[0].reset();
    $('#tags').tagsinput('removeAll');
    $('#delete_img_button').removeClass('notUploaded').hide();
    $('#image_box').css("background-image","none");
	}

  // smart server error messages
  function parseAndDisplayError(error)
  {
    var message = '';
    for (var err in error) {
      message += '<li>' + error[err] + '</li>';
      $('#' + err).parent().addClass('has-error');
			}

    $('#submission_error').html(message).show();
	}

	function trimString(yourString, maxLength)
  {
		//trim the string to the maximum length
		if(yourString.length > maxLength)	{
			var trimmedString = yourString.substr(0, maxLength);

			//re-trim if we are in the middle of a word
			trimmedString = trimmedString.substr(0, Math.min(trimmedString.length, trimmedString.lastIndexOf(" ")))
			trimmedString += " " +String.fromCharCode(8230);

			return trimmedString;
		}

		return yourString;
	}

  function addTableRow(replyData, exchanges, exchangeIds)
  {
    $('#create_table tr:last').after(
      '<tr id="tr_'+replyData.entry_id+'">'+
        '<td class="td_post_type">'+replyData.post_type.toUpperCase()+'</td>'+
        '<td class="td_qty">'+replyData.qty+ '</td><td class="td_title">'+trimString(replyData.title, 60)+'</td>'+
        '<td class="td_exchanges">'+exchanges+ '</td>'+
        '<td class="td_tags">'+replyData.tags + '</td>'+
        '<td>'+
          '<button class="button_delete smooth_font btn btn-warning btn-sm" data-entryid="'+replyData.entry_id+'"><i class="fa fa-trash-o fa-lg"></i></button>'+
          '<button class="button_edit smooth_font btn btn-info btn-sm" data-entryid="'+replyData.entry_id+'"><i class="fa fa-pencil fa-lg"></i></button>'+
        '</td>'+
      '</tr>');
  }

  function updateTableRow(data, exchanges, exchangeIds)
  {
    var entry_id = data.entry_id;
    $("#ajaxAdd").html("{{ trans('general.entries.save') }}");
    $("#title").removeClass( "update_"+entry_id);
    $("input#title").focus();

    $('tr#tr_'+entry_id+' .td_post_type').html(data.post_type.toUpperCase());
    $('tr#tr_'+entry_id+' .td_title').html(trimString(data.title, 60));
    $('tr#tr_'+entry_id+' .td_description').html(data.description);
    $('tr#tr_'+entry_id+' .td_qty').html(data.qty);
    $('tr#tr_'+entry_id+' .td_exchanges').html(exchanges);
    $('tr#tr_'+entry_id+' .td_tags').html(data.tags);
  }

  function isEdit()
  {
    var entryClass = $('#title').prop('class');
    position = entryClass.indexOf("update_");
    return (position>=0) ? entryClass.match(/\d+/g) : null;  
  }

});

</script>
@stop


