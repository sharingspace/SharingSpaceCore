@extends('layouts.master')

{{-- Page title --}}
@section('title')
     {{ trans('general.nav.members') }} ::
@parent
@stop


@section('content')

<!-- Profile -->
  <section class="padding-top-0">
  	<div class="container user_profile">
     <h1 class="margin-bottom-0 size-24 text-center">{{trans('general.profile.profile')}} {{ $user->getDisplayName() }}</h1>
  		<!-- LEFT -->
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-5">
          <div class="row">
            <div class="col-md-12">
              <h2 class="margin-bottom-20 size-20 text-center">Profile</h2>
            </div>
            <div class="col-lg-5 col-md-5">
  			      <div class="thumbnail text-center">
                <img src="{{ $user->gravatar() }}?s=400" alt="" />
              </div>
            </div>
            <div class="col-lg-7 col-md-7">
              <div class="text-muted">
                <ul class="list-unstyled nomargin">
                  @if($user->location)                  
                    <li class="margin-bottom-6"><i class="fa fa-location-arrow width-20"></i> {{ $user->location }}</li>
                  @endif
                  @if ($user->website)
                    <li class="margin-bottom-6"><i class="fa fa-globe width-20 hidden-xs hidden-sm"></i> <a href="{{ $user->website }}">{{ $user->getDisplayName() }}'s  website</a></li>
                  @endif

                  @if ($user->twitter)
                    <li class="margin-bottom-6"><i class="fa fa-twitter width-20 hidden-xs hidden-sm"></i> <a href="{{ $user->twitter }}">Twitter</a></li>
                  @endif

                  @if ($user->fb_url)
                    <li class="margin-bottom-6"><i class="fa fa-facebook width-20 hidden-xs hidden-sm"></i> <a href="{{ $user->facebook }}">Facebook</a></li>
                  @endif

                  @if ($user->pinterest)
                    <li class="margin-bottom-6"><i class="fa fa-pinterest width-20 hidden-xs hidden-sm"></i> <a href="{{ $user->pinterest }}">Pinterest</a></li>
                  @endif

                  @if ($user->google)
                    <li class="margin-bottom-6"><i class="fa fa-google width-20 hidden-xs hidden-sm"></i> <a href="{{ $user->google }}">Google +</a></li>
                  @endif
                </ul>
              </div> <!-- muted -->
            </div> <!-- col 6 -->
            <div class="col-md-12"
              <p>{{ $user->bio }}</p>
            </div> <!-- col 12 -->
            <div class="col-md-12"
              @if (1 || Auth::user() && (Auth::user()->id != $user->id))
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
            </div> <!-- col 12 -->        
          </div> <!-- row -->
        </div> <!-- col 6 -->
        <div class="col-lg-6 col-md-6 col-sm-6">
          <h2 class="margin-bottom-20 size-20 text-center">Exchanges</h2>

          <!-- Begin entries table -->
          <table class="table table-condensed"
            name="communityListings"
            id="table"
            data-url="{{ route('json.browse', $user->id) }}"
            data-sucess="";
            data-cookie="true"
            data-cookie-id-table="communityListingv1">
          <caption class="my_exchanges sr-only">Exchanges</caption>
            <thead>
              <tr>
                <th data-sortable="true" data-field="post_type">{{ trans('general.entries.post_type') }}</th>
                <th data-sortable="true" data-field="title">{{ trans('general.entries.title') }}</th>
                <th data-sortable="true" data-field="created_at">{{ trans('general.entries.created_at') }}</th>
                <th data-sortable="true" data-field="tags">{{ trans('general.entries.keywords') }}</th>
                <th data-sortable="false" data-field="actions"></th>
              </tr>
            </thead>
          </table>
          <!-- End entries table -->
        </div>  <!-- col 6 -->
      </div> <!-- row -->
    </div> <!-- container -->
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
    var entryID = $(this).attr('id').split('_')[2];
    
    // add a clas to the row so we can remove it on success
    $(this).closest('tr').addClass("remove_"+entryID);

    var CSRF_TOKEN = $('meta[name="ajax-csrf-token"]').attr('content');

    $.post(entryID+"/ajaxdelete",{_token: CSRF_TOKEN},function (replyData) {
      if (replyData.success) {
        // remove row from table
        $('.remove_'+entryID).remove();
      }
      else {
        //console.error('delete failed');
      }
    });
  });
})

</script>
@stop
