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


        <!-- Added tiles .... -->
        <div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
        <h1 class="size-16 uppercase margin-bottom-20">{{ trans('general.entries.create') }}</h1>

        <table class="table" id="create_table" >
          <caption>You Added</caption>
          <thead>
              <tr>
                  <th>{{ trans('general.entries.post_type') }}</th>
                  <th>{{ trans('general.entries.qty') }}</th>
                  <th>{{ trans('general.entries.title') }}</th>
                  <th>{{ trans('general.entries.exchange_types') }}</th>
                  <th>Action</th>
                  <th style='display:none'></th>
              </tr>
          </thead>
        </table>
        </div>
      </div>
    </section>

			<section>

				<div id="add_tile_wrapper" class="container margin-top-20">
					<div class="row">
						<!-- Entry -->
						<div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
							<div class="row">

                <div class="alert alert-danger" style="display:none" id="submission_error"></div>

                <!-- entry form -->

                <form method="post" action="{{ route('entry.create.ajax.save') }}" enctype="multipart/form-data" autocomplete="off" class="nomargin" id='entry_form'>
                  {!! csrf_field() !!}
                  <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="4096000" />
    							<input type="hidden" name="upload_key" id="upload_key" value="" />

                  	<div class="col-md-3 col-sm-4 col-xs-12" style="border-right:#CCC thin solid;">

                    	<div class="form-group" style="margin-bottom: 5px;">
                      	<fieldset class="margin-bottom-10">

                        	<legend class="sr-only">Exchange by:</legend>

                          {{ $errors->first('tile_exchange_type', '<div class="alert-no-fade alert-danger col-sm-12"><i class="icon-remove-sign"></i> :message</div>') }}
													<div class="exchange_types">

                            <!-- checkboxes for exchange types -->
                              <div class="checkbox">
                              @foreach ($whitelabel_group->exchangeTypes as $exchange_types)
                              <div class="col-md-12 pull-left margin-bottom-10">
                                <label class="checkbox col-md-12 pull-left margin-bottom-10">
                                {{ Form::checkbox('exchange_types['.$exchange_types->id.']', $exchange_types->id, $exchange_types->id, ['class' => 'exchanges']) }}
                                  <i></i> {{ $exchange_types->name }}
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

                  		<fieldset class="nomargin">
                    		<div class="col-md-2 margin-bottom-10 {{ $errors->first('post_type', ' has-error') }}">
                        	<select class="form-control" name="post_type" id="post_type">
                          	<option value="want">I want</option>
                          	<option value="have">I have</option>
                        	</select>
                    		</div>
                        <div class="col-md-2 margin-bottom-10">
                          <!-- stepper -->
                          <input type="text" value="{{ Input::old('qty', 1) }}" min="1" max="1000" class="form-control stepper" id="qty" name="qty">
                        </div>
                    		<div class="col-md-6 margin-bottom-8 {{ $errors->first('title', ' has-error') }}">
                      		<!-- Name -->
                      		<label class="input">
                        		<input type="text" name="title" id="title" class="form-control" placeholder="Description">
                            <span class="fa fa-asterisk inputErr"></span>
                            <span class="fa fa-asterisk noInputErr" style="display:none;"></span>
                      		</label>
                    		</div>

                   		</fieldset>
                      <!-- File upload -->
                      <div class="col-md-10 form-group {{ $errors->first('file', 'has-error') }}">
                        <div class="fancy-file-upload fancy-file-info">
                          <i class="fa fa-picture-o"></i>
                          <input id="choose-file" type="file" class="form-control" name="file" onchange="jQuery(this).next('input').val(this.value);"/>
                          <input id="shadow_input" type="text" class="form-control" placeholder="no file selected" readonly="" />
                          <span class="button">{{ trans('general.uploads.choose_file') }}</span>
                        </div>
                      </div>
                   		<div class="col-md-10">
                        <div id="prefs_panel">

                          <div class="form-group {{ $errors->first('description', 'has-error') }}">
                            <!-- Description -->
                            <label class="input">
                              <textarea name="description" rows="5" class="form-control" data-maxlength="200" id="description" data-info="textarea-words-info" placeholder="Detailed description..."></textarea>
                            </label>
                          </div>

                          <!-- Tags -->
                          <div class="form-group {{ $errors->first('tags', 'has-error') }}">
                            <label class="input">
                          		<input type="text" name="tags" id="tags" class="form-control" placeholder="Keywords, comma-separated">
                        		</label>
                          </div>


                          <!-- Location -->
                          <div class="form-group {{ $errors->first('location', 'has-error') }}">
                            <label class="control-label sr-only" for="location">Location</label>
                            <div class="input-group">
                              <input type="text" class="form-control" id="location" name="location" placeholder="Near (optional)" aria-describedby="basic-addon2" value="{{{ Input::old('location', Auth::user()->location) }}}">
                              <div class="input-group-addon" id="basic-addon2">
                                <i class="fa fa-location-arrow" id="geolocate"></i>
                              </div>
                              {!! $errors->first('location', '<span class="help-block">:message</span>') !!}
                           </div>
                          </div>



                          <div class="col-md-10 col-sm-10 col-xs-10">
                            <label class="checkbox pull-left" for="visible_checkbox">
                              {{ Form::checkbox('private', 1, 0, array('id'=>'visible_checkbox')) }}
                              <i></i> Visible only to you
                            </label>
                          </div>
                          <div class="col-md-2 col-sm-2 col-xs-2 ">
                          <button class="btn btn-success" id="ajaxAdd" name="ajaxAdd" value="ajaxAdd">Create</button>

                          </div>
                        </div> <!-- prefs panel -->
                       </div>
                    </div>

                </form>
              </div>
						</div>
					</div>


				</div>
			</section>
			<!-- / -->


<script type="text/javascript">

$("#ajaxAdd").attr('disabled','disabled'); // disable add button until page has loaded
$("#create_table").hide();

$( document ).ready(function() {

	$("#ajaxAdd").removeAttr('disabled');//enable add button	now page has loaded

	if ($('#visible_checkbox').is(":checked")) {
		$('#select_hub').hide();
	}else {
		$('#select_hub').show();
	}

	$(document).on( "click", "#visible_checkbox", function( e ) {
		$('#select_hub').toggle();
	});

	$('#title').on('input', function() {
		if($(this).val().length < 3) {
			$(".noInputErr").hide();
			$(".inputErr").show();
		}
		else {
			$(".inputErr").hide();
			$(".noInputErr").show();
		}
	});

	$(document).on( "click", ".button_edit", function( e ) {
		e.preventDefault();
		$(".inputErr").hide();
		$(".noInputErr").show();
		var entry_id = $(this).attr('data-entryid') ;
		var title = $(this).closest('tr').children('td.td_title').html();
		var post_type = $(this).closest('tr').children('td.td_post_type').html();
		var qty = $(this).closest('tr').children('td.td_qty').html();
		var desc = $(this).closest('tr').children('td.td_description').html();
    //console.warn("Title is: "+title +", post type is: "+post_type+", quantity is: "+qty+", entry id is: "+$(this).prop('class')+entry_id);

		$("#title").val(title);
		$('#qty').val(qty);
		$('#description').val(desc);
		$("#title").css('background-color','FFFFCC').animate({
            'background-color': 'white'
            //your input background color.
       			 }, 2000);
		$("#title").focus();
		$("#title" ).addClass( "update_"+entry_id);
		$("#ajaxAdd").html("Update");
	});

	$(document).on( "click", ".button_delete", function( e ) {
		e.preventDefault();
		//var tile = $(this).closest('.tile_container').prop("id");
		var entry_id = $(this).data("entryid");
    var myrow = $(this).closest('tr');
		//console.log("delete clicked on entry: "+entry_id);
    $.post(entry_id+"/delete/ajax",{_token: $('input[name=_token]').val()},function (replyData) {
      //console.log("delete success :-)  "+replyData.entry_id);
      if(replyData.success) {
        //$('td.entry_'+replyData.entry_id).closest('tr').remove();
        myrow.remove();

        // count how many rows we have, if we only have the header row hide the table
        if( $('#create_table tr').length == 1) {
          $('#create_table').css('display','none');
        }
      } else {
        // TODO: display some kind of error?
      }
    }).fail(function (jqxhr,errorStatus) {
      window.alert("Server error status is: "+errorStatus);
      $('#tile_'+entry_id +' .delete_error').html('<p style="margin-top:5px">'+replyData.error+'</p>').show();
    });
	});


	$(document).on( "click", "#select_all", function( e ) {
		//e.preventDefault();
		if(this.checked) {
			$('.exchanges').each(function(e) {
				this.checked = true;
			});
		}
		else {
			$('.exchanges').each(function(e) {
				this.checked = false;
			});
		}
	});

	$(document).on( "click", ".exchanges", function( e ) {
		$('#select_all').prop('checked', false);
	});

	function updateExisting() {
		// has title text changed?
		$focusedTitle = $(':focus');
		if( $focusedTitle ) {
			return !($focusedTitle.val() == $focusedTitle.data().initail)
		}
		else {
			return false;
		}
	}

	function restorePlaceholder(element, ph_text) {
    $(element).val("");
		$(element).attr('placeholder',ph_text);
	}

  // Return smart server error messages
  function parseAndDisplayError(error) {
    var message = '';
    for (var err in error) {
      message += '<li>' + error[err] + '</li>';
      $('#' + err).parent().addClass('has-error');
    }
    $('#submission_error').html(message).show();
  }

  $("#choose-file").change(function() {
    $('#shadow_input').val($(this).val().replace("C:\\fakepath\\", ""));
  });

	$(document).on( "click", "#ajaxAdd", function( e ) {
    // finish_submit will get invoked later, after
    // we handle the file upload. But we have to define
    // it before we call it.
    var finish_submit = function (img_upload_results) {
      if(img_upload_results && !img_upload_results.success) {
        alert("Error uploading image file!");
        return false;
      }
  		var save = true;

  		var title = $("#title").val();
  		if(title.length < 3 && false) {
  			restorePlaceholder("#title", "Your want or have must be at least 3 characters long")
  			setTimeout(function() {
  					restorePlaceholder("#title", "Press enter to save");
  				}, 2000);
        return;
  		}

  		if($('.exchange_types input:checked').length == 0) {
        $('#submission_error').text('Please select at least one exchange type').show();
        return;
  		}

  		if(!title) {
        //I suspect that this will never fire; validation will catch this
        return;
      }

      var post_url="new/ajax";
  		var tileClasses = $('#title').prop('class');
  		position = tileClasses.indexOf("update_");
  		if(position>=0) {
  			entry_id = tileClasses.match(/\d+/g);
  			//console.log("update, edit = true "+entry_id+"  "+tileClasses);
  			save = false;
        post_url=entry_id+"/edit/ajax";
  		}

      //console.warn("Serialized Post is: "+$('#entry_form').serialize());
      $.post( post_url, $('#entry_form').serialize(),function (replyData) {
      	//console.warn("Yay we posted! Here's our reply: ");
        //console.dir(replyData);
        if(!replyData.success) {
          //console.log("Create: failed ************************************"+replyData.error)
          parseAndDisplayError(replyData.error);
          return;
        }

        if (replyData.exchange_types) {
          var exchanges=replyData.exchange_types.join(", ");
        }

        // reset the form
        $('#entry_form')[0].reset();

        if(replyData.save)
        {
          $('#submission_error').hide();

          if( $('#create_table tr').length == 1) {
            $('#create_table').show();
          }

  				// is this an edit or a save?
  				$('#create_table tr:last').after('<tr id="tr_'+replyData.entry_id+'"><td class="td_post_type">'+replyData.post_type.toUpperCase()+'</td><td class="td_qty">'+replyData.qty+ '</td><td class="td_title">'+
  				trimString(replyData.title, 60)+'</td><td class="td_exchanges">'+exchanges+ '</td><td><button class="button_delete smooth_font btn btn-warning btn-sm" data-entryid="'+replyData.entry_id+'"><i class="fa fa-trash-o fa-lg"></i></button> <button class="button_edit smooth_font btn btn-info btn-sm" data-entryid="'+replyData.entry_id+'"><i class="fa fa-pencil fa-lg"></i></button> <button class="smooth_font image_button btn btn-info btn-sm" data-entryid="'+replyData.entry_id+'"><i class="fa fa-picture-o fa-lg"></i></button></td><td style="display:none;"  class="td_description">'+replyData.description+'</td></tr>');

  				$(".inputErr").show();
  				$(".noInputErr").hide();
         	//console.warn("End of create 'save' branch and of the entire callback");
        }
  			else
        {
  				$("#ajaxAdd").html("Create");

          //console.log("Edit response  "+replyData.success) ;
          $("#title").removeClass( "update_"+entry_id);

          tile_info = "I "+replyData.post_type + " "+replyData.title;
          lastEntryDiv = $("#tile_"+entry_id);
          $("#tile_"+entry_id +" .tile_info").html(trimString(tile_info,70));
          $("#title").value = "Saved";
          $("#title").css('color','green').css('font-weight','bold');
          $("#title").animate({
            color: 'white'
            //your input background color.
          }, 1000, 'linear', function(){
            $(this).val('').css('color','#000').css('font-weight','normal');
            //this is done so that when you start typing, you see the text again :P
          });

          $("#title").find('input:text').focus();

          $('tr#tr_'+entry_id+' .td_post_type').html(replyData.post_type.toUpperCase());
          $('tr#tr_'+entry_id+' .td_title').html(trimString(replyData.title, 60));
          $('tr#tr_'+entry_id+' .td_qty').html(replyData.qty);
          $('tr#tr_'+entry_id+' .td_exchanges').html(exchanges);
        }

      }).fail(function (jqxhr,errorStatus) {
        $('#submission_error').text(errorStatus).show();
        restorePlaceholder("#title", errorStatus)
        setTimeout(function() {
            restorePlaceholder("#title", "Press enter to save");
          },
        4000);
      });
    };
		//console.log("add or return hit");

		e.preventDefault();
		var newUpload_key = Math.random().toString(36).substring(7);
		$('#upload_key').val(newUpload_key);

		// do what you like with the input
		// if we have an image, handle that separately
		if($('#choose-file').val()) {
			handleFile(newUpload_key, finish_submit);
		} else {
      finish_submit();
    }
    // console.warn("Aborting ajax add to debug file upload part - REMOVE ME!");
    // return false;
	});


	$(document).on("click", '[id^=button_]', function () {
		//console.log('Upload image click');
		var parent_div = $(this).parents( '.tile_container').attr('id');

		if(parent_div) {
			var buttonArray = parent_div.split('_');
			//console.log("Upload click: tile id: #tile_"+buttonArray[1]);
			$('#tile_' + buttonArray[1]+' input[type=file]').trigger('click');
		}
	});


  function handleFile(upload_key,callback){

		var image=$('input[type=file]')[0].files[0];
		var fileReader = new FileReader();
		//console.log("handleFile: file = "+image.name+", upload_key = "+upload_key);

		//fileReader.onload=function(e){ console.log("file read")}
		fileReader.readAsDataURL(image);

		var maxSize = $('#MAX_FILE_SIZE').val();
		//console.log("handleFile: " +image.name+", maxSize = "+ maxSize+",  file size = "+image.size);

		if(image.size < maxSize) {
			uploadFile(image, upload_key,callback);
		}
		else {
			//$("#tile_"+id +" .too_large").show().addClass("error_message").fadeOut(9000, "linear");
			//console.log("handleFile: file too big");
		}
  }


	function uploadFile(image, upload_key,callback){

		var xhr = new XMLHttpRequest();
		var form_data = new FormData();

		form_data.append('_token', $('input[name=_token]').val());
		form_data.append('image', image);
		form_data.append('upload_key', upload_key);
		//console.log("uploadFile: " +image.name+"  "+ JSON.stringify(form_data));

		xhr.upload.onprogress = function(e) {
			if (e.lengthComputable) {
				var percentage =  parseInt((e.loaded / e.total) * 100);
				//$("#tile_"+entry_id+ " .percentage").html(percentage+"%");
				//console.log("progress: "+percentage+"% complete");
			}
		};

		xhr.upload.addEventListener("loadstart", function(e){
    	$("#percentage").show();
  	}, false);

		xhr.upload.addEventListener("load", function(e){
    	$("#percentage").html("100% Done");
		}, false);

		xhr.onreadystatechange = function () {
			//console.log("uploadFile: status change");
			if (xhr.readyState==4 && xhr.status==200) {
				//console.log("uploadFile: success!!!!!!!!!!");
				replyData = JSON.parse(xhr.responseText);
        //console.warn("Results: "+xhr.responseText);
        //console.dir(replyData);
        callback(replyData);
				//console.log("onreadystatechange: image name = "+replyData.image +"  "+replyData.upload_key +"  "+replyData.user_id);
				//$("#tile_"+entry_id+ " .percentage").fadeOut( 1200);//,"linear");
				//$("#tile_"+entry_id+ " .show_thumbnail img").delay(3500).css('width','23px').css('height','23px');
			}
		};

		xhr.open("POST", "/entry/upload", true);
		xhr.overrideMimeType('text/plain; charset=x-user-defined-binary');
		xhr.send(form_data);
	}

	function trimString(yourString, maxLength) {
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

});


</script>

@stop
