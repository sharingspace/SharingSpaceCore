@extends('layouts/master')
{{-- Page title --}}
@section('title')
     {{ trans('general.nav.browse') }} ::
@parent
@stop

{{-- Page content --}}
@section('content')

@if ($whitelabel_group->show_info_bar)
<section class="info-bar hidden-xs">
	<div class="container">

		<div class="row">
      <h1 class="sr-only">{{ $whitelabel_group->name }} {{ trans('home.homepage')}}</h1>

			<div class="col-sm-4">
				<i class="glyphicon glyphicon-globe"></i>
          @if ($whitelabel_group->group_type == 'O')
            <h3 class="uppercase">{{ trans('general.community.open.title') }}</h3>
            <p>{{ trans('general.community.open.text') }}</p>
          @elseif ($whitelabel_group->group_type == 'C')
            <h3 class="uppercase">{{ trans('general.community.closed.title') }}</h3>
            <p>{{ trans('general.community.closed.text') }}</p>
          @elseif ($whitelabel_group->group_type == 'S')
            <h3 class="uppercase">{{ trans('general.community.secret.title') }}</h3>
            <p>{{ trans('general.community.secret.text') }}</p>
          @endif
			</div>

			<div class="col-sm-4">
				<i class="glyphicon glyphicon-user"></i>

				<h3 class="uppercase">{{ $whitelabel_group->members->count() }} {{ trans_choice('general.our_members', $whitelabel_group->members->count()) }}</h3>
                @if ($whitelabel_group->created_at)
				<p>Since {{ $whitelabel_group->created_at->format('M j, Y') }}</p>
                @endif
			</div>

			<div class="col-sm-4">
				<i class="glyphicon glyphicon-flag"></i>
				<h3 class="uppercase">{{ trans_choice('general.community.exchange_types.title', $whitelabel_group->exchangeTypes->count()) }}</h3>
				<ul class="exchange_types">
          @if ($whitelabel_group->exchangeTypes->count() == 10)
            <li>{{ trans('general.community.exchange_types.all_allowed') }}</li>
          @else
            @foreach ($whitelabel_group->exchangeTypes as $exchange_type)
              <li>{{ $exchange_type->name }}</li>
            @endforeach
          @endif
        </ul>
			</div>
		</div>
	</div>
</section>
@endif <!-- /INFO BAR -->

<div class="col-md-12 margin-top-20">
  <!-- Notifications -->
  @include('notifications')
</div>

<section class="container padding-top-0 browse_table">
<div class="row">
  <h2 class="margin-bottom-0 size-20 text-center">{{trans('general.entries.browse_entries')}}</h1>
    <!-- Begin entries table -->

    <table class="table table-condensed"
    name="communityListings"
    id="entry_browse_table"
    data-sort-name="created_at"
    data-sort-order="desc"
    data-url="{{ route('json.browse') }}"
    data-cookie="true"
    data-cookie-id-table="communityListingv1-{{ $whitelabel_group->id }}">
      <thead>
        <tr>
          <th data-sortable="false" data-field="image">{{ trans('general.members.image')}}</th>
          <th data-sortable="true" data-field="post_type">{{ trans('general.entries.post_type') }}</th>
          <th data-sortable="true" data-field="title">{{ trans('general.entry') }}</th>
          <th class="hidden-xs" data-sortable="true" data-field="author">{{ trans('general.entries.posted_by') }}</th>
          <th data-sortable="false" data-field="exchangeTypes">{{ trans('general.entries.exchange') }}</th>
          <th data-sortable="true" data-field="location">{{ trans('general.location') }}</th>
          <th data-sortable="true" data-field="created_at">{{ trans('general.entries.created_at') }}</th>
          <th class="hidden-xs" data-sortable="false" data-field="tags" data-visible="false">{{ trans('general.keywords') }}</th>
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
        $('div.ajax_success').removeClass('hidden');//.delay(5000).fadeOut();
      }
      else {
        // display error message
        $('div.ajax_error').removeClass('hidden');
        $('div.ajax_error .fa-exclamation-circle').after('&nbsp;<strong>Error: </strong>'+replyData.message);
      }
    });
  });

  $('#entry_browse_table').bootstrapTable({
    classes: 'table table-responsive table-no-bordered',
    undefinedText: '',
    iconsPrefix: 'fa',
    showRefresh: true,
    search: true,
    pageSize: 100,
    pagination: true,
    sidePagination: 'server',
    sortable: true,
    mobileResponsive: true,
    showExport: true,
    showColumns: true,
    exportDataType: 'all',
    exportTypes: ['csv', 'txt','json', 'xml'],
    maintainSelected: true,
    paginationFirstText: "{{ trans('gernal.first') }}",
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
        refresh: 'fa-refresh',
        export: 'fa-download'
    }
  });

  // for some reason the columns and refresh have their tooltips added automatically
  $('.export > button').attr('title','Download data as');

  $('#entry_browse_table').on('load-success.bs.table', function () {
    $('.pull-right.search').removeClass('pull-right').addClass('pull-left');
  });

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
      }
      else {
        //console.error('delete failed');
      }
    });
  });
});

</script>

@stop
