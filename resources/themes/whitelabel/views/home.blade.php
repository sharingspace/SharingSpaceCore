@extends('layouts/master')
{{-- Page title --}}
@section('title')
     {{ trans('general.nav.browse') }} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<section class="info-bar">
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

				<h3 class="uppercase">{{ $whitelabel_group->members->count() }} {{ trans_choice('general.community.members', $whitelabel_group->members->count()) }}</h3>
				<p>Since {{ $whitelabel_group->created_at->format('M d, Y') }}</p>
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
<!-- /INFO BAR -->

<div class="col-md-12 margin-top-20">
  <!-- Notifications -->
  @include('notifications')
</div>

@if ($whitelabel_group->about!='')
<section class="container padding-none">
  <div class="row">
      <div class="col-md-12 col-sm-12">
          <p>{{ $whitelabel_group->about }}</p>
      </div>
  </div><!--end row-->
</section>
@endif

<section class="container padding-top-0 browse_table">
<div class="row">
  <h2 class="margin-bottom-0 size-20 text-center">{{trans('general.entries.browse_entries')}}</h1>
    <!-- Begin entries table -->
    <table class="table table-condensed"
    name="communityListings"
    id="table"
    data-url="{{ route('json.browse') }}"
    data-cookie="true"
    data-cookie-id-table="communityListingv1">
      <thead>
          <tr>
            <th data-sortable="true" data-field="post_type"><span class="sr-onlyy">{{ trans('general.entries.post_type') }}</span></th>
            <th data-sortable="true" data-field="title">{{ trans('general.entries.title') }}</th>
            <th data-sortable="true" data-field="author">{{ trans('general.entries.posted_by') }}</th>
            <th data-sortable="true" data-field="location">{{ trans('general.entries.location') }}</th>
            <th data-sortable="true" data-field="created_at" data-visible="false">{{ trans('general.entries.created_at') }}</th>
            <th data-sortable="false" data-field="tags">{{ trans('general.entries.tags') }}</th>
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

$( document ).ready(function() {
  $('#table').on('load-success.bs.table', function () {
    $('.pull-right.search').removeClass('pull-right').addClass('pull-left');
  });

  $("#display_about").click(function(e){
    $("#about_panel").slideToggle("slow");
    return false;
  });
});

</script>

@stop
