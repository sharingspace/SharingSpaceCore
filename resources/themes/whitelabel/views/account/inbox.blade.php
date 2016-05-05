@extends('layouts.master')

@section('content')


<section class="container padding-top-0 browse_table">
<div class="row">
  <h1 class="margin-bottom-0 size-24 text-center">{{trans('general.messages.inbox')}}</h1>
    <!-- Begin messages table -->
    <table class="table table-condensed"
    name="messages"
    id="table"
    data-cookie="true"
    data-cookie-id-table="messages">
      <thead>
          <tr>
            <th data-sortable="true" data-field="post_type"><span class="sr-only">{{ trans('general.entries.post_type') }}</span></th>
            <th data-sortable="true" data-field="title">{{ trans('general.entries.entry') }}</th>
            <th data-sortable="true" data-field="author">{{ trans('general.messages.from') }}</th>
            <th data-sortable="true" data-field="author">{{ trans('general.messages.message') }}</th>
            <th data-sortable="true" data-field="created_at">{{ trans('general.messages.created_at') }}</th>
          </tr>
      </thead>
      <tbody>
          @foreach ($messages as $message)
          <tr>
            <td>
                @if ($message->conversation->entry)
                {{ strtoupper($message->conversation->entry->post_type) }}
                @endif
            </td>
            <td>
                @if ($message->conversation->entry)
                    <a href="{{ route('entry.view', $message->conversation->entry->id) }}">{{ $message->conversation->entry->title }}</a>
                @endif
            </td>
            <td><a href="{{ route('user.profile', $message->sender->id) }}"><img src="{{ $message->sender->gravatar() }}" class="avatar-sm">{{ $message->sender->getDisplayName() }}</a></td>
            <td><a href="{{ route('message.view', $message->conversation->id) }}">
                    {{ ($message->conversation->subject!='' ? $message->conversation->subject: '(No subject)') }}</a></td>
            <td>{{ $message->created_at->format('M j, Y') }}</td>
          </tr>
          @endforeach
      </tbody>
    </table>
    <!-- End messages table -->
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
        return 'Showing ' + pageFrom + ' to ' + pageTo + ' of ' + totalRows + ' messages';
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
