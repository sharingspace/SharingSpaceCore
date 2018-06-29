@extends('layouts.master')

@section('title')
     {{ trans('general.role.list') }} ::
@parent
@stop


@section('content')

<div class="container">
  <div class="row">
    <h1 class="margin-bottom-0  size-24 text-center">{{ trans('general.role.roles') }}</h1>
    <a href="{{ route('admin.role.create') }}">
                <button type="button" class="btn btn-sm btn-colored" title="{{ trans('general.role.create') }}"><i class="fa fa-plus"></i><span class="hidden-xs"> {{ trans('general.role.create') }}</span></button>
              </a>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-20">
      <div class="table-responsive">
        <table class="table table-condensed" id="members">
          <tbody>
            <tr>
              <th class="col-md-3">{{ trans('general.role.name') }}</th>
              <th class="col-md-2">{{ trans('general.role.permission') }}</th>
              <th class="col-md-2">{{ trans('general.action') }}</th>

              
            </th>
          @foreach ($roles as $role)
            <tr>
              <td class="col-md-3"> <a href="/admin/role/edit/{{$role->id}}">{{ $role->name }}</td>
              <td class="col-md-2"> {{ $role->permissions()->count() }}</td>
              <td class="col-md-1"> 
                
                <a href="{{ route('admin.role.delete', $role->id) }}">
                  {{ trans('general.delete') }}
                </a>
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
