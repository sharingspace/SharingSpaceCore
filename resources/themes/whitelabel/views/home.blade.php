@extends('layouts/master')

{{-- Page title --}}
@section('title')
    {{ trans('general.nav.browse') }} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<section class="container padding-top-0">
    <h1 class="sr-only">{{trans('general.entries.browse_entries')}}</h1>
    <div class="row margin-y-0">
        <div class="col-sm-10 col-xs-8">
            <input id="entry-search" class="form-control" type="text" placeholder="&nbsp; Search" onfocus="this.placeholder=''" onblur="this.placeholder=' Search'" >
        </div>

        <div class="col-sm-2 col-xs-4">
            <i class="fa fa-2x fa-list sort-icon" title="list view" id="listView"></i>
            <i class="fa fa-2x fa-th sort-icon" title="grid view" id="gridView"></i>
        </div>
    </div>
</section>

<!-- Begin entries table -->
<section class="container browse_table">
    <table class="table table-condensed"
        name="communityListings"
        id="entry_browse_table"
        data-sort-name="created_at"
        data-sort-order="desc"
        data-cookie="true"
        data-cookie-id-table="communityListingv1-{{ $whitelabel_group->id }}">
        <thead>
            <tr>
                <th data-sortable="false" data-field="image">{{ trans('general.members.image')}}</th>
                <th data-sortable="true" data-field="post_type">{{ trans('general.type') }}</th>
                <th data-sortable="true" data-field="title">{{ trans('general.entry') }}</th>
                <th class="hidden-xs" data-sortable="true" data-field="display_name">{{ trans('general.entries.posted_by') }}</th>
                <th data-sortable="false" data-field="exchangeTypes">{{ trans('general.entries.exchange') }}</th>
                <th data-sortable="true" data-field="location">{{ trans('general.location') }}</th>
                <th data-sortable="true" data-field="created_at">{{ trans('general.entries.created_at') }}</th>
                <th class="hidden-xs" data-sortable="false" data-field="tags" data-visible="false">{{ trans('general.keywords') }}</th>
                <th data-sortable="false" data-field="actions" data-visible="false">{{ trans('general.actions') }}</th>
            </tr>
        </thead>
    </table>
    <!-- End entries table -->
</section>

<section class="container margin-y-0 padding-y-0">
    <div id="entry_browse_grid" class="grid">
        <div class="grid-item clone hidden"></div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.js" integrity="sha256-OOtvdnMykxjRaxLUcjV2WjcyuFITO+y7Lv+3wtGibNA=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/cookie/bootstrap-table-cookie.min.js" integrity="sha256-w/PfNZrLr3ZTIA39D8KQymSlThKrM6qPvWA6TYcWrX0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/mobile/bootstrap-table-mobile.min.js" integrity="sha256-+G625AaRHZS3EzbW/2aCeoTykr39OFPJFfDdB8s0WHI=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/export/bootstrap-table-export.min.js" integrity="sha256-Hn0j2CZE8BjcVTBcRLjiSJnLBMEHkdnsfDgYH3EAeVQ=" crossorigin="anonymous"></script>
<script src="{{ Helper::cdn('js/extensions/export/tableExport.js') }}"></script>
<script src="{{ Helper::cdn('js/extensions/export/jquery.base64.js') }}"></script>
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.js"></script>

<script type="text/javascript">

$(document).ready(function() {
    var CSRF_TOKEN = $('meta[name="ajax-csrf-token"]').attr('content');
    var entryRows;
    var GRID
    var qsRegex;
    var GRID_LOADED = false;
    var LIST_LOADED = false;
    var GRID_WIDTH = 100;

    // debounce so filtering doesn't happen every millisecond
    function debounce(fn, threshold)
    {
        var timeout;

        return function debounced() {
            if ( timeout ) {
                clearTimeout( timeout );
            }
            
            function delayed() {
                fn();
                timeout = null;
            }
            timeout = setTimeout( delayed, threshold || 100 );
        }
    }

    function masonryInit()
    {
        GRID_WIDTH = parseInt($('.grid-item').css('width').replace(/[^-\d\.]/g, ''));
        GRID = $('#entry_browse_grid').isotope({
            // options
            itemSelector: '.grid-item',
            getSortData: {
                post_type: '.post_type',
                title: '.title',
                posted_by: '.posted_by'
            },
            masonry: {
                gutter: 6,
                columnWidth: GRID_WIDTH,
            },
            filter: function() {
                return qsRegex ? $(this).text().match( qsRegex ) : true;
            }
        });

        // unbind any previously attached handlers
        $("#entry-search").unbind();

        // use value of search field to filter
        var $quicksearch = $('#entry-search').keyup( debounce( function() {
            qsRegex = new RegExp( $quicksearch.val(), 'gi' );
            GRID.isotope();
        }, 200 ) );
    }

    function tableSearch()
    {
        var filter, td;
        filter = $('#entry-search').val().toUpperCase();
        rowCount = $("#entry_browse_table tr").length;

        if (rowCount){
            // Loop through all table rows, and hide those who don't match the search query
            $("#entry_browse_table tr td:nth-child(3)").each(function(i, td) {
                if ($(td).text().toUpperCase().indexOf(filter) > -1) {
                    $(td).parent().show();
                }
                else {
                    $(td).parent().hide();
                }
            });
        }
    }

    function tableLayout(data)
    {
        // Note I did have it that this function was being passed in the data so I didn't have to do a seperate
        // ajax call for list and grid, however for sorting this bootstrap library does a fresh ajax call
        // with the serach parameters and I haven't how to work around this yet.
        $('#entry_browse_table').bootstrapTable({
            data: data.rows,
            classes: 'table table-responsive table-no-bordered',
            undefinedText: '',
            iconsPrefix: 'fa',
            showRefresh: false,
            search: false,
            pageSize: 100,
            pagination: false,
            sidePagination: 'server',
            sortable: false,
            mobileResponsive: true,
            showExport: false,
            showColumns: false,
            exportDataType: 'all',
            exportTypes: ['csv', 'txt','json', 'xml'],
            maintainSelected: true,
            paginationFirstText: "{{ trans('gernal.first') }}",
            paginationLastText: "{{ trans('general.last') }}",
            paginationPreText: "{{ trans('general.prev') }}",
            paginationNextText: "{{ trans('general.next') }}",
            pageList: ['10','25','50','100','150','200'],
            formatShowingRows: function (pageFrom, pageTo, totalRows) {
            return 'Showing ' + pageFrom + ' to ' + pageTo + ' of ' + totalRows + ' pages';
            },
            icons: {
                paginationSwitchDown: 'fa-caret-square-o-down',
                paginationSwitchUp: 'fa-caret-square-o-up',
                columns: 'fa-columns',
                refresh: 'fa-refresh',
                export: 'fa-download'
            }
        });

        // unbind any previously attached handlers
        $("#entry-search").unbind();

         // use value of search field to filter
        $('#entry-search').keyup( debounce( function() {
            tableSearch();
        }, 200));
    }

    function masonryLayout(data)
    {
        var count = data['total'];
        var item, contents, postType;

        for(i=0; i< count; i++) {
            item = $(".clone").clone().appendTo("#entry_browse_grid").removeClass('clone hidden');
            postType = data['rows'][i]['post_type'];
            natural_post_type = data['rows'][i]['natural_post_type'];
            author_name = data['rows'][i]['author_name'];
            author_image = data['rows'][i]['author_image'];
            posted_by = " <span class='posted_by'>"+data['rows'][i]['display_name']+"</span> ";
            post_type = " <span class='post_type'>"+natural_post_type+"</span> ";
            entry_id = data['rows'][i]['entry_id'];
            title = " <span class='title'>"+data['rows'][i]['title']+"</span> ";

            if (data['rows'][i]['image_url']) {
                ratio = data['rows'][i]['aspect_ratio'];
                if (ratio > 1.5) {
                    // image is roughly landscape, stick it in a 2x1 box
                    $(item).addClass('grid-item--width2');

                }
                else if (ratio < 0.75) {
                    // image is roughly portrait, stick it in a 2x1 box
                    $(item).addClass('grid-item--height2');
                    //$(item).addClass('grid-item--width2 grid-item--height2');

                }
                else {
                    // image is roughly square, stick it in a 2x2 box
                    $(item).addClass('grid-item--width2 grid-item--height2');
                } 
 
                $(item).css("background-image", 'url('+data['rows'][i]['image_url']+')');
                imageClass = "withImage";
            }
            else {
                imageClass = "noImage";
            }

            contents = "<div class='"+imageClass+"'><h3  class='"+postType.toLowerCase()+"_color'> "+posted_by + post_type + title +"</h3></div>";

            $(item).addClass(postType.toLowerCase()+'_color');
            $(item).attr('id', 'entry-'+ entry_id);
            $(item).html(contents);
        }
        masonryInit();
    }


    function getEntries(entries)
    {
        $.ajax({
            type: "GET",
            _token: CSRF_TOKEN,
            url: "{{ route('json.browse') }}",
            dataType: "json",
            success: function(data, textStatus, jqXHR)
            {
                entryRows = data;
                if (data['gridView']) {
                    masonryLayout(data);
                    $('#listView').addClass("dim-icon");
                    entryClick();
                    GRID_LOADED = true;
                }
                else {
                    tableLayout(entryRows);
                    $('#entry_browse_table').show();
                    $('#gridView').addClass("dim-icon");
                    LIST_LOADED = true;
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                // Handle errors here
                alert("danger "+textStatus+errorThrown);
            }
        });
    }

    getEntries();  

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
                $('div.ajax_success').removeClass('hidden');
            }
            else {
                // display error message
                $('div.ajax_error').removeClass('hidden');
                $('div.ajax_error .fa-exclamation-circle').after('&nbsp;<strong>Error: </strong>'+replyData.message);
            }
        });
    });

    // for some reason the columns and refresh have their tooltips added automatically
    $('.export > button').attr('title','Download data as');

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

    $("#listView").click(function() {
        $('#entry_browse_table').hide();
        if (!LIST_LOADED) {
            // load up list view if we haven't before
            tableLayout(entryRows);
            LIST_LOADED = true;
        }

        // unbind any previously attached handlers
        $("#entry-search").unbind();

         // use value of search field to filter
        $('#entry-search').keyup( debounce( function() {
            tableSearch();
        }, 200));

        $('#entry-search').keyup();
        $("#gridView").addClass("dim-icon");
        $("#listView").removeClass("dim-icon");
        $('#entry_browse_grid').hide();
        $('#entry_browse_table').show();
   });

    $("#gridView").click(function() {
        if (!GRID_LOADED) {
            // load up grid view if we haven't before
            masonryLayout(entryRows);
        }

        // unbind any previously attached handlers
        $("#entry-search").unbind();

        // use value of search field to filter
        var $quicksearch = $('#entry-search').keyup( debounce( function() {
            qsRegex = new RegExp( $quicksearch.val(), 'gi' );
            GRID.isotope();
        }, 200 ) );

        $('#entry-search').keyup();
        $("#listView").addClass("dim-icon");
        $("#gridView").removeClass("dim-icon");
        $('#entry_browse_table').hide();
        $('#entry_browse_grid').show();
    });

    $('#isotope-sort a').click(function(){
        // get href attribute, minus the '#'
        var sortName = $(this).attr('href').slice(1);
        $('#entry_browse_grid').isotope({ sortBy : sortName });
        return false;
    });

     $('select').on('change', function(){
        // get href attribute, minus the '#'
        var sortName = $(this).val();
        $('#entry_browse_grid').isotope({ sortBy : sortName });
        return false;
    });

    function entryClick()
    {
        $('.grid-item').on('click', function() {
            var id = $(this).attr('id').split('-')[1];
            window.open('/entry/'+id,'_self');
        });
    }

    $( window ).resize(function() {
        if (GRID_LOADED) {
            var newWidth= $('.grid-item').css('width').replace(/[^-\d\.]/g, '');
            if (GRID_WIDTH != parseInt(newWidth)) {
                GRID_WIDTH = parseInt(newWidth);
                GRID.isotope({
                    // update columnWidth to half of container width
                    masonry: {
                        gutter: 6,
                        columnWidth: GRID_WIDTH
                    }
                });
            }
        }
    });
});

</script>
@stop
