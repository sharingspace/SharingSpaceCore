@extends('layouts/frontend-master')

@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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
                            <div class="tab-pane active fade show" id="Menu">
                                <div class="col-sm-12">
                                    <div>
                                        <div  class="text-center">
                                            <h3 class="heading fw-normal fz-34">{{$module_subtitle_menu}}</h3>
                                        </div>
                                        <div class="clearfix">&nbsp;&nbsp;</div>
                                        <div class="row">
                                            <div class="col-sm-12" style="margin-left: 15px">
                                                <a href="{{ route('frontend.admin.control.menu.create') }}" class="btn btn-primary btn-sm btn-flat"> 
                                                    <span class="glyphicon glyphicon-plus"></span> Add
                                                </a>
                                            </div>
                                        </div>
                                        <div class="clearfix">&nbsp;</div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="contact-form-wrapper">
                                                    @include("includes/message")
                                                    
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-20">
                                                        <div class="message"></div>
                                                        <ul id="sortable">
                                                            @foreach ($menus_data as $menu)
                                                                <li class="ui-state-default" id="item-{{$menu->id}}"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{$menu->name}}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('ul').sortable({
            axis: 'y',
            update: function (event, ui) {
                var data = $(this).sortable('serialize');
                // POST to server using $.post or $.ajax
                $.ajax({
                    data: {
                            "_token": "{{ csrf_token() }}",
                            data
                        },
                    type: 'POST',
                    url: '{{route("frontend.admin.control.menu.order")}}',
                    success: function(response){
                        if(response.meta.code){
                            $('.message').html('<div class="alert alert-success">'+response.meta.message+'</div>');
                        } else {
                            $('.message').html('<div class="alert alert-danger">Something wrong</div>');
                        }
                    },
                    error: function(){
                        $('.message').html('<div class="alert alert-danger">Something wrong!</div>');
                    }
                });
            }
        });
    });

    $(document).on("click",".trash_btn", function (e) {
        e.preventDefault();         
        
        var id = $(this).attr("id");

        var self = this;
        if (id != '') {
            swal({
                title: "Delete confirmation",
                text: "Are sure you want to delete ?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function (isConfirm) {
                if (isConfirm) {
                    var url = $(self).attr('href');
                    window.location.href = url
                }
            });
        } else {

        }
    });
</script>
@endsection
