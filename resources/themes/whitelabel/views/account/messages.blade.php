@extends('layouts.master')

@section('content')


<section id="messages" class="container padding-top-0 browse_table">
  <div class="row">
    <div class="col-xs-12">
      <h1 class="size-24 text-center">{{ $conversation->subject }}</h1>

      <form method="post" enctype="multipart/form-data" autocomplete="off" class="margin-left-10 margin-right-10" id="message_form">
        {!! csrf_field() !!}    <!-- Begin messages table -->
        <table
        name="messages"
        id="table"
        data-cookie="true"
        data-cookie-id-table="inbox-messages">
          <thead>
            <tr>
              <th data-sortable="true" data-field="author" style="width:18%;">{{ trans('general.messages.sent_by') }}</th>
              <th data-sortable="true" data-field="message"  style="width:40%;">{{ trans('general.messages.message') }}</th>
              <th data-sortable="true" data-field="created_at">{{ trans('general.messages.created_at') }}</th>
              <th data-sortable="true" data-field="community">{{ trans('general.community.community') }}</th>
              <th data-sortable="false" data-field="actions"></th>
            </tr>
          </thead>
          <tbody>
          @foreach ($conversation->messages as $message)
            <tr>
              <td>
                <a class="member_thumb pull-left" href="{{ route('user.profile', $message->sender->id) }}">
                  <img class="hidden-xs" src="{{ $message->sender->gravatar_img() }}">
                  {{ $message->sender->getDisplayName() }} 
                </a>
              </td>
              <td>
                {!!  Helper::parseText($message->message) !!}
              </td>
            
              <td>
                <span class="hidden-xs">{{ date('M j, Y g:ia', strtotime($message->created_at)) }}</span>
                <span class="visible-xs">{{ date('M j, Y', strtotime($message->created_at)) }}</span>

              </td>
              <td class="hidden-xs">
                @if ($message->conversation->community)
                  {{ $message->conversation->community->name }}
                @endif
              </td>
              <td>
                <button class="btn btn-danger btn-sm button_delete" id="messageid_{{$message->id}}">
                  <i class="fa fa-trash"></i>
                </button>       
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
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

          <div class="clearfix margin-top-30 margin-bottom-20">

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
            <textarea class="summernote form-control" data-height="200" data-lang="en-US" name="message"></textarea>
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
$(document).ready(function () {

  $("#offerForm").submit(function(){
    $('#offerStatusbox').hide();
    $('#offerStatusText').html('');
    $('#offerStatus').html('');
    $('#offerStatusbox').removeClass('alert alert-success alert-danger');
    //console.log($('#offerForm').serialize());
    $.ajax({
      type: "POST",
      url: "{{ route('messages.create.save', $conversation->findSendToId(Auth::user())) }}",
      data: $('#offerForm').serialize(),

      success: function(data){

        $('#offerStatusbox').show();

        if (data.success) {
          $('#offerStatusbox').addClass('alert alert-success');
          $('#offerStatusText').html('Success!');
          $('#offerStatus').html(data.success.message);

        } else {
          $('#offerStatusbox').addClass('alert alert-danger');
          $('#offerStatusText').html('Error: ');
          $('#offerStatus').html(data.error.message[0]);
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
      messageHTML ='<div class="alert alert-'+data.alert_class+' margin-top-3 margin-bottom-3"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa margin-right-10 fa-check"></i>'+data.message+'</div>';
    }
    else {
      messageHTML ='<div class="alert alert-error margin-top-3 margin-bottom-3"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa margin-right-10 fa-exclamation"></i></div>';
    }
    $('#submission_error').append(messageHTML);
    $('#submission_error').show();
  }

  function deleteMessage(object)
  {
    var message_id = object.attr("id").split("_")[1];
    var $url = "ajaxdelete/"+message_id;
    //console.log(message_id+"   "+$url);

    $.post($url,{_token: $('input[name=_token]').val()},function (replyData)
    {
      if (replyData.success) {
        //console.log("message deleted!!!"+replyData.messageId);

        $('#messageid_'+replyData.messageId).closest('tr').fadeOut(300, function(){ $(this).remove();});
      } 
      else {
        //console.log("message error!!!"+replyData.messageId);

        displayFlashMessage("danger",replyData.error);
      }
    }).fail(function (jqxhr,errorStatus) {
      parseAndDisplayError(errorStatus);
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
