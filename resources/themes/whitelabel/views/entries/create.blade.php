@extends('layouts/master')

{{-- Page title --}}
@section('title')
     {{ trans('general.entries.create') }} ::
@parent
@stop


{{-- Page content --}}
@section('content')

<style>
.checkbox {
   padding-left: 0px;
}
</style>

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
                  <th>{{ trans('general.entries.title') }}</th>
                  <th>{{ trans('general.entries.exchange_types') }}</th>
                  <th>Action</th>
                  <th style='display:none'>id</th>
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

 										<!--
                    Added tiles ....
                    -->

                    <div class="col-md-12 col-sm-12 col-xs-12 tile_container" id="tile_1" style="display:none;margin-bottom:15px;">
                      <div class="row" style="margin-bottom:7px;">
                      	<div class="tile_info col-md-5 col-sm-5 col-xs-5" >
                        </div> <!-- col-md-7 tile_info  -->
												<div class="tile_exchanges col-md-5 col-sm-5 col-xs-5" >
                        </div> <!-- col-md-7 tile_exchanges  -->
                        <div class="delete_error col-md-10 col-sm-10 col-xs-10" style="display:none"></div>

                        <div class="col-md-2 col-sm-2 col-xs-2">
                        	<button type="button" class="more_button btn btn-info btn-md" style="float:right;">more</i> <i class="fa fa-caret-down fa-lg"></i></button>
                        </div> <!-- col-md-2 -->

                        <!--
                        More controls ....
                        -->

                        <div class="more_controls col-md-12 col-sm-12 col-xs-12" style="display:none;margin-top:10px;">
                          <div class="image_upload">
                            <label for="fileupload_" class="sr-only">Upload image</label>
                            <input id="fileupload_" class="file_upload" type="file" onchange="handleFile(this.files, this.id)" accept="image/gif, image/jpeg, image/png"/></label>

                            <button type="button" id='button_' class="smooth_font pull-left image_button btn btn-info btn-md">image <i class="fa fa-picture-o fa-lg"></i></button>
                            <span class='too_large smooth_font' style="display:none;">File exceeds the 4MB maximum</span>

                            <div class="percentage"></div>
                          </div> <!-- image_upload -->


            							<!-- <button type="button" class="button_edit smooth_font btn btn-info btn-md"  style="float:right;margin-left:10px;font-size:13px;">edit <i class="fa fa-pencil fa-lg"></i></button>

                          <button type="button" class="button_delete smooth_font btn btn-warning btn-md"  style="float:right;margin-left:10px;background-color:rgba(255,0,0,0.6);font-size:13px;">delete <i class="fa fa-times fa-lg"></i></button> -->

                        </div> <!-- more_controls -->
                      </div> <!-- row  -->
                    </div> <!-- col-md-10 tile_container  -->
                  	<div class="col-md-3 col-sm-3 col-xs-3" style="border-right:#CCC thin solid;">

                    	<div class="form-group" style="margin-bottom: 5px;">
                      	<fieldset class="margin-bottom-10">

                        	<legend class="sr-only">Exchange by:</legend>

                          {{ $errors->first('tile_exchange_type', '<div class="alert-no-fade alert-danger col-sm-12"><i class="icon-remove-sign"></i> :message</div>') }}
													<div class="exchange_types">


                            <!-- checkboxes for exchange types -->
                            <div class="col-md-12 margin-bottom-10">
                              <div class="checkbox">
                              @foreach ($whitelabel_group->exchangeTypes as $exchange_types)
                              <div class="col-md-12 pull-left margin-bottom-10">
                                <label class="checkbox col-md-12 pull-left margin-bottom-10">
                                  {{ Form::checkbox('exchange_types['.$exchange_types->id.']', $exchange_types->id, $exchange_types->id) }}
                                  <i></i> {{ $exchange_types->name }}
                                </label>
                              </div>
                              @endforeach
                              </div>
                          </div> <!-- exchange_types -->
                         </fieldset>
                        </div> <!-- form-group -->

                      </div> <!-- col-md-3 -->

                      <div class="col-md-9 col-sm-9 col-xs-9">

                  		<fieldset class="nomargin">
                    		<div class="col-md-2 margin-bottom-10 {{ $errors->first('post_type', ' has-error') }}">
                        	<select class="form-control" name="post_type" id="post_type">
                          	<option value="want">I want</option>
                          	<option value="have">I have</option>
                        	</select>
                    		</div>
                        <div class="col-md-2 margin-bottom-10">
                          <!-- stepper -->
                          <input type="text" value="{{ Input::old('qty', 1) }}" min="1" max="1000" class="form-control stepper" name="qty">
                        </div>
                    		<div class="col-md-6 margin-bottom-8 {{ $errors->first('title', ' has-error') }}">
                      		<!-- Name -->
                      		<label class="input">
                        		<input type="text" name="title" id="title" class="form-control" placeholder="Description">
                      		</label>
                    		</div>
                    		<div class="col-md-2 margin-bottom-10">
                    		<button class="btn btn-success  pull-right" id="quickAdd" name="quickAdd" value="quickAdd">Create</button>

                    		</div>
                   		</fieldset>

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

                          <!-- File upload -->
                          <div class="form-group {{ $errors->first('file', 'has-error') }}">
                            <div class="fancy-file-upload fancy-file-info">
                            	<i class="fa fa-picture-o"></i>
                            	<input type="file" class="form-control" name="file" onchange="jQuery(this).next('input').val(this.value);" />
                            	<input type="text" class="form-control" placeholder="no file selected" readonly="" />
                            	<span class="button">{{ trans('general.uploads.choose_file') }}</span>
                            </div>
                          </div>

                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="checkbox pull-left" for="visible_checkbox">
                              {{ Form::checkbox('private', 1, 0, array('id'=>'visible_checkbox')) }}
                              <i></i> Visible only to you
                            </label>
                          </div>
                        </div> <!-- prefs panel -->
                       </div>

                    </div>


                  <!--  <div>
                  <input id="option" type="checkbox" name="field" value="option">
                  <label for="option"><span><span></span></span>Value</label>
                </div> -->


                </form>
              </div>
						</div>
					</div>


				</div>
			</section>
			<!-- / -->

      <!-- Modal -->
      <div id="myExamples" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Examples</h4>
            </div>
            <div class="modal-body">
              <p>I want a new bicycle<br />
              I have karate skills I can share<br />
              I want carrot cake for my birthday<br />
              I have the ability to speak French<br />
              I want help cleaning my garage<br />
              I have a pile of scrap wood</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>
<script type="text/javascript">

$("#quickAdd").attr('disabled','disabled'); // disable add button until page has loaded
$("#create_table").hide();

$(function() {

//console.log(exchangeTypeName);
	$("#quickAdd").removeAttr('disabled');//enable add button	now page has loaded

		if ($('#visible_checkbox').is(":checked")) {
			$('#select_hub').hide();
		} else {
			$('#select_hub').show();
		}
		$(document).on( "click", "#visible_checkbox", function( e ) {
			$('#select_hub').toggle();
		});


	$(document).on( "click", "#pref_button", function( e ) {
		e.preventDefault();
		//console.log("preferences clicked");
		$('#pref_button i').toggleClass('fa-caret-left fa-caret-right');
		//$('#pref_button').find('i').toggleClass('fa-caret-up');


		$('#prefs_panel').toggle();
	});


	$(document).on( "click", "#example_button", function( e ) {
		e.preventDefault();
		//console.log("example clicked");

		$('#example_button').find('i').toggleClass('fa-caret-down fa-caret-up');
		$('#example_panel').toggle();
	});

	$(document).on( "click", ".more_button", function( e ) {
		e.preventDefault();
		//console.log("more clicked");
		$(this).find('i').toggleClass('fa-caret-down fa-caret-up');

		$(this).closest('.tile_container').find('.more_controls').toggle();
	});

	$(document).on( "click", ".button_edit", function( e ) {
		e.preventDefault();
    return window.alert("This hasn't been built yet.");
		entry_info = $(this).closest('.tile_container').find('.tile_info').text();
    console.warn("Tile info is: "+entry_info);
		entry_info = entry_info.substr(6);
		//console.log("edit clicked"+tile_info);

		var tile = $(this).closest('.tile_container').prop("id");
    var entry_id = $(this).data("entryid");
		//console.log("edit clicked"+entry_id);
		$("#title").val(tile_info);
		$("#title").css('background-color','FFFFCC').animate({
            'background-color': 'white'
            //your input background color.
       			 }, 2000);
		$("#title").focus();
		$("#title" ).addClass( "update_"+entry_id);
	});

	$(document).on( "click", ".button_delete", function( e ) {
		e.preventDefault();
		//var tile = $(this).closest('.tile_container').prop("id");
		var entry_id = $(this).data("entryid");
    var myrow = $(this).closest('tr');
		console.log("delete clicked on entry: "+entry_id);
    $.post(entry_id+"/delete/ajax",{_token: $('input[name=_token]').val()},function (replyData) {
      //console.log("delete success :-)  "+replyData.entry_id);
      if(replyData.success) {
        //$('td.entry_'+replyData.entry_id).closest('tr').remove();
        myrow.remove();

        // count how many rows we have, if we only have the header row hide the table
        //console.log($('#create_table tr').length);
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

	function getHubList() {
		var hubList = "";
		var hubs = [];

		$('.hubs input:checked').each(function() {
			hubs.push($(this).val());
		});

		for(i=0; i< hubs.length; i++){
			hubList = hubList + "&groups["+hubs[i]+"]="+hubs[i];
		};

		return hubList;
	}

	function updateExisting() {
		// has title text changed?
		$focusedTitle = $(':focus');
		if( $focusedTitle ) {
			return !($focusedTitle.val() == $focusedTitle.data().initail)
		}
		else return false;
	}

	function restorePlaceholder(ph_text) {
			$("#title").val(""); // = "";
			$("#title").attr('placeholder',ph_text);
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


	$(document).on( "click", "#quickAdd", function( e ) {
		//console.log("add or return hit");

		e.preventDefault();
		edit = false;

		var title = $("#title").val();
		if(title.length < 3 && false)
		{
			restorePlaceholder("Your want or have must be at least 3 characters long")
			setTimeout(function() {
					restorePlaceholder("Press enter to save");
				},
			2000);
      return;
		}

    // console.dir($('.exchange_types input:checked'));

		if($('.exchange_types input:checked').length == 0) {
      $('#submission_error').text('Please select at least one exchange type').show();
      return;
		}
		if(!title) // step 1. Anything to save?
		{
      //I suspect that this will never fire; if there was no title text-left
      // then title.length < 3 anyways.
      return;
    }
		//console.log("title of new tile = "+title);

		// step 2. Get the id of the last div with id starting with tile_xx
		// this is where we will store the results if this tile saves successfully
		var lastEntryDiv = $('div[id^="tile_"]:last');
		var entry_id = parseInt( lastEntryDiv.prop("id").match(/\d+/g), 10 );


		tileClasses = $('#title').attr('class');
		//console.log("work ?  "+tileClasses.match(/\d+/g));
    var post_url="new/ajax";
		position = tileClasses.indexOf("update_");
		if(position>=0) {
			entry_id = tileClasses.match(/\d+/g);
			//console.log("update, edit = true "+entry_id+"  "+tileClasses);
			edit = true;
      post_url=entry_id+"/edit/ajax";
		}

		//var hubList = getHubList() ;
		//console.log("Visible only to you checked:" + $('#visible_checkbox').checked);

		// step 4. Create the ajax call
		// saveEntry(entry_id, title, want_have, exchangeList, location, visible, edit);
    // console.warn("about to post...");
    // console.warn("Serialized POst IS: "+$('#entry_form').serialize());
    $.post( post_url, $('#entry_form').serialize(),function (replyData) {
      //console.warn("Yay we posted! Here's our reply: ");
      //console.dir(replyData);
      if(!replyData.success) {
        parseAndDisplayError(replyData.error);
        return;
      }
      //console.log("success!!!!! "+xhr.responseText + "  "+replyData.exchange_types);

      if (replyData.exchange_types) {
        var exchanges=replyData.exchange_types.join(", ");
      }

      //exchanges = exchanges.replace(/(^\s*, )|(, \s*$)/g, '');
      //exchanges = " ("+exchanges+')';

      if(edit)
      {
        //console.log("Edit response  "+replyData.success) ;
        // step 4d. Find existing tile div and update contents
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
      }
      else
      {
        // console.warn("create 'else' branch entered");
        //console.log("Create response  "+replyData.success) ;

        tile_info = "I "+replyData.post_type + " "+replyData.title;

        //console.log("stateChanged, tile_info: "+tile_info);

        $('#submission_error').hide();

        if( $('#create_table tr').length == 1) {
          $('#create_table').show();
        }
        $('#create_table tr:last').after('<tr><td>'+replyData.post_type.toUpperCase()+'</td><td>'+
        trimString(replyData.title, 60)+'</td><td>'+exchanges+ '</td><td><button class="button_delete smooth_font btn btn-warning btn-sm" data-entryid="'+replyData.entry_id+'"><i class="fa fa-trash-o fa-lg"></i></button> <button class="button_edit smooth_font btn btn-info btn-sm" data-entryid="'+replyData.entry_id+'"><i class="fa fa-pencil fa-lg"></i></button> <button class="smooth_font image_button btn btn-info btn-sm" data-entryid="'+replyData.entry_id+'"><i class="fa fa-picture-o fa-lg"></i></button></td></tr>');
        console.warn("End of create 'else' branch and of the entire callback");
      }
    }).fail(function (jqxhr,errorStatus) {
      $('#submission_error').text(errorStatus).show();
      console.warn("Boo, we failed at posting :(");
      restorePlaceholder(errorStatus)
      setTimeout(function() {
          restorePlaceholder("Press enter to save");
        },
      4000);
    });
	});

	function updateTileIds(temp_entry_id, entry_id)
	{
		//console.log("updateTileIds temp_entry_id = "+temp_entry_id +", entry_id = " +entry_id);
		$("#tile_"+temp_entry_id).id="tile_"+entry_id;
		$("#fileupload_").id = "fileupload_"+entry_id;

		$("#tile_"+entry_id+" .title_text label").attr('for','title_'+entry_id);
	}

	$(document).on("click", '[id^=button_]', function () {
		//console.log('Upload image click');
		var parent_div = $(this).parents( '.tile_container').attr('id');
		//console.log("Upload click: div: "+parent_div);

		if(parent_div) {
			var buttonArray = parent_div.split('_');
			//console.log("Upload click: tile id: #tile_"+buttonArray[1]);
			$('#tile_' + buttonArray[1]+' input[type=file]').trigger('click');
		}
	});

});

  function handleFile(files, entry_id){
		var image=files[0];
		var fileReader = new FileReader();
		var imageElem = document.createElement("img");
		var id_array  = entry_id.split('_');
		//console.log("handleFile: entry_id = "+id_array[1]+", file = "+image.name);
		id = id_array[1];

		fileReader.onload=(function(img){return function(e){img.src = e.target.result;};})(imageElem);
		fileReader.readAsDataURL(image);

		var maxSize = $('#MAX_FILE_SIZE').value;
		//console.log("handleFile: " +image.name+"tile id = "+ id+",  file size = "+image.size);

		if(image.size < maxSize) {
			$("#tile_"+id +" .show_thumbnail").append(imageElem);
			$("#tile_"+id +" .show_thumbnail img").attr('alt',"");
			$("#button_"+id).hide();
			uploadFile(image, id);
		}
		else
		{
			$("#tile_"+id +" .too_large").show().addClass("error_message").fadeOut(9000, "linear");
			//console.log("handleFile: file too big");
		}
   }


function uploadFile(image, entry_id){
	var xhr = new XMLHttpRequest();
	var form_data = new FormData();

	form_data.append('_token', $('input[name=_token]').val());
	form_data.append('image', image);
	//form_data.append('entry_id', entry_id);
	//console.log("uploadFile: " +image.name+"  "+ entry_id+JSON.stringify(form_data));

	xhr.upload.onprogress = function(e) {
		if (e.lengthComputable) {
			var percentage =  parseInt((e.loaded / e.total) * 100);
			$("#tile_"+entry_id+ " .percentage").html(percentage+"%");
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
			//console.log("uploadFile: "+xhr.statusText);

		//console.log("uploadFile: status change");
		if (xhr.readyState==4 && xhr.status==200)
		{
			//console.log("uploadFile: success!!!!!!!!!!");
			replyData = JSON.parse(xhr.responseText);
			//console.log("onreadystatechange: image name = "+replyData.image);
			$("#tile_"+entry_id+ " .percentage").fadeOut( 1200);//,"linear");
			//$("#tile_"+entry_id+ " .show_thumbnail img").delay(3500).css('width','23px').css('height','23px');

		}
	};
	xhr.open("POST", +entry_id+"/upload", true);
	xhr.overrideMimeType('text/plain; charset=x-user-defined-binary');
	xhr.send(form_data);
}

$(document).ready(function() {
	$('.exc_checkbox').prop('checked', true);

		$('#location_checkbox').click(function(event)
		{
			$('#location_block').toggle();
    });

});


function trimString(yourString, maxLength) {
	//trim the string to the maximum length

	if(yourString.length > maxLength)
	{
		var trimmedString = yourString.substr(0, maxLength);

		//re-trim if we are in the middle of a word
		trimmedString = trimmedString.substr(0, Math.min(trimmedString.length, trimmedString.lastIndexOf(" ")))

		trimmedString += " " +String.fromCharCode(8230);

		return trimmedString;
	}

	return yourString;
}

function toggleBoxes(source) {
  checkboxes = document.querySelectorAll("input[name^='tile_exchange_type[']");
	//console.log(checkboxes.length);
  for (i=0; i < checkboxes.length; i++) {
		checkboxes[i].checked = source.checked;
	}
	$('.exchange_types').toggle();
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

$('#post_type').change(function(){
	if ($(this).val() == "want") {
		$('.wrapper').css("border",'8px solid #4d3a93');
		$('.edit_listing li > a').css("background-color",'rgba(77,58,147,0.5)');
		$('.edit_listing li.active > a').css("background-color",'#4d3a93');
		$('button.submit_listing').css("background-color",'#4d3a93');
		$('#buy').show();
		$('#sell').hide();
		$('button.submit_listing').html('Save Want');

	} else if ($(this).val() == "have") {
		$('.wrapper').css("border",'8px solid #24b5ec');
		$('.edit_listing li > a').css("background-color",'rgba(36,181,236,0.5)');

		$('.edit_listing li.active > a').css("background-color",'#24b5ec');
		$('button.submit_listing').css("background-color",'#24b5ec');
		$('#sell').show();
		$('#buy').hide();
		$('button.submit_listing').html('Save Have');
	}
});


$('div.edit_listing ul.nav-tabs li a').click(function(){

	if($('#post_type').val() == "want")
	{
		$('.edit_listing li > a').css("background-color",'rgba(77,58,147,0.5)');
		$(this).css("background-color",'#4d3a93');

	}
	else
	{
		$('.edit_listing li > a').css("background-color",'rgba(36,181,236,0.5)');
		$(this).css("background-color",'#24b5ec');
	}
});


</script>

@stop
