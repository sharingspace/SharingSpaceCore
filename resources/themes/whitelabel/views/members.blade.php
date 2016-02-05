@extends('layouts.master')

{{-- Page title --}}
@section('title')
     {{ trans('general.nav.members') }} ::
@parent
@stop

<style>
.thumbnail {
    height: 40px;
    border:none;
}

.image {
    width: 100%;
    height: 100%;    
}

.member_image img {
    -webkit-transition: all 1s ease; /* Safari and Chrome */
    -moz-transition: all 1s ease; /* Firefox */
    -ms-transition: all 1s ease; /* IE 9 */
    -o-transition: all 1s ease; /* Opera */
    transition: all 1s ease;
}

.member_image:hover img {
		-ms-transform: translate(50px,0) scale(4); 			/* IE 9 */
    -webkit-transform: translate(50px,0) scale(4); 	/* Safari */
    transform: translate(50px,0) scale(4); 					/* Standard syntax */
    o-transform:translate(50px,0) scale(4);
}


table#members thead .sortable {
  background-position-x: 90%;
  background-position-y: 50%;
}
</style>
@section('content')


<div class="container">
	<div class="row">
		<div class="col-lg-10 col-md-12 col-lg-offset-1  col-sm-10 col-sm-offset-1 col-xs-12 margin-top-20">
 			<table class="table table-condensed" id="members">
      	<thead>
          <tr>
						<th data-sortable="false"><span class='sr-only'>Image</span></th>
						<th data-sortable="true">Name</th>
						<th data-sortable="true">Location</th>
						<th data-sortable="false">Bio</th>
						<th data-sortable="true">Since</th>
          </tr>
        </thead>
				<tbody>
					@foreach ($members as $member)
						<tr><td class="thumbnail" style="border:none;"><div class="member_image"><img src="{{ $member->gravatar() }}" class="thumbnail pull-left"></div></td>
						<td>{{ $member->getDisplayName() }}</td>
						<td>{{$member->location}}</td>
						<td>{{ substr_replace($member->bio, '&hellip;', 60) }} <a href="{{ route('user.profile', [$member->id]) }}">more</a></td>
						<td>{{date("m-Y", strtotime($member->created_at))}}
						</tr>
					@endforeach
    		</tbody>
    	</table>
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
