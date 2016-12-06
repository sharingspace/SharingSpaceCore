@extends('layouts/master')

{{-- Page title --}}
@section('title')
     {{ trans('general.create') }} ::
@parent
@stop
@if($errors->any())
      <ul class="alert alert-danger">
        @foreach($errors->any() as $error)
          <li>{{$error}}</li>
        @endforeach
      </ul>
    @endif
{{-- Page content --}}
@section('content')
  <section class="container">
    <div class="row">
     <h1 class="margin-bottom-0 size-24 text-center">{{ trans('general.create') }}</h1>

      <!-- Added tiles .... -->
      <div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12 margin-bottom-0">
        <table class="table" id="create_table" style="display:none;">
          <caption>{{ trans('general.entries.added') }}</caption>
          <thead>
            <tr>
              <th>{{ trans('general.entries.post_type') }}</th>
              <th>{{ trans('general.entries.qty') }}</th>
              <th>{{ trans('general.entries.title') }}</th>
              <th>{{ trans('general.entries.exchange_types') }}</th>
              <th>{{ trans('general.keywords') }}</th>
              <th>{{ trans('general.action') }}</th>
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
              <i class="fa margin-right-10"></i> {{ trans('general.entries.messages.errors') }}
            </div>
          </div>
        </div> <!-- col 10 -->

@include('./entries/entry_form')
 
      </div> <!-- row -->
		</div> <!-- add_tile_wrapper -->
	</section>
	<!-- / -->

<script type="text/javascript">
  $("#ajaxSubmit").attr('disabled','disabled'); // disable add button until page has loaded
  $("#create_table").hide(); // hide entry table
  $('#image_box_container').hide();
  $('#image_controls').hide();
  var fileJustChosen = false;
  var reader = new FileReader(); // instance of the FileReader
  var rotationAngle=0;
</script>

<script src="{{ Helper::cdn('js/entry_utils.js')}}"></script>

<script type="text/javascript">
$( document ).ready(function() {

  $(document).on( "click", "#ajaxSubmit", function( e ) {
    // finish_submit will get invoked later, after
    // we handle the file upload.
    e.preventDefault();
    var newUpload_key = Math.random().toString(36).substring(7);
    $('#upload_key').val(newUpload_key);

    // do what you like with the input, if we have an image, handle that separately
    if ($('#choose-file').val()) {
      // note. After uploadFiles completes it calls finish_submit()
      uploadFiles();
		}
		else {
      finish_submit();
		}
  });
  
  $("#ajaxSubmit").removeAttr('disabled'); //enable add button now page has loaded

  $(document).on( "click", ".button_edit", function(e) {
    e.preventDefault();
    editEntry($(this));
    $('#cancel_button').show();
  });

  $(document).on( "click", ".button_delete", function(e) {
    e.preventDefault();
    deleteEntry($(this));
  });

  $(document).on( "click", "#cancel_button", function(e) {
    e.preventDefault();
    resetForm();
  });
});

</script>
@stop
