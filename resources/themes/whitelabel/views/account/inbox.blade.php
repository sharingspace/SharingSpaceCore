@extends('layouts.master')

@section('content')

<section class="container padding-top-0 browse_table">
<div class="row">
  <div class="col-xs-12">
    <h1 class="margin-bottom-0 size-24 text-center">{{trans('general.messages.inbox')}}</h1>

    <form method="post" enctype="multipart/form-data" autocomplete="off" class="margin-left-10 margin-right-10" id="entry_form">
      {!! csrf_field() !!}    <!-- Begin messages table -->
      <table
      name="messages"
      id="table"
      data-cookie="true"
      data-cookie-id-table="inbox-messages">
        <thead>
          <tr>
            <th data-sortable="true" data-field="author">{{ trans('general.messages.from') }}</th>
            <th data-sortable="true" data-field="entry">{{ trans('general.entries.entry') }}</th>
            <th data-sortable="true" data-field="thread">{{ trans('general.messages.message') }}</th>
            <th data-sortable="true" data-field="created_at">{{ trans('general.messages.created_at') }}</th>
            <th data-sortable="true" data-field="community">{{ trans('general.community.community') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($messages as $message)
          <tr>
            <td>
              <a href="{{ route('user.profile', $message->sender->id) }}">
                <img src="{{ $message->sender->gravatar_img() }}" class="avatar-sm">
                {{ $message->sender->getDisplayName() }} 
              </a>
            </td>
            <td>
            @if (!empty($message->conversation->entry))
              <a href="{{ route('entry.view', $message->conversation->entry->id) }}">
                @if ($message->conversation->entry)
                  {{ strtoupper($message->conversation->entry->post_type) }}:
                @endif
                {{ $message->conversation->entry->title }}
              </a>
            @endif
            </td>
            <td>
              <a href="{{ route('messages.view', $message->conversation->id) }}">
                {{ ($message->conversation->subject!='' ? $message->conversation->subject: '(No subject)') }}
              </a>
            </td>
            <td>
              {{ $message->created_at->format('M j, Y') }}
            </td>
            <td>
              @if ($message->conversation->community)
                {{ $message->conversation->community->name }}
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <!-- End messages table -->
    </form>
  </div>
</section>
<div id="dialog-confirm" title="Delete message?">
  <p><i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i><span>This message will be permanently deleted.</span></p>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.js" integrity="sha256-OOtvdnMykxjRaxLUcjV2WjcyuFITO+y7Lv+3wtGibNA=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/cookie/bootstrap-table-cookie.min.js" integrity="sha256-w/PfNZrLr3ZTIA39D8KQymSlThKrM6qPvWA6TYcWrX0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/mobile/bootstrap-table-mobile.min.js" integrity="sha256-+G625AaRHZS3EzbW/2aCeoTykr39OFPJFfDdB8s0WHI=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/export/bootstrap-table-export.min.js" integrity="sha256-Hn0j2CZE8BjcVTBcRLjiSJnLBMEHkdnsfDgYH3EAeVQ=" crossorigin="anonymous"></script>
<script src="{{ Helper::cdn('js/extensions/export/tableExport.js') }}"></script>
<script src="{{ Helper::cdn('js/extensions/export/jquery.base64.js') }}"></script>
<script src="{{ Helper::cdn('js/entry_utils.js')}}"></script>

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
    paginationFirstText: "{{ trans('general.first') }}",
    paginationLastText: "{{ trans('general.last') }}",
    paginationPreText: "{{ trans('general.prev') }}",
    paginationNextText: "{{ trans('general.next') }}",
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

</script>

@stop
