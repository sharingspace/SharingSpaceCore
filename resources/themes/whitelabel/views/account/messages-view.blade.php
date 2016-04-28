@extends('layouts.master')

@section('content')


<section class="container padding-top-0 browse_table">
<div class="row">
  <h1 class="margin-bottom-0 size-24 text-center">{{trans('general.messages.inbox')}}</h1>
    <!-- Begin entries table -->
    <table class="table table-condensed"
    name="messages"
    id="table"
    data-cookie="true"
    data-cookie-id-table="messages">
      <thead>
          <tr>
            <th data-sortable="true" data-field="post_type"><span class="sr-only">{{ trans('general.entries.post_type') }}</span></th>
            <th data-sortable="true" data-field="title">{{ trans('general.entries.title') }}</th>
            <th data-sortable="true" data-field="author">{{ trans('general.messages.from') }}</th>
            <th data-sortable="true" data-field="created_at">{{ trans('general.messages.created_at') }}</th>
            <th data-sortable="false" data-field="actions" data-visible="false">{{ trans('general.entries.actions') }}</th>
          </tr>
      </thead>
    </table>
    <!-- End entries table -->
  </div>
</section>

<script src="{{ asset('assets/js/bootstrap-table.js') }}"></script>
<script src="{{ asset('assets/js/extensions/cookie/bootstrap-table-cookie.js') }}"></script>
<script src="{{ asset('assets/js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/bootstrap-table-export.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/tableExport.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/jquery.base64.js') }}"></script>

<script type="text/javascript">
$( document ).ready(function() {
  // we off screen the table headers as they are obvious.
  $('table').on( "click", '[id^=delete_entry_]', function() {
    var entryID = $(this).attr('id').split('_')[2];
    // add a clas to the row so we can remove it on success
    $(this).closest('tr').addClass("remove_"+entryID);

    var CSRF_TOKEN = $('meta[name="ajax-csrf-token"]').attr('content');

    $.post(entryID+"/ajaxdelete",{_token: CSRF_TOKEN},function (replyData) {
      //console.log("delete success :-)  "+replyData.entry_id);
      if (replyData.success) {
        // remove row from table
        $('.remove_'+entryID).remove();
        // display error message
        $('div.ajax_success .fa-check').after('&nbsp;<strong>Success: </strong>'+replyData.message);
        $('div.ajax_success').removeClass('hidden').delay(5000).fadeOut();
      }
      else {
        // display error message
        $('div.ajax_error').removeClass('hidden');
        $('div.ajax_error .fa-exclamation-circle').after('&nbsp;<strong>Error: </strong>'+replyData.message);
      }
    });
  });

  $('#table').bootstrapTable({
    classes: 'table table-responsive table-no-bordered',
    undefinedText: '',
    iconsPrefix: 'fa',
    showRefresh: true,
    search: true,
    pageSize: 100,
    pagination: true,
    sidePagination: 'client',
    sortable: true,
    cookie: true,
    mobileResponsive: true,
    showExport: true,
    showColumns: true,
    exportDataType: 'all',
    exportTypes: ['csv', 'txt','json', 'xml'],
    maintainSelected: true,
    paginationFirstText: "{{ trans('pagination.first') }}",
    paginationLastText: "{{ trans('pagination.last') }}",
    paginationPreText: "{{ trans('pagination.previous') }}",
    paginationNextText: "{{ trans('pagination.next') }}",
    pageList: ['10','25','50','100','150','200'],
    formatShowingRows: function (pageFrom, pageTo, totalRows) {
        return 'Showing ' + pageFrom + ' to ' + pageTo + ' of ' + totalRows + ' entries';
      },
    icons: {
        paginationSwitchDown: 'fa-caret-square-o-down',
        paginationSwitchUp: 'fa-caret-square-o-up',
        columns: 'fa-columns',
        refresh: 'fa-refresh'
    },
  });
})


</script>

@stop
