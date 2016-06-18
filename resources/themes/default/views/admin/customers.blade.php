@extends('layouts.master')

{{-- Page title --}}
@section('title')
    Accounts -
    @parent
@stop
p

{{-- Page content --}}
@section('content')


    <!-- *** Page section *** -->
    <!-- Head section -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>

    <section class="container">
        <div class="row">
            <div class="col-md-12 margin-top-30">

                <div class="table-responsive">
                    <table class="table table-condensed"
                           name="customers"
                           id="table"
                           data-cookie="true"
                           data-cookie-id-table="customers">
                        <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Hub</th>
                            <th>Active</th>
                            <th>Type</th>
                            <th>Trial Started</th>
                            <th>Trial Ends</th>
                            <th>Next Charge</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($subscriptions as $subscription)
                            <?php $subscription_meta = json_decode($subscription->plan); ?>
                            <tr {!! ($subscription->active!='1' ? 'class="danger"' : '') !!}>
                                <td>{{ $subscription->user->getDisplayName() }}</td>
                                <td><a href="mailto:{{ $subscription->user->email }}">{{ $subscription->user->email }}</a></td>
                                <td>
                                    @if ($subscription->community)
                                        <a href="{{ $subscription->community->getCommunityUrl() }}.">{{ $subscription->community->name }}</a>
                                    @endif
                                </td>
                                <td>
                                    @if ($subscription->active=='1')
                                        Y
                                    @else
                                        N
                                    @endif
                                </td>
                                <td>
                                    {{ $subscription_meta->interval }}
                                </td>
                                <td>
                                    {{ $subscription->trial_starts_at }}
                                </td>
                                <td>
                                    {{ date('M d, Y',strtotime($subscription->trial_ends_at)) }}
                                </td>
                                <td>
                                    {{ date('M d, Y',strtotime($subscription->period_ends_at)) }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $subscriptions->render() !!}


                </div>

            </div><!--end col-->
        </div><!--end row-->
        </div><!--end container-->
    </section>
    <!-- End head section -->

@section('moar_scripts')

    <script src="{{ asset('assets/js/bootstrap-table.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/cookie/bootstrap-table-cookie.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/export/bootstrap-table-export.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/export/tableExport.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/export/jquery.base64.js') }}"></script>


    <script>
        $('#table').bootstrapTable({
            classes: 'table table-responsive table-no-bordered',
            undefinedText: '',
            iconsPrefix: 'fa',
            showRefresh: true,
            search: true,
            pageSize: 100,
            pagination: true,
            sidePagination: 'client',
            sortable: true,
            cookie: true,
            mobileResponsive: true,
            showExport: true,
            showColumns: true,
            exportDataType: 'all',
            exportTypes: ['csv', 'txt','json', 'xml'],
            maintainSelected: true,
            paginationFirstText: "{{ trans('pagination.first') }}",
            paginationLastText: "{{ trans('pagination.last') }}",
            paginationPreText: "{{ trans('pagination.previous') }}",
            paginationNextText: "{{ trans('pagination.next') }}",
            pageList: ['10','25','50','100','150','200'],
            formatShowingRows: function (pageFrom, pageTo, totalRows) {
                return 'Showing ' + pageFrom + ' to ' + pageTo + ' of ' + totalRows + ' entries';
            },
            icons: {
                paginationSwitchDown: 'fa-caret-square-o-down',
                paginationSwitchUp: 'fa-caret-square-o-up',
                columns: 'fa-columns',
                refresh: 'fa-refresh'
            },
        });

    </script>


@stop


@stop
