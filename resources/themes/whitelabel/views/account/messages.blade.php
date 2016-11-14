@extends('layouts.master')

@section('content')


<section id="messages" class="container padding-top-0 browse_table">
  <div class="row">
    <div class="col-xs-12">
      <h1 class="size-24 text-center">{{ $conversation->subject }}</h1>

      <form method="post" enctype="multipart/form-data" autocomplete="off" class="margin-left-10 margin-right-10" id="message_form">
        {!! csrf_field() !!}    <!-- Begin messages table -->
        
        @foreach ($conversation->messages as $message)
        <div class="row messageRow message_{{$message->id}}">  
          <div class="col-xs-1">
            <a class="member_thumb pull-left" href="{{ route('user.profile', $message->sender->id) }}">
              <img class="hidden-xs margin-right-10" src="{{ $message->sender->gravatar_img() }}">
            </a>
          </div>
          <div class="col-xs-8">
            <div class="row">
              <div class="col-xs-12 padding-top-10">
                <strong class="sent_by">{{ $message->sender->getDisplayName() }}</strong>
                @if ($message->conversation->community)
                  <span> / {{ $message->conversation->community->name }}</span>
                @endif
              </div>
              <div class="col-xs-12">
                @if (strlen($message->message) > 100)
                  <a data-toggle="collapse" data-target="#expand_{{$message->id}}">
                  @if (empty($message->read_on))
                    <i class="fa fa-eye-slash fa-lg pull-left text-green margin-top-5"></i>
                  @endif
                @endif
                  {!! Str::limit(Helper::parseText($message->message), 100) !!}
                @if (strlen($message->message) > 100)
                  </a>
                @endif
                <div id="expand_{{$message->id}}" class="collapse">
                  {!! Helper::parseText($message->message) !!}
                </div>
              </div>
            </div>
          </div>

          <div class="col-xs-2">
            <span class="hidden-sm hidden-xs">{{ date('M j, Y g:ia', strtotime($message->created_at)) }}</span>
            <span class="visible-sm visible-xs">{{ date('M j, Y', strtotime($message->created_at)) }}</span>
          </div>

          <div class="col-xs-1">
            <button class="btn btn-danger btn-sm button_delete" id="messageid_{{$message->id}}">
              <i class="fa fa-trash"></i>
            </button>       
          </div>
        </div>
        @endforeach

      <!-- End messages table -->
      </form>
    </div>

    <div class="col-xs-12">
      <!-- reply -->
      <div class="clearfix margin-bottom-60">

        <div class="border-bottom-1 border-top-1 padding-10">
          <span class="pull-right size-11 margin-top-3 text-muted">today</span>
          <strong>LEAVE A REPLY</strong></a>
        </div>

        <form id="offerForm" class="block-review-content">
          {!! csrf_field() !!}

          <div class="margin-top-30 margin-bottom-20">

            <!-- alert -->
            <div class="alert alert-dismissable" style="display: none;" id="offerStatusbox">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <i class="fa fa-exclamation-circle"></i>
              <strong id="offerStatusText"></strong><span id="offerStatus"></span>
            </div>
            <!-- alert -->

            <input type="hidden" name="thread_subject" value="{{ $conversation->subject }}">
            <input type="hidden" name="thread_id" value="{{ $conversation->id }}">
            @if ($conversation->entry)
              <input type="hidden" name="entry_id" value="{{ $conversation->entry_id }}">
            @endif
            <textarea class="messageText form-control" data-height="200" data-lang="en-US" name="message"></textarea>
          </div>

          <button class="btn btn-3d btn-sm btn-reveal btn-teal">
            <i class="fa fa-check"></i>
            <span>SUBMIT POST</span>
          </button>
        </form>
      </div>
      <!-- /reply -->
    </div>
  </div>
</section>

<div id="dialog-confirm" title="Delete message?">
  <p><i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i><span>This message will be permanently deleted.</span></p>
</div>

<script>
$(window).load(function () {
  // scroll to reply box, this works on firefix and chrome
  window.setTimeout(function() {
    $(window).scrollTop($(document).height()); 
  }, 0);
});

$(document).ready(function () {
  $("#offerForm").submit(function(){
    $('#offerStatusbox').hide();
    $('#offerStatusText').html('');
    $('#offerStatus').html('');
    $('#offerStatusbox').removeClass('alert alert-success alert-danger');
    //console.log($('#offerForm').serialize()); $conversation->entryId
    console.log({{$conversation->findSendToId(Auth::user())}}+"   "+{{$conversation->entry_id}});
    $.ajax({
      type: "POST",
      url: "{{ route('messages.create.save', [$conversation->findSendToId(Auth::user()), $conversation->entry_id]) }}",
      data: $('#offerForm').serialize(),

      success: function(data){
        $('#offerStatusbox').show();

        if (data.success) {
          $('#offerStatusbox').addClass('alert alert-success');
          $('#offerStatusText').html('Success! '+data.message);
          $('#offerStatusbox').fadeTo(1000, 500).slideUp(500);
          $('.messageText').val('');
          //var lastRow = $('.messageRow').last();
          //var clone = $(lastRow).clone();
          //$(clone).clone().insertAfter(lastRow);
        } else {
          $('#offerStatusbox').addClass('alert alert-warning');
          $('#offerStatusText').html('Error: '+data.message);
        }

      },
      error: function(data){
        $('#offerStatusbox').addClass('alert alert-danger');
        $('#offerStatus').html('Something went wrong :(');
      }
    });
    return false;
  });

  function displayFlashMessage(status, data)
  {
    if('success' == status ) {
      messageHTML ='<div class="alert alert-'+status+' margin-top-0 margin-bottom-6 alert_'+data.message_id+'"><i class="fa margin-right-10 fa-check"></i>'+data.message+'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>';
      $('.message_'+data.message_id).before(messageHTML);
      $('.alert_'+data.message_id).fadeTo(2000, 500).slideUp(500);
    }
    else {
      messageHTML ='<div class="alert alert-'+status+' alert-dismissable margin-top-0 margin-bottom-6 alert_'+data.message_id+'"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa margin-right-10 fa-exclamation"></i>'+data.message+'</div>';
      $('.message_'+data.message_id).before(messageHTML);
      $('.alert_'+data.message_id).fadeTo(2000, 500).slideUp(500);
    }
  }

  function deleteMessage(object)
  {
    var message_id = object.attr("id").split("_")[1];
    var url = "ajaxdelete/"+message_id;
    //console.log(message_id+"   "+url);

    $.post(url,{_token: $('input[name=_token]').val()},function (replyData)
    {
      if (replyData.success) {
        //console.log("message deleted!!!"+replyData.message_id);
        displayFlashMessage("success",replyData);

        $('.row.message_'+replyData.message_id).fadeTo(1000, 500).slideUp(500).$(this).remove();
      } 
      else {
        //console.log("message error!!!"+replyData.message_id+replyData.message);

        displayFlashMessage("warning",replyData);
      }
    }).fail(function (jqxhr,errorStatus) {
      console.log("message error: "+errorStatus); 
      //parseAndDisplayError(errorStatus);
    });
  }

  function deleteMessageDialog(object)
  {
    $("#dialog-confirm").dialog({
      resizable: false,
      height: "auto",
      width: 430,
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
            $(this).dialog("close"); 
            deleteMessage(object);
          } 
        }
      ]
    });
  }

  $(document).on( "click", ".button_delete", function(e) {
    e.preventDefault();
    deleteMessageDialog($(this));
  });
});

</script>

@stop
