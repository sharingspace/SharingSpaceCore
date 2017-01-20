@extends('layouts.master')

@section('content')


<section class="container padding-top-0 browse_table">
<div class="row">
  <h1 class="margin-bottom-0 size-24 text-center">{{trans('general.entries.browse_entries')}}</h1>
    <!-- Begin entries table -->
    <table class="table table-condensed"
    name="communityListings"
    id="table"
    data-url="{{ route('json.browse') }}"
    data-cookie="true"
    data-sort-name="created_at"
    data-sort-order="desc"
    data-cookie-id-table="communityListingv1">
      <thead>
          <tr>
            <th data-sortable="true" data-field="post_type"><span class="sr-onlyy">{{ trans('general.type') }}</span></th>
            <th data-sortable="true" data-field="title">{{ trans('general.entry') }}</th>
            <th data-sortable="true" data-field="author">{{ trans('general.entries.posted_by') }}</th>
            <th data-sortable="true" data-field="location">{{ trans('general.entries.location') }}</th>
            <th data-sortable="true" data-field="created_at">{{ trans('general.entries.created_at') }}</th>
            <th data-sortable="false" data-field="tags">{{ trans('general.keywords') }}</th>
            <th data-sortable="false" data-field="actions" data-visible="false">{{ trans('general.actions') }}</th>
          </tr>
      </thead>
    </table>
    <!-- End entries table -->
  </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.js" integrity="sha256-OOtvdnMykxjRaxLUcjV2WjcyuFITO+y7Lv+3wtGibNA=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/cookie/bootstrap-table-cookie.min.js" integrity="sha256-w/PfNZrLr3ZTIA39D8KQymSlThKrM6qPvWA6TYcWrX0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/mobile/bootstrap-table-mobile.min.js" integrity="sha256-+G625AaRHZS3EzbW/2aCeoTykr39OFPJFfDdB8s0WHI=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/export/bootstrap-table-export.min.js" integrity="sha256-Hn0j2CZE8BjcVTBcRLjiSJnLBMEHkdnsfDgYH3EAeVQ=" crossorigin="anonymous"></script>
<script src="{{ Helper::cdn('js/extensions/export/tableExport.js') }}"></script>
<script src="{{ Helper::cdn('js/extensions/export/jquery.base64.js') }}"></script>

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
    sidePagination: 'server',
    sortable: true,
    cookie: true,
    mobileResponsive: true,
    showExport: true,
    showColumns: true,
    exportDataType: 'all',
    exportTypes: ['csv', 'txt','json', 'xml'],
    maintainSelected: true,
    paginationFirstText: "{{ trans('general.first') }}",
    paginationLastText: "{{ trans('general.last') }}",
    paginationPreText: "{{ trans('general.prev') }}",
    paginationNextText: "{{ trans('general.next') }}",
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
