@extends('layouts/master')
{{-- Page title --}}
@section('title')
     {{ trans('general.nav.browse') }} ::
@parent
@stop

{{-- Page content --}}
@section('content')

@if ($whitelabel_group->show_info_bar)
<section class="info-bar hidden-xs">
	<div class="container">

		<div class="row">
      <h1 class="sr-only">{{ $whitelabel_group->name }} {{ trans('home.homepage')}}</h1>

			<div class="col-xs-6 text-center">
        <h3 class="uppercase"><a href="" data-toggle="modal" data-target="#aboutModal"><i class="fa fa-lightbulb-o"></i> {{ trans('general.about')}}</a></h3>
        <p>Story, location, membership &hellip;</p> 
			</div>

			<div class="col-xs-6 text-center">
        <h3 class="uppercase"><a href="" data-toggle="modal" data-target="#statsModal"><i class="fa fa-bar-chart-o"></i> {{ trans('general.stats')}}</a></h3>
        <p>Entries, users &hellip;</p> 
			</div>
		</div>
	</div>
</section>
@endif <!-- /INFO BAR -->

<div class="col-md-12 margin-top-20">
  <!-- Notifications -->
  @include('notifications')
</div>

<section class="container padding-top-0 browse_table">
<div class="row">
  <h2 class="margin-bottom-0 size-20 text-center">{{trans('general.entries.browse_entries')}}</h1>
    <!-- Begin entries table -->

    <table class="table table-condensed"
    name="communityListings"
    id="entry_browse_table"
    data-sort-name="created_at"
    data-sort-order="desc"
    data-url="{{ route('json.browse') }}"
    data-cookie="true"
    data-cookie-id-table="communityListingv1-{{ $whitelabel_group->id }}">
      <thead>
        <tr>
          <th data-sortable="false" data-field="image">{{ trans('general.members.image')}}</th>
          <th data-sortable="true" data-field="post_type">{{ trans('general.entries.post_type') }}</th>
          <th data-sortable="true" data-field="title">{{ trans('general.entry') }}</th>
          <th class="hidden-xs" data-sortable="true" data-field="author">{{ trans('general.entries.posted_by') }}</th>
          <th data-sortable="false" data-field="exchangeTypes">{{ trans('general.entries.exchange') }}</th>
          <th data-sortable="true" data-field="location">{{ trans('general.location') }}</th>
          <th data-sortable="true" data-field="created_at">{{ trans('general.entries.created_at') }}</th>
          <th class="hidden-xs" data-sortable="false" data-field="tags" data-visible="false">{{ trans('general.keywords') }}</th>
          <th data-sortable="false" data-field="actions" data-visible="false">{{ trans('general.actions') }}</th>
        </tr>
      </thead>
    </table>
    <!-- End entries table -->
  </div>
</section>


<!-- Modals -->

<div id="aboutModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">About {{$whitelabel_group->name}}</h4>
      </div>
      <div class="modal-body">
        <p  class="about_info"><strong>Started:</strong> <span>{{$whitelabel_group->created_at->format('F jS, Y')}}</span>
        @if (!empty($whitelabel_group->location))
          <br><strong>Location:</strong> <span class="about_info">{{$whitelabel_group->location}}</span>
        @endif
        @if ($whitelabel_group->group_type == 'O')
          <br><strong>Privacy:</strong> <span class="about_info">Open Membership</span> 
          <a href="#" title="An open Share lets anyone join and exchange. It is the most permissive way to build members.""><i class="fa fa-info-circle"></i></a>

        @elseif ($whitelabel_group->group_type == 'C')
          <br><strong>Privacy:</strong> <span class="about_info">Closed, Membership requires approval</span> 
          <a href="#" title="A closed Share lets you approve members before they join. You can also invite members! Visitors can see basic information in its content, but not the details."><i class="fa fa-info-circle"></i></a>
        @else
          <br><strong>Privacy:</strong> <span class="about_info">Secret, Membership is by invitation only</span> 
          <a href="" data-toggle="modal" data-target="#learnPrivacy"><i class="fa fa-info-circle"></i></a>
        @endif
          <br><strong>{{ trans_choice('general.community.exchange_types.title', $whitelabel_group->exchangeTypes->count()) }}</strong>
          <span class="about_info">
            @if ($whitelabel_group->exchangeTypes->count() == 10)
              {{ trans('general.community.exchange_types.all_allowed') }}
            @else
              {{--*/ $exchangeTypes = array() /*--}}
              @foreach ($whitelabel_group->exchangeTypes as $exchange_type)
                {{--*/ $exchangeTypes[] = $exchange_type->name /*--}}
              @endforeach
              {{ implode(', ', $exchangeTypes)}}
              <a href="#" title="This shows options for member exchange on this Share"><i class="fa fa-info-circle"></i></a>
            @endif
          </span>
        </p>

        {!! Markdown::convertToHtml($whitelabel_group->about) !!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('general.close')}}</button>
      </div>
    </div>
  </div>
</div>

<div id="statsModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{$whitelabel_group->name}} Stats</h4>
      </div>
      <div class="modal-body">
        <p><strong>Total members:</strong> {{$whitelabel_group->members()->count()}}<br>
        <strong>Total entries:</strong> {{$whitelabel_group->entries()->count()}}<br>
        <span class="margin-left-10"><strong >Wants:</strong></span> {{$whitelabel_group->entries()->where('post_type', 'want')->count()}}
        <a href="#" title="All the needs of the members"><i class="fa fa-info-circle"></i></a>
<br>            
        <span class="margin-left-10"><strong>Haves:</strong></span> {{$whitelabel_group->entries()->where('post_type', 'have')->count()}}
        <a href="#" title="All the resources of the members"><i class="fa fa-info-circle"></i></a>
</p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('general.close')}}</button>
      </div>
    </div>
  </div>
</div>

<div id="optionsModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{$whitelabel_group->name}} {{ trans('general.options')}}</h4>
      </div>
      <div class="modal-body">
        <p>
          <strong>{{ trans_choice('general.community.exchange_types.title', $whitelabel_group->exchangeTypes->count()) }}</strong>: 
          <span class="exchange_types">

            @if ($whitelabel_group->exchangeTypes->count() == 10)
              {{ trans('general.community.exchange_types.all_allowed') }}
            @else
              {{--*/ $exchangeTypes = array() /*--}}
              @foreach ($whitelabel_group->exchangeTypes as $exchange_type)
                {{--*/ $exchangeTypes[] = $exchange_type->name /*--}}
              @endforeach
              {{ implode(', ', $exchangeTypes)}}
              <a href="#" title="This shows options for member exchange on this Share"><i class="fa fa-info-circle light-primary"></i></a>
            @endif
          </span>
        </p>
        <div class="keep-open btn-group" title="Columns"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="fa fa-columns"></i> <span class="caret"></span></button><ul class="dropdown-menu" role="menu"><li><label><input type="checkbox" data-field="image" value="0" checked="checked"> Image</label></li><li><label><input type="checkbox" data-field="post_type" value="1" checked="checked"> Type</label></li><li><label><input type="checkbox" data-field="title" value="2" checked="checked"> What</label></li><li><label><input type="checkbox" data-field="author" value="3" checked="checked"> Posted by</label></li><li><label><input type="checkbox" data-field="exchangeTypes" value="4" checked="checked"> How</label></li><li><label><input type="checkbox" data-field="location" value="5" checked="checked"> Where</label></li><li><label><input type="checkbox" data-field="created_at" value="6" checked="checked"> Created on</label></li><li><label><input type="checkbox" data-field="tags" value="7"> Keywords</label></li><li><label><input type="checkbox" data-field="actions" value="8"> Actions</label></li></ul></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('general.close')}}</button>
      </div>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.js" integrity="sha256-OOtvdnMykxjRaxLUcjV2WjcyuFITO+y7Lv+3wtGibNA=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/cookie/bootstrap-table-cookie.min.js" integrity="sha256-w/PfNZrLr3ZTIA39D8KQymSlThKrM6qPvWA6TYcWrX0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/mobile/bootstrap-table-mobile.min.js" integrity="sha256-+G625AaRHZS3EzbW/2aCeoTykr39OFPJFfDdB8s0WHI=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/export/bootstrap-table-export.min.js" integrity="sha256-Hn0j2CZE8BjcVTBcRLjiSJnLBMEHkdnsfDgYH3EAeVQ=" crossorigin="anonymous"></script>
<script src="{{ Helper::cdn('js/extensions/export/tableExport.js') }}"></script>
<script src="{{ Helper::cdn('js/extensions/export/jquery.base64.js') }}"></script>

<script type="text/javascript">
$( document ).ready(function() {
  $( document ).tooltip();
  // we off screen the table headers as they are obvious.
  $('table').on( "click", '[id^=delete_entry_]', function() {
    var entryID = $(this).attr('id').split('_')[2];
    // add a clas to the row so we can remove it on success
    $(this).closest('tr').addClass("remove_"+entryID);

    var CSRF_TOKEN = $('meta[name="ajax-csrf-token"]').attr('content');

    $.post(entryID+"/ajaxdelete",{_token: CSRF_TOKEN},function (replyData) {
      //console.log("delete success :-)  "+replyData.entry_id);
      if (replyData.success) {
        // remove row from table
        $('.remove_'+entryID).remove();
        // display error message
        $('div.ajax_success .fa-check').after('&nbsp;<strong>Success: </strong>'+replyData.message);
        $('div.ajax_success').removeClass('hidden');//.delay(5000).fadeOut();
      }
      else {
        // display error message
        $('div.ajax_error').removeClass('hidden');
        $('div.ajax_error .fa-exclamation-circle').after('&nbsp;<strong>Error: </strong>'+replyData.message);
      }
    });
  });

  $('#entry_browse_table').bootstrapTable({
    classes: 'table table-responsive table-no-bordered',
    undefinedText: '',
    iconsPrefix: 'fa',
    showRefresh: true,
    search: true,
    pageSize: 100,
    pagination: true,
    sidePagination: 'server',
    sortable: true,
    mobileResponsive: true,
    showExport: true,
    showColumns: true,
    exportDataType: 'all',
    exportTypes: ['csv', 'txt','json', 'xml'],
    maintainSelected: true,
    paginationFirstText: "{{ trans('gernal.first') }}",
    paginationLastText: "{{ trans('general.last') }}",
    paginationPreText: "{{ trans('general.prev') }}",
    paginationNextText: "{{ trans('general.next') }}",
    pageList: ['10','25','50','100','150','200'],
    formatShowingRows: function (pageFrom, pageTo, totalRows) {
        return 'Showing ' + pageFrom + ' to ' + pageTo + ' of ' + totalRows + ' entries';
      },
    icons: {
        paginationSwitchDown: 'fa-caret-square-o-down',
        paginationSwitchUp: 'fa-caret-square-o-up',
        columns: 'fa-columns',
        refresh: 'fa-refresh',
        export: 'fa-download'
    }
  });

  // for some reason the columns and refresh have their tooltips added automatically
  $('.export > button').attr('title','Download data as');

  $('#entry_browse_table').on('load-success.bs.table', function () {
    $('.pull-right.search').removeClass('pull-right').addClass('center-block');
  });

  // we off screen the table headers as they are obvious.
  $('table').on( "click", '[id^=delete_entry_]', function() {
    var entryID = $(this).attr('id').split('_')[2];
    // add a clas to the row so we can remove it on success
    $(this).closest('tr').addClass("remove_"+entryID);

    var CSRF_TOKEN = $('meta[name="ajax-csrf-token"]').attr('content');

    $.post(entryID+"/ajaxdelete",{_token: CSRF_TOKEN},function (replyData) {
      //console.log("delete success :-)  "+replyData.entry_id);
      if (replyData.success) {
        // remove row from table
        $('.remove_'+entryID).remove();
      }
      else {
        //console.error('delete failed');
      }
    });
  });

  function positionSearch()
  {
    var searchHeight;
    if ($('.info-bar').height() && $('.wl_usercover').height()) {
      searchHeight = $('.wl_usercover').height()/2 + $('.info-bar').height() + $('h2.size-20').height() +30;
    }
    else if ($('.info-bar').height()) {
      searchHeight = $('.info-bar').height() + $('h2.size-20').height() + 67;

    }
    else if ($('.wl_usercover').height()) {
      searchHeight = $('.wl_usercover').height()/2 + $('h2.size-20').height() + 50;

    }
    else {
      searchHeight = $('h2.size-20').height() + 40;
    }

    //console.log( searchHeight+",  "+$('.wl_usercover').height()/2+",  "+$('.info-bar').height()+",  "+$('h2.size-20').height());
    $('.search').css('top', -searchHeight);
  }
  positionSearch();

  $( window ).resize(function() {
    positionSearch();
  });
});

</script>

@stop
