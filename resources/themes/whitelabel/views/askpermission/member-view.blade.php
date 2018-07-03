@extends('layouts.master')

@section('title')
     {{ trans('general.ask_permission.view-request') }} ::
@parent
@stop


@section('content')
<div class="container margin-top-20">
  <div class="row">
    

    <form method="post" action="{{route('admin.member.request.granted')}}" id="payment-form" enctype="multipart/form-data" autocomplete="off" class="sky-form boxed clearfix">

    <input type="hidden" name="id" value="{{$ask->id}}">
    {!! csrf_field() !!}


      <header>
          <div class="row">
              <div class="col-sm-9 col-sm-offset-3 text-muted">
                  <h2>
                    {{ trans('general.ask_permission.view-request') }}
                  </h2>
              </div>
          </div>
      </header>
      
      <div class="row">
        <div class="col-sm-9 col-sm-offset-3">
          <div class="form-group">
            <div class="col-sm-3">
              <label>Request Type : </label>
            </div>
            <div class="col-sm-6">
              <label>{{$ask->request_type}}</label>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-sm-9 col-sm-offset-3">
          <div class="form-group">
            <div class="col-sm-3">
              <label> Requested By : </label>
            </div>
            <div class="col-sm-6">
              <label>{{ Auth::user()->email}}</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-9 col-sm-offset-3">
          <div class="form-group">
            <div class="col-sm-3">
              <label>Requested Role : </label>
            </div>
            <div class="col-sm-6">
              <label>{{$role->name}}</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-9 col-sm-offset-3">
          <div class="form-group">
            <div class="col-sm-3">
              <label>Requested Message : </label>
            </div>
            <div class="col-sm-6">
              <label>{{$ask->custom_text}}</label>
            </div>
          </div>
        </div>
      </div>
    
      <div class="row">
          <div class="col-sm-9 col-sm-offset-3">
            <div class="col-sm-1 col-sm-offset-3">
              <button type="submit" class="btn btn-success" name="accept" value="1">
                  Accept
            </div>
            <div class="col-sm-1">
              <button type="submit" class="btn btn-danger" name="reject" value="1">
                  Reject
              </button>
            </div>
          </div>
      </div>
    </form>
  </div>
</div> <!-- #container -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.js" integrity="sha256-OOtvdnMykxjRaxLUcjV2WjcyuFITO+y7Lv+3wtGibNA=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/cookie/bootstrap-table-cookie.min.js" integrity="sha256-w/PfNZrLr3ZTIA39D8KQymSlThKrM6qPvWA6TYcWrX0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/mobile/bootstrap-table-mobile.min.js" integrity="sha256-+G625AaRHZS3EzbW/2aCeoTykr39OFPJFfDdB8s0WHI=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/export/bootstrap-table-export.min.js" integrity="sha256-Hn0j2CZE8BjcVTBcRLjiSJnLBMEHkdnsfDgYH3EAeVQ=" crossorigin="anonymous"></script>
<script src="{{ Helper::cdn('js/extensions/export/tableExport.js') }}"></script>
<script src="{{ Helper::cdn('js/extensions/export/jquery.base64.js') }}"></script>

<script type="text/javascript">
$(document).ready(function() {
    $('#members').bootstrapTable({
      classes: 'table table-responsive table-no-bordered',
      undefinedText: '',
      iconsPrefix: 'fa',
      showRefresh: false,
      search: true,
      pageSize: 20,
      pagination: true,
      sortable: true,
      mobileResponsive: true,
      formatShowingRows: function (pageFrom, pageTo, totalRows) {
        return 'Showing ' + pageFrom + ' to ' + pageTo + ' of ' + totalRows + ' members';
      },
       icons: {
          paginationSwitchDown: 'fa-caret-square-o-down',
          paginationSwitchUp: 'fa-caret-square-o-up',
          columns: 'fa-columns',
          refresh: 'fa-refresh'
      }
    });

});




</script>

@stop
