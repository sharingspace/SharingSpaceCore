@extends('layouts.master')

{{-- Page title --}}
  @section('title')
    {{ trans('general.our_members') }} ::
  @parent
@stop


@section('content')

<div class="container">
	<div class="row">
    <h1 class="margin-bottom-0  size-24 text-center">{{trans('general.our_members')}}</h1>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-20">
      <div class="table-responsive">
   			<table class="table table-condensed" id="members">
        	<thead>
            <tr>
              <th data-sortable="false"><span class='sr-only'>{{trans('general.members.image')}}</span></th>
              <th data-sortable="true" class="name">{{trans('general.name')}}</th>
              <th data-sortable="true" class="location">{{trans('general.location')}}</th>
              <th data-sortable="false" class="bio">{{trans('general.members.bio')}}</th>
              <th data-sortable="true" class="assigned-role">{{trans('general.members.assigned-role')}}</th>
              <th data-sortable="true">{{trans('general.members.member_since')}}</th>
            </tr>
          </thead>
  				<tbody>
  					@foreach ($members as $member)
  						<tr>
                <td class="member_thumb">
                  <a href="{{ route('user.profile', [$member->id]) }}">
                    <img src="{{ $member->gravatar_img() }}">
                  </a>
                </td>
                <td>
                    <a href="{{ route('user.profile', [$member->id]) }}">{{ $member->getDisplayName() }}</a>

                @if ($member->canAdmin($whitelabel_group))
                  <i class="fa fa-star text-warning"></i>
                @endif

                @if ($member->pivot->custom_label!='')
                    <span class="label label-primary">{{ $member->pivot->custom_label }}</span>
                @endif

                </td>
                <td>{{$member->location}}</td>
                <td>
                  <a href="{{ route('user.profile', [$member->id]) }}">{{ ((strlen($member->bio) > 150) ? substr_replace($member->bio, '&hellip;', 150) : $member->bio)}}</a>
                </td>
                <td>

                @if (Permission::adminRole($member, $whitelabel_group))
                  <p align="center"> <strong> ---- </strong></p>
                @else
                  @if(Permission::checkPermission('assign-role-permission', $whitelabel_group))
                    {!! Form::open(['route' => 'admin.assign-role.update', 'method' => 'post', 'role'=>'form','class'=>'role_form']) !!}
                    
                      {{ Form::select('role_id', $roles, Permission::getSelectedRole($member, $whitelabel_group) ,['class' => 'form-control assignRole']) }}
                      <input type="hidden" name="user_id" value="{{$member->id}}">
                    {{ Form::close() }}
                    @else
                      <p align="center"> <strong> ---- </strong></p>
                    @endif
                @endif
                </td>
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

$(document).on("change",".assignRole",function(){
  $(this).parent(".role_form").submit();
});

</script>

@stop
