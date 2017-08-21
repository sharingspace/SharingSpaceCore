@extends('layouts.master')

{{-- Page title --}}
@section('title')
  {{ trans('general.nav.profile') }} ::
@parent
@stop


@section('content')

<!-- Profile -->
<section class="padding-top-0">
	<div class="container user_profile">
    <h1>{{trans('general.profile.profile')}} {{ $user->getDisplayName() }}</h1>
    <!-- LEFT -->
    <div class="row">
      <div class="col-md-5 col-sm-12 col-xs-12">
        <div class="row">
          <div class="col-xs-5">
            <div class="thumbnail">
              <img src="{{ $user->gravatar_img() }}" alt="" />
            </div>
          </div>
          <div class="col-xs-7">
            <div class="text-muted">
              <ul class="list-unstyled margin-left-10">
                @if($user->location)
                  <li class="margin-bottom-6"><i class="fa fa-location-arrow"></i>{{ $user->location }}</li>
                @endif
                @if ($user->website)
                  <li class="margin-bottom-6"><i class="fa fa-globe"></i><a href="{{ $user->website }}">{{ $user->getDisplayName() }}'s  website</a></li>
                @endif

                @if ($user->twitter)
                  <li class="margin-bottom-6"><i class="fa fa-twitter-square"></i><a href="{{ $user->twitter }}">Twitter</a></li>
                @endif

                @if ($user->fb_url)
                  <li class="margin-bottom-6"><i class="fa fa-facebook-square"></i><a href="{{ $user->fb_url }}">Facebook</a></li>
                @endif

                @if ($user->pinterest)
                  <li class="margin-bottom-6"><i class="fa fa-pinterest-square"></i><a href="{{ $user->pinterest }}">Pinterest</a></li>
                @endif

                @if ($user->google)
                  <li class="margin-bottom-6"><i class="fa fa-google-plus-square"></i><a href="{{ $user->google }}">Google +</a></li>
                @endif

                @if ($user->youtube)
                  <li class="margin-bottom-6"><i class="fa fa-youtube-square"></i><a href="{{ $user->youtube }}">Youtube</a></li>
                @endif
              </ul>
            </div> <!-- muted -->
          </div> <!-- col 6 -->
          @if ($user->bio)
          <div class="col-xs-12">
            <p class="margin-bottom-6"><strong>Bio:</strong></p>
            {!! Markdown::convertToHtml($user->bio) !!}
          </div> <!-- col 12 -->
          @endif

          @if (Auth::check())
            @can('update-profile', $user->id)
            <div class="col-xs-12">
              <a href="{{ route('user.settings.view') }}">
                <button class="btn btn-sm btn-colored">{{trans('general.settings.edit_profile')}}</button>
              </a>
            </div> 
            @endcan

            @can('send-msg', $whitelabel_group)
              <div class="col-xs-12"> 
                <form id="offerForm" class="box-light margin-top-20"><!-- .box-light OR .box-dark -->
                  {!! csrf_field() !!}
                  <!-- alert -->
                  <div class="alert alert-dismissable" style="display: none;" id="offerStatusbox">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="fa fa-exclamation-circle"></i>
                    <strong id="offerStatusText"></strong><span id="offerStatus"></span>
                  </div>
                  <!-- alert -->
                      
                  <p>{{trans('general.email.leave_message')}} <strong>{{ $user->getDisplayName() }} </strong></p>

                  <textarea name="message" required class="messageText form-control word-count" data-maxlength="100" rows="5" placeholder="Type your message here..."></textarea>
                  <input type="hidden" name="subject" value="Profile Message">
                  <div class="text-muted text-right margin-top-3 size-12 margin-bottom-10">
                    <span>0/100</span> Words
                  </div>

                  <button type="submit" class="btn btn-colored pull-right">{{trans('general.email.submit')}}</button>
                </form>
              </div> <!-- col 12 -->
            @else
              @cannot('update-profile', $user->id)
                <div class="col-xs-12">
                  <p><strong>{{ trans('general.user.join_to_send_message') }}.</strong></p>
                  <p>
                    <a class="btn btn-colored btn-sm" href=
                    @if ($whitelabel_group->group_type == 'O')
                      "{{ route('join-community') }}">
                    @else 
                      "{{ route('community.request-access.form') }}">
                    @endif 
                    {{ trans('general.register.join_share') }}</a>
                  </p>
                </div>
              @endcannot
            @endcan
          @else
            <div class="col-xs-12">
              <p><strong>{{ trans('general.user.login_to_send_message') }}.</strong></p>
              <a class="btn btn-colored" href="{{ route('login') }}">{{ trans('general.nav.login') }}</a></p>
            </div>
          @endif
        </div> <!-- row -->
      </div> <!-- col 6 -->
      <div class="col-md-7 col-sm-12 col-xs-12">
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
              <th data-sortable="true" data-field="post_type">{{ trans('general.type') }}</th>
              <th data-sortable="true" data-field="title">{{ trans('general.entry') }}</th>
              <th data-sortable="true" data-field="created_at">{{ trans('general.entries.created_at') }}</th>
              <th data-sortable="true" data-field="tags">{{ trans('general.keywords') }}</th>
              <th data-sortable="false" data-field="actions"></th>
            </tr>
          </thead>
        </table>
        <!-- End entries table -->
      </div>  <!-- col 6 -->
    </div> <!-- row -->
  </div> <!-- container -->
</section>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.js" integrity="sha256-OOtvdnMykxjRaxLUcjV2WjcyuFITO+y7Lv+3wtGibNA=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/cookie/bootstrap-table-cookie.min.js" integrity="sha256-w/PfNZrLr3ZTIA39D8KQymSlThKrM6qPvWA6TYcWrX0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/mobile/bootstrap-table-mobile.min.js" integrity="sha256-+G625AaRHZS3EzbW/2aCeoTykr39OFPJFfDdB8s0WHI=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/export/bootstrap-table-export.min.js" integrity="sha256-Hn0j2CZE8BjcVTBcRLjiSJnLBMEHkdnsfDgYH3EAeVQ=" crossorigin="anonymous"></script>
<script src="{{ Helper::cdn('js/extensions/export/tableExport.js') }}"></script>
<script src="{{ Helper::cdn('js/extensions/export/jquery.base64.js') }}"></script>
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
    paginationFirstText: "@lang('general.first')",
    paginationLastText: "@lang('general.last')",
    paginationPreText: "@lang('general.prev')",
    paginationNextText: "@lang('general.next')",
    pageList: ['10','25','50','100','150','200'],
    icons: {
        paginationSwitchDown: 'fa-caret-square-o-down',
        paginationSwitchUp: 'fa-caret-square-o-up',
        columns: 'fa-columns',
        refresh: 'fa-refresh'
    },
   });

$( document ).ready(function() {
  $( document ).tooltip();

  // we off screen the table headers as they are obvious.
  $('table th').addClass('sr-only');
  $('table').on( "click", '[id^=delete_entry_]', function() {
    if (!confirm('{{trans("general.entries.delete_confirmation")}}')) {
      return false;
    }
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

<script>
$(document).ready(function () {

  $("#offerForm").submit(function(){
  $('#offerStatusbox').hide();
  $('#offerStatusText').html('');
  $('#offerStatus').html('');
  $('#offerStatusbox').removeClass('alert alert-success alert-danger');

  $.ajax({
      type: "POST",
      url: "{{ route('messages.create.save', $user->id) }}",
      data: $('#offerForm').serialize(),

      success: function(data){
        $('#offerStatusbox').show();

        if (data.success) {
          $('.messageText').val('');
          $('#offerStatusbox').addClass('alert alert-success');
          $('#offerStatusText').html('Success! '+data.message);
          $('#offerStatusbox').fadeTo(1000, 500).slideUp(500);
        }
        else {
          $('#offerStatusbox').addClass('alert alert-danger');
          $('#offerStatusText').html('Error: '+data.message);
        }
      },
      error: function(data){
          $('#offerStatusbox').addClass('alert alert-danger');
          $('#offerStatus').html('Something went wrong :(');
      }
    });
    return false;
  });
});
</script>
@stop
