@extends('layouts.master')

{{-- Page title --}}
@section('title')
  {{ trans('general.user.join_requests') }} ::
@parent
@stop


@section('content')


<div class="container">
	<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
        <div id="submission_error" style="display:none" >

      </div>
    </div> <!-- col 10 -->
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-20">
      <h1 class="margin-bottom-20  size-24 text-center">{{trans('general.user.join_requests')}}</h1>

      <div class="table-responsive">
        <table class="table table-condensed" id="requests">
          <thead>
            <tr>
              <th data-sortable="false" >Name</span></th>
              <th data-sortable="true" class="email">Email</th>
              <th data-sortable="true" class="message">Message</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($join_requests as $request)
              <tr id="request_{{$request->id}}">
                <td id="displayName_{{$request->id}}">{{$request->display_name}}</td>
                <td>{{$request->email}}</td>
                <td>{{$request->pivot['message']}}</td>
                <td>
                  <button class="button_accept smooth_font btn btn-success btn-sm" data-userid="{{$request->id}}" data-communityid="{{$whitelabel_group->id}}">Accept</button>
                  <button class="button_reject smooth_font btn btn-danger btn-sm margin-left-10" data-userid="{{$request->id}}" "data-communityid="{{$whitelabel_group->id}}">Decline</button></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
 	 </div> <!-- col-lg-10 -->
	</div> <!-- row -->
</div> <!-- #container -->
          {!! csrf_field() !!}

<script src="{{ asset('assets/js/bootstrap-table.js') }}"></script>
<script src="{{ asset('assets/js/extensions/cookie/bootstrap-table-cookie.js') }}"></script>
<script src="{{ asset('assets/js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/bootstrap-table-export.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/tableExport.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/jquery.base64.js') }}"></script>

<script type="text/javascript">
$(document).ready(function() {
  $('#members').bootstrapTable({
		classes: 'table table-responsive table-no-bordered',
    undefinedText: '',
    iconsPrefix: 'fa',
    showRefresh: false,
    search: false,
    pageSize: 20,
    pagination: true,
    sortable: true,
    mobileResponsive: true,
    formatShowingRows: function (pageFrom, pageTo, totalRows) {
      return 'Showing ' + pageFrom + ' to ' + pageTo + ' of ' + totalRows + ' requests';
    },
     icons: {
        paginationSwitchDown: 'fa-caret-square-o-down',
        paginationSwitchUp: 'fa-caret-square-o-up',
        columns: 'fa-columns',
        refresh: 'fa-refresh'
    }
  });

  $(".button_accept").on("click", function() {
    var user_id = $(this).attr('data-userid');
    var community_id = $(this).attr('data-communityid');
    var name = $('#displayName_'+user_id).text();
    accept(user_id, community_id, name);
  });

  function accept(user_id, community_id, name)
  {
    data={displayName:name, user_id:user_id};
    $.get("accept", data, function (replyData)
    {
      if (replyData.success) {
        displayFlashMessage('success', replyData);

        // now remove this request entry from our table
        $('#request_'+replyData.user_id).fadeOut(600, function() {
          $(this).remove();
        });

        var numRequest = $('#numberRequests span').text() -1; 
        if (numRequest) {
          $('#numberRequests span').text(numRequest) ;
        }
        else {
          $('#numberRequests').hide();
        }
      } 
      else {
        console.log("accept: fail");
      }
    }).fail(function (jqxhr,errorStatus) {
      console.log("accept: fail");
    }).always(function() {
    });
  }

  $(".button_reject").on("click", function() {
    var user_id = $(this).attr('data-userid');
    var community_id = $(this).attr('data-communityid');
    var name = $('#displayName_'+user_id).text();
    reject(user_id, community_id, name);
  });

  function reject(user_id, community_id, name)
  {
    data={displayName:name, user_id:user_id};
    $.get("reject", data, function (replyData)
    {
      if (replyData.success) {
        displayFlashMessage('success', replyData);

        // now remove this request entry from our table
        $('#request_'+replyData.user_id).fadeOut(600, function() {
          $(this).remove();
        });
        
        var numRequest = $('#numberRequests span').text() -1; 
        if (numRequest) {
          $('#numberRequests span').text(numRequest) ;
        }
        else {
          $('#numberRequests').hide();
        }
      } 
      else {
        console.log("reject: fail");
      }
    }).fail(function (jqxhr,errorStatus) {
      console.log("reject: fail");
    }).always(function() {
    });
  }


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

});
</script>

@stop
