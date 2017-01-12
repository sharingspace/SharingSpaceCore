@extends('layouts.master')

{{-- Page title --}}
@section('title')
     {{ trans('general.memberships') }} ::
@parent
@stop


@section('content')

<div class="container">
  <div class="row">
    <h1 class="margin-bottom-0  size-24 text-center">{{ trans('general.memberships') }}</h1>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-20">
      <div class="table-responsive">
        <table class="table table-condensed" id="members">
          <tbody>
            <tr>
              <th class="col-md-3">{{ trans('general.share') }}</th>
              <th class="col-md-2">{{ trans('general.location') }}</th>
              <th class="col-md-6">{{ trans('general.about') }}</th>
              <th class="col-md-1 text-center">{{ trans('general.action') }}</th>
            </th>
          @foreach ($communities as $community)
            <tr>
              <td class="col-md-3"> {{ $community->name }}</td>
              <td class="col-md-2"> {{ $community->location }}</td>
              <td class="col-md-6"> {{ Str::limit($community->about, 200) }}</td>
              <td class="col-md-1 text-center">
                <a href="/account/leave/{{ $community->id }}" class="btn btn-sm btn-warning btn-colored">{{ trans('general.community.membership.leave') }}</a>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div> <!-- table responsive -->
    </div> <!-- col-lg-12 -->
  </div> <!-- row -->
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
