@extends('layouts.master')

@section('content')
<script src="{{ asset('assets/js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>

<section class="container">
<div class="row">
<table
    name="communityListings"
    id="table"
    data-url="{{ route('json.browse') }}"
    data-cookie="true"
    data-click-to-select="true"
    data-cookie-id-table="communityListingsTablesdkgjlg">
        <thead>
            <tr>
                <th data-sortable="true" data-field="title">{{ trans('general.entries.title') }}</th>
                <th data-sortable="true" data-field="author">{{ trans('general.entries.author') }}</th>
                <th data-sortable="true" data-field="location">{{ trans('general.entries.location') }}</th>
                <th data-sortable="true" data-field="created_at">{{ trans('general.entries.created_at') }}</th>
            </tr>
        </thead>
    </table>
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
        pageSize: 20,
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
        paginationFirstText: "@lang('pagination.first')",
        paginationLastText: "@lang('pagination.last')",
        paginationPreText: "@lang('pagination.previous')",
        paginationNextText: "@lang('pagination.next')",
        pageList: ['10','25','50','100','150','200'],
        icons: {
            paginationSwitchDown: 'fa-caret-square-o-down',
            paginationSwitchUp: 'fa-caret-square-o-up',
            columns: 'fa-columns',
            refresh: 'fa-refresh'
        },

    });
</script>

@stop
