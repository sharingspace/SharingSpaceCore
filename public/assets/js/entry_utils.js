
function finish_submit(data=null)
{
  entry_id = isEdit(); 
  if (entry_id) {
    if (entry_id.length > 10) alert("bad");
    create = false;
    post_url=entry_id+"/edit/ajax";
  }
  else {
    create = true;
    post_url="new/ajax";
  }

  // start the create or save ajax call off
  $.post(post_url,$('#entry_form').serialize(), function(data)
  {
    if (data.success) {
      var exchanges = null;

      if( $('#create_table tr').length == 1) {
        $('#create_table').show();
      }

      resetForm();
      // clear all checkboxes and then select the ones we want
      $('input:checkbox[class=exchanges]').prop('checked',false);
      jQuery.each(data.typeIds, function(index, item) {
        $('input:checkbox[class=exchanges][value='+item+']').prop('checked',true);
      });
      
      if (data.exchange_types) {
        exchanges=data.exchange_types.join(", ");
      }

      if (data.typeIds.length) {
        exchangeIds=data.typeIds.join(",");
      }

      if (data.create) {
        addTableRow(data, exchanges, exchangeIds);
      }
      else {
        updateTableRow(data, exchanges, exchangeIds)
      }
    } 
    else {
      var errorHtml;
      // clear any old error lists
      $('#error-list').remove();

      if (typeof data.errors != 'undefined') {
        // multiple errors
        errorHtml='<ul id="error-list" class="list-unstyled margin-bottom-0">';
        $.each( data.errors, function(index, value) {
          errorHtml += '<li class="margin-left-20"><strong>' + value[0] + '</strong></li>'; 
        });
        errorHtml+='</ul>';
      }
      else if (typeof data.error != 'undefined') {
        // single error
        errorHtml = data.error;
      }
      else {
        // single error
        errorHtml = "unknown error";
      }

      displayFlashMessage("danger",errorHtml);
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
  data.append('rotation', $('#rotation').val());

  entry_id = isEdit(); 
  if (entry_id) {
    data.append('entry_id', entry_id);
  }

  $("#progressbar").progressbar({
    value: 0
  }).append("<div class='percent_caption'>File upload: 0%</span>");

  $.ajax(
  { 
    url:'/entry/upload',
    type: 'POST',
    data: data,
    dataType: 'json',
    processData: false, // Don't process the files
    contentType: false, // Set content type to false as jQuery will tell the server if it
                        // is a query string request. This is why we can't use $.post here
    timeout: 15000, // 15 second timeout
    xhr: function() {
      var myXhr = $.ajaxSettings.xhr();
      if(myXhr.upload) {
          myXhr.upload.addEventListener('progress',progress, false);
      }
      return myXhr;
    },
    success: function(data, textStatus, jqXHR)
    {
      if (data.success) {
        // Success so call finish_submit to process rest of form
        finish_submit(data);
      }
      else {
        // Handle errors here
        displayFlashMessage("danger", data.error);
      }
    },
    error: function(jqXHR, textStatus, errorThrown)
    {
      // Handle errors here
      displayFlashMessage("danger",textStatus);
    }
  });
}

$("#choose-file").change(function() {
  var maxSize = $('#MAX_FILE_SIZE').val();
  var imageSize = $("#choose-file")[0].files[0].size;
  // test for zero length as well as max size
  if (!imageSize || imageSize > maxSize) {
    $("#shadow_input").val("");
    $('p.too_large').show().addClass("error_message").fadeOut(8000, "swing");
  }
  else {
    $('#shadow_input').val($(this).val().replace("C:\\fakepath\\", ""));
    var files = !!this.files ? this.files : [];
    if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

    if (/^image/.test( files[0].type)) { // only image file
      fileJustChosen = true;
      reader.readAsDataURL(files[0]); // read the local file

      reader.onloadend = function(){ // set insert image before button
        $('#image_box').css('background-image', 'url("' + reader.result + '")');
        $('#image_box_container').show();
      }
    }
    $('#delete_image').addClass('notUploaded');
  }
});

$('#rotate_image').click(function() {
  rotationAngle += 90;
  rotationAngle %= 360;

  $('#rotation').val(-rotationAngle);
  setCSSTransform(rotationAngle);
});

$("#delete_image").on("click", function() {
  deleteImgDialog();
});

$(document).on( "click", "#select_all", function( e ) {
  $('.exchanges').prop('checked', $(this).prop("checked"));
});

$(document).on( "click", ".exchanges", function(e) {
  $('#select_all').prop('checked', false);
});
  
function progress(e)
{
  if(e.lengthComputable) {
    var max = e.total;
    
    // max should never be zero but check doesn't hurt
    if (max) {
      var current = e.loaded;
      var fraction = parseInt(100*current/max, 10);

      $("#progressbar .percent_caption").html("File upload: "+fraction+"%");
      $("#progressbar").progressbar({
          value: fraction
      });

      if (fraction >= 100) {
        $("#progressbar").progressbar({
          value: 100
        });
        $("#progressbar .percent_caption").html("File upload: 100%");
        $("#progressbar").delay(1500).fadeOut(400);
      }
    }
  }  
}

function setCSSTransform(angle)
{
  $('#image_box').css({
    '-webkit-transform':'rotate('+angle+'deg)',
    '-moz-transform':'rotate('+angle+'deg)',
    '-ms-transform':'rotate('+angle+'deg)',
    '-o-transform':'rotate('+angle+'deg)',
    'transform':'rotate('+angle+'deg)'
  });
}


function editEntry(object)
{
  var entry_id = object.attr('data-entryid');
  $.get(entry_id+"/ajaxgetentry",function(data)
  {
    if (data.success) {
      // reload our form
      $("#post_type").val(data.post_type);
      $("#title").val(data.title);
      $('#entryId').val(data.entry_id);
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
        setCSSTransform(0);
        $('#image_box').css("background-image", 
          "url('/assets/uploads/entries/"+data.entry_id+"/"+data.image+"?"+Date.now()+"')");
        $('#image_box_container').show();
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
      if ($('#entryId').val().length ){
        $('#entryId').val('');
        //$("#title").removeClass( "update_"+entry_id);
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
  if('success' == status ) {
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
  $('#delete_image').removeClass('notUploaded');
  $('#image_box').attr('style','').empty();
  $('#image_box_container').hide();
  $('.image_controls').show();
  $('#cancel_button').hide();

  // get rid of any upadate_451 etc classes 
  $('#title').attr('class', 'form-control');
  $('#rotation').val('');
  $('#deleteImage').val('');

  fileJustChosen = false;
  rotationAngle=0;
}

 // smart server error messages
function parseAndDisplayError(error)
{
  var message = '';
  for (var err in error) {
    message += '<li>boo' + error[err] + '</li>';
    $('#' + err).parent().addClass('has-error');
  }

  $('#submission_error').html(message).show();
}

function trimString(yourString, maxLength)
{
  //trim the string to the maximum length
  if(yourString.length > maxLength)   {
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
        '<button class="button_delete smooth_font btn btn-warning btn-sm" data-entryid="'+replyData.entry_id+'">'+
          '<i class="fa fa-trash-o fa-lg"></i></button>'+
        '<button class="button_edit smooth_font btn btn-info btn-sm" data-entryid="'+replyData.entry_id+'">'+
          '<i class="fa fa-pencil fa-lg"></i></button>'+
      '</td>'+
    '</tr>'
  );
}

function updateTableRow(data, exchanges, exchangeIds)
{
  var entry_id = data.entry_id;

  $('#entryId').val('');
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
  return $('#entryId').val();  
}

function deleteImgDialog()
{
  if (!$('#delete_image').hasClass('notUploaded')) {
    $("#dialog-confirm").dialog({
      resizable: false,
      height: "auto",
      width: 400,
      modal: true,
      buttons: [ 
        { 
          text: "Cancel",
          class: 'ui-button ui-corner-all ui-widget', 
          click: function() { 
            $(this).dialog("close"); 
          } 
        },
        { 
          text: "Delete",
          class: 'ui-button ui-corner-all ui-widget', 
          click: function() { 
            $('#image_box').prepend('<img src="/assets/img/default/deleted_image.png">');
            $('.image_controls').hide();
            $(this).dialog("close"); 
            fileJustChosen = false;
            $('#deleteImage').val(1);
          } 
        }
      ]
    });
  }
  else {
    // this isn't a saved image so no need to show a warning dialog, just clear the background-image
    $('#image_box').css("background-image","");
    $('#image_box_container').hide();
    $("#shadow_input").val("");
  }
}
