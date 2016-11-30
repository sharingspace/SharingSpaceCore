@extends('layouts.master')

{{-- Page title --}}
@section('title')
     {{ trans('general.nav.members') }} ::
@parent
@stop


@section('content')

<div class="container">
	<div class="row">
  <h1 class="margin-bottom-0  size-24 text-center">{{trans('general.members.members')}}</h1>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-20">
      <div class="table-responsive">
   			<table class="table table-condensed" id="members">
        	<thead>
            <tr>
              <th data-sortable="false"><span class='sr-only'>Image</span></th>
              <th data-sortable="true" class="name">Name</th>
              <th data-sortable="true" class="location">Location</th>
              <th data-sortable="false" class="bio">Bio</th>
              <th data-sortable="true">Member since</th>
            </tr>
          </thead>
  				<tbody>
  					@foreach ($members as $member)
  						<tr>
                <td class="member_thumb"><img src="{{ $member->gravatar() }}"></div></td>
                <td><a href="{{ route('user.profile', [$member->id]) }}">{{ $member->getDisplayName() }}</a>

                @if ($member->canAdmin($whitelabel_group))
                  <i class="fa fa-star text-warning"></i>
                @endif
                </td>
                <td>{{$member->location}}</td>
                <td>{{ ((strlen($member->bio) > 150) ? substr_replace($member->bio, '&hellip;', 150) : $member->bio)}}</td>
                <td>{{date("Y", strtotime($member->created_at))}}</td>
  						</tr>
  					@endforeach
      		</tbody>
      	</table>
      </div>
 	 </div> <!-- col-lg-10 -->
	</div> <!-- row -->
</div> <!-- #container -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.js" integrity="sha256-OOtvdnMykxjRaxLUcjV2WjcyuFITO+y7Lv+3wtGibNA=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/cookie/bootstrap-table-cookie.min.js" integrity="sha256-w/PfNZrLr3ZTIA39D8KQymSlThKrM6qPvWA6TYcWrX0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/mobile/bootstrap-table-mobile.min.js" integrity="sha256-+G625AaRHZS3EzbW/2aCeoTykr39OFPJFfDdB8s0WHI=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/export/bootstrap-table-export.min.js" integrity="sha256-Hn0j2CZE8BjcVTBcRLjiSJnLBMEHkdnsfDgYH3EAeVQ=" crossorigin="anonymous"></script>
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
