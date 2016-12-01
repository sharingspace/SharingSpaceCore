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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/css/bootstrap-editable.css" integrity="sha256-YsJ7Lkc/YB0+ssBKz0c0GTx0RI+BnXcKH5SpnttERaY=" crossorigin="anonymous" />
 
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
                            <th>{{ trans('customers.user') }}</th>
                            <th>{{ trans('customers.email') }}</th>
                            <th>{{ trans('customers.share') }}</th>
                            <th>{{ trans('customers.active') }}</th>
                            <th>{{ trans('customers.type') }}</th>
                            <th>{{ trans('customers.date') }}</th>
                            <th>{{ trans('customers.trial_start') }}</th>
                            <th>{{ trans('customers.trial_end') }}</th>
                            <th>{{ trans('customers.next_charge') }}</th>
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
                                        <a href="{{ $subscription->community->getCommunityUrl() }}">{{ $subscription->community->name }}</a>
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
                                    {{ $subscription->created_at->format('M d, Y') }}
                                </td>
                                <td>
                                    {{ ($subscription->trial_starts_at!='') ? date('M d, Y',strtotime($subscription->trial_starts_at)) : '' }}
                                </td>
                                <td>
                                    {{ ($subscription->trial_ends_at!='') ? date('M d, Y',strtotime($subscription->trial_ends_at)) : '' }}
                                </td>
                                <td>
                                    {{ ($subscription->period_ends_at!='') ? date('M d, Y',strtotime($subscription->period_ends_at)) : '' }}

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.js" integrity="sha256-OOtvdnMykxjRaxLUcjV2WjcyuFITO+y7Lv+3wtGibNA=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/cookie/bootstrap-table-cookie.min.js" integrity="sha256-w/PfNZrLr3ZTIA39D8KQymSlThKrM6qPvWA6TYcWrX0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/mobile/bootstrap-table-mobile.min.js" integrity="sha256-+G625AaRHZS3EzbW/2aCeoTykr39OFPJFfDdB8s0WHI=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/export/bootstrap-table-export.min.js" integrity="sha256-Hn0j2CZE8BjcVTBcRLjiSJnLBMEHkdnsfDgYH3EAeVQ=" crossorigin="anonymous"></script>
    <script src="{{ Helper::cdn('js/extensions/export/tableExport.js') }}"></script>
    <script src="{{ Helper::cdn('js/extensions/export/jquery.base64.js') }}"></script>


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
