@extends('layouts.master')

{{-- Page title --}}
@section('title')
     {{ trans('general.nav.members') }} ::
@parent
@stop


@section('content')

<div class="container">
    <div class="row">
        
        <h1 class="margin-bottom-0  size-24 text-center">Communities</h1>

    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-20">
            <div class="table-responsive">
       			<table class="table table-condensed" id="members">
          			<tbody>
        			@foreach ($communities as $community)
        				<tr>
                        <td class="col-md-3"> {{ $community->name }}</td>
                        <td class="col-md-2"> {{ $community->location }}</td>
                        <td class="col-md-6"> {{ $community->about }}</td>
                        <td class="col-md-1"> <a href="leave/{{ $community->id }}" class="btn btn-sm btn-warning">Leave</a></td>
                        </tr>
          			@endforeach
              		</tbody>
          	    </table>
            </div> <!-- table responsive -->
        </div> <!-- col-lg-12 -->

	</div> <!-- row -->
</div> <!-- #container -->

<script src="{{ asset('assets/js/bootstrap-table.js') }}"></script>
<script src="{{ asset('assets/js/extensions/cookie/bootstrap-table-cookie.js') }}"></script>
<script src="{{ asset('assets/js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/bootstrap-table-export.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/tableExport.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/jquery.base64.js') }}"></script>

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
