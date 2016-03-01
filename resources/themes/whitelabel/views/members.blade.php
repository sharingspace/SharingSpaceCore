@extends('layouts.master')

{{-- Page title --}}
@section('title')
     {{ trans('general.nav.members') }} ::
@parent
@stop


@section('content')


<div class="container">
	<div class="row">
		<div class="col-lg-10 col-md-12 col-lg-offset-1  col-sm-10 col-sm-offset-1 col-xs-12 margin-top-20">
      <div class="table-responsive">
   			<table class="table table-condensed" id="members">
        	<thead>
            <tr>
              <th data-sortable="false"><span class='sr-only'>Image</span></th>
              <th data-sortable="true">Name</th>
              <th data-sortable="true">Location</th>
              <th data-sortable="false" class="bio">Bio</th>
              <th data-sortable="true">Since</th>
            </tr>
          </thead>
  				<tbody>
  					@foreach ($members as $member)
  						<tr>
                <td class="member_thumb"><img src="{{ $member->gravatar() }}"></div></td>
                <td><a href="{{ route('user.profile', [$member->id]) }}">{{ $member->getDisplayName() }}</a>

                @if ($member->pivot->is_admin==1)
                  <i class="fa fa-star text-warning"></i>
                @endif
                </td>
                <td>{{$member->location}}</td>
                <td>{{ substr_replace($member->bio, '&hellip;', 200) }}</td>
                <td>{{date("m-Y", strtotime($member->created_at))}}</td>
  						</tr>
  					@endforeach
      		</tbody>
      	</table>
      </div>
 	 </div> <!-- col-lg-10 -->
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
