@extends('layouts/master')

{{-- Page title --}}
@section('title')
     {{ trans('general.entries.create') }} ::
@parent
@stop


{{-- Page content --}}
@section('content')

<!-- -->
			<section>

				<div id="add_tile_wrapper" class="container margin-top-20">
					<div class="row">
						<!-- Entry -->
						<div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
							<div class="row">

                <h1 class="size-16 uppercase">{{ trans('general.entries.create') }}</h1>
                <p>{{ trans('general.entries.create_subheadline') }}</p>
                <!-- entry form -->

                <form method="post" action="{{ route('entry.create.save') }}" enctype="multipart/form-data" autocomplete="off" class="nomargin">
                  {!! csrf_field() !!}
                  <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="4096000" />


                  <div class="clearfix"></div>
                  <fieldset class="nomargin">

                    <div class="col-md-2 margin-bottom-10 {{ $errors->first('post_type', ' has-error') }}">
                        <select class="form-control" name="post_type" id="post_type">
                          <option value="want">I want</option>
                          <option value="have">I have</option>
                        </select>
                    </div>
                    <div class="col-md-7 margin-bottom-10 {{ $errors->first('title', ' has-error') }}">
                      <!-- Name -->
                      <label class="input">
                        <input type="text" name="title" id="title" class="form-control" placeholder="Description">
                      </label>
                    </div>
                    <div class="col-md-3 margin-bottom-10">
                    	<button type="button" id="pref_button"  class="btn btn-info btn-md" style="float:right;"><i class="fa fa-cogs fa-lg" style="margin-right:10px;"></i><i class="fa fa-caret-down fa-lg"></i></button>
                      <button class="btn btn-success" id="quickAdd" name="quickAdd" value="quickAdd" style="margin-right:10px;float:right;"><i class="fa fa-sign-in fa-lg" style="margin-right:5px;"></i>Create</button>

                    </div>
                    <!--
                    Added tiles ....
                    -->

                    <div class="col-md-12 col-sm-12 col-xs-12" id="added_heading">
                      <h4 class="text-left">You Added</h4>
                    </div> <!-- col-md-12 -->

                    <div class="col-md-12 col-sm-12 col-xs-12 tile_container" id="tile_1" style="display:none;">
                      <div class="row" style="margin-bottom:7px;">
                        <div class="tile_info col-md-11 col-sm-11 col-xs-11" >
													<div class="col-md-11 margin-bottom-10">
                    				<div class="checkbox">
                              @foreach ($whitelabel_group->exchangeTypes as $exchange_types)
                              <label>
                                {{ Form::checkbox('entry_exchange_types['.$exchange_types->id.']', $exchange_types->id, $exchange_types->id) }}
                                {{ $exchange_types->name }}
                              </label>
                              @endforeach
                             </div>
                          </div>
                        </div> <!-- col-md-10 tile_info  -->
                        <div class="delete_error col-md-11 col-sm-11 col-xs-11" style="display:none"></div>


                        <div class="col-md-1 col-sm-1 col-xs-1">
                        	<button type="button" class="more_button btn btn-info btn-md" style="float:right;">more</i> <i class="fa fa-caret-down fa-lg"></i></button>
                        </div> <!-- col-md-2 -->

                        <!--
                        More controls ....
                        -->

                        <div class="more_controls col-md-12 col-sm-12 col-xs-12" style="display:none;margin-top:10px;">
                          <div class="image_upload">
                            <label for="fileupload_" class="sr-only">Upload image</label>
                            <input id="fileupload_" class="file_upload" type="file" onchange="handleFile(this.files, this.id)" accept="image/gif, image/jpeg, image/png"/></label>

                            <button type="button" id='button_' class="smooth_font pull-left image_button btn btn-info btn-md">image <i class="fa fa-upload fa-lg"></i></button>
                            <span class='too_large smooth_font' style="display:none;">File exceeds the 4MB maximum</span>

                            <div class="percentage"></div>
                          </div> <!-- image_upload -->


            							<button type="button" class="button_edit smooth_font btn btn-info btn-md"  style="float:right;margin-left:10px;font-size:13px;">edit <i class="fa fa-pencil fa-lg"></i></button>

                          <button type="button" class="button_delete smooth_font btn btn-warning btn-md"  style="float:right;margin-left:10px;background-color:rgba(255,0,0,0.6);font-size:13px;">delete <i class="fa fa-times fa-lg"></i></button>

                        </div> <!-- more_controls -->
                      </div> <!-- row  -->
                    </div> <!-- col-md-10 tile_container  -->

                  <!--  <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12 pull-right">
                      <span class='pull-right' >
                      	<button type="button" id="pref_button" style="border:none; outline: 0;  -webkit-box-shadow: none; box-shadow: none;" >Preferences <i class="fa fa-caret-down"></i></button>
                        <button type="button" id="pref_button" class="fa fa-cogs fa-lg">Preferences <i class="fa fa-caret-down"></i></button>

                    	</span>
                    </div> --><!-- col-md-10 -->

                    <div id="prefs_panel" style="display:none;">

                      <!-- Location -->
                      <div class="col-md-12 form-group {{ $errors->first('location', 'has-error') }}">
                        <label class="control-label" for="location">Location</label>
                        <div class="input-group">
                        <input type="text" class="form-control" id="location" name="location" placeholder="Near (optional)" aria-describedby="basic-addon2" value="{{{ Input::old('location', Auth::user()->location) }}}" placeholder="Address, City, Country">
                        <div class="input-group-addon" id="basic-addon2"><i class="fa fa-location-arrow" id="geolocate"></i></div>
                         {!! $errors->first('location', '<span class="help-block">:message</span>') !!}
                       </div>
                      </div>

                      <!-- checkboxes for exchange types -->
                      <div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-10">
                        <div class="checkbox">
                        @foreach ($whitelabel_group->exchangeTypes as $exchange_types)
                        <div class="col-md-2 pull-left margin-bottom-10">
                          <label class="checkbox col-md-3 pull-left margin-bottom-10">
                            {{ Form::checkbox('entry_exchange_types['.$exchange_types->id.']', $exchange_types->id, $exchange_types->id) }}
                            <i></i> {{ $exchange_types->name }}
                          </label>
                        </div>
                        @endforeach
                        </div>
                      </div>

                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="checkbox col-md-12 pull-left margin-bottom-10">
                          <label class="checkbox pull-left margin-bottom-10" for="private_checkbox">
                            {{ Form::checkbox('private', 1, 0, array('id'=>'private_checkbox')) }}
                            <i></i> Keep this value private
                          </label>
                        </div>
                      </div>

                      <div class="col-md-12 col-sm-12 col-xs-12" id="select_hub" style="display:none;margin-top:20px;">
                        <div class="hubs row">
                          @if(isset($groups) && count($groups))
                          <fieldset>
                            <legend style="border:none;">Add to Hubs:</legend>

                          </fieldset>
                          @endif
                        </div> <!-- hubs & row -->
                      </div> <!-- col-md-10 -->
                    </div> <!-- prefs panel -->




                  </fieldset>
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

$(function() {

	$("#quickAdd").removeAttr('disabled');//enable add button	now page has loaded

		if ($('#private_checkbox').is(":checked")) {
			$('#select_hub').hide();
		} else {
			$('#select_hub').show();
		}
		$(document).on( "click", "#private_checkbox", function( e ) {
			$('#select_hub').toggle();
		});


	$(document).on( "click", "#pref_button", function( e ) {
		e.preventDefault();
		// console.log("preferences clicked");
		$('#pref_button').find('i:nth-child(2)').toggleClass('fa-caret-down fa-caret-up');
		//$('#pref_button').find('i').toggleClass('fa-caret-up');


		$('#prefs_panel').toggle();
	});


	$(document).on( "click", "#example_button", function( e ) {
		e.preventDefault();
		// console.log("example clicked");

		$('#example_button').find('i').toggleClass('fa-caret-down fa-caret-up');
		$('#example_panel').toggle();
	});

	$(document).on( "click", ".more_button", function( e ) {
		e.preventDefault();
		// console.log("more clicked");
		$(this).find('i').toggleClass('fa-caret-down fa-caret-up');

		$(this).closest('.tile_container').find('.more_controls').toggle();
	});

	$(document).on( "click", ".button_edit", function( e ) {
		e.preventDefault();
		tile_info = $(this).closest('.tile_container').find('.tile_info').text();
		tile_info = tile_info.substr(6);
		// console.log("edit clicked"+tile_info);

		var tile = $(this).closest('.tile_container').prop("id");
		var tile_id = parseInt( tile.match(/\d+/g), 10 );
		// console.log("edit clicked"+tile_id);
		document.getElementById("title").value = tile_info;
		$("#title").css('background-color','FFFFCC').animate({
            'background-color': 'white'
            //your input background color.
       			 }, 2000);
		document.getElementById("title").focus();
		$( "#title" ).addClass( "update_"+tile_id);

	});

	$(document).on( "click", ".button_delete", function( e ) {
		e.preventDefault();
		var tile = $(this).closest('.tile_container').prop("id");
		var tile_id = parseInt( tile.match(/\d+/g), 10 );
		// console.log("delete clicked on tile id: "+tile_id);
		deleteTile(tile_id);
	});

function getExchangeList() {
		var exchanges = [];
		var exchangeList = "";

		$('.exchange_types input:checked').each(function() {
		exchanges.push($(this).val());
		});

		for(i=0; i< exchanges.length; i++){
			if(exchanges[i] != "all") exchangeList = exchangeList + "&tile_exchange_type["+exchanges[i]+"]="+exchanges[i];
		};

		// console.log("exchangeList: "+exchangeList);
		return exchangeList;
	}

	function getHubList() {
		var hubList = "";
		var hubs = [];

		$('.hubs input:checked').each(function() {
			hubs.push($(this).val());
		});

		for(i=0; i< hubs.length; i++){
			hubList = hubList + "&groups["+hubs[i]+"]="+hubs[i];
		};

		// console.log("hubList: "+hubList);
		return hubList;
	}

	function updateExisting() {
		// has title text changed?
		$focusedTitle = $(':focus');
		if( $focusedTitle ) {
			// console.log("Current value "+ $focusedTitle.val()+", initial value "+$focusedTitle.data().initail);

			return !($focusedTitle.val() == $focusedTitle.data().initail)
		}
		else return false;
	}

	function restorePlaceholder(ph_text) {
		//return function() {
			document.getElementById("title").value = "";
			document.getElementById("title").placeholder = ph_text;
		//};
	}

	$(document).on( "click", "#quickAdd", function( e ) {
		// console.log("add or return hit");

		e.preventDefault();
		edit = false;

		var title = $("#title").val();
		if(title.length < 3)
		{
			restorePlaceholder("Your want or have must be at least 3 characters long")
			setTimeout(function() {
					restorePlaceholder("Press enter to save");
				},
			2000);
		}
		else if(title) // step 1. Anything to save?
		{
			// console.log("title of new tile = "+title);

			// step 2. Get the id of the last div with id starting with tile_xx
			// this is where we will store the results if this tile saves successfully
			var lastTileDiv = $('div[id^="tile_"]:last');
			// console.log("last = "+lastTileDiv.attr("id"));
			var tile_id = parseInt( lastTileDiv.prop("id").match(/\d+/g), 10 );
			// console.log("On success save tile at id = tile_"+tile_id);


			tileClasses = $('#title').attr('class');
			// console.log("work ?  "+tileClasses.match(/\d+/g));
			position = tileClasses.indexOf("update_");
			if(position>=0) {
				tile_id = tileClasses.match(/\d+/g);
				// console.log("update, edit = true "+tile_id+"  "+tileClasses);
				edit = true;
			}

			// step 3. Gather everything else we need from the form, want/have, location, exchanges etc
			var want_have = $( "#post_type" ).val();
			var location = $('#location').val();
			var exchangeList = getExchangeList();
			var hubList = getHubList() ;
			if (document.getElementById('private_checkbox').checked == true) var public =0;
			else var public =1;
			var visible =1; // always visible for quick add
			// console.log("Private checkbox checked:" + document.getElementById('private_checkbox').checked);

			// step 4. Create the ajax call
			saveTile(tile_id, title, want_have, exchangeList, location, hubList, visible, public, edit);
		}
	});

	function createRequest() {
		try {
			request = new XMLHttpRequest();
		} catch (tryMS) {
			try {
				request = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (otherMS) {
				try {
					request = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (failed) {
					request = null;
				}
			}
		}
		return request;
	}

	function updateTileIds(temp_tile_id, tile_id)
	{
		// console.log("updateTileIds temp_tile_id = "+temp_tile_id +", tile_id = " +tile_id);
		document.getElementById("tile_"+temp_tile_id).id="tile_"+tile_id;
		document.getElementById("fileupload_").id = "fileupload_"+tile_id;

		$("#tile_"+tile_id+" .title_text label").attr('for','title_'+tile_id);
	}


	// step 4. Create the ajax call
	function saveTile(tile_id, title, post_type, exchangeTypes, location, hubList, visible, public, edit){
		var xhr = createRequest();

		// console.log("saveTile: " +title+"  "+ post_type+"  "+exchangeTypes+"  "+location+"  "+hubList+ ", tile_id = "+tile_id + ", visible = "+visible + ", edit = "+edit);

		// step 4a. Create the ajax callback
		xhr.onreadystatechange = function () {
			stateChanged();
		};

		if(edit) {
			xhr.open("POST", tile_id+"/edit", true);
		}
		else {
			xhr.open("POST", "new", true);
		}

		token ='_token='+$('input[name=_token]').val() +'&';

		//// console.log('token = ' + $('input[name=_token]').val());
		xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		var parameters =token+"ajaxAdd=true&title="+title+"&post_type="+ post_type+exchangeTypes+"&tiletype_id=1&location="+location+"&visible="+visible+"&public="+public+"&hubList="+hubList;
		// console.log("parameters: "+parameters);

		// step 4b. Fire off the ajax call
		xhr.send(parameters);

		function stateChanged()
		{
			var data;

			// step 4c. Check status change for success

			if (xhr.readyState==4 && xhr.status==200)
			{
				// console.log("success!!!!!  "+xhr.responseText) ;

				replyData = JSON.parse(xhr.responseText);


				if(replyData.success)
				{
					// console.log("success!!!!! "+xhr.responseText) ;

					if(edit)
					{
						// console.log("Edit response  "+replyData.success) ;
						// step 4d. Find existing tile div and update contents
						$("#title").removeClass( "update_"+tile_id);

						tile_info = "I "+replyData.post_type + " "+replyData.title;
						lastTileDiv = $("#tile_"+tile_id);
						$("#tile_"+tile_id +" .tile_info").html(trimString(tile_info,70));
						document.getElementById("title").value = "Saved";
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
						// console.log("Create response  "+replyData.success) ;
						// step 4d. Clone existing div ready for the next want/have and set focus.
						// Note we clone it here before it has actual values in it
						//var div_id = "tile_"+tile_id;
						var lastTileDiv = $("#tile_"+tile_id);
						// console.log("last = "+lastTileDiv.attr("id"));
						newDivId = tile_id +1;
						var newTileDiv = lastTileDiv.clone().prop('id', 'tile_'+newDivId );
						$(lastTileDiv).after(newTileDiv);
						$("#title").val('');
						$("#title").find('input:text').focus();
						// console.log("stateChanged  "+$("#title").val());

						// step 4e. Start filling up the tile div with the successful want/have
						tile_info = "I "+replyData.post_type + " "+replyData.title;
						//if(replyData.location) tile_info = tile_info+ ", near "+replyData.location;
						//tile_info = tile_info+ ". Exchanging by " +replyData.tile_exchange_types;
						$("#tile_"+tile_id+" .title_text input").attr('data-initail',  title);
						//if(replyData.hubNames) tile_info +=". Within hubs: "+replyData.hubNames;
						updateTileIds(tile_id, replyData.tile_id);

						document.getElementById("button_").id = "button_"+replyData.tile_id;
						$("#tile_"+replyData.tile_id +" .show_thumbnail").show();
						$("#tile_"+replyData.tile_id +" .tile_info").html(trimString(tile_info,70));
						document.getElementById('added_heading').style.display = 'block';
						$("#tile_"+replyData.tile_id).toggle();
						// console.log("stateChanged, tile_info: "+tile_info);
					}
				}
				else
				{
					restorePlaceholder(replyData.error)
					setTimeout(function() {
							restorePlaceholder("Press enter to save");
						},
					4000);
				}
			}
		}
	}

	function deleteTile(tile_id)
	{
		var xhr = new XMLHttpRequest();

		// console.log("deleteTile: tile_id = "+tile_id);

		// step 4a. Create the ajax callback
		xhr.onreadystatechange = function () {
			deleteChanged();
		};

		xhr.open("POST", tile_id+"/delete", true);
		xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");

		// step 4b. Fire off the ajax call
		xhr.send("_token="+$('input[name=_token]').val()+'&ajaxAdd=true');
		setTimeout(function() {  xhr.abort()  },20000); //abort after 20 seconds


		function deleteChanged()
		{
			var data;
			// console.log("statusText: "+xhr.statusText +"  "+xhr.responseText);
			if (xhr.readyState==4 && xhr.status==200)
			{
					replyData = JSON.parse(xhr.responseText);

					if(replyData.success) {
						// console.log("delete success :-)  "+replyData.entry_id);

						$('#tile_'+replyData.entry_id).remove();

						// count how many tiles we have, if none, remove the "recently added" text
						// Note we always have 1 hidden #tile_
						if( $("div[id^='tile_']").length == 1) {
							document.getElementById('added_heading').style.display = 'none';
						}
					}
					else {
						// console.log("delete failed :-(  "+replyData.entry_id + "   "+replyData.error);
						$('#tile_'+tile_id +' .delete_error').html('<p style="margin-top:5px">'+replyData.error+'</p>').show();
					}
				}
			}
		}


	$(document).on("click", '[id^=button_]', function () {
		// console.log('Upload image click');
		var parent_div = $(this).parents( '.tile_container').attr('id');
		// console.log("Upload click: div: "+parent_div);

		if(parent_div) {
			var buttonArray = parent_div.split('_');
			// console.log("Upload click: tile id: #tile_"+buttonArray[1]);
			$('#tile_' + buttonArray[1]+' input[type=file]').trigger('click');
		}
	});

});

  function handleFile(files, tile_id){
		var image=files[0];
		var fileReader = new FileReader();
		var imageElem = document.createElement("img");
		var id_array  = tile_id.split('_');
		// console.log("handleFile: tile_id = "+id_array[1]+", file = "+image.name);
		id = id_array[1];

		fileReader.onload=(function(img){return function(e){img.src = e.target.result;};})(imageElem);
		fileReader.readAsDataURL(image);

		var maxSize = document.getElementById('MAX_FILE_SIZE').value;
		// console.log("handleFile: " +image.name+"tile id = "+ id+",  file size = "+image.size);

		if(image.size < maxSize) {
			$("#tile_"+id +" .show_thumbnail").append(imageElem);
			$("#tile_"+id +" .show_thumbnail img").attr('alt',"");
			$("#button_"+id).hide();
			uploadFile(image, id);
		}
		else
		{
			$("#tile_"+id +" .too_large").show().addClass("error_message").fadeOut(9000, "linear");
			// console.log("handleFile: file too big");
		}
   }


function uploadFile(image, tile_id){
	var xhr = new XMLHttpRequest();
	var form_data = new FormData();

	// console.log("uploadFile: " +image.name+"  "+ tile_id+JSON.stringify(formData));

	form_data.append('image', image);
	form_data.append('tile_id', tile_id);

	xhr.upload.onprogress = function(e) {
		if (e.lengthComputable) {
			var percentage =  parseInt((e.loaded / e.total) * 100);
			$("#tile_"+tile_id+ " .percentage").html(percentage+"%");
			// console.log("progress: "+percentage+"% complete");
		}
	};

	xhr.upload.addEventListener("loadstart", function(e){
    $("#percentage").show();
  }, false);

	xhr.upload.addEventListener("load", function(e){
    $("#percentage").html("100% Done");
	}, false);

	xhr.onreadystatechange = function () {
		// console.log("uploadFile: status change");
		if (xhr.readyState==4 && xhr.status==200)
		{
			// console.log("uploadFile: success!!!!!!!!!!");
			$("#tile_"+tile_id+ " .percentage").fadeOut( 1200);//,"linear");
			//$("#tile_"+tile_id+ " .show_thumbnail img").delay(3500).css('width','23px').css('height','23px');

		}
	};
	xhr.open("POST", '/entry'+tile_id+"/upload");
	xhr.overrideMimeType('text/plain; charset=x-user-defined-binary');
	xhr.send(form_data);
}

$(document).ready(function() {
	$('.exc_checkbox').prop('checked', true);
		$('#selectall').click(function(event)
		{
			if(this.checked)
			{
				// console.log("select currently checked");
				$('.exc_checkbox').each(function(e)
				{
					this.checked = true;
				});
				$('div.exchange_types').hide();
			}
			else
			{
				// console.log("select currently unchecked");
				$('.exc_checkbox').each(function(e)
				{
					this.checked = false;
				});

				$('div.exchange_types').show();
			}
    });

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
	// console.log(checkboxes.length);
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
