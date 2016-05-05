@extends('layouts.master')

@section('content')


<section class="container padding-top-0 browse_table">
<div class="row">
  <h1 class="margin-bottom-0 size-24 text-center">{{ trans('general.messages.message_from', ['name' => $message->sender->getDisplayName() ]) }}</h1>

  <!-- post -->
  <div class="clearfix margin-bottom-60">

    <div class="border-bottom-1 border-top-1 padding-10">
      <span class="pull-right size-11 margin-top-3 text-muted">{{ $message->created_at->format('M i, Y h:iA') }}</span>
      <strong>{{ $message->sender->getDisplayName()  }}</strong></a>
    </div>

    <div class="block-review-content">

      <div class="block-review-body">

        <div class="block-review-avatar text-center">
          <div class="push-bit">
            <a href="{{ route('user.profile', $message->sender->id) }}">
              <img src="{{ $message->sender->gravatar() }}" width="100" alt="avatar">
            </a>
          </div>

        </div>
        {!!  Helper::parseText($message->message) !!}
      </div>

    </div>

  </div>
  <!-- /post -->


  <!-- reply -->
  <div class="clearfix margin-bottom-60">

    <div class="border-bottom-1 border-top-1 padding-10">
      <span class="pull-right size-11 margin-top-3 text-muted">today</span>
      <strong>LEAVE A REPLY</strong></a>
    </div>

    <form id="offerForm" class="block-review-content">
      {!! csrf_field() !!}

      <div class="clearfix margin-top-30 margin-bottom-20">
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
</section>


<script>
  $(document).ready(function () {

    //$("#messageSubmit").attr('disabled','disabled'); // disable button until message has been types

    $("#offerForm").submit(function(){

      $.ajax({
        type: "POST",
        url: "{{ route('messages.create.save', $message->entry->id) }}",
        data: $('#offerForm').serialize(),
        success: function(data){
          if (data.success) {
            alert("success");
          } else {
            alert("ERROR: " + data.error.message[0]);
          }

        },
        error: function(data){
          alert("failure");
        }
      });
      return false;
    });
  });
</script>

@stop
