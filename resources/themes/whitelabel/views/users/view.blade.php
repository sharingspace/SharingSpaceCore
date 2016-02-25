@extends('layouts.master')

{{-- Page title --}}
@section('title')
     {{ trans('general.nav.members') }} ::
@parent
@stop


@section('content')

<!-- Profile -->
			<section>
				<div class="container user_profile">
					<!-- LEFT -->
					<div class="col-lg-6 col-md-6 col-sm-5">
						<div class="thumbnail text-center">
              <img src="{{ $user->gravatar() }}?s=400" alt="" />
              <div class="box-icon-title">
              <h2 class="text-center margin-bottom-10">{{ $user->getDisplayName() }} &ndash; Profile</h2>
              <h3 class="size-11 margin-top-0 margin-bottom-10 text-muted text-center">Located in {{ $user->location }}</h3>
            </div>
						</div>
            <div class="text-muted">
              <ul class="list-unstyled nomargin list-inline">
                @if ($user->website)
                  <li class="margin-bottom-10"><i class="fa fa-globe width-20 hidden-xs hidden-sm"></i> <a href="{{ $user->website }}">{{ $user->getDisplayName() }}'s  website</a></li>
                @endif

                @if ($user->twitter)
                  <li class="margin-bottom-10"><i class="fa fa-twitter width-20 hidden-xs hidden-sm"></i> <a href="{{ $user->twitter }}">Twitter</a></li>
                @endif

                @if ($user->fb_url)
                  <li class="margin-bottom-10"><i class="fa fa-facebook width-20 hidden-xs hidden-sm"></i> <a href="{{ $user->facebook }}">Facebook</a></li>
                @endif

                @if ($user->pinterest)
                  <li class="margin-bottom-10"><i class="fa fa-pinterest width-20 hidden-xs hidden-sm"></i> <a href="{{ $user->pinterest }}">Pinterest</a></li>
                @endif

                @if ($user->google)
                  <li class="margin-bottom-10"><i class="fa fa-google width-20 hidden-xs hidden-sm"></i> <a href="{{ $user->google }}">Google +</a></li>
                @endif
              </ul>
              </div> <!-- muted -->
  <!-- BIO BOX -->
                <div class="box-icon box-icon-center box-icon-round box-icon-large text-center nomargin">
                  <div class="front">
                    <div class="box1 noradius">
            
                    
                      <p>{{ $user->bio }}</p>
                    </div>
                  </div>
                </div>
                <!-- /BIO BOX -->
              

                @if (Auth::user() && (Auth::user()->id != $user->id))
                  <form method="post" action="#" class="box-lightt margin-top-20"><!-- .box-light OR .box-dark -->
                    <div>
                      <h4 class="uppercase">LEAVE A MESSAGE FOR <strong>{{ strtoupper($user->getDisplayName()) }} </strong></h4>

                      <textarea required class="form-control word-count" data-maxlength="100" rows="5" placeholder="Type your message here..."></textarea>
                      <div class="text-muted text-right margin-top-3 size-12 margin-bottom-10">
                        <span>0/100</span> Words
                      </div>

                      <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i>I'm intersted</button>
                    </div>
                  </form>
                @endif                          
          </div> <!-- col 4 -->


						
					<!-- RIGHT -->
					<div class="col-lg-6 col-md-6 col-sm-6">
				    <div class="box-lightg"><!-- .box-light OR .box-dark -->
							<div class="row">
								<div class="box-inner" style="border:1px white solid;">
                  <!-- Begin entries table -->
                  <table class="table table-condensed"
                  name="communityListings"
                  id="table"
                  data-url="{{ route('json.browse', $user->id) }}"
                  data-sucess="";
                  data-cookie="true"
                  data-cookie-id-table="communityListingv1">
                  <caption class="my_exchanges">My exchanges</caption>
                    <thead>
                      <tr>
                        <th data-sortable="true" data-field="post_type">{{ trans('general.entries.post_type') }}</th>
                        <th data-sortable="true" data-field="title">{{ trans('general.entries.title') }}</th>
                        <th data-sortable="true" data-field="created_at">{{ trans('general.entries.created_at') }}</th>
                        <th data-sortable="false" data-field="actions"></th>
                      </tr>
                    </thead>
                  </table>
                  <!-- End entries table -->
                </div>
						</div>
					</div>
				</div>
			<!-- / -->


<script src="{{ asset('assets/js/bootstrap-table.js') }}"></script>
<script src="{{ asset('assets/js/extensions/cookie/bootstrap-table-cookie.js') }}"></script>
<script src="{{ asset('assets/js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/bootstrap-table-export.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/tableExport.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/jquery.base64.js') }}"></script>
<script type="text/javascript">
  $('#table').bootstrapTable({
    //alert('table done');
    classes: 'table table-responsive table-no-bordered',
    undefinedText: '',
    iconsPrefix: 'fa',
    search: false,
    pageSize: 20,
    pagination: true,
    sidePagination: 'server',
    cookie: true,
    mobileResponsive: true,
    showExport: false,
    showRefresh: false,
    sortable: false,
    showColumns: false,
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
  
$( document ).ready(function() {

  // we off screen the table headers as they are obvious. 
  $('table th').addClass('sr-only');
  $('table').on( "click", '[id^=delete_entry_]', function() {
    var id = $(this).attr('id').split('_')[2];
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  
    $.ajax({
      url: 'entry.delete.ajax.save',
      type: 'POST',
      data: {_token:CSRF_TOKEN, entryID:'813'},
      dataType: 'JSON',
      contentType:"application/json",
      headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
      success: function (data) {
          alert("delete complete :-) ");
      }
    });  
  });
})


</script>
@stop
