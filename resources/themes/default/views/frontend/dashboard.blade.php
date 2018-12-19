@extends('layouts/frontend-master')

@section('content')

<div id="main">
    <div class="clearfix">&nbsp;&nbsp;&nbsp;</div>
    <div class="section pb-10">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="tabs vertical-tab mb-4">
                        <!-- Nav tabs -->
                        @include('includes/side')

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active fade show" id="dashboard">
                                <p>Dashboard is here</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">

    $(document).ready(function(){
        $(document).on("click",".active_tab", function (e) {
            window.location.href = $(this).attr("route");
        }); 
    });
</script>
@endsection
